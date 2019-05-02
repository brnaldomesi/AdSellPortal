<?php
/**
 * LaraClassified - Classified Ads Web Application
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Models;


use Larapen\Admin\app\Models\Crud;

class CategoryField extends BaseModel
{
	use Crud;
	
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'category_field';
	
	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	// protected $primaryKey = 'id';
	
	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var boolean
	 */
	public $timestamps = false;
	
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'category_id',
		'field_id',
		'disabled_in_subcategories',
		'parent_id',
		'lft',
		'rgt',
		'depth',
	];
	
	/**
	 * The attributes that should be hidden for arrays
	 *
	 * @var array
	 */
	// protected $hidden = [];
	
	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	// protected $dates = [];
	
	/*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/
	protected static function boot()
	{
		parent::boot();
	}
	
	public function getCategoryHtml()
	{
		$out = '';
		if (!empty($this->category)) {
			$currentUrl = preg_replace('#/(search)$#', '', url()->current());
			$editUrl = $currentUrl . '/' . $this->category->id . '/edit';
			
			$out .= '<a href="' . $editUrl . '">' . $this->category->name . '</a>';
		} else {
			$out .= '--';
		}
		
		return $out;
	}
	
	public function getFieldHtml()
	{
		$out = '';
		if (!empty($this->field)) {
			$currentUrl = preg_replace('#/(search)$#', '', url()->current());
			$editUrl = $currentUrl . '/' . $this->field->id . '/edit';
			
			$out .= '<a href="' . $editUrl . '" style="float:left;">' . $this->field->name . '</a>';
			
			if (in_array($this->field->type, ['select', 'radio', 'checkbox_multiple'])) {
				$optionUrl = admin_url('custom_fields/' . $this->field->id . '/options');
				$out .= ' ';
				$out .= '<span style="float:right;">';
				$out .= '<a class="btn btn-xs btn-danger" href="' . $optionUrl . '"><i class="fa fa-cog"></i> ' . mb_ucfirst(trans('admin::messages.options')) . '</a>';
				$out .= '</span>';
			}
		} else {
			$out .= '--';
		}
		
		return $out;
	}
	
	public function getDisabledInSubCategoriesHtml()
	{
		return checkboxDisplay($this->disabled_in_subcategories);
	}
	
	/**
	 * Get Fields details
	 *
	 * @param $catNestedIds
	 * @param null $postId
	 * @param null $languageCode (Required for AJAX Requests in v4.8 and lower)
	 * @return \Illuminate\Support\Collection
	 */
	public static function getFields($catNestedIds, $postId = null, $languageCode = null)
	{
		$fields = [];
		
		// Make sure that the Category nested IDs variables exist
		if (!isset($catNestedIds->parentId) || !isset($catNestedIds->id)) {
			return collect($fields);
		}
		
		// Make sure that the category nested IDs variable are not empty
		if (empty($catNestedIds->parentId) && empty($catNestedIds->id)) {
			return collect($fields);
		}
		
		// Get Post's Custom Fields values
		$postFieldsValues = collect([]);
		if (!empty($postId) && trim($postId) != '') {
			$postFieldsValues = PostValue::where('post_id', $postId)->get();
			$postFieldsValues = self::keyingByFieldId($postFieldsValues);
		}
		
		// Get Category's fields
		if (!empty($catNestedIds->parentId) && !empty($catNestedIds->id)) {
			$catFields = self::with(['field' => function ($builder) {
				$builder->with(['options']);
			}])
				->where(function ($query) use ($catNestedIds) {
					$query->where('category_id', $catNestedIds->parentId)->availableForSubCats();
				})
				->orWhere('category_id', $catNestedIds->id)
				->orderBy('lft', 'ASC')
				->get();
		} else {
			if (!empty($catNestedIds->parentId)) {
				$catFields = self::with(['field' => function ($builder) {
					$builder->with(['options']);
				}])
					->where('category_id', $catNestedIds->parentId)
					->availableForSubCats()
					->orderBy('lft', 'ASC')
					->get();
			} else {
				$catFields = self::with(['field' => function ($builder) {
					$builder->with(['options']);
				}])
					->where('category_id', $catNestedIds->id)
					->orderBy('lft', 'ASC')
					->get();
			}
		}
		
		if ($catFields->count() > 0) {
			foreach ($catFields as $key => $catField) {
				if (!empty($catField->field)) {
					$fields[$key] = $catField->field;
					
					// Retrieve the Field's Default value
					if ($postFieldsValues->count() > 0) {
						if ($postFieldsValues->has($catField->field->tid)) {
							$postValue = $postFieldsValues->get($catField->field->tid);
							if (isset($postValue->value)) {
								$defaultValue = $postValue->value;
							} else {
								if ($catField->field->options->count() > 0) {
									$selectedOptions = [];
									foreach ($catField->field->options as $option) {
										if (isset($postValue[$option->tid])) {
											$selectedOptions[$option->tid] = $option;
										}
									}
									$defaultValue = $selectedOptions;
								} else {
									$defaultValue = [];
								}
							}
							
							$fields[$key]->default = $defaultValue;
						}
					}
					
				}
			}
		}
		
		return collect($fields);
	}
	
	/**
	 * @param $values
	 * @return \Illuminate\Support\Collection
	 */
	private static function keyingByFieldId($values)
	{
		if (empty($values) || $values->count() <= 0) {
			return $values;
		}
		
		$postValues = [];
		foreach ($values as $value) {
			if (!empty($value->option_id)) {
				$postValues[$value->field_id][$value->option_id] = $value;
			} else {
				$postValues[$value->field_id] = $value;
			}
		}
		
		return collect($postValues);
	}
	
	/*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
	public function category()
	{
		return $this->belongsTo(Category::class, 'category_id', 'translation_of')->where('translation_lang', config('app.locale'));
	}
	
	public function field()
	{
		return $this->belongsTo(Field::class, 'field_id', 'translation_of')->where('translation_lang', config('app.locale'));
	}
	
	/*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/
	public function scopeAvailableForSubCats($builder)
	{
		return $builder->where('disabled_in_subcategories', '!=', 1);
	}
	
	public function scopeUnavailableForSubCats($builder)
	{
		return $builder->where('disabled_in_subcategories', 1);
	}
	
	/*
	|--------------------------------------------------------------------------
	| ACCESSORS
	|--------------------------------------------------------------------------
	*/
	
	/*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
}

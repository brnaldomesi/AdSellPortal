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

namespace App\Http\Controllers\Admin;

use App\Models\Field;
use Larapen\Admin\app\Http\Controllers\PanelController;
use App\Models\Category;
use App\Http\Requests\Admin\CategoryFieldRequest as StoreRequest;
use App\Http\Requests\Admin\CategoryFieldRequest as UpdateRequest;

class CategoryFieldController extends PanelController
{
	public $parentEntity = null;
	private $categoryId = null;
	private $fieldId = null;
	
	public function setup()
	{
		// Parents Entities
		$parentEntities = ['categories', 'custom_fields'];
		
		// Get the parent Entity slug
		$this->parentEntity = request()->segment(2);
		if (!in_array($this->parentEntity, $parentEntities)) {
			abort(404);
		}
		
		// Category => CategoryField
		if ($this->parentEntity == 'categories') {
			$this->categoryId = request()->segment(3);
			
			// Get Parent Category's name
			$category = Category::findTransOrFail($this->categoryId);
		}
		
		// Field => CategoryField
		if ($this->parentEntity == 'custom_fields') {
			$this->fieldId = request()->segment(3);
			
			// Get Field's name
			$field = Field::findTransOrFail($this->fieldId);
		}
		
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\CategoryField');
		$this->xPanel->with(['category', 'field']);
		$this->xPanel->enableParentEntity();
		
		// Category => CategoryField
		if ($this->parentEntity == 'categories') {
			$this->xPanel->setRoute(admin_uri('categories/' . $category->id . '/custom_fields'));
			$this->xPanel->setEntityNameStrings(
				trans('admin::messages.custom field') . ' &rarr; ' . '<strong>' . $category->name . '</strong>',
				trans('admin::messages.custom fields') . ' &rarr; ' . '<strong>' . $category->name . '</strong>'
			);
			$this->xPanel->enableReorder('field.name', 1);
			if (!request()->input('order')) {
				$this->xPanel->orderBy('lft', 'ASC');
			}
			$this->xPanel->setParentKeyField('category_id');
			$this->xPanel->addClause('where', 'category_id', '=', $category->id);
			$this->xPanel->setParentRoute(admin_uri('categories'));
			$this->xPanel->setParentEntityNameStrings(trans('admin::messages.category'), trans('admin::messages.categories'));
			$this->xPanel->allowAccess(['reorder', 'parent']);
		}
		
		// Field => CategoryField
		if ($this->parentEntity == 'custom_fields') {
			$this->xPanel->setRoute(admin_uri('custom_fields/' . $field->id . '/categories'));
			$this->xPanel->setEntityNameStrings(
				'<strong>' . $field->name . '</strong> ' . trans('admin::messages.custom field') . ' &rarr; ' . trans('admin::messages.category'),
				'<strong>' . $field->name . '</strong> ' . trans('admin::messages.custom fields') . ' &rarr; ' . trans('admin::messages.categories')
			);
			$this->xPanel->setParentKeyField('field_id');
			$this->xPanel->addClause('where', 'field_id', '=', $field->id);
			$this->xPanel->setParentRoute(admin_uri('custom_fields'));
			$this->xPanel->setParentEntityNameStrings(trans('admin::messages.custom field'), trans('admin::messages.custom fields'));
			$this->xPanel->allowAccess(['parent']);
		}
		
		$this->xPanel->addButtonFromModelFunction('top', 'bulk_delete_btn', 'bulkDeleteBtn', 'end');
		
		
		/*
		|--------------------------------------------------------------------------
		| COLUMNS AND FIELDS
		|--------------------------------------------------------------------------
		*/
		// COLUMNS
		$this->xPanel->addColumn([
			'name'  => 'id',
			'label' => '',
			'type'  => 'checkbox',
			'orderable' => false,
		]);
		
		// Category => CategoryField
		if ($this->parentEntity == 'categories') {
			$this->xPanel->addColumn([
				'name'          => 'field_id',
				'label'         => mb_ucfirst(trans("admin::messages.custom field")),
				'type'          => 'model_function',
				'function_name' => 'getFieldHtml',
			]);
		}
		
		// Field => CategoryField
		if ($this->parentEntity == 'custom_fields') {
			$this->xPanel->addColumn([
				'name'          => 'category_id',
				'label'         => trans("admin::messages.Category"),
				'type'          => 'model_function',
				'function_name' => 'getCategoryHtml',
			]);
		}
		
		$this->xPanel->addColumn([
			'name'          => 'disabled_in_subcategories',
			'label'         => trans("admin::messages.Disabled in subcategories"),
			'type'          => 'model_function',
			'function_name' => 'getDisabledInSubCategoriesHtml',
			'on_display'    => 'checkbox',
		]);
		
		
		// FIELDS
		// Category => CategoryField
		if ($this->parentEntity == 'categories') {
			$this->xPanel->addField([
				'name'  => 'category_id',
				'type'  => 'hidden',
				'value' => $this->categoryId,
			], 'create');
			$this->xPanel->addField([
				'name'        => 'field_id',
				'label'       => mb_ucfirst(trans("admin::messages.Select a Custom field")),
				'type'        => 'select2_from_array',
				'options'     => $this->fields($this->fieldId),
				'allows_null' => false,
			]);
		}
		
		// Field => CategoryField
		if ($this->parentEntity == 'custom_fields') {
			$this->xPanel->addField([
				'name'  => 'field_id',
				'type'  => 'hidden',
				'value' => $this->fieldId,
			], 'create');
			$this->xPanel->addField([
				'name'        => 'category_id',
				'label'       => trans("admin::messages.Select a Category"),
				'type'        => 'select2_from_array',
				'options'     => $this->categories($this->categoryId),
				'allows_null' => false,
			]);
		}
		
		$this->xPanel->addField([
			'name'  => 'disabled_in_subcategories',
			'label' => trans("admin::messages.Disabled in subcategories"),
			'type'  => 'checkbox',
		]);
	}
	
	public function store(StoreRequest $request)
	{
		return parent::storeCrud();
	}
	
	public function update(UpdateRequest $request)
	{
		return parent::updateCrud();
	}
	
	private function fields($selectedEntryId)
	{
		$entries = Field::trans()->orderBy('name')->get();
		
		return $this->getTranslatedArray($entries, $selectedEntryId);
	}
	
	private function categories($selectedEntryId)
	{
		$entries = Category::trans()->where('parent_id', 0)->orderBy('lft')->get();
		if ($entries->count() <= 0) {
			return [];
		}
		
		$tab = [];
		foreach ($entries as $entry) {
			$tab[$entry->tid] = $entry->name;
			
			$subEntries = Category::trans()->where('parent_id', $entry->id)->orderBy('lft')->get();
			if ($subEntries->count() > 0) {
				foreach ($subEntries as $subEntry) {
					$tab[$subEntry->tid] = "---| " . $subEntry->name;
				}
			}
		}
		
		return $tab;
	}
}

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
use App\Http\Requests\Admin\FieldOptionRequest as StoreRequest;
use App\Http\Requests\Admin\FieldOptionRequest as UpdateRequest;

class FieldOptionController extends PanelController
{
	private $fieldId = null;
	
	public function setup()
	{
		// Get the Custom Field's ID
		$this->fieldId = request()->segment(3);
		
		// Get the Custom Field's name
		$field = Field::findTransOrFail($this->fieldId);
		
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\FieldOption');
		$this->xPanel->setRoute(admin_uri('custom_fields/' . $field->id . '/options'));
		$this->xPanel->setEntityNameStrings(
			trans('admin::messages.option') . ' &rarr; ' . '<strong>' . $field->name . '</strong>',
			trans('admin::messages.options') . ' &rarr; ' . '<strong>' . $field->name . '</strong>'
		);
		$this->xPanel->enableReorder('value', 1);
		$this->xPanel->enableDetailsRow();
		if (!request()->input('order')) {
			$this->xPanel->orderBy('lft', 'ASC');
		}
		
		$this->xPanel->enableParentEntity();
		$this->xPanel->setParentKeyField('field_id');
		$this->xPanel->addClause('where', 'field_id', '=', $field->id);
		$this->xPanel->setParentRoute(admin_uri('custom_fields'));
		$this->xPanel->setParentEntityNameStrings(trans('admin::messages.custom field'), trans('admin::messages.custom fields'));
		$this->xPanel->allowAccess(['reorder', 'details_row', 'parent']);
		
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
		$this->xPanel->addColumn([
			'name'  => 'value',
			'label' => trans("admin::messages.Value"),
		]);
		
		
		// FIELDS
		$this->xPanel->addField([
			'name'  => 'field_id',
			'type'  => 'hidden',
			'value' => $this->fieldId,
		], 'create');
		$this->xPanel->addField([
			'name'       => 'value',
			'label'      => trans("admin::messages.Value"),
			'type'       => 'text',
			'attributes' => [
				'placeholder' => trans("admin::messages.Value"),
			],
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
}

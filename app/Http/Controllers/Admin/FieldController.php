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

use Larapen\Admin\app\Http\Controllers\PanelController;
use App\Http\Requests\Admin\FieldRequest as StoreRequest;
use App\Http\Requests\Admin\FieldRequest as UpdateRequest;

class FieldController extends PanelController
{
	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\Field');
		
		$this->xPanel->setRoute(admin_uri('custom_fields'));
		$this->xPanel->setEntityNameStrings(trans('admin::messages.custom field'), trans('admin::messages.custom fields'));
		$this->xPanel->enableDetailsRow();
		$this->xPanel->allowAccess(['details_row']);
		
		$this->xPanel->addButtonFromModelFunction('top', 'bulk_delete_btn', 'bulkDeleteBtn', 'end');
		$this->xPanel->addButtonFromModelFunction('line', 'add_to_category', 'addToCategoryBtn', 'end');
		$this->xPanel->addButtonFromModelFunction('line', 'options', 'optionsBtn', 'end');
		
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
			'name'          => 'name',
			'label'         => trans("admin::messages.Name"),
			'type'          => 'model_function',
			'function_name' => 'getNameHtml',
		]);
		$this->xPanel->addColumn([
			'name'  => 'type',
			'label' => trans("admin::messages.Type"),
		]);
		$this->xPanel->addColumn([
			'name'          => 'active',
			'label'         => trans("admin::messages.Active"),
			'type'          => 'model_function',
			'function_name' => 'getActiveHtml',
			'on_display'    => 'checkbox',
		]);
		
		
		// FIELDS
		$this->xPanel->addField([
			'name'  => 'belongs_to',
			'type'  => 'hidden',
			'value' => 'posts',
		]);
		$this->xPanel->addField([
			'name'       => 'name',
			'label'      => trans("admin::messages.Name"),
			'type'       => 'text',
			'attributes' => [
				'placeholder' => trans("admin::messages.Name"),
			],
		]);
		$this->xPanel->addField([
			'name'  => 'type',
			'label' => trans("admin::messages.Type"),
			'type'  => 'enum',
		]);
		$this->xPanel->addField([
			'name'       => 'max',
			'label'      => trans("admin::messages.Field Length"),
			'type'       => 'text',
			'attributes' => [
				'placeholder' => trans("admin::messages.Field Length"),
			],
		]);
		$this->xPanel->addField([
			'name'       => 'default',
			'label'      => trans("admin::messages.Default value"),
			'type'       => 'text',
			'attributes' => [
				'placeholder' => trans("admin::messages.Default value"),
			],
		]);
		$this->xPanel->addField([
			'name'  => 'required',
			'label' => trans("admin::messages.Required"),
			'type'  => 'checkbox',
		]);
		$this->xPanel->addField([
			'name'  => 'active',
			'label' => trans("admin::messages.Active"),
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
}

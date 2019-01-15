<?php
/**
 * LaraClassified - Geo Classified Ads CMS
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

use App\Models\Traits\ActiveTrait;
use App\Models\Traits\VerifiedTrait;
use Illuminate\Database\Eloquent\Model;
use Prologue\Alerts\Facades\Alert;

class BaseModel extends Model
{
	use ActiveTrait, VerifiedTrait;
	
	public static $msg = 'This feature has been turned off in demo mode.';
	
	/**
	 * BaseModel constructor.
	 * @param array $attributes
	 */
	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
	}
	
	/**
	 * @param array $attributes
	 * @return $this|bool|Model
	 */
	public static function create(array $attributes = [])
	{
		if (isDemo()) {
			self::$msg = t(self::$msg);
			
			if (isFromAdminPanel()) {
				Alert::info(self::$msg)->flash();
			} else {
				flash(self::$msg)->info();
			}
			
			return false;
		} else {
			return static::query()->create($attributes);
		}
	}
	
	/**
	 * @param array $attributes
	 * @param array $options
	 * @return bool
	 */
	public function update(array $attributes = [], array $options = [])
	{
		if (!$this->exists) {
			return false;
		}
		
		if (isDemo()) {
			if (isset($options['canBeUpdated']) && $options['canBeUpdated'] == true) {
				unset($options['canBeUpdated']);
				return $this->fill($attributes)->save($options);
			}
			
			self::$msg = t(self::$msg);
			
			if (isFromAdminPanel()) {
				Alert::info(self::$msg)->flash();
			} else {
				flash(self::$msg)->info();
			}
			
			return false;
		} else {
			return $this->fill($attributes)->save($options);
		}
	}
	
	/**
	 * @param array $options
	 * @return bool
	 */
	public function save(array $options = [])
	{
		if (isDemo()) {
			if (isset($options['canBeSaved']) && $options['canBeSaved'] == true) {
				unset($options['canBeSaved']);
				return parent::save($options);
			}
			
			self::$msg = t(self::$msg);
			
			if (isFromAdminPanel()) {
				Alert::info(self::$msg)->flash();
			} else {
				flash(self::$msg)->info();
			}
			
			return false;
		} else {
			return parent::save($options);
		}
	}
	
	/**
	 * @return bool|null
	 * @throws \Exception
	 */
	public function delete()
	{
		if (isDemo()) {
			self::$msg = t(self::$msg);
			
			if (isFromAdminPanel()) {
				Alert::info(self::$msg)->flash();
			} else {
				flash(self::$msg)->info();
			}
			
			return false;
		} else {
			return parent::delete();
		}
	}
}

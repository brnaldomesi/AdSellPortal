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

use App\Observer\SettingObserver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Larapen\Admin\app\Models\Crud;
use Prologue\Alerts\Facades\Alert;

class Setting extends BaseModel
{
	use Crud;
	
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'settings';
	
	protected $fakeColumns = ['value'];
	
	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id';
	
	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var boolean
	 */
	public $timestamps = false;
	
	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	protected $guarded = ['id'];
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id', 'key', 'name', 'value', 'description', 'field', 'parent_id', 'lft', 'rgt', 'depth', 'active'];
	
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
	
	protected $casts = [
		'value' => 'array',
	];
	
	/*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/
	protected static function boot()
	{
		parent::boot();
		
		Setting::observe(SettingObserver::class);
	}
	
	public function getNameHtml()
	{
		$currentUrl = preg_replace('#/(search)$#', '', url()->current());
		$url = $currentUrl . '/' . $this->getKey() . '/edit';
		
		$out = '<a href="' . $url . '">' . $this->name . '</a>';
		
		return $out;
	}
	
	public function configureBtn($xPanel = false)
	{
		$url = admin_url('settings/' . $this->id . '/edit');
		
		$msg = trans('admin::messages.Configure :entity', ['entity' => $this->name]);
		$tooltip = ' data-toggle="tooltip" title="' . $msg . '"';
		
		$out = '';
		$out .= '<a class="btn btn-xs btn-primary" href="' . $url . '"' . $tooltip . '>';
		$out .= '<i class="fa fa-cog"></i> ';
		$out .= mb_ucfirst(trans('admin::messages.Configure'));
		$out .= '</a>';
		
		return $out;
	}
	
	/*
	|--------------------------------------------------------------------------
	| SCOPES
	|--------------------------------------------------------------------------
	*/
	public function scopeActive($builder)
	{
		return $builder->where('active', 1);
	}
	
	/*
	|--------------------------------------------------------------------------
	| ACCESSORS
	|--------------------------------------------------------------------------
	*/
	public function getValueAttribute($value)
	{
		// Hide all these fake field content
		$hiddenValues = [
			'recaptcha_site_key',
			'recaptcha_secret_key',
			'mail_password',
			'mailgun_secret',
			'mandrill_secret',
			'ses_key',
			'ses_secret',
			'sparkpost_secret',
			'stripe_secret',
			'paypal_username',
			'paypal_password',
			'paypal_signature',
			'facebook_client_id',
			'facebook_client_secret',
			'linkedin_client_id',
			'linkedin_client_secret',
			'twitter_client_id',
			'twitter_client_secret',
			'google_client_id',
			'google_client_secret',
			'google_maps_key',
			'fixer_access_key',
			'currency_layer_access_key',
			'open_exchange_rates_app_id',
			'currency_data_feed_api_key',
			'forge_api_key',
			'xignite_token',
		];
		
		// Get 'value' field value
		$value = jsonToArray($value);
		
		// Handle 'value' field value
		if (!empty($value)) {
			// Get Entered values (Or Default values if the Entry doesn't exist)
			if ($this->key == 'app') {
				foreach ($value as $key => $item) {
					if ($key == 'logo') {
						$value['logo'] = str_replace('uploads/', '', $value['logo']);
						if (!Storage::exists($value['logo'])) {
							$value[$key] = config('larapen.core.logo');
						}
					}
					
					if ($key == 'favicon') {
						if (!Storage::exists($value['favicon'])) {
							$value[$key] = config('larapen.core.favicon');
						}
					}
				}
				if (!isset($value['purchase_code'])) {
					$value['purchase_code'] = env('PURCHASE_CODE', '');
				}
				if (!isset($value['app_name'])) {
					$value['app_name'] = config('app.name');
				}
				if (!isset($value['logo'])) {
					$value['logo'] = config('larapen.core.logo');
				}
				if (!isset($value['favicon'])) {
					$value['favicon'] = config('larapen.core.favicon');
				}
				if (!isset($value['auto_detect_language'])) {
					$value['auto_detect_language'] = '0';
				}
				if (!isset($value['default_date_format'])) {
					$value['default_date_format'] = config('larapen.core.defaultDateFormat');
				}
				if (!isset($value['default_datetime_format'])) {
					$value['default_datetime_format'] = config('larapen.core.defaultDatetimeFormat');
				}
				if (!isset($value['default_timezone'])) {
					$value['default_timezone'] = config('larapen.core.defaultTimezone');
				}
				if (!isset($value['show_countries_charts'])) {
					$value['show_countries_charts'] = '1';
				}
			}
			
			if ($this->key == 'style') {
				foreach ($value as $key => $item) {
					if ($key == 'body_background_image') {
						if (!Storage::exists($value['body_background_image'])) {
							$value[$key] = null;
						}
					}
				}
				if (!isset($value['app_skin'])) {
					$value['app_skin'] = 'skin-default';
				}
				if (!isset($value['header_bottom_border_width'])) {
					$value['header_bottom_border_width'] = '1px';
				}
				if (!isset($value['header_bottom_border_color'])) {
					$value['header_bottom_border_color'] = '#e8e8e8';
				}
				if (!isset($value['admin_skin'])) {
					$value['admin_skin'] = 'skin-blue';
				}
			}
			
			if ($this->key == 'listing') {
				if (!isset($value['display_mode'])) {
					$value['display_mode'] = '.grid-view';
				}
				if (!isset($value['items_per_page'])) {
					$value['items_per_page'] = '12';
				}
				if (!isset($value['left_sidebar'])) {
					$value['left_sidebar'] = '1';
				}
				if (!isset($value['cities_extended_searches'])) {
					$value['cities_extended_searches'] = '1';
				}
				if (!isset($value['search_distance_max'])) {
					$value['search_distance_max'] = '500';
				}
				if (!isset($value['search_distance_default'])) {
					$value['search_distance_default'] = '50';
				}
				if (!isset($value['search_distance_interval'])) {
					$value['search_distance_interval'] = '100';
				}
			}
			
			if ($this->key == 'single') {
				if (!isset($value['publication_form_type'])) {
					$value['publication_form_type'] = '1';
				}
				if (!isset($value['picture_mandatory'])) {
					$value['picture_mandatory'] = '1';
				}
				if (!isset($value['pictures_limit'])) {
					$value['pictures_limit'] = '5';
				}
				if (!isset($value['tags_limit'])) {
					$value['tags_limit'] = '15';
				}
				if (!isset($value['guests_can_post_ads'])) {
					$value['guests_can_post_ads'] = '1';
				}
				if (!isset($value['guests_can_contact_ads_authors'])) {
					$value['guests_can_contact_ads_authors'] = '1';
				}
				if (!isset($value['auto_registration'])) {
					$value['auto_registration'] = '0';
				}
				if (!isset($value['simditor_wysiwyg'])) {
					$value['simditor_wysiwyg'] = '1';
				}
			}
			
			if ($this->key == 'upload') {
				if (!isset($value['image_types'])) {
					$value['image_types'] = 'jpg,jpeg,gif,png';
				}
				if (!isset($value['file_types'])) {
					$value['file_types'] = 'pdf,doc,docx,word,rtf,rtx,ppt,pptx,odt,odp,wps,jpeg,jpg,bmp,png';
				}
				if (!isset($value['max_file_size'])) {
					$value['max_file_size'] = '2500';
				}
			}
			
			if ($this->key == 'geo_location') {
				if (!isset($value['country_flag_activation'])) {
					$value['country_flag_activation'] = '1';
				}
			}
			
			if ($this->key == 'security') {
				if (!isset($value['login_open_in_modal'])) {
					$value['login_open_in_modal'] = '1';
				}
				if (!isset($value['login_max_attempts'])) {
					$value['login_max_attempts'] = '5';
				}
				if (!isset($value['login_decay_minutes'])) {
					$value['login_decay_minutes'] = '15';
				}
				if (!isset($value['recaptcha_version'])) {
					$value['recaptcha_version'] = 'v2';
				}
				
				// Get reCAPTCHA old config values
				if (isset($value['recaptcha_public_key'])) {
					$value['recaptcha_site_key'] = $value['recaptcha_public_key'];
				}
				if (isset($value['recaptcha_private_key'])) {
					$value['recaptcha_secret_key'] = $value['recaptcha_private_key'];
				}
			}
			
			if ($this->key == 'social_link') {
				if (!isset($value['facebook_page_url'])) {
					$value['facebook_page_url'] = '';
				}
				if (!isset($value['twitter_url'])) {
					$value['twitter_url'] = '';
				}
				if (!isset($value['google_plus_url'])) {
					$value['google_plus_url'] = '';
				}
				if (!isset($value['linkedin_url'])) {
					$value['linkedin_url'] = '';
				}
				if (!isset($value['pinterest_url'])) {
					$value['pinterest_url'] = '';
				}
				if (!isset($value['instagram_url'])) {
					$value['instagram_url'] = '';
				}
			}
			
			if ($this->key == 'optimization') {
				if (!isset($value['cache_driver'])) {
					$value['cache_driver'] = 'file';
				}
				if (!isset($value['cache_expiration'])) {
					$value['cache_expiration'] = '1440';
				}
				if (!isset($value['memcached_servers_1_host'])) {
					$value['memcached_servers_1_host'] = '127.0.0.1';
				}
				if (!isset($value['memcached_servers_1_port'])) {
					$value['memcached_servers_1_port'] = '11211';
				}
				if (!isset($value['redis_client'])) {
					$value['redis_client'] = 'predis';
				}
				if (!isset($value['redis_cluster'])) {
					$value['redis_cluster'] = 'predis';
				}
				if (!isset($value['redis_host'])) {
					$value['redis_host'] = '127.0.0.1';
				}
				if (!isset($value['redis_password'])) {
					$value['redis_password'] = null;
				}
				if (!isset($value['redis_port'])) {
					$value['redis_port'] = '6379';
				}
				if (!isset($value['redis_database'])) {
					$value['redis_database'] = '0';
				}
			}
			
			if ($this->key == 'seo') {
				if (!isset($value['posts_permalink'])) {
					$value['posts_permalink'] = '{slug}/{id}';
				}
				if (!isset($value['posts_permalink_ext'])) {
					if (is_null($value['posts_permalink_ext'])) {
						$value['posts_permalink_ext'] = '';
					} else {
						$value['posts_permalink_ext'] = '.html';
					}
				}
				if (!isset($value['multi_countries_urls'])) {
					$value['multi_countries_urls'] = config('larapen.core.multiCountriesUrls');
				}
			}
			
			if ($this->key == 'other') {
				if (!isset($value['cookie_consent_enabled'])) {
					$value['cookie_consent_enabled'] = '0';
				}
				if (!isset($value['show_tips_messages'])) {
					$value['show_tips_messages'] = '1';
				}
				if (!isset($value['timer_new_messages_checking'])) {
					$value['timer_new_messages_checking'] = 60000;
				}
				if (!isset($value['simditor_wysiwyg'])) {
					$value['simditor_wysiwyg'] = '1';
				}
				if (!isset($value['cookie_expiration'])) {
					$value['cookie_expiration'] = '86400';
				}
			}
			
			if ($this->key == 'cron') {
				if (!isset($value['unactivated_posts_expiration'])) {
					$value['unactivated_posts_expiration'] = '30';
				}
				if (!isset($value['activated_posts_expiration'])) {
					$value['activated_posts_expiration'] = '90';
				}
				if (!isset($value['archived_posts_expiration'])) {
					$value['archived_posts_expiration'] = '30';
				}
				if (!isset($value['manually_archived_posts_expiration'])) {
					$value['manually_archived_posts_expiration'] = '180';
				}
			}
			
			if ($this->key == 'footer') {
				if (!isset($value['hide_payment_plugins_logos'])) {
					$value['hide_payment_plugins_logos'] = '1';
				}
			}
			
			if ($this->key == 'watermark') {
				if (!isset($value['width'])) {
					$value['width'] = '150';
				}
				if (!isset($value['height'])) {
					$value['height'] = '150';
				}
				if (!isset($value['position'])) {
					$value['position'] = 'bottom-right';
				}
				if (!isset($value['position_x'])) {
					$value['position_x'] = '20';
				}
				if (!isset($value['position_y'])) {
					$value['position_y'] = '20';
				}
			}
			
			if ($this->key == 'currency_exchange') {
				if (!isset($value['activation'])) {
					$value['activation'] = '1';
				}
				if (!isset($value['currencies'])) {
					$value['currencies'] = 'USD,EUR';
				}
				if (!isset($value['cache_ttl'])) {
					$value['cache_ttl'] = '86400';
				}
				if (!isset($value['european_central_bank'])) {
					$value['european_central_bank'] = '1';
				}
				if (!isset($value['national_bank_of_romania'])) {
					$value['national_bank_of_romania'] = '1';
				}
				if (!isset($value['central_bank_of_republic_turkey'])) {
					$value['central_bank_of_republic_turkey'] = '1';
				}
				if (!isset($value['central_bank_of_czech_republic'])) {
					$value['central_bank_of_czech_republic'] = '1';
				}
				if (!isset($value['russian_central_bank'])) {
					$value['russian_central_bank'] = '1';
				}
				if (!isset($value['webservicex'])) {
					$value['webservicex'] = '1';
				}
				if (!isset($value['google'])) {
					$value['google'] = '1';
				}
				if (!isset($value['cryptonator'])) {
					$value['cryptonator'] = '1';
				}
			}
			
			if ($this->key == 'domain_mapping') {
				if (!isset($value['share_session'])) {
					$value['share_session'] = '1';
				}
			}
			
			// Demo: Secure some Data (Applied for all Entries)
			if (isFromAdminPanel() && isDemo()) {
				foreach ($value as $key => $item) {
					if (!in_array(request()->segment(2), ['password', 'login'])) {
						if (in_array($key, $hiddenValues)) {
							$value[$key] = '************************';
						}
					}
				}
			}
		} else {
			if (isset($this->key)) {
				// Get Default values
				$value = [];
				if ($this->key == 'app') {
					$value['purchase_code'] = env('PURCHASE_CODE', '');
					$value['app_name'] = config('app.name');
					$value['logo'] = config('larapen.core.logo');
					$value['favicon'] = config('larapen.core.favicon');
					$value['auto_detect_language'] = '0';
					$value['default_date_format'] = config('larapen.core.defaultDateFormat');
					$value['default_datetime_format'] = config('larapen.core.defaultDatetimeFormat');
					$value['default_timezone'] = config('larapen.core.defaultTimezone');
					$value['show_countries_charts'] = '1';
				}
				if ($this->key == 'style') {
					$value['app_skin'] = 'skin-default';
					$value['header_bottom_border_width'] = '1px';
					$value['header_bottom_border_color'] = '#e8e8e8';
					$value['admin_skin'] = 'skin-blue';
				}
				if ($this->key == 'listing') {
					$value['display_mode'] = '.grid-view';
					$value['items_per_page'] = '12';
					$value['left_sidebar'] = '1';
					$value['cities_extended_searches'] = '1';
					$value['search_distance_max'] = '500';
					$value['search_distance_default'] = '50';
					$value['search_distance_interval'] = '100';
				}
				if ($this->key == 'single') {
					$value['publication_form_type'] = '1';
					$value['picture_mandatory'] = '1';
					$value['pictures_limit'] = '5';
					$value['tags_limit'] = '15';
					$value['guests_can_post_ads'] = '1';
					$value['guests_can_contact_ads_authors'] = '1';
					$value['auto_registration'] = '0';
					$value['simditor_wysiwyg'] = '1';
				}
				if ($this->key == 'upload') {
					$value['image_types'] = 'jpg,jpeg,gif,png';
					$value['file_types'] = 'pdf,doc,docx,word,rtf,rtx,ppt,pptx,odt,odp,wps,jpeg,jpg,bmp,png';
					$value['max_file_size'] = '2500';
				}
				if ($this->key == 'geo_location') {
					$value['country_flag_activation'] = '1';
				}
				if ($this->key == 'security') {
					$value['login_open_in_modal'] = '1';
					$value['login_max_attempts'] = '5';
					$value['login_decay_minutes'] = '15';
					$value['recaptcha_version'] = 'v2';
				}
				if ($this->key == 'social_link') {
					$value['facebook_page_url'] = '#';
					$value['twitter_url'] = '#';
					$value['google_plus_url'] = '#';
					$value['linkedin_url'] = '#';
					$value['pinterest_url'] = '#';
					$value['instagram_url'] = '#';
				}
				if ($this->key == 'optimization') {
					$value['cache_driver'] = 'file';
					$value['cache_expiration'] = '1440';
					$value['memcached_servers_1_host'] = '127.0.0.1';
					$value['memcached_servers_1_port'] = '11211';
					$value['redis_client'] = 'predis';
					$value['redis_cluster'] = 'predis';
					$value['redis_host'] = '127.0.0.1';
					$value['redis_password'] = null;
					$value['redis_port'] = '6379';
					$value['redis_database'] = '0';
				}
				if ($this->key == 'seo') {
					$value['posts_permalink'] = '{slug}/{id}';
					$value['posts_permalink_ext'] = '';
					$value['multi_countries_urls'] = config('larapen.core.multiCountriesUrls');
				}
				if ($this->key == 'other') {
					$value['cookie_consent_enabled'] = '0';
					$value['show_tips_messages'] = '1';
					$value['timer_new_messages_checking'] = 60000;
					$value['simditor_wysiwyg'] = '1';
					$value['cookie_expiration'] = '86400';
				}
				if ($this->key == 'cron') {
					$value['unactivated_posts_expiration'] = '30';
					$value['activated_posts_expiration'] = '90';
					$value['archived_posts_expiration'] = '30';
					$value['manually_archived_posts_expiration'] = '180';
				}
				if ($this->key == 'footer') {
					$value['hide_payment_plugins_logos'] = '1';
				}
				if ($this->key == 'watermark') {
					$value['width'] = '150';
					$value['height'] = '150';
					$value['position'] = 'bottom-right';
					$value['position_x'] = '20';
					$value['position_y'] = '20';
				}
				if ($this->key == 'currency_exchange') {
					$value['activation'] = '1';
					$value['currencies'] = 'USD,EUR';
					$value['cache_ttl'] = '86400';
					$value['european_central_bank'] = '1';
					$value['national_bank_of_romania'] = '1';
					$value['central_bank_of_republic_turkey'] = '1';
					$value['central_bank_of_czech_republic'] = '1';
					$value['russian_central_bank'] = '1';
					$value['webservicex'] = '1';
					$value['google'] = '1';
					$value['cryptonator'] = '1';
				}
				if ($this->key == 'domain_mapping') {
					$value['share_session'] = '1';
				}
			}
		}
		
		// During the Cache variable updating from the Admin panel,
		// Check if the /.env file's cache configuration variables are different to the DB value,
		// If so, then display the right value from the /.env file.
		if (isset($this->key) && $this->key == 'optimization' && is_array($value)) {
			if (Str::contains(\Route::currentRouteAction(), 'Admin\SettingController@edit')) {
				if (array_key_exists('cache_driver', $value) && getenv('CACHE_DRIVER')) {
					if ($value['cache_driver'] != env('CACHE_DRIVER')) {
						$value['cache_driver'] = env('CACHE_DRIVER');
					}
				}
				if (array_key_exists('memcached_servers_1_host', $value) && getenv('MEMCACHED_SERVER_1_HOST')) {
					if ($value['memcached_servers_1_host'] != env('MEMCACHED_SERVER_1_HOST')) {
						$value['memcached_servers_1_host'] = env('MEMCACHED_SERVER_1_HOST');
					}
				}
				if (array_key_exists('memcached_servers_1_port', $value) && getenv('MEMCACHED_SERVER_1_PORT')) {
					if ($value['memcached_servers_1_port'] != env('MEMCACHED_SERVER_1_PORT')) {
						$value['memcached_servers_1_port'] = env('MEMCACHED_SERVER_1_PORT');
					}
				}
				if (array_key_exists('redis_client', $value) && getenv('REDIS_CLIENT')) {
					if ($value['redis_client'] != env('REDIS_CLIENT')) {
						$value['redis_client'] = env('REDIS_CLIENT');
					}
				}
				if (array_key_exists('redis_cluster', $value) && getenv('REDIS_CLUSTER')) {
					if ($value['redis_cluster'] != env('REDIS_CLUSTER')) {
						$value['redis_cluster'] = env('REDIS_CLUSTER');
					}
				}
				if (array_key_exists('redis_host', $value) && getenv('REDIS_HOST')) {
					if ($value['redis_host'] != env('REDIS_HOST')) {
						$value['redis_host'] = env('REDIS_HOST');
					}
				}
				if (array_key_exists('redis_password', $value) && getenv('REDIS_PASSWORD')) {
					if ($value['redis_password'] != env('REDIS_PASSWORD')) {
						$value['redis_password'] = env('REDIS_PASSWORD');
					}
				}
				if (array_key_exists('redis_port', $value) && getenv('REDIS_PORT')) {
					if ($value['redis_port'] != env('REDIS_PORT')) {
						$value['redis_port'] = env('REDIS_PORT');
					}
				}
				if (array_key_exists('redis_database', $value) && getenv('REDIS_DB')) {
					if ($value['redis_database'] != env('REDIS_DB')) {
						$value['redis_database'] = env('REDIS_DB');
					}
				}
			}
		}
		
		return $value;
	}
	
	/*
	|--------------------------------------------------------------------------
	| MUTATORS
	|--------------------------------------------------------------------------
	*/
	public function setValueAttribute($value)
	{
		$value = jsonToArray($value);
		
		// Logo
		if (isset($value['logo'])) {
			$logo = [
				'attribute' => 'logo',
				'path'      => 'app/logo',
				'default'   => config('larapen.core.logo'),
				'width'     => 454,
				'height'    => 80,
				'upsize'    => true,
				'quality'   => 100,
				'filename'  => 'logo-',
				'orientate' => false,
			];
			$value = $this->upload($value, $logo);
		}
		
		// Favicon
		if (isset($value['favicon'])) {
			$favicon = [
				'attribute' => 'favicon',
				'path'      => 'app/ico',
				'default'   => config('larapen.core.favicon'),
				'width'     => 32,
				'height'    => 32,
				'upsize'    => false,
				'quality'   => 100,
				'filename'  => 'ico-',
				'orientate' => false,
			];
			$value = $this->upload($value, $favicon);
		}
		
		// Body Background Image
		if (isset($value['body_background_image'])) {
			$bodyBackgroundImage = [
				'attribute' => 'body_background_image',
				'path'      => 'app/logo',
				'default'   => null,
				'width'     => 2000,
				'height'    => 2000,
				'upsize'    => true,
				'quality'   => 100,
				'filename'  => 'body-background-',
				'orientate' => false,
			];
			$value = $this->upload($value, $bodyBackgroundImage);
		}
		
		// Check and Get Plugins settings vars
		$value = plugin_set_setting_value($value, $this);
		
		$this->attributes['value'] = json_encode($value);
	}
	
	// Set Upload
	private function upload($value, $params)
	{
		$attribute_name = $params['attribute'];
		$destination_path = $params['path'];
		
		// If 'logo' value doesn't exist, don't make the upload and save data
		if (!isset($value[$attribute_name])) {
			return $value;
		}
		
		// If the image was erased
		if (empty($value[$attribute_name])) {
			// Delete the image from disk
			if (isset($this->value) && isset($this->value[$attribute_name])) {
				if (!empty($params['default'])) {
					if (!Str::contains($this->value[$attribute_name], $params['default'])) {
						Storage::delete($this->value[$attribute_name]);
					}
				} else {
					Storage::delete($this->value[$attribute_name]);
				}
			}
			
			// Set null in the database column
			$value[$attribute_name] = null;
			
			return $value;
		}
		
		// If laravel request->file('filename') resource OR base64 was sent, store it in the db
		try {
			if (fileIsUploaded($value[$attribute_name])) {
				// Get file extension
				$extension = getUploadedFileExtension($value[$attribute_name]);
				if (empty($extension)) {
					$extension = 'jpg';
				}
				
				// Check if 'Auto Orientate' is enabled
				$autoOrientateIsEnabled = false;
				if (isset($params['orientate']) && $params['orientate']) {
					$autoOrientateIsEnabled = exifExtIsEnabled();
				}
				
				// Make the Image
				if ($autoOrientateIsEnabled) {
					$image = Image::make($value[$attribute_name])->orientate()->resize($params['width'], $params['height'], function ($constraint) use ($params) {
						$constraint->aspectRatio();
						if ($params['upsize']) {
							$constraint->upsize();
						}
					})->encode($extension, $params['quality']);
				} else {
					$image = Image::make($value[$attribute_name])->resize($params['width'], $params['height'], function ($constraint) use ($params) {
						$constraint->aspectRatio();
						if ($params['upsize']) {
							$constraint->upsize();
						}
					})->encode($extension, $params['quality']);
				}
				
				// Generate a filename.
				$filename = uniqid($params['filename']) . '.' . $extension;
				
				// Store the image on disk.
				Storage::put($destination_path . '/' . $filename, $image->stream());
				
				// Save the path to the database
				$value[$attribute_name] = $destination_path . '/' . $filename;
			} else {
				// Retrieve current value without upload a new file.
				if (!empty($params['default'])) {
					if (Str::contains($value[$attribute_name], $params['default'])) {
						$value[$attribute_name] = null;
					} else {
						if (!Str::startsWith($value[$attribute_name], $destination_path)) {
							$value[$attribute_name] = $destination_path . last(explode($destination_path, $value[$attribute_name]));
						}
					}
				} else {
					if ($value[$attribute_name] == url('/')) {
						$value[$attribute_name] = null;
					} else {
						if (!Str::startsWith($value[$attribute_name], $destination_path)) {
							$value[$attribute_name] = $destination_path . last(explode($destination_path, $value[$attribute_name]));
						}
					}
				}
			}
			
			return $value;
		} catch (\Exception $e) {
			Alert::error($e->getMessage())->flash();
			
			$value[$attribute_name] = null;
			
			return $value;
		}
	}
	
	public function getFieldAttribute($value)
	{
		$breadcrumb = trans('admin::messages.Admin panel') . ' &rarr; '
			. mb_ucwords(trans('admin::messages.setup')) . ' &rarr; '
			. mb_ucwords(trans('admin::messages.general settings')) . ' &rarr; ';
		
		$formTitle = '{"name":"group_name","type":"custom_html","value":"<h2 class=\"setting-group-name\">' . $this->name . '</h2>","disableTrans":"true"},
	{"name":"group_breadcrumb","type":"custom_html","value":"<p class=\"setting-group-breadcrumb\">' . $breadcrumb . $this->name . '</p>","disableTrans":"true"},';
		
		
		if ($this->key == 'app') {
			$value = '{"name":"separator_1","type":"custom_html","value":"<h3>Brand Info</h3>"},
	{"name":"purchase_code","label":"Purchase Code","type":"text","hint":"find_my_purchase_code"},
	{"name":"app_name","label":"App Name","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"slogan","label":"App Slogan","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"logo","label":"App Logo","type":"image","upload":"true","disk":"public","default":"app/default/logo.png","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"favicon","label":"Favicon","type":"image","upload":"true","disk":"public","default":"app/default/ico/favicon.png","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"separator_clear_1","type":"custom_html","value":"<div style=\"clear: both;\"></div>"},
	{"name":"email","label":"Email","type":"email","hint":"The email address that all emails from the contact form will go to.","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"phone_number","label":"Phone number","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"language_auto_detection_sep","type":"custom_html","value":"language_auto_detection_sep_value"},
	{"name":"auto_detect_language","label":"auto_detect_language_label","type":"select2_from_array","options":{"0":"' . trans('admin::messages.auto_detect_language_option_0') . '","1":"' . trans('admin::messages.auto_detect_language_option_1') . '","2":"' . trans('admin::messages.auto_detect_language_option_2') . '"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"auto_detect_language_warning_sep","type":"custom_html","value":"auto_detect_language_warning_sep_value"},
	
	{"name":"separator_2","type":"custom_html","value":"<h3>Date Format</h3>"},
	{"name":"default_date_format","label":"Date Format","type":"text","hint":"The implementation makes a call to <a href=\"http://php.net/strftime\" target=\"_blank\">strftime</a> using the current instance timestamp.","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"default_datetime_format","label":"Date Time Format","type":"text","hint":"The implementation makes a call to <a href=\"http://php.net/strftime\" target=\"_blank\">strftime</a> using the current instance timestamp.","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"default_timezone","label":"Default Timezone","type":"select2","attribute":"time_zone_id","key":"time_zone_id","model":"\\\App\\\Models\\\TimeZone","hint":"NOTE: This option is used in the Admin panel","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"date_force_utf8","label":"Force UTF-8 encoding for Dates","type":"checkbox","hint":"date_force_utf8_hint","wrapperAttributes":{"class":"form-group col-md-6","style":"margin-top: 20px;"}},
	
	{"name":"separator_3","type":"custom_html","value":"settings_app_dashboard_h3"},
	{"name":"show_countries_charts","label":"show_countries_charts_label","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6","style":"margin-top: 20px;"}},
	{"name":"latest_entries_limit","label":"settings_app_latest_entries_limit_label","type":"select2_from_array","options":{"5":"5","10":"10","15":"15","20":"20","25":"25"},"wrapperAttributes":{"class":"form-group col-md-6"}}';
		}
		
		if ($this->key == 'style') {
			$value = '{"name":"separator_1","type":"custom_html","value":"<h3>Front-End</h3>"},
	{"name":"app_skin","label":"Front Skin","type":"select2_from_array","options":{"skin-default":"Default","skin-blue":"Blue","skin-yellow":"Yellow","skin-green":"Green","skin-red":"Red"}},
	
	{"name":"separator_2","type":"custom_html","value":"<h4>Customize the Front Style</h4>"},
	{"name":"separator_2_1","type":"custom_html","value":"<h5><strong>Global</strong></h5>"},
	{"name":"body_background_color","label":"Body Background Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#FFFFFF"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"body_text_color","label":"Body Text Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#292B2C"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"body_background_image","label":"Body Background Image","type":"image","upload":"true","disk":"public","default":"","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"separator_clear_1","type":"custom_html","value":"<div style=\"clear: both;\"></div>"},
	{"name":"body_background_image_fixed","label":"Body Background Image Fixed","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6","style":"margin-top: 20px;"}},
	{"name":"page_width","label":"Page Width","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"separator_clear_2","type":"custom_html","value":"<div style=\"clear: both;\"></div>"},
	{"name":"title_color","label":"Titles Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#292B2C"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"progress_background_color","label":"Progress Background Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":""},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"link_color","label":"Links Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#4682B4"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"link_color_hover","label":"Links Color (Hover)","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#FF8C00"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_2_2","type":"custom_html","value":"<h5><strong>Header</strong></h5>"},
	{"name":"header_sticky","label":"Header Sticky","type":"checkbox"},
	{"name":"header_height","label":"Header Height","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"header_background_color","label":"Header Background Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#F8F8F8"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"header_bottom_border_width","label":"Header Bottom Border Width","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"header_bottom_border_color","label":"Header Bottom Border Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#E8E8E8"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"header_link_color","label":"Header Links Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#333"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"header_link_color_hover","label":"Header Links Color (Hover)","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#000"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_2_3","type":"custom_html","value":"<h5><strong>Footer</strong></h5>"},
	{"name":"footer_background_color","label":"Footer Background Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#F5F5F5"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"footer_text_color","label":"Footer Text Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#333"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"footer_title_color","label":"Footer Titles Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#000"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"separator_clear_2","type":"custom_html","value":"<div style=\"clear: both;\"></div>"},
	{"name":"footer_link_color","label":"Footer Links Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#333"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"footer_link_color_hover","label":"Footer Links Color (Hover)","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#333"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"payment_icon_top_border_width","label":"Payment Methods Icons Top Border Width","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"payment_icon_top_border_color","label":"Payment Methods Icons Top Border Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#DDD"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"payment_icon_bottom_border_width","label":"Payment Methods Icons Bottom Border Width","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"payment_icon_bottom_border_color","label":"Payment Methods Icons Bottom Border Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#DDD"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_2_4","type":"custom_html","value":"<h5><strong>Button \'Add Listing\'</strong></h5>"},
	{"name":"btn_post_bg_top_color","label":"Gradient Background Top Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#ffeb43"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"btn_post_bg_bottom_color","label":"Gradient Background Bottom Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#fcde11"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"btn_post_border_color","label":"Button Border Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#f6d80f"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"btn_post_text_color","label":"Button Text Color","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#292b2c"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"btn_post_bg_top_color_hover","label":"Gradient Background Top Color (Hover)","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#fff860"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"btn_post_bg_bottom_color_hover","label":"Gradient Background Bottom Color (Hover)","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#ffeb43"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"btn_post_border_color_hover","label":"Button Border Color (Hover)","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#fcde11"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"btn_post_text_color_hover","label":"Button Text Color (Hover)","type":"color_picker","colorpicker_options":{"customClass":"custom-class"},"attributes":{"placeholder":"#1b1d1e"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_3","type":"custom_html","value":"<h4>Raw CSS (Optional)</h4>"},
	{"name":"separator_3_1","type":"custom_html","value":"You can also add raw CSS to customize your website style by using the field below. <br>If you want to add a large CSS code, you have to use the /public/css/custom.css file."},
	{"name":"custom_css","label":"Custom CSS","type":"textarea","attributes":{"rows":"5"},"hint":"Please <strong>do not</strong> include the &lt;style&gt; tags."},
	
	{"name":"separator_4","type":"custom_html","value":"<h3>Admin panel</h3>"},
	{"name":"admin_skin","label":"Admin Skin","type":"select2_from_array","options":{"skin-black":"Black","skin-blue":"Blue","skin-purple":"Purple","skin-red":"Red","skin-yellow":"Yellow","skin-green":"Green","skin-blue-light":"Blue light","skin-black-light":"Black light","skin-purple-light":"Purple light","skin-green-light":"Green light","skin-red-light":"Red light","skin-yellow-light":"Yellow light"}}';
		}
		
		if ($this->key == 'listing') {
			$value = '{"name":"separator_1","type":"custom_html","value":"<h3>Displaying</h3>"},
	{"name":"display_mode","label":"Listing Page Display Mode","type":"select2_from_array","options":{".grid-view":"Grid",".list-view":"List",".compact-view":"Compact"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"grid_view_cols","label":"Grid View Columns","type":"select2_from_array","options":{"4":"4","3":"3","2":"2"},"wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"items_per_page","label":"Items per page","type":"text","hint":"Number of items per page (> 4 and < 40)","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"left_sidebar","label":"Listing Page Left Sidebar","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6","style":"margin-top: 20px;"}},
	
	{"name":"separator_2","type":"custom_html","value":"<h3>Distance</h3>"},
	{"name":"cities_extended_searches","label":"Enable the cities extended searches","type":"checkbox","hint":"cities_extended_searches_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"search_distance_max","label":"Max Search Distance","type":"select2_from_array","options":{"1000":"1000","900":"900","800":"800","700":"700","600":"600","500":"500","400":"400","300":"300","200":"200","100":"100","50":"50","0":"0"},"hint":"Max search radius distance (in km or miles)","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"separator_3","type":"custom_html","value":"<div style=\"clear: both;\"></div>"},
	{"name":"search_distance_default","label":"Default Search Distance","type":"select2_from_array","options":{"200":"200","100":"100","50":"50","25":"25","20":"20","10":"10","0":"0"},"hint":"Default search radius distance (in km or miles)","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"search_distance_interval","label":"Distance Interval","type":"select2_from_array","options":{"250":"250","200":"200","100":"100","50":"50","25":"25","20":"20","10":"10","5":"5"},"hint":"The interval between filter distances (shown on the search results page)","wrapperAttributes":{"class":"form-group col-md-6"}}';
		}
		
		if ($this->key == 'single') {
			$value = '{"name":"publication_sep","type":"custom_html","value":"<h3>Publication</h3>"},
	{"name":"publication_form_type","label":"publication_form_type_label","type":"select2_from_array","options":{"1":"' . trans('admin::messages.publication_form_type_option_1') . '","2":"' . trans('admin::messages.publication_form_type_option_2') . '"},"hint":"publication_form_type_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"picture_mandatory","label":"picture_mandatory_label","type":"checkbox","hint":"picture_mandatory_hint","wrapperAttributes":{"class":"form-group col-md-6","style":"margin-top: 10px;"}},
	{"name":"separator_clear_1","type":"custom_html","value":"<div style=\"clear: both;\"></div>"},
	{"name":"pictures_limit","label":"Pictures Limit","type":"text","hint":"pictures_limit_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"tags_limit","label":"Tags Limit","type":"text","hint":"NOTE: The \'tags\' field in the \'posts\' table is a varchar 255","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"separator_clear_2","type":"custom_html","value":"<div style=\"clear: both;\"></div>"},
	{"name":"guests_can_post_ads","label":"Allow Guests to post Ads","type":"checkbox","hint":"guests_can_post_ads_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"posts_review_activation","label":"Allow Ads to be reviewed by Admins","type":"checkbox","hint":"posts_review_activation_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"auto_registration_sep","type":"custom_html","value":"auto_registration_sep_value"},
	{"name":"auto_registration","label":"auto_registration_label","type":"select2_from_array","options":{"0":"' . trans('admin::messages.auto_registration_option_0') . '","1":"' . trans('admin::messages.auto_registration_option_1') . '","2":"' . trans('admin::messages.auto_registration_option_2') . '"},"hint":"auto_registration_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"edition_sep","type":"custom_html","value":"<h3>Edition</h3>"},
	{"name":"simditor_wysiwyg","label":"Allow the Simditor WYSIWYG Editor","type":"checkbox"},
	{"name":"ckeditor_wysiwyg","label":"Allow the CKEditor WYSIWYG Editor","type":"checkbox","hint":"For commercial use: http://ckeditor.com/pricing. NOTE: You need to disable the \'Simditor WYSIWYG Editor\'"},
	
	{"name":"others_sep","type":"custom_html","value":"others_sep_value"},
	{"name":"guests_can_contact_ads_authors","label":"guests_can_contact_ads_authors_label","type":"checkbox","hint":"guests_can_contact_ads_authors_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"external_services_sep","type":"custom_html","value":"<h3>External Services</h3>"},
	{"name":"show_post_on_googlemap","label":"Show Ads on Google Maps (Single Page Only)","type":"checkbox","hint":"You have to enter your Google Maps API key at: <br>Setup -> General Settings -> Others.","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"activation_facebook_comments","label":"Allow Facebook Comments (Single Page Only)","type":"checkbox","hint":"You have to configure the Login with Facebook at: <br>Setup -> General Settings -> Social Login.","wrapperAttributes":{"class":"form-group col-md-6"}}';
		}
		
		if ($this->key == 'mail') {
			$value = '{"name":"driver","label":"Mail Driver","type":"select2_from_array","options":{"smtp":"SMTP","mailgun":"Mailgun","mandrill":"Mandrill","ses":"Amazon SES","sparkpost":"Sparkpost","mail":"PHP Mail","sendmail":"Sendmail"}},
	
	{"name":"separator_1","type":"custom_html","value":"<h3>SMTP Parameters</h3>"},
	{"name":"separator_1_1","type":"custom_html","value":"Required for drivers: SMTP, Mailgun, Mandrill, Sparkpost"},
	{"name":"host","label":"Mail Host","type":"text","hint":"SMTP Host","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"port","label":"Mail Port","type":"text","hint":"SMTP Port (e.g. 25, 587, ...)","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"username","label":"Mail Username","type":"text","hint":"SMTP Username","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"password","label":"Mail Password","type":"text","hint":"SMTP Password","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"encryption","label":"Mail Encryption","type":"text","hint":"SMTP Encryption (e.g. tls, ssl, starttls)","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_2","type":"custom_html","value":"<h3>Mailgun</h3>"},
	{"name":"mailgun_domain","label":"Mailgun Domain","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"mailgun_secret","label":"Mailgun Secret","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_3","type":"custom_html","value":"<h3>Mandrill</h3>"},
	{"name":"mandrill_secret","label":"Mandrill Secret","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_4","type":"custom_html","value":"<h3>Amazon SES</h3>"},
	{"name":"ses_key","label":"SES Key","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"ses_secret","label":"SES Secret","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"ses_region","label":"SES Region","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_5","type":"custom_html","value":"<h3>Sparkpost</h3>"},
	{"name":"sparkpost_secret","label":"Sparkpost Secret","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_6","type":"custom_html","value":"<hr>"},
	
	{"name":"separator_7","type":"custom_html","value":"<h3>Other Configurations</h3>"},
	{"name":"email_sender","label":"Transactional Email Sender","type":"email","hint":"Transactional Email Sender. Example: noreply@yoursite.com","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"email_verification","label":"settings_mail_email_verification_label","type":"checkbox","hint":"settings_mail_email_verification_hint"},
	{"name":"confirmation","label":"settings_mail_confirmation_label","type":"checkbox","hint":"settings_mail_confirmation_hint"},
	{"name":"admin_notification","label":"settings_mail_admin_notification_label","type":"checkbox","hint":"settings_mail_admin_notification_hint"},
	{"name":"payment_notification","label":"settings_mail_payment_notification_label","type":"checkbox","hint":"settings_mail_payment_notification_hint"}';
		}
		
		if ($this->key == 'sms') {
			$value = '{"name":"driver","label":"SMS Driver","type":"select2_from_array","options":{"nexmo":"Nexmo","twilio":"Twilio"}},
	
	{"name":"separator_1","type":"custom_html","value":"<h3>Nexmo</h3>"},
	{"name":"separator_1_1","type":"custom_html","value":"Get a Nexmo Account <a href=\"https://www.nexmo.com/\" target=\"_blank\">here</a>."},
	{"name":"nexmo_key","label":"Nexmo Key","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"nexmo_secret","label":"Nexmo Secret","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"nexmo_from","label":"Nexmo From","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_2","type":"custom_html","value":"<h3>Twilio</h3>"},
	{"name":"separator_2_1","type":"custom_html","value":"Get a Twilio Account <a href=\"https://www.twilio.com/\" target=\"_blank\">here</a>."},
	{"name":"twilio_account_sid","label":"Twilio Account SID","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"twilio_auth_token","label":"Twilio Auth Token","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"twilio_from","label":"Twilio From","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_3","type":"custom_html","value":"<hr>"},
	
	{"name":"separator_4","type":"custom_html","value":"<h3>Other Configurations</h3>"},
	{"name":"phone_verification","label":"Enable Phone Verification","type":"checkbox","hint":"By enabling this option you have to add this entry: <strong>DISABLE_PHONE=false</strong> in the /.env file."},
	{"name":"message_activation","label":"Enable SMS Message","type":"checkbox","hint":"Send a SMS in addition for each message between users. NOTE: You will have a lot to spend on the SMS sending credit."}';
		}
		
		if ($this->key == 'upload') {
			$value = '{"name":"image_types","label":"Upload Image Types","type":"text","hint":"Upload image types (ex: jpg,jpeg,gif,png,...)","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"file_types","label":"Upload File Types","type":"text","hint":"Upload file types (ex: pdf,doc,docx,odt,...)","wrapperAttributes":{"class":"form-group col-md-6"}},
{"name":"max_file_size","label":"Upload Max File Size","type":"text","hint":"Upload Max File Size (in KB)","wrapperAttributes":{"class":"form-group col-md-6"}}';
		}
		
		if ($this->key == 'geo_location') {
			$value = '{"name":"geolocation_activation","label":"Enable Geolocation","type":"checkbox","hint":"Before enabling this option you need to download the Maxmind database by following the documentation <a href=\"http://support.bedigit.com/help-center/articles/14/enable-the-geo-location\" target=\"_blank\">here</a>.","wrapperAttributes":{"class":"form-group col-md-6","style":"margin-top: 20px;"}},
	{"name":"default_country_code","label":"Default Country","type":"select2","attribute":"asciiname","model":"\\\App\\\Models\\\Country","allows_null":"true","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"separator_clear_1","type":"custom_html","value":"<div style=\"clear: both;\"></div>"},
	{"name":"country_flag_activation","label":"Show country flag on top","type":"checkbox","hint":"<br>","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"local_currency_packages_activation","label":"Allow users to pay the Packages in their country currency","type":"checkbox","hint":"You have to create a list of <a href=\"#admin#/package\" target=\"_blank\">Packages</a> per currency (using currencies of activated countries) to allow users to pay the Packages in their local currency.<br>NOTE: By unchecking this field all the lists of Packages (without currency matching) will be shown during the payment process.","wrapperAttributes":{"class":"form-group col-md-6"}}';
		}
		
		if ($this->key == 'security') {
			$value = '{"name":"login_sep","type":"custom_html","value":"login_sep_value"},
	{"name":"login_open_in_modal","label":"Open In Modal","type":"checkbox","hint":"Open the top login link into Modal"},
	{"name":"login_max_attempts","label":"Max Attempts","type":"select2_from_array","options":{"30":"30","20":"20","10":"10","5":"5","4":"4","3":"3","2":"2","1":"1"},"hint":"The maximum number of attempts to allow","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"login_decay_minutes","label":"Decay Minutes","type":"select2_from_array","options":{"1440":"1440","720":"720","60":"60","30":"30","20":"20","15":"15","10":"10","5":"5","4":"4","3":"3","2":"2","1":"1"},"hint":"The number of minutes to throttle for","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"recaptcha_sep","type":"custom_html","value":"recaptcha_sep_value"},
	{"name":"recaptcha_sep_info","type":"custom_html","value":"recaptcha_sep_info_value"},
	{"name":"recaptcha_activation","label":"recaptcha_activation_label","type":"checkbox"},
	{"name":"recaptcha_site_key","label":"recaptcha_site_key_label","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"recaptcha_secret_key","label":"recaptcha_secret_key_label","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"recaptcha_version","label":"recaptcha_version_label","type":"select2_from_array","options":{"v2":"v2","v3":"v3"},"hint":"recaptcha_version_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"recaptcha_skip_ips","label":"recaptcha_skip_ips_label","type":"textarea","hint":"recaptcha_skip_ips_hint","wrapperAttributes":{"class":"form-group col-md-6"}}';
		}
		
		if ($this->key == 'social_auth') {
			$value = '{"name":"social_login_activation","label":"social_login_activation_label","type":"checkbox","hint":"social_login_activation_hint"},
	
	{"name":"facebook_sep","type":"custom_html","value":"facebook_sep_value"},
	{"name":"facebook_sep_1","type":"custom_html","value":"facebook_sep_1_value"},
	{"name":"facebook_client_id","label":"facebook_client_id_label","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"facebook_client_secret","label":"facebook_client_secret_label","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"linkedin_sep","type":"custom_html","value":"linkedin_sep_value"},
	{"name":"linkedin_sep_1","type":"custom_html","value":"linkedin_sep_1_value"},
	{"name":"linkedin_client_id","label":"linkedin_client_id_label","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"linkedin_client_secret","label":"linkedin_client_secret_label","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"twitter_sep","type":"custom_html","value":"twitter_sep_value"},
	{"name":"twitter_sep_1","type":"custom_html","value":"twitter_sep_1_value"},
	{"name":"twitter_client_id","label":"twitter_client_id_label","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"twitter_client_secret","label":"twitter_client_secret_label","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"google_sep","type":"custom_html","value":"google_sep_value"},
	{"name":"google_sep_1","type":"custom_html","value":"google_sep_1_value"},
	{"name":"google_client_id","label":"google_client_id_label","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"google_client_secret","label":"google_client_secret_label","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}}';
		}
		
		if ($this->key == 'social_link') {
			$value = '{"name":"facebook_page_url","label":"Facebook Page URL","type":"text"},
	{"name":"twitter_url","label":"Twitter URL","type":"text"},
	{"name":"google_plus_url","label":"Google+ URL","type":"text"},
	{"name":"linkedin_url","label":"LinkedIn URL","type":"text"},
	{"name":"pinterest_url","label":"Pinterest URL","type":"text"},
	{"name":"instagram_url","label":"Instagram URL","type":"text"}';
		}
		
		if ($this->key == 'optimization') {
			$value = '{"name":"caching_system_sep","type":"custom_html","value":"caching_system_sep_value"},
	{"name":"cache_driver","label":"cache_driver_label","type":"select2_from_array","options":{"file":"File (Default)","array":"None","database":"Database","apc":"APC","memcached":"Memcached","redis":"Redis"},"hint":"cache_driver_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"cache_expiration","label":"cache_expiration_label","type":"text","hint":"cache_expiration_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"cache_driver_info_sep","type":"custom_html","value":"cache_driver_info"},
	
	{"name":"memcached_sep","type":"custom_html","value":"memcached_sep_value"},
	{"name":"memcached_persistent_id","label":"memcached_persistent_id_label","type":"text","hint":"memcached_persistent_id_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"separator_clear_1","type":"custom_html","value":"<div style=\"clear: both;\"></div>"},
	{"name":"memcached_sasl_username","label":"memcached_sasl_username_label","type":"text","hint":"memcached_sasl_username_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"memcached_sasl_password","label":"memcached_sasl_password_label","type":"text","hint":"memcached_sasl_password_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"memcached_servers_sep","type":"custom_html","value":"memcached_servers_sep_value"},
	{"name":"memcached_servers_1_host","label":"' . trans('admin::messages.memcached_servers_host_label', ['num' => 1]) . '","type":"text","hint":"' . trans('admin::messages.memcached_servers_host_hint') . '","wrapperAttributes":{"class":"form-group col-md-6"},"disableTrans":"true"},
	{"name":"memcached_servers_1_port","label":"' . trans('admin::messages.memcached_servers_port_label', ['num' => 1]) . '","type":"text","hint":"' . trans('admin::messages.memcached_servers_port_hint') . '","wrapperAttributes":{"class":"form-group col-md-6"},"disableTrans":"true"},
	{"name":"memcached_servers_2_host","label":"' . trans('admin::messages.memcached_servers_host_label', ['num' => 2]) . ' (' . trans('admin::messages.Optional') . ')","type":"text","wrapperAttributes":{"class":"form-group col-md-6"},"disableTrans":"true"},
	{"name":"memcached_servers_2_port","label":"' . trans('admin::messages.memcached_servers_port_label', ['num' => 2]) . ' (' . trans('admin::messages.Optional') . ')","type":"text","wrapperAttributes":{"class":"form-group col-md-6"},"disableTrans":"true"},
	{"name":"memcached_servers_3_host","label":"' . trans('admin::messages.memcached_servers_host_label', ['num' => 3]) . ' (' . trans('admin::messages.Optional') . ')","type":"text","wrapperAttributes":{"class":"form-group col-md-6"},"disableTrans":"true"},
	{"name":"memcached_servers_3_port","label":"' . trans('admin::messages.memcached_servers_port_label', ['num' => 3]) . ' (' . trans('admin::messages.Optional') . ')","type":"text","wrapperAttributes":{"class":"form-group col-md-6"},"disableTrans":"true"},
	
	{"name":"redis_sep","type":"custom_html","value":"redis_sep_value"},
	{"name":"redis_client","label":"redis_client_label","type":"select2_from_array","options":{"predis":"Predis","phpredis":"PhpRedis"},"hint":"redis_client_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"separator_clear_2","type":"custom_html","value":"<div style=\"clear: both;\"></div>"},
	{"name":"redis_cluster_activation","label":"redis_cluster_activation_label","type":"checkbox","hint":"redis_cluster_activation_hint","wrapperAttributes":{"class":"form-group col-md-6","style":"margin-top: 5px;"}},
	{"name":"redis_cluster","label":"redis_cluster_label","type":"select2_from_array","options":{"predis":"Predis","redis":"Redis"},"hint":"redis_cluster_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"separator_clear_3","type":"custom_html","value":"<div style=\"clear: both;\"></div>"},
	{"name":"redis_server_sep","type":"custom_html","value":"redis_server_sep_value"},
	{"name":"redis_host","label":"redis_host_label","type":"text","hint":"redis_host_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"redis_password","label":"redis_password_label","type":"text","hint":"redis_password_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"redis_port","label":"redis_port_label","type":"text","hint":"redis_port_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"redis_database","label":"redis_database_label","type":"text","hint":"redis_database_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"redis_clusters_sep","type":"custom_html","value":"redis_clusters_sep_value"},
	{"name":"redis_cluster_1_host","label":"' . trans('admin::messages.redis_cluster_host_label', ['num' => 1]) . '","type":"text","hint":"' . trans('admin::messages.redis_cluster_host_hint') . '","wrapperAttributes":{"class":"form-group col-md-6"},"disableTrans":"true"},
	{"name":"redis_cluster_1_password","label":"' . trans('admin::messages.redis_cluster_password_label', ['num' => 1]) . '","type":"text","hint":"' . trans('admin::messages.redis_cluster_password_hint') . '","wrapperAttributes":{"class":"form-group col-md-6"},"disableTrans":"true"},
	{"name":"redis_cluster_1_port","label":"' . trans('admin::messages.redis_cluster_port_label', ['num' => 1]) . '","type":"text","hint":"' . trans('admin::messages.redis_cluster_port_hint') . '","wrapperAttributes":{"class":"form-group col-md-6"},"disableTrans":"true"},
	{"name":"redis_cluster_1_database","label":"' . trans('admin::messages.redis_cluster_database_label', ['num' => 1]) . '","type":"text","hint":"' . trans('admin::messages.redis_cluster_database_hint') . '","wrapperAttributes":{"class":"form-group col-md-6"},"disableTrans":"true"},
	{"name":"redis_cluster_2_host","label":"' . trans('admin::messages.redis_cluster_host_label', ['num' => 2]) . ' (' . trans('admin::messages.Optional') . ')","type":"text","wrapperAttributes":{"class":"form-group col-md-6"},"disableTrans":"true"},
	{"name":"redis_cluster_2_password","label":"' . trans('admin::messages.redis_cluster_password_label', ['num' => 2]) . ' (' . trans('admin::messages.Optional') . ')","type":"text","wrapperAttributes":{"class":"form-group col-md-6"},"disableTrans":"true"},
	{"name":"redis_cluster_2_port","label":"' . trans('admin::messages.redis_cluster_port_label', ['num' => 2]) . ' (' . trans('admin::messages.Optional') . ')","type":"text","wrapperAttributes":{"class":"form-group col-md-6"},"disableTrans":"true"},
	{"name":"redis_cluster_2_database","label":"' . trans('admin::messages.redis_cluster_database_label', ['num' => 2]) . ' (' . trans('admin::messages.Optional') . ')","type":"text","wrapperAttributes":{"class":"form-group col-md-6"},"disableTrans":"true"},
	{"name":"redis_cluster_3_host","label":"' . trans('admin::messages.redis_cluster_host_label', ['num' => 3]) . ' (' . trans('admin::messages.Optional') . ')","type":"text","wrapperAttributes":{"class":"form-group col-md-6"},"disableTrans":"true"},
	{"name":"redis_cluster_3_password","label":"' . trans('admin::messages.redis_cluster_password_label', ['num' => 3]) . ' (' . trans('admin::messages.Optional') . ')","type":"text","wrapperAttributes":{"class":"form-group col-md-6"},"disableTrans":"true"},
	{"name":"redis_cluster_3_port","label":"' . trans('admin::messages.redis_cluster_port_label', ['num' => 3]) . ' (' . trans('admin::messages.Optional') . ')","type":"text","wrapperAttributes":{"class":"form-group col-md-6"},"disableTrans":"true"},
	{"name":"redis_cluster_3_database","label":"' . trans('admin::messages.redis_cluster_database_label', ['num' => 3]) . ' (' . trans('admin::messages.Optional') . ')","type":"text","wrapperAttributes":{"class":"form-group col-md-6"},"disableTrans":"true"},
	
	{"name":"separator_hr_1","type":"custom_html","value":"<hr>"},
	
	{"name":"minify_html_sep","type":"custom_html","value":"minify_html_sep_value"},
	{"name":"minify_html_activation","label":"minify_html_activation_label","type":"checkbox","hint":"minify_html_activation_hint","wrapperAttributes":{"class":"form-group col-md-6"}}';
		}
		
		if ($this->key == 'seo') {
			$value = '{"name":"verification_tools_sep","type":"custom_html","value":"verification_tools_sep_value"},
	{"name":"google_site_verification","label":"google_site_verification_label","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"alexa_verify_id","label":"alexa_verify_id_label","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"msvalidate","label":"msvalidate_label","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"yandex_verification","label":"yandex_verification_label","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"twitter_username","label":"twitter_username_label","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_2","type":"custom_html","value":"<h3>Indexing (On Search Engines)</h3>"},
	{"name":"no_index_categories","label":"No Index Categories Pages","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"no_index_tags","label":"No Index Tags Pages","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"no_index_cities","label":"No Index Cities Pages","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"no_index_users","label":"No Index Users Pages","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"no_index_post_report","label":"No Index Post Report Pages","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"no_index_all","label":"No Index All Pages","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_3","type":"custom_html","value":"<h3>Posts Permalink Settings</h3>"},
	{"name":"separator_3_1","type":"custom_html","value":"posts_permalink_settings_warning"},
	{"name":"posts_permalink","label":"Posts Permalink","type":"select2_from_array","options":{"{slug}-{id}":"{slug}-{id}","{slug}/{id}":"{slug}/{id}","{slug}_{id}":"{slug}_{id}","{id}-{slug}":"{id}-{slug}","{id}/{slug}":"{id}/{slug}","{id}_{slug}":"{id}_{slug}","{id}":"{id}"},"hint":"posts_permalink_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"posts_permalink_ext","label":"Posts Permalink Extension","type":"select2_from_array","options":{"":"&nbsp;",".html":".html",".htm":".htm",".php":".php",".aspx":".aspx"},"hint":"posts_permalink_ext_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_4","type":"custom_html","value":"<h3>Multi-countries URLs Optimization</h3>"},
	{"name":"separator_4_1","type":"custom_html","value":"multi_countries_urls_optimization_warning"},
	{"name":"multi_countries_urls","label":"Enable The Multi-countries URLs Optimization","type":"checkbox","hint":"multi_countries_urls_optimization_hint"},
	{"name":"separator_4_2","type":"custom_html","value":"multi_countries_urls_optimization_info"}';
		}
		
		if ($this->key == 'other') {
			$value = '{"name":"separator_1","type":"custom_html","value":"<h3>Alerts Boxes (Cookie Consent, Tips, etc.)</h3>"},
	{"name":"cookie_consent_enabled","label":"Cookie Consent Enabled","type":"checkbox","hint":"Enable Cookie Consent Alert to comply for EU law.","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"show_tips_messages","label":"Show Tips Notification Messages","type":"checkbox","hint":"e.g. SITENAME is also available in your country: COUNTRY. Starting good deals here now!<br>Login for faster access to the best deals. Click here if you don\'t have an account.","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_2","type":"custom_html","value":"<h3>Google Maps</h3>"},
	{"name":"googlemaps_key","label":"Google Maps Key","type":"text","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_3","type":"custom_html","value":"<h3>Conversation (Messaging)</h3>"},
	{"name":"timer_new_messages_checking","label":"Timer for New Messages Checking","type":"text","hint":"Timer (in milliseconds). 60000 = 60 seconds. 0 to disable the auto-checking feature.","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_4","type":"custom_html","value":"textarea_editor_h3"},
	{"name":"simditor_wysiwyg","label":"Allow the Simditor WYSIWYG Editor","type":"checkbox","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"ckeditor_wysiwyg","label":"Allow the CKEditor WYSIWYG Editor","type":"checkbox","hint":"For commercial use: http://ckeditor.com/pricing. NOTE: You need to disable the \'Simditor WYSIWYG Editor\'","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_5","type":"custom_html","value":"<h3>Mobile Apps URLs</h3>"},
	{"name":"ios_app_url","label":"App Store","type":"text","hint":"Available on the App Store with the given URL","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"android_app_url","label":"Google Play","type":"text","hint":"Available on Google Play with the given URL","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_6","type":"custom_html","value":"<h3>Number Format</h3>"},
	{"name":"decimals_superscript","label":"Decimals Superscript","type":"checkbox"},
	
	{"name":"cookie_sep","type":"custom_html","value":"cookie_sep_value"},
	{"name":"cookie_expiration","label":"cookie_expiration_label","type":"text","hint":"cookie_expiration_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"separator_8","type":"custom_html","value":"<h3>JavaScript (in the &lt;head&gt; section)</h3>"},
	{"name":"js_code","label":"JavaScript Code","type":"textarea","attributes":{"rows":"10"},"hint":"Paste your JavaScript code here to put it in the &lt;head&gt; section of HTML pages."}';
		}
		
		if ($this->key == 'cron') {
			$value = '{"name":"cron_sep","type":"custom_html","value":"cron_sep_value"},
	{"name":"cron_info_sep","type":"custom_html","value":"cron_info_sep_value"},
	{"name":"cron_ads_clear_sep","type":"custom_html","value":"cron_ads_clear_sep_value"},
	{"name":"unactivated_posts_expiration","label":"unactivated_posts_expiration_label","type":"text", "hint":"unactivated_posts_expiration_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"activated_posts_expiration","label":"activated_posts_expiration_label","type":"text", "hint":"activated_posts_expiration_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"archived_posts_expiration","label":"archived_posts_expiration_label","type":"text", "hint":"archived_posts_expiration_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	{"name":"manually_archived_posts_expiration","label":"manually_archived_posts_expiration_label","type":"text", "hint":"manually_archived_posts_expiration_hint","wrapperAttributes":{"class":"form-group col-md-6"}},
	
	{"name":"cron_test_sep","type":"custom_html","value":"cron_test_sep_value"},
	{"name":"cron_test_sep_details","type":"custom_html","value":"cron_settings_details"},
	{"name":"cron_test_sep_detail_btn","type":"custom_html","value":"cron_settings_details_btn"}';
		}
		
		if ($this->key == 'footer') {
			$value = '{"name":"hide_links","label":"Hide Links","type":"checkbox"},
	{"name":"hide_payment_plugins_logos","label":"Hide Payment Plugins Logos","type":"checkbox"},
	{"name":"hide_powered_by","label":"Hide Powered by Info","type":"checkbox"},
	{"name":"powered_by_info","label":"Powered by","type":"text"},
	{"name":"tracking_code","label":"Tracking Code","type":"textarea","attributes":{"rows":"15"},"hint":"Paste your Google Analytics (or other) tracking code here. This will be added into the footer."}';
		}
		
		if (config('plugins.watermark.installed')) {
			if ($this->key == 'watermark') {
				$value = \App\Plugins\watermark\Watermark::getFieldData();
			}
		}
		
		if (config('plugins.reviews.installed')) {
			if ($this->key == 'reviews') {
				$value = \App\Plugins\reviews\Reviews::getFieldData();
			}
		}
		
		if (config('plugins.currencyexchange.installed')) {
			if ($this->key == 'currency_exchange') {
				$value = \App\Plugins\currencyexchange\Currencyexchange::getFieldData();
			}
		}
		
		if (config('plugins.domainmapping.installed')) {
			if ($this->key == 'domain_mapping') {
				$value = \App\Plugins\domainmapping\Domainmapping::getFieldData();
			}
		}
		
		$value = '[' . $formTitle . $value . ']';
		
		return $value;
	}
}

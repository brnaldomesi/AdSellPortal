<?php
/**
 * Laravel reCAPTCHA
 * Author: Bedigit
 * Web: www.bedigit.com
 */

namespace Bedigit\ReCaptcha\app\Rules;

use Bedigit\ReCaptcha\Service\ReCaptchaInvisible;
use Bedigit\ReCaptcha\Service\ReCaptchaV2;
use Bedigit\ReCaptcha\Service\ReCaptchaV3;
use Illuminate\Contracts\Validation\Rule;

class ReCaptchaRule implements Rule
{
	/**
	 * Determine if the validation rule passes.
	 * Call out to reCAPTCHA and process the response.
	 *
	 * @param  string  $attribute
	 * @param  mixed  $value
	 * @return bool
	 */
	public function passes($attribute, $value)
	{
		$value = strip_tags($value);
		
		$recaptchaClass = '';
		switch (config('recaptcha.version')) {
			case 'v3' :
				$recaptchaClass = ReCaptchaV3::class;
				break;
			case 'v2' :
				$recaptchaClass = ReCaptchaV2::class;
				break;
			case 'invisible':
				$recaptchaClass = ReCaptchaInvisible::class;
				break;
		}
		if (empty($recaptchaClass)) return false;
		
		$recaptcha = new $recaptchaClass(config('recaptcha.site_key'), config('recaptcha.secret_key'), config('recaptcha.lang'));
		
		if ($recaptcha->skipByIp()) {
			return true;
		}
		
		$params = http_build_query([
			'secret'   => $recaptcha->getSecretKey(),
			'remoteip' => request()->getClientIp(),
			'response' => $value,
		]);
		
		$url = $recaptcha->getApiUrl() . '?' . $params;
		
		if (function_exists('curl_version')) {
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 1);
			if (strpos(strtolower($url), 'https://') !== false) {
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			}
			$buffer = curl_exec($ch);
			$error = curl_error($ch);
			curl_close($ch);
			
			if (!$buffer) {
				return false;
			}
		} else {
			$buffer = file_get_contents($url);
		}
		
		if (is_null($buffer) || empty($buffer)) {
			return false;
		}
		
		$response = json_decode(trim($buffer), true);
		
		return (isset($response['success'])) ? $response['success'] : false;
	}
	
	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message()
	{
		return trans('validation.recaptcha');
	}
}

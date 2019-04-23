<?php
/**
 * Laravel reCAPTCHA
 * Author: Bedigit
 * Web: www.bedigit.com
 */

namespace Bedigit\ReCaptcha\app\Http\Controllers;

use Bedigit\ReCaptcha\Service\ReCaptchaV3;
use Illuminate\Routing\Controller;

class ReCaptchaController extends Controller
{
	/**
	 * @return array
	 */
	public function validateV3()
	: array
	{
		$token = request()->input(config('recaptcha.token_parameter_name', 'token'), '');
		
		if (config('recaptcha.version') != 'v3') {
			//...
		}
		
		$recaptcha = new ReCaptchaV3(config('recaptcha.site_key'), config('recaptcha.secret_key'), config('recaptcha.lang'));
		
		if ($recaptcha->skipByIp()) {
			// Add 'skip_by_ip' field to response
			return [
				'skip_by_ip' => true,
				'score'      => 0.9,
				'success'    => true,
			];
		}
		
		$params = http_build_query([
			'secret'   => $recaptcha->getSecretKey(),
			'remoteip' => request()->getClientIp(),
			'response' => $token,
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
				// Add 'error' field to response
				return [
					'error'   => $error,
					'score'   => 0.1,
					'success' => false,
				];
			}
		} else {
			$buffer = file_get_contents($url);
		}
		
		if (is_null($buffer) || empty($buffer)) {
			// Add 'error' field to response
			return [
				'error'   => 'cURL response empty',
				'score'   => 0.1,
				'success' => false,
			];
		}
		
		$response = json_decode(trim($buffer), true);
		
		return $response;
	}
}

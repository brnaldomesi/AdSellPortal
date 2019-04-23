<?php
/**
 * Laravel reCAPTCHA
 * Author: Bedigit
 * Web: www.bedigit.com
 */

use Bedigit\ReCaptcha\Facades\ReCaptcha;

if (!function_exists('recaptcha')) {
	/**
	 * @return Bedigit\ReCaptcha\Service\ReCaptcha
	 */
	function recaptcha()
	{
		return app('recaptcha');
	}
}

/**
 * Call ReCaptcha::apiJsScriptTag()
 * Write script HTML tag in you HTML code
 * Insert before </head> tag
 *
 * @param $formId required if you are using invisible ReCaptcha
 */
if (!function_exists('recaptchaApiJsScriptTag')) {
	
	/**
	 * @param string $formId
	 *
	 * @return string
	 */
	function recaptchaApiJsScriptTag($formId = '')
	: string
	{
		return ReCaptcha::apiJsScriptTag($formId);
	}
}

/**
 * Call ReCaptcha::apiJsScriptTag()
 * Write script HTML tag in you HTML code
 * Insert before </head> tag
 *
 * @param $formId required if you are using invisible ReCaptcha
 */
if (!function_exists('recaptchaApiV3JsScriptTag')) {
	
	/**
	 * @param array $config
	 *
	 * @return string
	 */
	function recaptchaApiV3JsScriptTag($config = [])
	: string
	{
		return ReCaptcha::apiV3JsScriptTag($config);
	}
}

/**
 * Call ReCaptcha::htmlFormButton()
 * Write HTML <button> tag in your HTML code
 * Insert before </form> tag
 *
 * Warning! Using only with ReCAPTCHA INVISIBLE
 *
 * @param $buttonInnerHTML What you want to write on the submit button
 */
if (!function_exists('recaptchaHtmlFormButton')) {
	
	/**
	 * @param null|string $buttonInnerHTML
	 *
	 * @return string
	 */
	function recaptchaHtmlFormButton(?string $buttonInnerHTML = 'Submit')
	: string
	{
		return ReCaptcha::htmlFormButton($buttonInnerHTML);
	}
}

/**
 * Call ReCaptcha::htmlFormSnippet()
 * Write ReCAPTCHA HTML tag in your FORM
 * Insert before </form> tag
 *
 * Warning! Using only with ReCAPTCHA v2
 */
if (!function_exists('recaptchaHtmlFormSnippet')) {
	
	/**
	 * @return string
	 */
	function recaptchaHtmlFormSnippet()
	: string
	{
		return ReCaptcha::htmlFormSnippet();
	}
}

/**
 * IETF language tag(s)
 * Example: en-US, pt-BR, fr-CA, ... (Usage of "-" instead of "_")
 */
if (!function_exists('ietfLangTag')) {
	
	/**
	 * @param null $locale
	 * @return mixed
	 */
	function ietfLangTag($locale = null)
	{
		if (empty($locale)) {
			$locale = config('app.locale');
		}
		
		return str_replace('_', '-', $locale);
	}
}

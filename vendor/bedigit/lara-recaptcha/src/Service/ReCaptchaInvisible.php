<?php
/**
 * Laravel reCAPTCHA
 * Author: Bedigit
 * Web: www.bedigit.com
 */

namespace Bedigit\ReCaptcha\Service;


class ReCaptchaInvisible extends ReCaptcha
{
	/**
	 * ReCaptchaInvisible constructor.
	 *
	 * @param string $siteKey
	 * @param string $secretKey
	 * @param string $lang
	 */
	public function __construct(string $siteKey, string $secretKey, string $lang)
	{
		parent::__construct($siteKey, $secretKey, $lang, 'invisible');
	}
	
	/**
	 * Write HTML <button> tag in your HTML code
	 * Insert before </form> tag
	 *
	 * @param string $buttonInnerHTML
	 *
	 * @return string
	 */
	public function htmlFormButton($buttonInnerHTML = 'Submit')
	: string
	{
		return ($this->version == 'invisible')
			? '<button class="g-recaptcha" data-sitekey="' . $this->siteKey . '" data-callback="laraReCaptcha">' . $buttonInnerHTML . '</button>'
			: '';
	}
}

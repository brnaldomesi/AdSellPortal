<?php
/**
 * Laravel reCAPTCHA
 * Author: Bedigit
 * Web: www.bedigit.com
 */

namespace Bedigit\ReCaptcha\Service;

use Illuminate\Support\Arr;

class ReCaptcha
{
	/**
	 * The Site key
	 * please visit https://developers.google.com/recaptcha/docs/start
	 * @var string
	 */
	protected $siteKey;
	
	/**
	 * The Secret key
	 * please visit https://developers.google.com/recaptcha/docs/start
	 * @var string
	 */
	protected $secretKey;
	
	/**
	 * The Language Code
	 */
	protected $lang = null;
	
	/**
	 * The chosen ReCAPTCHA version
	 * please visit https://developers.google.com/recaptcha/docs/start
	 * @var string
	 */
	protected $version;
	
	/**
	 * Whether is true the ReCAPTCHA is inactive
	 * @var boolean
	 */
	protected $skipByIp = false;
	
	/**
	 * The API request URI
	 */
	protected $apiUrl = 'https://www.google.com/recaptcha/api/siteverify';
	
	/**
	 * ReCaptchaBuilder constructor.
	 *
	 * @param $siteKey
	 * @param $secretKey
	 * @param $lang
	 * @param string $version
	 */
	public function __construct($siteKey, $secretKey, $lang, $version = 'v2')
	{
		$this->setSiteKey($siteKey);
		$this->setSecretKey($secretKey);
		$this->setLanguage($lang);
		$this->setVersion($version);
		$this->setSkipByIp($this->skipByIp());
	}
	
	/**
	 * @param string $siteKey
	 * @return ReCaptcha
	 */
	public function setSiteKey(string $siteKey)
	: ReCaptcha
	{
		$this->siteKey = $siteKey;
		
		return $this;
	}
	
	/**
	 * @param string $secretKey
	 * @return ReCaptcha
	 */
	public function setSecretKey(string $secretKey)
	: ReCaptcha
	{
		$this->secretKey = $secretKey;
		
		return $this;
	}
	
	/**
	 * @param string $lang
	 * @return ReCaptcha
	 */
	public function setLanguage(string $lang)
	: ReCaptcha
	{
		$this->lang = $lang;
		
		return $this;
	}
	
	/**
	 * @param string $version
	 * @return ReCaptcha
	 */
	public function setVersion(string $version)
	: ReCaptcha
	{
		$this->version = $version;
		
		return $this;
	}
	
	/**
	 * @param bool $skipByIp
	 * @return ReCaptcha
	 */
	public function setSkipByIp(bool $skipByIp)
	: ReCaptcha
	{
		$this->skipByIp = $skipByIp;
		
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getApiUrl()
	{
		return $this->apiUrl;
	}
	
	/**
	 * @return string
	 */
	public function getSecretKey()
	{
		return $this->secretKey;
	}
	
	/**
	 * @return string
	 */
	public function getVersion()
	: string
	{
		return $this->version;
	}
	
	/**
	 * @return array|\Illuminate\Config\Repository|mixed
	 */
	public function getIpWhitelist()
	{
		$whitelist = config('recaptcha.skip_ip', []);
		
		if (!is_array($whitelist)) {
			$whitelist = explode(',', $whitelist);
		}
		
		return $whitelist;
	}
	
	/**
	 * Checks whether the user IP address is among IPs "to be skipped"
	 *
	 * @return bool
	 */
	public function skipByIp()
	: bool
	{
		return (in_array(request()->ip(), $this->getIpWhitelist()));
	}
	
	/**
	 * Write script HTML tag in you HTML code
	 * Insert before </head> tag
	 *
	 * @param string|null $formId
	 * @param array|null $configuration
	 * @return string
	 * @throws \Exception
	 */
	public function apiJsScriptTag(?string $formId = '', ?array $configuration = [])
	: string
	{
		if ($this->skipByIp) {
			return '';
		}
		
		// Get language code
		$this->lang = Arr::get($configuration, 'lang', config('app.locale', 'en'));
		$this->lang = ietfLangTag($this->lang);
		
		switch ($this->version) {
			case 'v3':
				$langParam = (!empty($this->lang) ? '&hl=' . $this->lang : '');
				$html = "<script src=\"https://www.google.com/recaptcha/api.js?render={$this->siteKey}{$langParam}\"></script>";
				break;
			default:
				$langParam = (!empty($this->lang) ? '?hl=' . $this->lang : '');
				$html = "<script src=\"https://www.google.com/recaptcha/api.js{$langParam}\" async defer></script>";
		}
		
		if ($this->version == 'invisible') {
			
			if (!$formId) {
				throw new \Exception("formId required", 1);
			}
			$html .= '<script>
			function laraReCaptcha(token) {
				document.getElementById("' . $formId . '").submit();
			}
			</script>';
			
		} else if ($this->version == 'v3') {
			
			$action = Arr::get($configuration, 'action', 'homepage');
			
			$jsCustomValidation = Arr::get($configuration, 'custom_validation', '');
			
			// Check if set custom_validation. That function will override default fetch validation function
			if ($jsCustomValidation) {
				$validateFunction = ($jsCustomValidation) ? "{$jsCustomValidation}(token);" : '';
			} else {
				
				$jsThenCallback = Arr::get($configuration, 'callback_then', '');
				$jsCallbackCatch = Arr::get($configuration, 'callback_catch', '');
				
				$jsThenCallback = ($jsThenCallback) ? "{$jsThenCallback}(response)" : '';
				$jsCallbackCatch = ($jsCallbackCatch) ? "{$jsCallbackCatch}(err)" : '';
				
				$validateFunction = "
                fetch('/" . config('recaptcha.validation_route', 'lara-recaptcha/validate') . "?" . config('recaptcha.token_parameter_name', 'token') . "=' + token, {
                    headers: {
                        \"X-Requested-With\": \"XMLHttpRequest\",
                        \"X-CSRF-TOKEN\": csrfToken.content
                    }
                })
                .then(function(response) {
                   	{$jsThenCallback}
                })
                .catch(function(err) {
                    {$jsCallbackCatch}
                });";
				
			}
			
			$html .= "<script>
			var csrfToken = document.head.querySelector('meta[name=\"csrf-token\"]');
			grecaptcha.ready(function() {
				grecaptcha.execute('{$this->siteKey}', {action: '{$action}'}).then(function(token) {
					{$validateFunction}
				});
			});
			</script>";
		}
		
		return $html;
	}
	
	/**
	 * @param array|null $configuration
	 * @return string
	 * @throws \Exception
	 */
	public function apiV3JsScriptTag(?array $configuration = [])
	: string
	{
		return $this->apiJsScriptTag('', $configuration);
	}
}

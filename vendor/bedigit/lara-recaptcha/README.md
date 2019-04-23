
# Laravel reCAPTCHA v2 and v3  
Advanced and painless Google reCAPTCHA package for Laravel  

Available reCAPTCHA versions:  
* v2 Invisible  
* v2 Checkbox  
* v3  
  
  
## System requirements  
| Package version | PHP version | Laravel version |  
|-----------------|-------------|-----------------|  
| dev-master             | 7.1 or greater | 5.5 or greater |  
  
  
## Composer  
You can install the package via composer:  

    $ composer require bedigit/lara-recaptcha:^1.0  

Laravel 5.5 (or greater) uses package auto-discovery, so doesn't require you to manually add the Service Provider, but if you don't use auto-discovery ReCaptchaServiceProvider must be registered in `config/app.php`:  

    'providers' => [
	 ... 
	 Bedigit\ReCaptcha\ReCaptchaServiceProvider::class,
	 ]; 

You can use the facade for shorter code. Add ReCaptcha to your aliases:  

    'aliases' => [
    ... 
    'ReCaptcha' => Bedigit\ReCaptcha\Facades\ReCaptcha::class,
    ];

  
## Configuration  
Publish package  
Create `config/recaptcha.php` configuration file using the following artisan command:  

    $ php artisan vendor:publish --provider="Bedigit\ReCaptcha\ReCaptchaServiceProvider" 

Set the environment  
Add your API Keys  
Open `.env` file and set `RECAPTCHA_SITE_KEY` and `RECAPTCHA_SECRET_KEY`:  
  
# in your .env file  
    RECAPTCHA_SITE_KEY=YOUR_API_SITE_KEY  
    RECAPTCHA_SECRET_KEY=YOUR_API_SECRET_KEY  

Complete configuration  
Open `config/recaptcha.php` configuration file and set version:  

    return [  
       'site_key' => env('RECAPTCHA_SITE_KEY', ''),  
       'secret_key' => env('RECAPTCHA_SECRET_KEY', ''),  
       'version' => 'v2', // supported: v3|v2|invisible   
       'skip_ip' => [], // array of IP addresses - String: dotted quad format e.g.: 127.0.0.1  
       'validation_route' => env('RECAPTCHA_VALIDATION_ROUTE', 'lara-recaptcha/validate'),  
       'token_parameter_name' => env('RECAPTCHA_TOKEN_PARAMETER_NAME', 'token')  
    ];  

`site_key` and `secret_key` are reCAPTCHA keys you have to create in order to perform Google API authentication. For more information about Site Key and Secret Key please visit Google reCAPTCHA developer documentation  
  
`version` indicates the reCAPTCHA version (supported: v3|v2|invisible). Get more info about reCAPTCHA version at https://developers.google.com/recaptcha/docs/versions.  
  
`skip_ip` is a whitelist of IP addresses that, if recognized, disable the reCAPTCHA validation (return always true) and if you embed JS code in blade (view) file NO validation call will be performed.  
  
`validation_route` is the route called via javascript built-in validation script (v3 only)  
  
`token_parameter_name` is the name of "token" GET parameter sent to `validation_route` to be validated (v3 only)  
  
Reload config cache file  
!!! IMPORTANT !!! Every time you change some configuration run the following shell command:  

    $ php artisan config:cache

Have you updated?  
If you are migrating from an older version add `skip_ip` array in `recaptcha.php` configuration file.  
  
Customize error message  
Just for _v2_ and _invisible_ users.  
  
Before starting please add the validation message to resources/lang/[LANG]/validation.php file  

    return [  
     ... 
     'recaptcha' => 'The :attribute is wrong!',
     ];  


# How to use v2

## Embed in Blade

Insert  `recaptchaApiJsScriptTag($formId)`  helper before closing  `</head>`  tag.

You can also use  `ReCaptcha::recaptchaApiJsScriptTag($formId)`.  `$formId`  is required only if you are using  **ReCAPTCHA INVISIBLE**

```blade
<!DOCTYPE html>
<html>
    <head>
        ...
        {!! recaptchaApiJsScriptTag(/* $formId - INVISIBLE version only */) !!}
    </head>

```

### ReCAPTCHA v2 Checkbox

After you have to insert  `recaptchaHtmlFormSnippet()`  helper inside the form where you want to use the field  `g-recaptcha-response`.

You can also use  `ReCaptcha::recaptchaHtmlFormSnippet()`  .

```blade
<form>
    ...
    {!! recaptchaHtmlFormSnippet() !!}
    <input type="submit">
</form>

```

### ReCAPTCHA v2 Invisible

After you have to insert  `recaptchaHtmlFormButton($buttonInnerHTML)`  helper inside the form where you want to use reCAPTCHA.

This function creates submit button therefore you don't have to insert  `<input type="submit">`  or similar.

You can also use  `ReCaptcha::recaptchaHtmlFormButton($buttonInnerHTML)`  .

`$buttonInnerHTML`  is what you want to write on the submit button

```html
<form id="{{ formId }}">
    ...
    {!! recaptchaHtmlFormButton(/* $buttonInnerHTML - Optional */) !!}
</form>

```

**!!!IMPORTANT!!!**  Use as  `$formId`  the same value you previously set in  `recaptchaApiJsScriptTag`  function.

## Verify submitted data

Add  **recaptcha**  to your rules

```php
$v = Validator::make(request()->all(), [
    ...
    'g-recaptcha-response' => 'recaptcha',
]);

```

Print form errors

```php
$errors = $v->errors();
```

# How to use v3

## Embed in Blade

Insert  `recaptchaApiV3JsScriptTag($config)`  helper before closing  `</head>`  tag.

```html
<!DOCTYPE html>
<html>
    <head>
        ...
        {!! recaptchaApiV3JsScriptTag([
            'action' => 'homepage',
            'callback_then' => 'callbackThen',
            'callback_catch' => 'callbackCatch'
        ]) !!}

        <!-- OR! -->
        
        {!! recaptchaApiV3JsScriptTag([
            'action' => 'homepage',
            'custom_validation' => 'myCustomValidation'
        ]) !!}
    </head>

```

`$config`  is required and is an associative array containing configuration parameters required for the JavaScript validation handling.

The keys are:

| Key | Required | Description | Default value |
|---|---|---|---|
| `action` | no | is the  `action`  parameter required by reCAPTCHA v3 API ([further info](https://developers.google.com/recaptcha/docs/v3)) | `homepage` |
| `custom_validation` | no | is the name of your custom callback javascript function who will override the built-in javascript validation system of this package | empty string |
| `callback_then` | no | (overlooked if  `custom_validation`is set) is the name of your custom callback javascript function called by the built-in javascript validation system of this package in case of response success | empty string |
| `callback_catch` | no | (overlooked if  `custom_validation`is set) is the name of your custom callback javascript function called by the built-in javascript validation system in this package in case of response fault | empty string |

## Built-in javascript validation system

As callback of  `grecaptcha.execute`  an AJAX call to  `config('recaptcha.validation_route')`  will be performed using  `fetch`  function. In case of successful response a Promise object will be received and passed as parameter to the  `callback_then`  function you have set. In not set, no actions will be performed.

Same will happen with  `callback_catch`.  `callback_catch`  will be called in event of response errors and errors will pass as parameter et that function. If not set, no actions will be performed.

Please, go to  [Using Fetch](https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch)  for further information on  `fetch`  javascript function.

> **Warning: Check browser compatibility**  `fetch`  function has compatibility issues with some browser like IE. Please create a custom validation function and set  `custom_validation`  with its name. That function has to accept as argument the  `token`received from Google reCAPTCHA API.
> 
> [Fetch browser compatibility](https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch#Browser_compatibility)

### Validation Laravel route

Default validation route is  `config('recaptcha.validation_route', 'lara-recaptcha/validate')`.  
Route and relative Controller are built-in in the package. The route if filtered and protected by Laravel  `web`  Middleware, that's why is important you embed  `csrf-token`  HTML meta tag and send  `X-Requested-Wit`  and  `X-CSRF-TOKEN`  headers.

You can also change the validation end-point changing  `validation_route`  value in  `recaptcha.php`  config file.

```html
<head>
    ...
    <!-- IMPORTANT!!! remember CSRF token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

```

### Validation response object

The output will be a JSON containing following data:

-   **Default output without errors**

```json
{
    "action":"homepage",
    "challenge_ts":"2019-01-29T00:42:08Z",
    "hostname":"www.yourdomain.tld",
    "score":0.9,
    "success":true
}

```

-   **Output when calling IP is included in "skip_ip" config whitelist**

```json
{
    "skip_by_ip":true,
    "score":0.9,
    "success":true
}

```

> If you embed code in your blade file using  `recaptchaApiV3JsScriptTag`  helper no validation call will be performed!

-   **Output with an empty response from Google reCAPTCHA API**

```json
{
    "error":"cURL response empty",
    "score":0.1,
    "success":false
}

```

In the next paragraph you can learn how handle Validation promise object

### "callback_then" and "callback_catch"

After built-in validation you should do something. How? Using  `callback_then`  and  `callback_catch`  functions.

What you have to do is just create functions and set parameters with their names.

-   `callback_then`  must receive one argument of type  `Promise`.
    
-   `callback_catch`  must receive one argument of type  `string`
    

The result should be something like that:

```html
<head>
    ...
    <!-- IMPORTANT!!! remember CSRF token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    ...
    <script type="text/javascript">
        function callbackThen(response){
            // read HTTP status
            console.log(response.status);
            
            // read Promise object
            response.json().then(function(data){
                console.log(data);
            });
        }
        function callbackCatch(error){
            console.error('Error:', error)
        }   
    </script>    
    ...
    {!! recaptchaApiV3JsScriptTag([
        'action' => 'homepage',
        'callback_then' => 'callbackThen',
        'callback_catch' => 'callbackCatch'
    ]) !!}    
</head>

```

### "custom_validation" function

As just said you can handle validation with your own function. To do that you have to write your function and set  `custom_validation`  parameter with its name.

The result should be something like that:

```html
<head>
    ...
    <!-- IMPORTANT!!! remember CSRF token --> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    ...
    <script type="text/javascript">
        function myCustomValidation(token) {
            // do something with token 
        }
    </script>    
    ...
    {!! htmlScriptTagJsApiV3([
        'action' => 'homepage',
        'custom_validation' => 'myCustomValidation'
    ]) !!}    
</head>
```

## License  
Under MIT License
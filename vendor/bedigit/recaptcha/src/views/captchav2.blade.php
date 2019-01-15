<?php
if ( ! function_exists('renderDataAttributes')) {
    function renderDataAttributes($attributes)
    {
        $mapped = [ ];
        foreach ($attributes as $key => $value) {
            $mapped[] = 'data-' . $key . '="' . $value . '"';
        };

        return implode(' ', $mapped);
    }
}
$divID = 'recap_'.uniqid();
?>
@if(!$jsincluded)
    @if(!empty($options))
        <script type="text/javascript">
            var RecaptchaOptions = <?=json_encode($options) ?>;

            function CaptchaCallback() {
                $('.g-recaptcha').each(function(){
                    grecaptcha.render($(this).attr('id'), {'sitekey' : '{{ $public_key }}'});

                })
            }
        </script>
    @endif
    <script src='https://www.google.com/recaptcha/api.js?onload=CaptchaCallback{{ (isset($lang) ? '&hl='.$lang : '') }}&render=explicit'></script>
    <?php
        View::share('jsincluded', true);
    ?>
@endif
<div id="{{ $divID }}" class="g-recaptcha" data-sitekey="{{ $public_key }}" <?=renderDataAttributes($dataParams)?>></div>


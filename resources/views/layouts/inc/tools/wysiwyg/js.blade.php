{{-- Simditor --}}
@if (config('settings.single.simditor_wysiwyg'))
    <script src="{{ asset('assets/plugins/simditor/scripts/mobilecheck.js') }}"></script>
    <script src="{{ asset('assets/plugins/simditor/scripts/module.js') }}"></script>
    <script src="{{ asset('assets/plugins/simditor/scripts/uploader.js') }}"></script>
    <script src="{{ asset('assets/plugins/simditor/scripts/hotkeys.js') }}"></script>
    <script src="{{ asset('assets/plugins/simditor/scripts/simditor.js') }}"></script>
    <script type="text/javascript">
        (function() {
            $(function() {
                var $preview, editor, mobileToolbar, toolbar, allowedTags;
                Simditor.locale = '{{ config('app.locale') }}-{{ config('country.code') }}';
                toolbar = ['bold','italic','underline','fontScale','|','ol','ul','blockquote','table','link'];
                mobileToolbar = ["bold", "italic", "underline", "ul", "ol"];
                if (mobilecheck()) {
                    toolbar = mobileToolbar;
                }
                allowedTags = ['br','span','a','img','b','strong','i','strike','u','font','p','ul','ol','li','blockquote','pre','h1','h2','h3','h4','hr','table'];
                editor = new Simditor({
                    textarea: $('#description'),
                    placeholder: '{{ t('Describe what makes your ad unique') }}...',
                    toolbar: toolbar,
                    pasteImage: false,
                    defaultImage: '{{ asset('assets/plugins/simditor/images/image.png') }}',
                    upload: false,
                    allowedTags: allowedTags
                });
                $preview = $('#preview');
                if ($preview.length > 0) {
                    return editor.on('valuechanged', function(e) {
                        return $preview.html(editor.getValue());
                    });
                }
            });
        }).call(this);
    </script>
@endif

{{-- CKEditor --}}
{{-- Use this plugin by deactiving the "Simditor WYSIWYG Editor" --}}
@if (!config('settings.single.simditor_wysiwyg') && config('settings.single.ckeditor_wysiwyg'))
    <script src="{{ asset('vendor/admin/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/admin/ckeditor/adapters/jquery.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            CKEDITOR.config.toolbar = [
                ['Bold','Italic','Underline','Strike','-','RemoveFormat','-','NumberedList','BulletedList','-','Undo','Redo','-','Table','-','Link','Unlink','Smiley','Source']
            ];
            $('textarea[name="description"].ckeditor').ckeditor({
                language: '{{ config('app.locale') }}'
            });
        });
    </script>
@endif

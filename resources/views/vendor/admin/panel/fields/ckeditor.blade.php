<!-- CKeditor -->
<div @include('admin::panel.inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    <textarea
    	id="ckeditor-{{ $field['name'] }}"
        name="{{ $field['name'] }}"
        @include('admin::panel.inc.field_attributes', ['default_class' => 'form-control ckeditor'])
    	>{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}</textarea>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($xPanel->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script src="{{ asset('vendor/admin/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('vendor/admin/ckeditor/adapters/jquery.js') }}"></script>
    @endpush

@endif

{{-- FIELD JS - will be loaded in the after_scripts section --}}
@push('crud_fields_scripts')
<script>
    jQuery(document).ready(function($) {
        // CKEdito Toolbar
        CKEDITOR.config.toolbar = [
            ['Bold','Italic','Underline','Strike','-','RemoveFormat','-','NumberedList','BulletedList','-','Undo','Redo','-','Table','-','Link','Unlink','Smiley','Source']
        ];
        $('textarea[name="{{ $field['name'] }}"].ckeditor').ckeditor({
            //"extraPlugins" : '{{ isset($field['extra_plugins']) ? implode(',', $field['extra_plugins']) : 'oembed,widget' }}',
            language: '{{ config('app.locale') }}'
        });
    });
</script>
@endpush

{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}

<!-- text input -->
<div @include('admin::panel.inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>

	{{-- Show the file name and a "Clear" button on EDIT form. --}}
    @if (isset($field['value']) && $field['value']!=null)
    <div class="well well-sm">
    	<a target="_blank" href="{{ isset($field['disk'])?asset(\Storage::disk($field['disk'])->url($field['value'])):asset(\Storage::url($field['value'])) }}">{{ $field['value'] }}</a>
    	<a id="{{ $field['name'] }}_file_clear_button" href="#" class="btn btn-default btn-xs pull-right" title="Clear file"><i class="fa fa-remove"></i></a>
    	<div class="clearfix"></div>
    </div>
    @endif

	{{-- Show the file picker on CREATE form. --}}
	<input
        type="file"
        id="{{ $field['name'] }}_file_input"
        name="{{ $field['name'] }}"
        value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
        @include('admin::panel.inc.field_attributes', ['default_class' =>  isset($field['value']) && $field['value']!=null?'form-control hidden':'form-control'])
    >

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- FIELD EXTRA JS --}}
{{-- push things in the after_scripts section --}}

    @push('crud_fields_scripts')
        <!-- no scripts -->
        <script>
	        $("#{{ $field['name'] }}_file_clear_button").click(function(e) {
	        	e.preventDefault();
	        	$(this).parent().addClass('hidden');

	        	var input = $("#{{ $field['name'] }}_file_input");
	        	input.removeClass('hidden');
	        	input.attr("value", "").replaceWith(input.clone(true));
	        	// add a hidden input with the same name, so that the setXAttribute method is triggered
	        	$("<input type='hidden' name='{{ $field['name'] }}' value=''>").insertAfter("#{{ $field['name'] }}_file_input");
	        });

	        $("#{{ $field['name'] }}_file_input").change(function() {
	        	console.log($(this).val());
	        	// remove the hidden input, so that the setXAttribute method is no longer triggered
	        	$(this).next("input[type=hidden]").remove();
	        });
        </script>
    @endpush
@if (isset($customFields) and $customFields->count() > 0)
	<form id="cfForm" role="form" class="form" action="{{ $fullUrlNoParams }}" method="GET">
		{!! csrf_field() !!}
		<?php
		$clearAll = '';
		$firstFieldFound = false;
		?>
		@foreach($customFields as $field)
			@continue(in_array($field->type, ['file', 'text', 'textarea']))
			<?php
			// Fields parameters
			$fieldId = 'cf.' . $field->tid;
			$fieldName = 'cf[' . $field->tid . ']';
			$fieldOld = 'cf.' . $field->tid;
			
			// Get the default value
			$defaulValue = (request()->filled($fieldOld)) ? request()->input($fieldOld) : $field->default;
			
			// Field Query String
			$fieldQueryString = '<input type="hidden" id="cf' . $field->tid . 'QueryString" value="' . httpBuildQuery(request()->except(['page', $fieldId])) . '">';
			
			// Clear All link
			if (request()->filled('cf')) {
				if (!$firstFieldFound) {
					$clearTitle = t('Clear all the :category\'s filters', ['category' => $cat->name]);
					$clearAll = '<a href="' . qsurl($fullUrlNoParams, request()->except(['page', 'cf'])) . '" title="' . $clearTitle . '">
									<span class="small" style="float: right;">' . t('Clear all') . '</span>
								</a>';
					$firstFieldFound = true;
				} else {
					$clearAll = '';
				}
			}
			?>
			
			@if ($field->type == 'checkbox')
				
				<!-- checkbox -->
				<div class="block-title has-arrow sidebar-header">
					<h5><strong><a href="#">{{ $field->name }}</a></strong> {!! $clearAll !!}</h5>
				</div>
				<div class="block-content list-filter">
					<div class="filter-content">
						<div class="form-check">
							<input id="{{ $fieldId }}"
								   name="{{ $fieldName }}"
								   value="1"
								   type="checkbox"
								   class="form-check-input"
									{{ ($defaulValue=='1') ? 'checked="checked"' : '' }}
							>
							<label class="form-check-label" for="{{ $fieldId }}">
								{{ $field->name }}
							</label>
						</div>
					</div>
				</div>
				{!! $fieldQueryString !!}
				<div style="clear:both"></div>
			
			@endif
			@if ($field->type == 'checkbox_multiple')
				
				@if ($field->options->count() > 0)
					<!-- checkbox_multiple -->
					<div class="block-title has-arrow sidebar-header">
						<h5><strong><a href="#">{{ $field->name }}</a></strong> {!! $clearAll !!}</h5>
					</div>
					<div class="block-content list-filter">
						<div class="filter-content">
							@foreach ($field->options as $option)
								<?php
								// Get the default value
								$defaulValue = (request()->filled($fieldOld . '.' . $option->tid))
									? request()->input($fieldOld . '.' . $option->tid)
									: (
										(is_array($field->default) && isset($field->default[$option->tid]) && isset($field->default[$option->tid]->value))
											? $field->default[$option->tid]->value
											: $field->default
									);
								
								// Field Query String
								$fieldQueryString = '<input type="hidden" id="cf' . $field->tid . $option->tid . 'QueryString"
									value="' . httpBuildQuery(request()->except(['page', $fieldId . '.' . $option->tid])) . '">';
								?>
								<div class="form-check">
									<input id="{{ $fieldId . '.' . $option->tid }}"
										   name="{{ $fieldName . '[' . $option->tid . ']' }}"
										   value="{{ $option->tid }}"
										   type="checkbox"
										   class="form-check-input"
											{{ ($defaulValue==$option->tid) ? 'checked="checked"' : '' }}
									>
									<label class="form-check-label" for="{{ $fieldId . '.' . $option->tid }}">
										{{ $option->value }}
									</label>
								</div>
								{!! $fieldQueryString !!}
							@endforeach
						</div>
					</div>
					<div style="clear:both"></div>
				@endif
			
			@endif
			@if ($field->type == 'radio')
				
				@if ($field->options->count() > 0)
					<!-- radio -->
					<div class="block-title has-arrow sidebar-header">
						<h5><strong><a href="#">{{ $field->name }}</a></strong> {!! $clearAll !!}</h5>
					</div>
					<div class="block-content list-filter">
						<div class="filter-content">
							@foreach ($field->options as $option)
								<div class="form-check">
									<input id="{{ $fieldId }}"
										   name="{{ $fieldName }}"
										   value="{{ $option->tid }}"
										   type="radio"
										   class="form-check-input"
											{{ ($defaulValue==$option->tid) ? 'checked="checked"' : '' }}
									>
									<label class="form-check-label" for="{{ $fieldId }}">
										{{ $option->value }}
									</label>
								</div>
							@endforeach
						</div>
					</div>
					{!! $fieldQueryString !!}
					<div style="clear:both"></div>
				@endif
				
			@endif
			@if ($field->type == 'select')
			
				<!-- select -->
				<div class="block-title has-arrow sidebar-header">
					<h5><strong><a href="#">{{ $field->name }}</a></strong> {!! $clearAll !!}</h5>
				</div>
				<div class="block-content list-filter">
					<div class="filter-content">
						<?php
							$select2Type = ($field->options->count() <= 10) ? 'selecter' : 'sselecter';
						?>
						<select id="{{ $fieldId }}" name="{{ $fieldName }}" class="form-control {{ $select2Type }}">
							<option value=""
									@if (old($fieldOld)=='' or old($fieldOld)==0)
										selected="selected"
									@endif
							>
								{{ t('Select') }}
							</option>
							@if ($field->options->count() > 0)
								@foreach ($field->options as $option)
									<option value="{{ $option->tid }}"
											@if ($defaulValue==$option->tid)
												selected="selected"
											@endif
									>
										{{ $option->value }}
									</option>
								@endforeach
							@endif
						</select>
					</div>
				</div>
				{!! $fieldQueryString !!}
				<div style="clear:both"></div>
			
			@endif
			
		@endforeach
	</form>
	<div style="clear:both"></div>
@endif

@section('after_scripts')
	@parent
	<script>
		$(document).ready(function ()
		{
			/* Select */
			$('#cfForm').find('select').change(function() {
				/* Get full field's ID */
				var fullFieldId = $(this).attr('id');
				
				/* Get full field's ID without dots */
				var jsFullFieldId = fullFieldId.split('.').join('');
				
				/* Get real field's ID */
				var tmp = fullFieldId.split('.');
				if (typeof tmp[1] !== 'undefined') {
					var fieldId = tmp[1];
				} else {
					return false;
				}
				
				/* Get saved QueryString */
				var fieldQueryString = $('#' + jsFullFieldId + 'QueryString').val();
				
				/* Add the field's value to the QueryString */
				if (fieldQueryString != '') {
					fieldQueryString = fieldQueryString + '&';
				}
				fieldQueryString = fieldQueryString + 'cf['+fieldId+']=' + $(this).val();
				
				/* Redirect to the new search URL */
				var searchUrl = baseUrl + '?' + fieldQueryString;
				redirect(searchUrl);
			});
			
			/* Radio & Checkbox */
			$('#cfForm').find('input[type=radio], input[type=checkbox]').click(function() {
				/* Get full field's ID */
				var fullFieldId = $(this).attr('id');
				
				/* Get full field's ID without dots */
				var jsFullFieldId = fullFieldId.split('.').join('');
				
				/* Get real field's ID */
				var tmp = fullFieldId.split('.');
				if (typeof tmp[1] !== 'undefined') {
					var fieldId = tmp[1];
					if (typeof tmp[2] !== 'undefined') {
						var fieldOptionId = tmp[2];
					}
				} else {
					return false;
				}
				
				/* Get saved QueryString */
				var fieldQueryString = $('#' + jsFullFieldId + 'QueryString').val();
				
				/* Check if field is checked */
				if ($(this).prop('checked') == true) {
					/* Add the field's value to the QueryString */
					if (fieldQueryString != '') {
						fieldQueryString = fieldQueryString + '&';
					}
					if (typeof fieldOptionId !== 'undefined') {
						fieldQueryString = fieldQueryString + 'cf[' + fieldId + '][' + fieldOptionId + ']=' + rawurlencode($(this).val());
					} else {
						fieldQueryString = fieldQueryString + 'cf[' + fieldId + ']=' + $(this).val();
					}
				}
				
				/* Redirect to the new search URL */
				var searchUrl = baseUrl + '?' + fieldQueryString;
				redirect(searchUrl);
			});
		});
	</script>
@endsection
<?php
	if (!isset($languageCode) or empty($languageCode)) {
		$languageCode = config('app.locale', session('language_code'));
	}
?>
@if (isset($fields) and $fields->count() > 0)
	@foreach($fields as $field)
		<?php
		// Fields parameters
		$fieldId = 'cf.' . $field->tid;
        $fieldName = 'cf[' . $field->tid . ']';
		$fieldOld = 'cf.' . $field->tid;
        
        // Errors & Required CSS
        $requiredClass = ($field->required == 1) ? 'required' : '';
        $errorClass = (isset($errors) && $errors->has($fieldOld)) ? ' is-invalid' : '';
        
        // Get the default value
        $defaultValue = (isset($oldInput) && isset($oldInput[$field->tid])) ? $oldInput[$field->tid] : $field->default;
		?>
		
		@if ($field->type == 'checkbox')
			
			<!-- checkbox -->
			<div class="form-group row {{ $requiredClass }}" style="margin-top: -10px;">
				<label class="col-md-3 col-form-label" for="{{ $fieldId }}"></label>
				<div class="col-md-8">
					<div class="form-check pt-2 pl-0">
						<input id="{{ $fieldId }}"
							   name="{{ $fieldName }}"
							   value="1"
							   type="checkbox"
							   class="form-check-input{{ $errorClass }}"
								{{ ($defaultValue=='1') ? 'checked="checked"' : '' }}
						>
						<label class="form-check-label" for="{{ $fieldId }}">
							{{ $field->name }}
						</label>
					</div>
					<small id="" class="form-text text-muted">{!! $field->help !!}</small>
				</div>
			</div>
		
		@elseif ($field->type == 'checkbox_multiple')
			
			@if ($field->options->count() > 0)
				<!-- checkbox_multiple -->
				<div class="form-group row {{ $requiredClass }}" style="margin-top: -10px;">
					<label class="col-md-3 col-form-label" for="{{ $fieldId }}">
						{{ $field->name }}
						@if ($field->required == 1)
							<sup>*</sup>
						@endif
					</label>
					<div class="col-md-8">
						@foreach ($field->options as $option)
							<?php
							// Get the default value
							$defaultValue = (isset($oldInput) && isset($oldInput[$field->tid]) && isset($oldInput[$field->tid][$option->tid]))
								? $oldInput[$field->tid][$option->tid]
								: (
								(is_array($field->default) && isset($field->default[$option->tid]) && isset($field->default[$option->tid]->tid))
									? $field->default[$option->tid]->tid
									: $field->default
								);
							?>
							<div class="form-check pt-2">
								<input id="{{ $fieldId . '.' . $option->tid }}"
									   name="{{ $fieldName . '[' . $option->tid . ']' }}"
									   value="{{ $option->tid }}"
									   type="checkbox"
									   class="form-check-input{{ $errorClass }}"
										{{ ($defaultValue==$option->tid) ? 'checked="checked"' : '' }}
								>
								<label class="form-check-label" for="{{ $fieldId . '.' . $option->tid }}">
									 {{ $option->value }}
								</label>
							</div>
						@endforeach
						<small id="" class="form-text text-muted">{!! $field->help !!}</small>
					</div>
				</div>
			@endif
			
		@elseif ($field->type == 'file')
			
			<!-- file -->
			<div class="form-group row {{ $requiredClass }}">
				<label class="col-md-3 col-form-label" for="{{ $fieldId }}">
					{{ $field->name }}
					@if ($field->required == 1)
						<sup>*</sup>
					@endif
				</label>
				<div class="col-md-8">
					<div class="mb10">
						<input id="{{ $fieldId }}" name="{{ $fieldName }}" type="file" class="file{{ $errorClass }}">
					</div>
					<small id="" class="form-text text-muted">
						{!! $field->help !!} {{ t('File types: :file_types', ['file_types' => showValidFileTypes('file')], 'global', $languageCode) }}
					</small>
					@if (!empty($field->default) and \Storage::exists($field->default))
						<div>
							<a class="btn btn-default" href="{{ \Storage::url($field->default) }}" target="_blank">
								<i class="icon-attach-2"></i> {{ t('Download') }}
							</a>
						</div>
					@endif
				</div>
			</div>
		
		@elseif ($field->type == 'radio')
			
			@if ($field->options->count() > 0)
				<!-- radio -->
				<div class="form-group row {{ $requiredClass }}">
					<label class="col-md-3 col-form-label" for="{{ $fieldId }}">
						{{ $field->name }}
						@if ($field->required == 1)
							<sup>*</sup>
						@endif
					</label>
					<div class="col-md-8">
						@foreach ($field->options as $option)
							<div class="form-check pt-2">
								<input id="{{ $fieldId }}"
									   name="{{ $fieldName }}"
									   value="{{ $option->tid }}"
									   type="radio"
									   class="form-check-input{{ $errorClass }}"
										{{ ($defaultValue==$option->tid) ? 'checked="checked"' : '' }}
								>
								<label class="form-check-label" for="{{ $fieldName }}">
									{{ $option->value }}
								</label>
							</div>
						@endforeach
					</div>
					<small id="" class="form-text text-muted">{!! $field->help !!}</small>
				</div>
			@endif
		
		@elseif ($field->type == 'select')
			
			<!-- select -->
			<div class="form-group row {{ $requiredClass }}">
				<label class="col-md-3 col-form-label{{ $errorClass }}" for="{{ $fieldId }}">
					{{ $field->name }}
					@if ($field->required == 1)
						<sup>*</sup>
					@endif
				</label>
				<div class="col-md-8">
                    <?php
                    	$select2Type = ($field->options->count() <= 10) ? 'selecter' : 'sselecter';
                    ?>
					<select id="{{ $fieldId }}" name="{{ $fieldName }}" class="form-control {{ $select2Type . $errorClass }}">
						<option value="{{ $field->default }}"
								@if (old($fieldOld)=='' or old($fieldOld)==$field->default)
									selected="selected"
								@endif
						>
							{{ t('Select', [], 'global', $languageCode) }}
						</option>
						@if ($field->options->count() > 0)
							@foreach ($field->options as $option)
								<option value="{{ $option->tid }}"
										@if ($defaultValue==$option->tid)
											selected="selected"
										@endif
								>
									{{ $option->value }}
								</option>
							@endforeach
						@endif
					</select>
				</div>
				<small id="" class="form-text text-muted">{!! $field->help !!}</small>
			</div>
		
		@elseif ($field->type == 'textarea')
			
			<!-- textarea -->
			<div class="form-group row {{ $requiredClass }}">
				<label class="col-md-3 col-form-label" for="{{ $fieldId }}">
					{{ $field->name }}
					@if ($field->required == 1)
						<sup>*</sup>
					@endif
				</label>
				<div class="col-md-8">
					<textarea class="form-control{{ $errorClass }}"
							  id="{{ $fieldId }}"
							  name="{{ $fieldName }}"
							  placeholder="{{ $field->name }}"
							  rows="10">{{ $defaultValue }}</textarea>
					<small id="" class="form-text text-muted">{!! $field->help !!}</small>
				</div>
			</div>
			
		@else
			
			<!-- text -->
			<div class="form-group row {{ $requiredClass }}">
				<label class="col-md-3 col-form-label" for="{{ $fieldId }}">
					{{ $field->name }}
					@if ($field->required == 1)
						<sup>*</sup>
					@endif
				</label>
				<div class="col-md-8">
					<input id="{{ $fieldId }}"
						   name="{{ $fieldName }}"
						   type="text"
						   placeholder="{{ $field->name }}"
						   class="form-control input-md{{ $errorClass }}"
						   value="{{ $defaultValue }}">
					<small id="" class="form-text text-muted">{!! $field->help !!}</small>
				</div>
			</div>
			
		@endif
	@endforeach
@endif
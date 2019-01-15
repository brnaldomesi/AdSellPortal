@if (isset($customFields) and $customFields->count() > 0)
	<div class="row" id="customFields">
		<div class="col-xl-12">
			<div class="row pl-2 pr-2">
				<div class="col-xl-12 pb-2 pl-1 pr-1">
					<h4><i class="icon-th-list"></i> {{ t('Additional Details') }}</h4>
				</div>
			</div>
		</div>
		
		<div class="col-xl-12">
			<div class="row pl-2 pr-2">
				@foreach($customFields as $field)
					<?php
					if (in_array($field->type, ['radio', 'select'])) {
						if (is_numeric($field->default)) {
							$option = \App\Models\FieldOption::findTrans($field->default);
							if (!empty($option)) {
								$field->default = $option->value;
							}
						}
					}
					if (in_array($field->type, ['checkbox'])) {
						$field->default = ($field->default == 1) ? t('Yes') : t('No');
					}
					?>
					@if ($field->type == 'file')
						<div class="detail-line col-xl-12 pb-2 pl-1 pr-1">
							<div class="rounded-small ml-0 mr-0 p-2">
								<span class="detail-line-label" style="padding-top: 8px;">{{ $field->name }}</span>
								<span class="detail-line-value">
									<a class="btn btn-default" href="{{ \Storage::url($field->default) }}" target="_blank">
										<i class="icon-attach-2"></i> {{ t('Download') }}
									</a>
								</span>
							</div>
						</div>
					@else
						@if (!is_array($field->default))
							<div class="detail-line col-sm-6 col-xs-12 pb-2 pl-1 pr-1">
								<div class="rounded-small p-2">
									<span class="detail-line-label">{{ $field->name }}</span>
									<span class="detail-line-value">{{ $field->default }}</span>
								</div>
							</div>
						@else
							@if (count($field->default) > 0)
							<div class="detail-line col-xl-12 pb-2 pl-1 pr-1">
								<div class="rounded-small p-2">
									<span>{{ $field->name }}:</span>
									<div class="row m-0 p-2">
										@foreach($field->default as $valueItem)
											@continue(!isset($valueItem->value))
											<div class="col-sm-4 col-xs-6 col-xxs-12">
												<div class="m-0">
													<i class="fa fa-check"></i> {{ $valueItem->value }}
												</div>
											</div>
										@endforeach
									</div>
								</div>
							</div>
							@endif
						@endif
					@endif
				@endforeach
			</div>
		</div>
	</div>
@endif

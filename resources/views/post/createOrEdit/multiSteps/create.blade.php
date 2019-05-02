{{--
 * LaraClassified - Classified Ads Web Application
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
--}}
@extends('layouts.master')

@section('wizard')
	@include('post.createOrEdit.multiSteps.inc.wizard')
@endsection

@section('content')
	@include('common.spacer')
	<div class="main-container">
		<div class="container">
			<div class="row">
				
				@include('post.inc.notification')

				<div class="col-md-9 page-content">
					<div class="inner-box category-content">
						<h2 class="title-2">
							<strong><i class="icon-docs"></i> {{ t('Post Free Ads') }}</strong>
						</h2>
						
						<div class="row">
							<div class="col-xl-12">
								
								<form class="form-horizontal" id="postForm" method="POST" action="{{ url()->current() }}" enctype="multipart/form-data">
									{!! csrf_field() !!}
									<fieldset>

										<!-- parent_id -->
										<?php $parentIdError = (isset($errors) and $errors->has('category_id')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-3 col-form-label{{ $parentIdError }}">{{ t('Category') }} <sup>*</sup></label>
											<div class="col-md-8">
												<select name="parent_id" id="parentId" class="form-control selecter{{ $parentIdError }}">
													<option value="0" data-type=""
															@if (old('parent_id')=='' or old('parent_id')==0)
																selected="selected"
															@endif
													> {{ t('Select a category') }} </option>
													@foreach ($categories as $cat)
														<option value="{{ $cat->tid }}" data-type="{{ $cat->type }}"
																@if (old('parent_id')==$cat->tid)
																	selected="selected"
																@endif
														> {{ $cat->name }} </option>
													@endforeach
												</select>
												<input type="hidden" name="parent_type" id="parentType" value="{{ old('parent_type') }}">
											</div>
										</div>

										<!-- category_id -->
										<?php $categoryIdError = (isset($errors) and $errors->has('category_id')) ? ' is-invalid' : ''; ?>
										<div id="subCatBloc" class="form-group row required">
											<label class="col-md-3 col-form-label{{ $categoryIdError }}">{{ t('Sub-Category') }} <sup>*</sup></label>
											<div class="col-md-8">
												<select name="category_id" id="categoryId" class="form-control selecter{{ $categoryIdError }}">
													<option value="0"
															@if (old('category_id')=='' or old('category_id')==0)
																selected="selected"
															@endif
													> {{ t('Select a sub-category') }} </option>
												</select>
											</div>
										</div>

										<!-- post_type_id -->
										<?php $postTypeIdError = (isset($errors) and $errors->has('post_type_id')) ? ' is-invalid' : ''; ?>
										<div id="postTypeBloc" class="form-group row required">
											<label class="col-md-3 col-form-label">{{ t('Type') }} <sup>*</sup></label>
											<div class="col-md-8">
												@foreach ($postTypes as $postType)
												<div class="form-check form-check-inline pt-2">
													<input name="post_type_id"
														   id="postTypeId-{{ $postType->tid }}"
														   value="{{ $postType->tid }}"
														   type="radio"
														   class="form-check-input{{ $postTypeIdError }}" {{ (old('post_type_id')==$postType->tid) ? 'checked="checked"' : '' }}
													>
													<label class="form-check-label" for="postTypeId-{{ $postType->tid }}">
														{{ $postType->name }}
													</label>
												</div>
												@endforeach
											</div>
										</div>

										<!-- title -->
										<?php $titleError = (isset($errors) and $errors->has('title')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-3 col-form-label" for="title">{{ t('Title') }} <sup>*</sup></label>
											<div class="col-md-8">
												<input id="title" name="title" placeholder="{{ t('Ad title') }}" class="form-control input-md{{ $titleError }}"
													   type="text" value="{{ old('title') }}">
												<small id="" class="form-text text-muted">{{ t('A great title needs at least 60 characters.') }}</small>
											</div>
										</div>

										<!-- description -->
										<?php $descriptionError = (isset($errors) and $errors->has('description')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<?php
												$descriptionErrorLabel = '';
												$descriptionColClass = 'col-md-8';
												if (config('settings.single.simditor_wysiwyg') or config('settings.single.ckeditor_wysiwyg')) {
													$descriptionColClass = 'col-md-12';
													$descriptionErrorLabel = $descriptionError;
												}
												$ckeditorClass = (config('settings.single.ckeditor_wysiwyg')) ? ' ckeditor' : '';
											?>
											<label class="col-md-3 col-form-label{{ $descriptionErrorLabel }}" for="description">
												{{ t('Description') }} <sup>*</sup>
											</label>
											<div class="{{ $descriptionColClass }}">
												<textarea class="form-control{{ $ckeditorClass . $descriptionError }}"
														  id="description"
														  name="description"
														  rows="10"
												>{{ old('description') }}</textarea>
												<small id="" class="form-text text-muted">{{ t('Describe what makes your ad unique') }}...</small>
											</div>
										</div>
										
										<!-- customFields -->
										<div id="customFields"></div>

										<!-- price -->
										<?php $priceError = (isset($errors) and $errors->has('price')) ? ' is-invalid' : ''; ?>
										<div id="priceBloc" class="form-group row">
											<label class="col-md-3 col-form-label" for="price">{{ t('Price') }}</label>
											<div class="input-group col-md-8">
												<div class="input-group-prepend">
													<span class="input-group-text">{!! config('currency')['symbol'] !!}</span>
												</div>
												
												<input id="price"
													   name="price"
													   class="form-control{{ $priceError }}"
													   placeholder="{{ t('e.i. 15000') }}"
													   type="text" value="{{ old('price') }}"
												>
												
												<div class="input-group-append">
													<span class="input-group-text">
														<input id="negotiable" name="negotiable" type="checkbox"
															   value="1" {{ (old('negotiable')=='1') ? 'checked="checked"' : '' }}>&nbsp;<small>{{ t('Negotiable') }}</small>
													</span>
												</div>
											</div>
										</div>
										
										<!-- country_code -->
										<?php $countryCodeError = (isset($errors) and $errors->has('country_code')) ? ' is-invalid' : ''; ?>
										@if (empty(config('country.code')))
											<div class="form-group row required">
												<label class="col-md-3 col-form-label{{ $countryCodeError }}" for="country_code">{{ t('Your Country') }} <sup>*</sup></label>
												<div class="col-md-8">
													<select id="countryCode" name="country_code" class="form-control sselecter{{ $countryCodeError }}">
														<option value="0" {{ (!old('country_code') or old('country_code')==0) ? 'selected="selected"' : '' }}> {{ t('Select a country') }} </option>
														@foreach ($countries as $item)
															<option value="{{ $item->get('code') }}" {{ (old('country_code', (!empty(config('ipCountry.code'))) ? config('ipCountry.code') : 0)==$item->get('code')) ? 'selected="selected"' : '' }}>{{ $item->get('name') }}</option>
														@endforeach
													</select>
												</div>
											</div>
										@else
											<input id="countryCode" name="country_code" type="hidden" value="{{ config('country.code') }}">
										@endif
										
										<?php
										/*
										@if (\Illuminate\Support\Facades\Schema::hasColumn('posts', 'address'))
										<!-- address -->
										<div class="form-group required <?php echo ($errors->has('address')) ? ' is-invalid' : ''; ?>">
											<label class="col-md-3 control-label" for="title">{{ t('Address') }} </label>
											<div class="col-md-8">
												<input id="address" name="address" placeholder="{{ t('Address') }}" class="form-control input-md"
													   type="text" value="{{ old('address') }}">
												<span class="help-block">{{ t('Fill an address to display on Google Maps.') }} </span>
											</div>
										</div>
										@endif
										*/
										?>
										
										@if (config('country.admin_field_active') == 1 and in_array(config('country.admin_type'), ['1', '2']))
											<!-- admin_code -->
											<?php $adminCodeError = (isset($errors) and $errors->has('admin_code')) ? ' is-invalid' : ''; ?>
											<div id="locationBox" class="form-group row required">
												<label class="col-md-3 col-form-label{{ $adminCodeError }}" for="admin_code">{{ t('Location') }} <sup>*</sup></label>
												<div class="col-md-8">
													<select id="adminCode" name="admin_code" class="form-control sselecter{{ $adminCodeError }}">
														<option value="0" {{ (!old('admin_code') or old('admin_code')==0) ? 'selected="selected"' : '' }}>
															{{ t('Select your Location') }}
														</option>
													</select>
												</div>
											</div>
										@endif
									
										<!-- city_id -->
										<?php $cityIdError = (isset($errors) and $errors->has('city_id')) ? ' is-invalid' : ''; ?>
										<div id="cityBox" class="form-group row required">
											<label class="col-md-3 col-form-label{{ $cityIdError }}" for="city_id">{{ t('City') }} <sup>*</sup></label>
											<div class="col-md-8">
												<select id="cityId" name="city_id" class="form-control sselecter{{ $cityIdError }}">
													<option value="0" {{ (!old('city_id') or old('city_id')==0) ? 'selected="selected"' : '' }}>
														{{ t('Select a city') }}
													</option>
												</select>
											</div>
										</div>
										
										<!-- tags -->
										<?php $tagsError = (isset($errors) and $errors->has('tags')) ? ' is-invalid' : ''; ?>
										<div class="form-group row">
											<label class="col-md-3 col-form-label" for="tags">{{ t('Tags') }}</label>
											<div class="col-md-8">
												<input id="tags"
													   name="tags"
													   placeholder="{{ t('Tags') }}"
													   class="form-control input-md{{ $tagsError }}"
													   type="text"
													   value="{{ old('tags') }}"
												>
												<small id="" class="form-text text-muted">{{ t('Enter the tags separated by commas.') }}</small>
											</div>
										</div>
										
										
										<div class="content-subheading">
											<i class="icon-user fa"></i>
											<strong>{{ t('Seller information') }}</strong>
										</div>
										
										
										<!-- contact_name -->
										<?php $contactNameError = (isset($errors) and $errors->has('contact_name')) ? ' is-invalid' : ''; ?>
										@if (auth()->check())
											<input id="contact_name" name="contact_name" type="hidden" value="{{ auth()->user()->name }}">
										@else
											<div class="form-group row required">
												<label class="col-md-3 col-form-label" for="contact_name">{{ t('Your name') }} <sup>*</sup></label>
												<div class="col-md-8">
													<input id="contact_name" name="contact_name" placeholder="{{ t('Your name') }}"
														   class="form-control input-md{{ $contactNameError }}" type="text" value="{{ old('contact_name') }}">
												</div>
											</div>
										@endif
									
										<!-- email -->
										<?php $emailError = (isset($errors) and $errors->has('email')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-3 col-form-label" for="email"> {{ t('Email') }} </label>
											<div class="input-group col-md-8">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="icon-mail"></i></span>
												</div>
												
												<input id="email" name="email"
													   class="form-control{{ $emailError }}" placeholder="{{ t('Email') }}" type="text"
													   value="{{ old('email', ((auth()->check() and isset(auth()->user()->email)) ? auth()->user()->email : '')) }}">
											</div>
										</div>
										
										<?php
											if (auth()->check()) {
												$formPhone = (auth()->user()->country_code == config('country.code')) ? auth()->user()->phone : '';
											} else {
												$formPhone = '';
											}
										?>
										<!-- phone -->
										<?php $phoneError = (isset($errors) and $errors->has('phone')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-3 col-form-label" for="phone">{{ t('Phone Number') }}</label>
											<div class="input-group col-md-8">
												<div class="input-group-prepend">
													<span id="phoneCountry" class="input-group-text">{!! getPhoneIcon(config('country.code')) !!}</span>
												</div>
												
												<input id="phone" name="phone"
													   placeholder="{{ t('Phone Number') }}"
													   class="form-control input-md{{ $phoneError }}" type="text"
													   value="{{ phoneFormat(old('phone', $formPhone), old('country', config('country.code'))) }}"
												>
												
												<div class="input-group-append">
													<span class="input-group-text">
														<input name="phone_hidden" id="phoneHidden" type="checkbox"
															   value="1" {{ (old('phone_hidden')=='1') ? 'checked="checked"' : '' }}>&nbsp;<small>{{ t('Hide') }}</small>
													</span>
												</div>
											</div>
										</div>
										
										@if (!auth()->check())
											@if (in_array(config('settings.single.auto_registration'), [1, 2]))
												<!-- auto_registration -->
												@if (config('settings.single.auto_registration') == 1)
													<?php $autoRegistrationError = (isset($errors) and $errors->has('auto_registration')) ? ' is-invalid' : ''; ?>
													<div class="form-group row required">
														<label class="col-md-3 col-form-label"></label>
														<div class="col-md-8">
															<div class="form-check">
																<input name="auto_registration" id="auto_registration"
																	   class="form-check-input{{ $autoRegistrationError }}"
																	   value="1"
																	   type="checkbox"
																	   checked="checked"
																>
																
																<label class="form-check-label" for="auto_registration">
																	{!! t('I want to register by submitting this ad.') !!}
																</label>
															</div>
															<small id="" class="form-text text-muted">{{ t('You will receive your authentication information by email.') }}</small>
															<div style="clear:both"></div>
														</div>
													</div>
												@else
													<input type="hidden" name="auto_registration" id="auto_registration" value="1">
												@endif
											@endif
										@endif
										
										@include('layouts.inc.tools.recaptcha', ['colLeft' => 'col-md-3', 'colRight' => 'col-md-8'])

										<!-- term -->
										<?php $termError = (isset($errors) and $errors->has('term')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-3 col-form-label{{ $termError }}"></label>
											<div class="col-md-8">
												<label class="checkbox mb-0" for="term-0">
													{!! t('By continuing on this website, you accept our <a :attributes>Terms of Use</a>', ['attributes' => getUrlPageByType('terms')]) !!}
												</label>
											</div>
										</div>

										<!-- Button  -->
										<div class="form-group row pt-3">
											<div class="col-md-12 text-center">
												<button id="nextStepBtn" class="btn btn-primary btn-lg"> {{ t('Submit') }} </button>
											</div>
										</div>

									</fieldset>
								</form>

							</div>
						</div>
					</div>
				</div>
				<!-- /.page-content -->

				<div class="col-md-3 reg-sidebar">
					<div class="reg-sidebar-inner text-center">
						<div class="promo-text-box"><i class=" icon-picture fa fa-4x icon-color-1"></i>
							<h3><strong>{{ t('Post Free Ads') }}</strong></h3>
							<p>
								{{ t('Do you have something to sell, to rent, any service to offer or a job offer? Post it at :app_name, its free, local, easy, reliable and super fast!', ['app_name' => config('app.name')]) }}
							</p>
						</div>

						<div class="card sidebar-card">
							<div class="card-header uppercase">
								<small><strong>{{ t('How to sell quickly?') }}</strong></small>
							</div>
							<div class="card-content">
								<div class="card-body text-left">
									<ul class="list-check">
										<li> {{ t('Use a brief title and description of the item') }} </li>
										<li> {{ t('Make sure you post in the correct category') }}</li>
										<li> {{ t('Add nice photos to your ad') }}</li>
										<li> {{ t('Put a reasonable price') }}</li>
										<li> {{ t('Check the item before publish') }}</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('after_styles')
	@include('layouts.inc.tools.wysiwyg.css')
@endsection

@section('after_scripts')
    @include('layouts.inc.tools.wysiwyg.js')

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
	@if (file_exists(public_path() . '/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js'))
		<script src="{{ url('assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js') }}" type="text/javascript"></script>
	@endif
	
	<script>
		/* Translation */
		var lang = {
			'select': {
				'category': "{{ t('Select a category') }}",
				'subCategory': "{{ t('Select a sub-category') }}",
				'country': "{{ t('Select a country') }}",
				'admin': "{{ t('Select a location') }}",
				'city': "{{ t('Select a city') }}"
			},
			'price': "{{ t('Price') }}",
			'salary': "{{ t('Salary') }}",
			'nextStepBtnLabel': {
			    'next': "{{ t('Next') }}",
                'submit': "{{ t('Submit') }}"
			}
		};
		
		/* Categories */
		var category = {{ old('parent_id', 0) }};
		var categoryType = '{{ old('parent_type') }}';
		if (categoryType=='') {
			var selectedCat = $('select[name=parent_id]').find('option:selected');
			categoryType = selectedCat.data('type');
		}
		var subCategory = {{ old('category_id', 0) }};
		
		/* Custom Fields */
		var errors = '{!! addslashes($errors->toJson()) !!}';
		var oldInput = '{!! addslashes(collect(session()->getOldInput('cf'))->toJson()) !!}';
		var postId = '';
		
		/* Locations */
        var countryCode = '{{ old('country_code', config('country.code', 0)) }}';
        var adminType = '{{ config('country.admin_type', 0) }}';
        var selectedAdminCode = '{{ old('admin_code', (isset($admin) ? $admin->code : 0)) }}';
        var cityId = '{{ old('city_id', (isset($post) ? $post->city_id : 0)) }}';
		
		/* Packages */
		var packageIsEnabled = false;
        @if (isset($packages) and isset($paymentMethods) and $packages->count() > 0 and $paymentMethods->count() > 0)
            packageIsEnabled = true;
        @endif

	</script>
	<script>
		$(document).ready(function() {
			$('#tags').tagit({
				fieldName: 'tags',
				placeholderText: '{{ t('add a tag') }}',
				caseSensitive: false,
				allowDuplicates: false,
				allowSpaces: false,
				tagLimit: {{ (int)config('settings.single.tags_limit', 15) }},
				singleFieldDelimiter: ','
			});
		});
	</script>
	
	<script src="{{ url('assets/js/app/d.select.category.js') . vTime() }}"></script>
	<script src="{{ url('assets/js/app/d.select.location.js') . vTime() }}"></script>
@endsection

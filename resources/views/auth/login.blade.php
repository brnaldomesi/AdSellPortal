{{--
 * LaraClassified - Geo Classified Ads CMS
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

@section('content')
	@if (!(isset($paddingTopExists) and $paddingTopExists))
		<div class="h-spacer"></div>
	@endif
	<div class="main-container">
		<div class="container">
			<div class="row">

				@if (isset($errors) and $errors->any())
					<div class="col-xl-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif

				@if (Session::has('flash_notification'))
					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif

				@if (config('settings.social_auth.social_login_activation'))
					<div class="col-xl-12">
						<div class="row d-flex justify-content-center">
							<div class="col-8">
								<div class="row mb-3 d-flex justify-content-center pl-3 pr-3">
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
										<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-fb">
											<a href="{{ lurl('auth/facebook') }}" class="btn-fb"><i class="icon-facebook"></i> {!! t('Connect with Facebook') !!}</a>
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
										<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-danger">
											<a href="{{ lurl('auth/google') }}" class="btn-danger"><i class="icon-googleplus-rect"></i> {!! t('Connect with Google') !!}</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endif
					
				<div class="col-lg-5 col-md-8 col-sm-10 col-xs-12 login-box mt-3">
					<form id="loginForm" role="form" method="POST" action="{{ url()->current() }}">
						{!! csrf_field() !!}
						<input type="hidden" name="country" value="{{ config('country.code') }}">
						<div class="card card-default">
							
							<div class="panel-intro text-center">
								<h2 class="logo-title"><strong>{{ t('Log In') }}</strong></h2>
							</div>
							
							<div class="card-body">
								<?php
									$loginValue = (session()->has('login')) ? session('login') : old('login');
									$loginField = getLoginField($loginValue);
									if ($loginField == 'phone') {
										$loginValue = phoneFormat($loginValue, old('country', config('country.code')));
									}
								?>
								<!-- login -->
								<?php $loginError = (isset($errors) and $errors->has('login')) ? ' is-invalid' : ''; ?>
								<div class="form-group">
									<label for="login" class="col-form-label">{{ t('Login') . ' (' . getLoginLabel() . ')' }}:</label>
									<div class="input-icon"><i class="icon-user fa"></i>
										<input id="login" name="login" type="text" placeholder="{{ getLoginLabel() }}" class="form-control{{ $loginError }}" value="{{ $loginValue }}">
									</div>
								</div>
								
								<!-- password -->
								<?php $passwordError = (isset($errors) and $errors->has('password')) ? ' is-invalid' : ''; ?>
								<div class="form-group">
									<label for="password" class="col-form-label">{{ t('Password') }}:</label>
									<div class="input-icon"><i class="icon-lock fa"></i>
										<input id="password" name="password" type="password" class="form-control{{ $passwordError }}" placeholder="{{ t('Password') }}" autocomplete="off">
									</div>
								</div>
								
								@if (config('settings.security.recaptcha_activation'))
									<!-- recaptcha -->
									<?php $recaptchaError = (isset($errors) and $errors->has('g-recaptcha-response')) ? ' is-invalid' : ''; ?>
									<div class="form-group required">
										<div class="no-label">
											{!! Recaptcha::render(['lang' => config('app.locale')]) !!}
										</div>
									</div>
								@endif
								
								<!-- Submit -->
								<div class="form-group">
									<button id="loginBtn" class="btn btn-primary btn-block"> {{ t('Log In') }} </button>
								</div>
							</div>
							
							<div class="card-footer">
								<label class="checkbox pull-left mt-2 mb-2">
									<input type="checkbox" value="1" name="remember" id="remember">
									<span class="custom-control-indicator"></span>
									<span class="custom-control-description"> {{ t('Keep me logged in') }}</span>
								</label>
								<div class="text-center pull-right mt-2 mb-2">
									<a href="{{ lurl('password/reset') }}"> {{ t('Lost your password?') }} </a>
								</div>
								<div style=" clear:both"></div>
							</div>
						</div>
					</form>

					<div class="login-box-btm text-center">
						<p>
							{{ t('Don\'t have an account?') }}<br>
							<a href="{{ lurl(trans('routes.register')) }}"><strong>{{ t('Sign Up') }} !</strong></a>
						</p>
					</div>
				</div>
				
			</div>
		</div>
	</div>
@endsection

@section('after_scripts')
	<script>
		$(document).ready(function () {
			$("#loginBtn").click(function () {
				$("#loginForm").submit();
				return false;
			});
		});
	</script>
@endsection

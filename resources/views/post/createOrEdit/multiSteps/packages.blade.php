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
                
                <div class="col-md-12 page-content">
                    <div class="inner-box">
						
                        <h2 class="title-2"><strong><i class="icon-tag"></i> {{ t('Pricing') }}</strong></h2>
						
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form" id="postForm" method="POST" action="{{ url()->current() }}">
                                    {!! csrf_field() !!}
                                    <input type="hidden" id="post_id" name="post_id" value="{{ $post->id }}">
                                    <fieldset>
                                        
                                        @if (isset($packages) and isset($paymentMethods) and $packages->count() > 0 and $paymentMethods->count() > 0)
                                            <div class="well pb-0">
                                                <h3><i class="icon-certificate icon-color-1"></i> {{ t('Premium Ad') }} </h3>
                                                <p>
                                                    {{ t('The premium package help sellers to promote their products or services by giving more visibility to their ads to attract more buyers and sell faster.') }}
                                                </p>
												<?php $packageIdError = (isset($errors) and $errors->has('package_id')) ? ' is-invalid' : ''; ?>
                                                <div class="form-group mb-0">
                                                    <table id="packagesTable" class="table table-hover checkboxtable mb-0">
														<?php
															// Get Current Payment data
															$currentPaymentMethodId = 0;
															$currentPaymentActive = 1;
															if (isset($post->latestPayment) and !empty($post->latestPayment)) {
																$currentPaymentMethodId = $post->latestPayment->payment_method_id;
																if ($post->latestPayment->active == 0) {
																	$currentPaymentActive = 0;
																}
															}
														?>
                                                        @foreach ($packages as $package)
                                                            <?php
                                                            $currentPackageId = 0;
                                                            $currentPackagePrice = 0;
                                                            $packageStatus = '';
                                                            $badge = '';
															if (isset($post->latestPayment) and !empty($post->latestPayment)) {
																if (isset($post->latestPayment->package) and !empty($post->latestPayment->package)) {
																	$currentPackageId = $post->latestPayment->package->tid;
																	$currentPackagePrice = $post->latestPayment->package->price;
																}
                                                            }
                                                            // Prevent Package's Downgrading
                                                            if ($currentPackagePrice > $package->price) {
                                                                $packageStatus = ' disabled';
                                                                $badge = ' <span class="badge badge-danger">'. t('Not available') . '</span>';
                                                            } elseif ($currentPackagePrice == $package->price) {
                                                                $badge = '';
                                                            } else {
                                                                $badge = ' <span class="badge badge-success">'. t('Upgrade') . '</span>';
                                                            }
                                                            if ($currentPackageId == $package->tid) {
                                                                $badge = ' <span class="badge badge-secondary">'. t('Current') . '</span>';
																if ($currentPaymentActive == 0) {
																	$badge .= ' <span class="badge badge-warning">'. t('Payment pending') . '</span>';
																}
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td class="text-left align-middle p-3">
																	<div class="form-check">
																		<input class="form-check-input package-selection{{ $packageIdError }}"
																			   type="radio"
																			   name="package_id"
																			   id="packageId-{{ $package->tid }}"
																			   value="{{ $package->tid }}"
																			   data-name="{{ $package->name }}"
																			   data-currencysymbol="{{ $package->currency->symbol }}"
																			   data-currencyinleft="{{ $package->currency->in_left }}"
																				{{ (old('package_id', $currentPackageId)==$package->tid) ? ' checked' : (($package->price==0) ? ' checked' : '') }} {{ $packageStatus }}
																		>
                                                                        <label class="form-check-label mb-0{{ $packageIdError }}">
                                                                            <strong class="tooltipHere"
																					title=""
																					data-placement="right"
																					data-toggle="tooltip"
																					data-original-title="{!! $package->description !!}"
																			>{!! $package->name . $badge !!} </strong>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td class="text-right align-middle p-3">
                                                                    <p id="price-{{ $package->tid }}" class="mb-0">
                                                                        @if ($package->currency->in_left == 1)
                                                                            <span class="price-currency">{!! $package->currency->symbol !!}</span>
                                                                        @endif
                                                                        <span class="price-int">{{ $package->price }}</span>
                                                                        @if ($package->currency->in_left == 0)
                                                                            <span class="price-currency">{!! $package->currency->symbol !!}</span>
                                                                        @endif
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td style="padding:0;" colspan="2">
                                                                <h3 style="margin-top:20px;"><i class="icon-certificate icon-color-1"></i> Additional Services </h3>
                                                            </td>
                                                        </tr>
                                                        <tr class="coupon_row">
                                                            <td class="text-left align-middle p-3 row">
                                                                <div class="form-group mb-0 col-md-4 col-sm-12 p-20">
                                                                    <input type="text" id="coupon" placeholder="Enter your coupon..." class="form-control input-md" />
                                                                </div>
                                                                <div class="form-group mb-0 col-md-3 col-sm-12 p-20 ">
                                                                    <a id="updatePrice" class="btn btn-default btn-block">
                                                                        <i class="fa fa-pencil-square-o"></i>Update
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            <td class="text-right align-middle p-3" id="coupon_percentage">
                                                                <span class="price-currency" id="coupon_price"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left align-middle p-3">
																<?php $paymentMethodIdError = (isset($errors) and $errors->has('payment_method_id')) ? ' is-invalid' : ''; ?>
                                                                <div class="form-group mb-0">
                                                                    <div class="col-md-10 col-sm-12 p-0">
                                                                        <select class="form-control selecter{{ $paymentMethodIdError }}" name="payment_method_id" id="paymentMethodId">
                                                                            @foreach ($paymentMethods as $paymentMethod)
                                                                                @if (view()->exists('payment::' . $paymentMethod->name))
                                                                                    <option value="{{ $paymentMethod->id }}" data-name="{{ $paymentMethod->name }}" {{ (old('payment_method_id', $currentPaymentMethodId)==$paymentMethod->id) ? 'selected="selected"' : '' }}>
                                                                                        @if ($paymentMethod->name == 'offlinepayment')
                                                                                            {{ trans('offlinepayment::messages.Offline Payment') }}
                                                                                        @else
                                                                                            {{ $paymentMethod->display_name }}
                                                                                        @endif
                                                                                    </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-right align-middle p-3">
                                                                <p class="mb-0">
                                                                    <strong>
																		{{ t('Payable Amount') }}:
																		<span class="price-currency amount-currency currency-in-left" style="display: none;"></span>
                                                                        <span class="payable-amount">0</span>
																		<span class="price-currency amount-currency currency-in-right" style="display: none;"></span>
                                                                    </strong>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            @if (isset($paymentMethods) and $paymentMethods->count() > 0)
                                                <!-- Payment Plugins -->
                                                <?php $hasCcBox = 0; ?>
                                                @foreach($paymentMethods as $paymentMethod)
                                                    @if (view()->exists('payment::' . $paymentMethod->name))
                                                        @include('payment::' . $paymentMethod->name, [$paymentMethod->name . 'PaymentMethod' => $paymentMethod])
                                                    @endif
                                                    <?php if ($paymentMethod->has_ccbox == 1 && $hasCcBox == 0) $hasCcBox = 1; ?>
                                                @endforeach
                                            @endif
                                        @endif
                                        
                                        <!-- Button  -->
                                        <div class="form-group">
                                            <div class="col-md-12 text-center mt-4">
                                                @if (getSegment(2) == 'create')
                                                    <a id="skipBtn" href="{{ lurl('posts/create/' . $post->tmp_token . '/finish') }}" class="btn btn-default btn-lg">{{ t('Skip') }}</a>
                                                @else
													<?php $attr = ['slug' => slugify($post->title), 'id' => $post->id]; ?>
                                                    <a id="skipBtn" href="{{ lurl($post->uri, $attr) }}" class="btn btn-default btn-lg">{{ t('Skip') }}</a>
                                                @endif
                                                <button id="submitPostForm" class="btn btn-success btn-lg submitPostForm"> {{ t('Pay') }} </button>
                                            </div>
                                        </div>
                                    
                                    </fieldset>
                                </form>
                                <form id="createInvoiceForm" method="POST" action="{{ lurl('invoice') }}">
                                    <input type="hidden" id="postId" name="postId" value="" />
                                    <input type="hidden" id="coupon_id" name="coupon_id" value="" />
                                    <input type="hidden" id="service_ids" name="service_ids[]" value="" />
                                    <input type="hidden" id="_token1" name="_token" value="" />

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.page-content -->
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
@endsection

@section('after_scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
    @if (file_exists(public_path() . '/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js'))
        <script src="{{ url('/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js') }}" type="text/javascript"></script>
    @endif

    <script>
        var servicePrice = 0;
        var packagePrice = 0; 
        var totalPrice = 0;
        var currentPackagePrice = 0;
        var packageCurrencyInLeft = ""; 
        var paymentMethod = "";     
        var coupon_percentage = 0;
        packageCurrencySymbol = "";                                                    
        @if (isset($packages) and isset($paymentMethods) and $packages->count() > 0 and $paymentMethods->count() > 0)
			
			currentPackagePrice = {{ $currentPackagePrice }};
            var currentPaymentActive = {{ $currentPaymentActive }};
			$(document).ready(function ()
			{
				/* Show price & Payment Methods */
				var selectedPackage = $('input[name=package_id]:checked').val();
				packagePrice = getPackagePrice(selectedPackage);
				packageCurrencySymbol = $('input[name=package_id]:checked').data('currencysymbol');
				packageCurrencyInLeft = $('input[name=package_id]:checked').data('currencyinleft');
				paymentMethod = $('#paymentMethodId').find('option:selected').data('name');
				
                
				/* Select a Package */
				$('.package-selection').click(function () {
					selectedPackage = $(this).val();
					totalPrice = getPackagePrice(selectedPackage) + servicePrice;
					packageCurrencySymbol = $(this).data('currencysymbol');
					packageCurrencyInLeft = $(this).data('currencyinleft');
					showAmount(totalPrice*(100-coupon_percentage)/100, packageCurrencySymbol, packageCurrencyInLeft);
					showPaymentSubmitButton(currentPackagePrice, totalPrice*(100-coupon_percentage)/100, currentPaymentActive, paymentMethod);
				});
				
				/* Select a Payment Method */
				$('#paymentMethodId').on('change', function () {
					paymentMethod = $(this).find('option:selected').data('name');
					showPaymentSubmitButton(currentPackagePrice, totalPrice*(100-coupon_percentage)/100, currentPaymentActive, paymentMethod);
				});
				
				/* Form Default Submission */
				$('#submitPostForm').on('click', function (e) {
					e.preventDefault();
					if (totalPrice <= 0) {
						$('#postForm').submit();
					} else {
                        var postId = $("#post_id").val();
                        var service_list = [];

                        $("#packagesTable")
                            .find(".service_check:checked")
                            .each(function(){
                                service_list.push($(this).val())
                            });
                       
                        $("#postId").val(postId);
                        $("#coupon_id").val($("#coupon").val());
                        $("#service_ids").val(service_list);
                        $("#_token1").val($("input[name=_token]").val())
                        $("#createInvoiceForm").submit();
                    }

					return false;
				});
			});
        
        @endif
        $(document).ready(function (){            

            $("#updatePrice").on('click', function(){
                applyCoupon();
            })

            $("#coupon").on('keydown', function(e){
                
                if(e.keyCode == 13){
                    e.preventDefault();
                    applyCoupon();
                    return false;
                }
            })

            function applyCoupon(){
                $.ajax({
                    type: 'GET',
                    url: siteUrl + "/coupon",
                    dataType: 'json',
                    data: {
                        code: $("#coupon").val(),
                        _token: $("input[name=_token]").val()
                    }
                }).done(function(data) {
                    var packageCurrencySymbol = $('input[name=package_id]:checked').data('currencysymbol');
                    if(data==null){
                        alert("Invalid coupon code. Please enter your correct code.");
                        coupon_percentage = 0;
                        $("#coupon_percentage").html("");
                    }else{
                        coupon_percentage = parseInt(data.percentage);
                        $("#coupon_percentage").html(data.percentage + "%");
                    }
                    showAmount(totalPrice*(100-coupon_percentage)/100 , packageCurrencySymbol, packageCurrencyInLeft);
                    showPaymentSubmitButton(currentPackagePrice, totalPrice*(100-coupon_percentage)/100, currentPaymentActive, paymentMethod);
                })
            }

            $.ajax({
                type: "GET",
                url: siteUrl + "/posts/" + $("#post_id").val() + "/invoice_data",
                dataType: "json",
                data: {
                    _token: $("input[name=_token]").val()
                }
            }).done(function(data) {
                
                var services_html = "";
                var packageCurrencySymbol = $('input[name=package_id]:checked').data('currencysymbol');
                $.each(data.service_list, function(i, item) {
                    var checked = "";
                    var disabled = "";
                    var ordered = "";
                    for (i = 0, len = data.addon_services.length; i < len; i++) {
                        if (item.id == data.addon_services[i].id) {
                            checked = "checked";
                            disabled = "disabled";
                            ordered = "_ordered";
                            // servicePrice += parseInt(item.price);
                        break;
                        }
                    }
                    var check_box_id = "check_box_" + item.id;
                    services_html += '<tr class="addon_services">'+
                                            '<td class="text-left align-middle p-3">'+
                                                '<label class="form-check-label mb-0">'+
                                                    '<span class="input-group-text1">' +
                                                        '<input class="service_check' +
                                                        ordered +
                                                        '" data-price="' +
                                                        item.price +
                                                        '" data-title="' +
                                                        item.name +
                                                        '" type="checkbox" value="' +
                                                        item.id +
                                                        '" id="' +
                                                        check_box_id +
                                                        '" ' +
                                                        checked +
                                                        " " +
                                                        disabled +
                                                        " >" +
                                                        "&nbsp;&nbsp;" +
                                                        '<label class="check_label" for="' +
                                                        check_box_id +
                                                        '"><strong class="tooltipHere" title="">' +
                                                        item.name +
                                                        '</strong>' +
                                                    '</span>'+    
                                                '</label>'+
                                            '</td>'+
                                            '<td class="text-right align-middle p-3">'+
                                                '<p class="mb-0">' + item.price + ' ' + packageCurrencySymbol + '</p>'+
                                            '</td>'+
                                        '</tr>';
                });
                $("#packagesTable").closest('table').find('tr.coupon_row').prev().after(services_html); 
                totalPrice = packagePrice + servicePrice;
                if(totalPrice >= 0){
                    showAmount(totalPrice*(100-coupon_percentage)/100, packageCurrencySymbol, packageCurrencyInLeft);
                    showPaymentSubmitButton(currentPackagePrice, totalPrice*(100-coupon_percentage)/100, currentPaymentActive, paymentMethod);
                }  
                $(".service_check").click(function(){
                    if($(this).prop("checked") == ""){
                        servicePrice -= parseInt($(this).attr("data-price"));
                        totalPrice -= parseInt($(this).attr("data-price"));
                    }else{
                        servicePrice += parseInt($(this).attr("data-price"));
                        totalPrice += parseInt($(this).attr("data-price"));
                    }
                    if(totalPrice >= 0){
                        showAmount(totalPrice*(100-coupon_percentage)/100, packageCurrencySymbol, packageCurrencyInLeft);
                        showPaymentSubmitButton(currentPackagePrice, totalPrice*(100-coupon_percentage)/100, currentPaymentActive, paymentMethod);
                    }
                })
            });
        })
		/* Show or Hide the Payment Submit Button */
		/* NOTE: Prevent Package's Downgrading */
		/* Hide the 'Skip' button if Package price > 0 */
		function showPaymentSubmitButton(currentPackagePrice, packagePrice, currentPaymentActive, paymentMethod)
		{
			if (packagePrice > 0) {
				$('#submitPostForm').show();
				$('#skipBtn').hide();
				
				if (currentPackagePrice > packagePrice) {
					$('#submitPostForm').hide();
				}
				if (currentPackagePrice == packagePrice) {
					if (paymentMethod == 'offlinepayment' && currentPaymentActive != 1) {
						$('#submitPostForm').hide();
						$('#skipBtn').show();
					}
				}
			} else {
				$('#skipBtn').show();
			}
		}
    </script>
@endsection

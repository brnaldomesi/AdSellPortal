/*
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
 */

$(document).ready(function()
{
	/* CSRF Protection */
	var token = $('meta[name="csrf-token"]').attr('content');
	if (token) {
		$.ajaxSetup({
			headers: {'X-CSRF-TOKEN': token}
		});
	}

	$('.showphone').click(function(){
		showPhone();
	});
});

/**
 * Show the Seller's Phone
 * @returns {boolean}
 */
function showPhone()
{
	return false; /* Disabled */
	
	if ($('#postId').val()==0) {
		return false;
	}

	$.ajax({
		method: 'POST',
		url: siteUrl + '/ajax/post/phone',
		data: {
			'postId': $('#postId').val(),
			'_token': $('input[name=_token]').val()
		}
	}).done(function(data) {
		if (typeof data.phone == "undefined") {
			return false;
		}
		$('.showphone').html('<i class="icon-phone-1"></i> ' + data.phone);
		$('#postId').val(0);
	});
}
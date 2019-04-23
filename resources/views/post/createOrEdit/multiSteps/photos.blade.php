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
						
                        <h2 class="title-2"><strong><i class="icon-camera-1"></i> {{ t('Photos') }}</strong></h2>
						
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form-horizontal" id="postForm" method="POST" action="{{ url()->current() }}" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <fieldset>
                                        @if (isset($picturesLimit) and is_numeric($picturesLimit) and $picturesLimit > 0)
                                            <!-- Pictures -->
											<?php $picturesError = (isset($errors) and $errors->has('pictures')) ? ' is-invalid' : ''; ?>
                                            <div id="picturesBloc" class="form-group row">
												<label class="col-md-3 control-label{{ $picturesError }}" for="pictures"> {{ t('Pictures') }} </label>
												<div class="col-md-8"></div>
												<div class="col-md-12 text-center pt-2" style="position: relative; float: {!! (config('lang.direction')=='rtl') ? 'left' : 'right' !!};">
													<div {!! (config('lang.direction')=='rtl') ? 'dir="rtl"' : '' !!} class="file-loading">
														<input id="pictureField" name="pictures[]" type="file" multiple class="file picimg{{ $picturesError }}">
													</div>
													<small id="" class="form-text text-muted">
														{{ t('Add up to :pictures_number pictures. Use real pictures of your product, not catalogs.', [
															'pictures_number' => $picturesLimit
														]) }}
													</small>
												</div>
                                            </div>
                                        @endif
                                        <div id="uploadError mt-2" style="display: none;"></div>
                                        <div id="uploadSuccess" class="alert alert-success fade show mt-2" style="display: none;"></div>
                                    
                                    
                                        <!-- Button -->
                                        <div class="form-group row mt-4">
                                            <div class="col-md-12 text-center">
                                                @if (getSegment(2) != 'create')
                                                    <a href="{{ lurl('posts/' . $post->id . '/edit') }}" class="btn btn-default btn-lg">{{ t('Previous') }}</a>
                                                @endif
                                                <a id="nextStepAction" href="{{ url($nextStepUrl) }}" class="btn btn-default btn-lg">{{ t('Skip') }}</a>
                                            </div>
                                        </div>
                                    
                                    </fieldset>
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
    <link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
	@endif
    <style>
        .krajee-default.file-preview-frame:hover:not(.file-preview-error) {
            box-shadow: 0 0 5px 0 #666666;
        }
		.file-loading:before {
			content: " {{ t('Loading') }}...";
		}
    </style>
@endsection

@section('after_scripts')
    <script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/plugins/bootstrap-fileinput/themes/fa/theme.js') }}" type="text/javascript"></script>
    @if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.ietfLangTag(config('app.locale')).'.js'))
        <script src="{{ url('assets/plugins/bootstrap-fileinput/js/locales/'.ietfLangTag(config('app.locale')).'.js') }}" type="text/javascript"></script>
    @endif
    <script>
        /* Initialize with defaults (pictures) */
        @if (isset($picturesLimit) and is_numeric($picturesLimit) and $picturesLimit > 0)
        <?php
            // Get Upload Url
            if (getSegment(2) == 'create') {
                $uploadUrl = lurl('posts/create/' . $post->tmp_token . '/photos/');
            } else {
                $uploadUrl = lurl('posts/' . $post->id . '/photos/');
            }
        ?>
            $('#pictureField').fileinput(
            {
				theme: "fa",
                language: '{{ config('app.locale') }}',
				@if (config('lang.direction') == 'rtl')
					rtl: true,
				@endif
                overwriteInitial: false,
                showCaption: false,
                showPreview: true,
                allowedFileExtensions: {!! getUploadFileTypes('image', true) !!},
				uploadUrl: '{{ $uploadUrl }}',
                uploadAsync: false,
				showBrowse: true,
				showCancel: true,
				showUpload: false,
				showRemove: false,
                maxFileSize: {{ (int)config('settings.upload.max_file_size', 1000) }},
                browseOnZoneClick: true,
                minFileCount: 0,
                maxFileCount: {{ (int)$picturesLimit }},
                validateInitialCount: true,
                @if (isset($post) and isset($post->pictures))
                /* Retrieve current images */
                /* Setup initial preview with data keys */
                initialPreview: [
                @for($i = 0; $i <= $picturesLimit-1; $i++)
                    @continue(!$post->pictures->has($i) or !isset($post->pictures->get($i)->filename))
                    '{{ resize($post->pictures->get($i)->filename) }}',
                @endfor
                ],
                initialPreviewAsData: true,
                initialPreviewFileType: 'image',
                /* Initial preview configuration */
                initialPreviewConfig: [
                @for($i = 0; $i <= $picturesLimit-1; $i++)
                    @continue(!$post->pictures->has($i) or !isset($post->pictures->get($i)->filename))
                    <?php
                    // Get Deletion Url
                    if (getSegment(2) == 'create') {
                        $initialPreviewConfigUrl = lurl('posts/create/' . $post->tmp_token . '/photos/' . $post->pictures->get($i)->id . '/delete');
                    } else {
                        $initialPreviewConfigUrl = lurl('posts/' . $post->id . '/photos/' . $post->pictures->get($i)->id . '/delete');
                    }
                    
                    // File size
					try {
						$fileSize = (int)File::size(filePath($post->pictures->get($i)->filename));
					} catch (\Exception $e) {
						$fileSize = 0;
					}
                    ?>
                    {
                        caption: '{{ last(explode('/', $post->pictures->get($i)->filename)) }}',
                        size: {{ $fileSize }},
                        url: '{{ $initialPreviewConfigUrl }}',
						key: {{ (int)$post->pictures->get($i)->id }}
                    },
                @endfor
                ],
                @endif
				
                /* elErrorContainer: '#uploadError', */
				/* msgErrorClass: 'file-error-message', */ /* @todo: depreciated. */
				
				uploadClass: 'btn btn-success'
            });
        @endif

		/* Auto-upload added file */
		$('#pictureField').on('filebatchselected', function(event, data, id, index) {
			if (typeof data === 'object') {
				{{--
					Display the exact error (If it exists (Before making AJAX call))
					NOTE: The index '0' is available when the first file size is smaller than the maximum size allowed.
					      This index does not exist in the opposite case.
				--}}
				if (data.hasOwnProperty('0')) {
					$(this).fileinput('upload');
					return true;
				}
			}
			
			return false;
		});
		
		/* Show upload status message */
        $('#pictureField').on('filebatchpreupload', function(event, data, id, index) {
            $('#uploadSuccess').html('<ul></ul>').hide();
        });
		
		/* Show success upload message */
        $('#pictureField').on('filebatchuploadsuccess', function(event, data, previewId, index) {
            /* Show uploads success messages */
            var out = '';
            $.each(data.files, function(key, file) {
                if (typeof file !== 'undefined') {
                    var fname = file.name;
                    out = out + {!! t('Uploaded file #key successfully') !!};
                }
            });
            $('#uploadSuccess ul').append(out);
            $('#uploadSuccess').fadeIn('slow');
            
            /* Change button label */
            $('#nextStepAction').html('{{ $nextStepLabel }}').removeClass('btn-default').addClass('btn-primary');
            
            /* Check redirect */
            var maxFiles = {{ (isset($picturesLimit)) ? (int)$picturesLimit : 1 }};
            var oldFiles = {{ (isset($post) and isset($post->pictures)) ? $post->pictures->count() : 0 }};
            var newFiles = Object.keys(data.files).length;
            var countFiles = oldFiles + newFiles;
            if (countFiles >= maxFiles) {
                var nextStepUrl = '{{ url($nextStepUrl) }}';
				redirect(nextStepUrl);
            }
        });
		
		/* Reorder (Sort) files */
		$('#pictureField').on('filesorted', function(event, params) {
			picturesReorder(params);
		});
		
		/* Delete picture */
        $('#pictureField').on('filepredelete', function(jqXHR) {
            var abort = true;
            if (confirm("{{ t('Are you sure you want to delete this picture?') }}")) {
                abort = false;
            }
            return abort;
        });

		/**
		 * Reorder (Sort) pictures
		 * @param params
		 * @returns {boolean}
		 */
		function picturesReorder(params)
		{
			if (typeof params.stack === 'undefined') {
				return false;
			}
			
			waitingDialog.show('{{ t('Processing') }}...');
	
			$.ajax({
				method: 'POST',
				url: siteUrl + '/ajax/post/pictures/reorder',
				data: {
					'params': params,
					'_token': $('input[name=_token]').val()
				}
			}).done(function(data) {
				
				waitingDialog.hide();
				
				if (typeof data.status === 'undefined') {
					return false;
				}
		
				/* Reorder Notification */
				if (data.status == 1) {
					$('#uploadSuccess').html('<ul></ul>').hide();
					$('#uploadSuccess ul').append('{{ t('Your picture has been reorder successfully') }}');
					$('#uploadSuccess').fadeIn('slow');
				}
		
				return false;
			});
	
			return false;
		}
    </script>
    
@endsection

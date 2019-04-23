<aside>
	<div class="inner-box">
		<div class="user-panel-sidebar">

			<div class="collapse-box">
				<h5 class="collapse-title no-border">
					{{ t('My Account') }}&nbsp;
					<a href="#MyClassified" data-toggle="collapse" class="pull-right"><i class="fa fa-angle-down"></i></a>
				</h5>
				<div class="panel-collapse collapse show" id="MyClassified">
					<ul class="acc-list">
						<li>
							<a {!! ($pagePath=='') ? 'class="active"' : '' !!} href="{{ lurl('account') }}">
								<i class="icon-home"></i> {{ t('Personal Home') }}
							</a>
						</li>
					</ul>
				</div>
			</div>
			<!-- /.collapse-box  -->

			<div class="collapse-box">
				<h5 class="collapse-title">
					{{ t('My Ads') }}
					<a href="#MyAds" data-toggle="collapse" class="pull-right"><i class="fa fa-angle-down"></i></a>
				</h5>
				<div class="panel-collapse collapse show" id="MyAds">
					<ul class="acc-list">
						<li>
							<a{!! ($pagePath=='my-posts') ? ' class="active"' : '' !!} href="{{ lurl('account/my-posts') }}">
							<i class="icon-docs"></i> {{ t('My ads') }}&nbsp;
							<span class="badge badge-pill">
								{{ isset($countMyPosts) ? \App\Helpers\Number::short($countMyPosts) : 0 }}
							</span>
							</a>
						</li>
						<li>
							<a{!! ($pagePath=='favourite') ? ' class="active"' : '' !!} href="{{ lurl('account/favourite') }}">
							<i class="icon-heart"></i> {{ t('Favourite ads') }}&nbsp;
							<span class="badge badge-pill">
								{{ isset($countFavouritePosts) ? \App\Helpers\Number::short($countFavouritePosts) : 0 }}
							</span>
							</a>
						</li>
						<li>
							<a{!! ($pagePath=='saved-search') ? ' class="active"' : '' !!} href="{{ lurl('account/saved-search') }}">
							<i class="icon-star-circled"></i> {{ t('Saved searches') }}&nbsp;
							<span class="badge badge-pill">
								{{ isset($countSavedSearch) ? \App\Helpers\Number::short($countSavedSearch) : 0 }}
							</span>
							</a>
						</li>
						<li>
							<a{!! ($pagePath=='pending-approval') ? ' class="active"' : '' !!} href="{{ lurl('account/pending-approval') }}">
							<i class="icon-hourglass"></i> {{ t('Pending approval') }}&nbsp;
							<span class="badge badge-pill">
								{{ isset($countPendingPosts) ? \App\Helpers\Number::short($countPendingPosts) : 0 }}
							</span>
							</a>
						</li>
						<li>
							<a{!! ($pagePath=='archived') ? ' class="active"' : '' !!} href="{{ lurl('account/archived') }}">
							<i class="icon-folder-close"></i> {{ t('Archived ads') }}&nbsp;
							<span class="badge badge-pill">
								{{ isset($countArchivedPosts) ? \App\Helpers\Number::short($countArchivedPosts) : 0 }}
							</span>
							</a>
						</li>
						<li>
							<a{!! ($pagePath=='conversations') ? ' class="active"' : '' !!} href="{{ lurl('account/conversations') }}">
							<i class="icon-mail-1"></i> {{ t('Conversations') }}&nbsp;
							<span class="badge badge-pill">
								{{ isset($countConversations) ? \App\Helpers\Number::short($countConversations) : 0 }}
							</span>&nbsp;
							<span class="badge badge-pill badge-important count-conversations-with-new-messages">0</span>
							</a>
						</li>
						<li>
							<a{!! ($pagePath=='transactions') ? ' class="active"' : '' !!} href="{{ lurl('account/transactions') }}">
							<i class="icon-money"></i> {{ t('Transactions') }}&nbsp;
							<span class="badge badge-pill">
								{{ isset($countTransactions) ? \App\Helpers\Number::short($countTransactions) : 0 }}
							</span>
							</a>
						</li>
						@if (config('plugins.apilc.installed'))
							<li>
								<a{!! ($pagePath=='api-dashboard') ? ' class="active"' : '' !!} href="{{ lurl('account/api-dashboard') }}">
									<i class="icon-cog"></i> {{ trans('api::messages.Clients & Applications') }}&nbsp;
								</a>
							</li>
						@endif
					</ul>
				</div>
			</div>
			<!-- /.collapse-box  -->

			<div class="collapse-box">
				<h5 class="collapse-title">
					{{ t('Terminate Account') }}&nbsp;
					<a href="#TerminateAccount" data-toggle="collapse" class="pull-right"><i class="fa fa-angle-down"></i></a>
				</h5>
				<div class="panel-collapse collapse show" id="TerminateAccount">
					<ul class="acc-list">
						<li>
							<a {!! ($pagePath=='close') ? 'class="active"' : '' !!} href="{{ lurl('account/close') }}">
								<i class="icon-cancel-circled "></i> {{ t('Close account') }}
							</a>
						</li>
					</ul>
				</div>
			</div>
			<!-- /.collapse-box  -->

		</div>
	</div>
	<!-- /.inner-box  -->
</aside>
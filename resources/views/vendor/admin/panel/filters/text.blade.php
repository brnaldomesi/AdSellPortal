{{-- Text CRUD filter --}}

<li filter-name="{{ $filter->name }}"
	filter-type="{{ $filter->type }}"
	class="dropdown {{ Request::get($filter->name) ? 'active' : '' }}">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $filter->label }} <span class="caret"></span></a>
	<div class="dropdown-menu">
		<div class="form-group backpack-filter m-b-0">
			<div class="input-group">
				<input class="form-control pull-right"
					   id="text-filter-{{ str_slug($filter->name) }}"
					   type="text"
					   @if ($filter->currentValue)
					   value="{{ $filter->currentValue }}"
					   @endif
				>
				<div class="input-group-addon">
					<a class="text-filter-{{ str_slug($filter->name) }}-clear-button" href=""><i class="fa fa-times"></i></a>
				</div>
			</div>
		</div>
	</div>
</li>

{{-- ########################################### --}}
{{-- Extra CSS and JS for this particular filter --}}


{{-- FILTERS EXTRA JS --}}
{{-- push things in the after_scripts section --}}

@push('crud_list_scripts')
	<!-- include select2 js-->
	<script>
		jQuery(document).ready(function($) {
			$('#text-filter-{{ str_slug($filter->name) }}').on('change', function(e) {
				
				var parameter = '{{ $filter->name }}';
				var value = $(this).val();
				
				// behaviour for ajax table
				var ajax_table = $('#crudTable').DataTable();
				var current_url = ajax_table.ajax.url();
				var new_url = addOrUpdateUriParameter(current_url, parameter, value);
				
				// replace the datatables ajax url with new_url and reload it
				new_url = normalizeAmpersand(new_url.toString());
				ajax_table.ajax.url(new_url).load();
				
				// mark this filter as active in the navbar-filters
				if (URI(new_url).hasQuery('{{ $filter->name }}', true)) {
					$('li[filter-name={{ $filter->name }}]').removeClass('active').addClass('active');
				} else {
					$('li[filter-name={{ $filter->name }}]').trigger('filter:clear');
				}
			});
			
			$('li[filter-name={{ str_slug($filter->name) }}]').on('filter:clear', function(e) {
				$('li[filter-name={{ $filter->name }}]').removeClass('active');
				$('#text-filter-{{ str_slug($filter->name) }}').val('');
			});
			
			// datepicker clear button
			$(".text-filter-{{ str_slug($filter->name) }}-clear-button").click(function(e) {
				e.preventDefault();
				
				$('li[filter-name={{ str_slug($filter->name) }}]').trigger('filter:clear');
				$('#text-filter-{{ str_slug($filter->name) }}').val('');
				$('#text-filter-{{ str_slug($filter->name) }}').trigger('change');
			})
		});
	</script>
@endpush
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
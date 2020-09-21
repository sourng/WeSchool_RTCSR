@if ($paginator->hasPages())
	<div class="post-pagination">
		@if ($paginator->onFirstPage())
			<a href="#" class="disabled pagination-back pull-left">{{ _lang('Back') }}</a>
		@else
			<a href="{{ $paginator->previousPageUrl() }}" class="pagination-back pull-left">{{ _lang('Back') }}</a>
		@endif
		
		<ul class="pages">
			{{-- Pagination Elements --}}
			@foreach ($elements as $element)
				{{-- "Three Dots" Separator --}}
				@if (is_string($element))
					<li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
				@endif

				{{-- Array Of Links --}}
				@if (is_array($element))
					@foreach ($element as $page => $url)
						@if ($page == $paginator->currentPage())
							<li class="active" aria-current="page"><span>{{ $page }}</span></li>
						@else
							<li><a href="{{ $url }}">{{ $page }}</a></li>
						@endif
					@endforeach
				@endif
			@endforeach
		</ul>	
		
		@if ($paginator->hasMorePages())
		   <a href="{{ $paginator->nextPageUrl() }}" class="pagination-next pull-right">{{ _lang('Next') }}</a>
		@else
		   <a href="#" class="disabled pagination-next pull-right">{{ _lang('Next') }}</a>
		@endif
		
	</div>
@endif

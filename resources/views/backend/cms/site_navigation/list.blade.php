@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default no-export">
			<div class="panel-heading"><span class="panel-title">{{ _lang('Site Navigations') }}</span>
			<a class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add Site Navigation') }}" href="{{route('site_navigations.create')}}">{{ _lang('Add New') }}</a>
			</div>

			<div class="panel-body">
			 @if (\Session::has('success'))
			  <div class="alert alert-success">
				<p>{{ \Session::get('success') }}</p>
			  </div>
			  <br />
			 @endif
			<table class="table table-bordered data-table">
			<thead>
			  <tr>
				<th>{{ _lang('Menu Name') }}</th>
				<th style="width:220px;">{{ _lang('Action') }}</th>
			  </tr>
			</thead>
			<tbody>
			  
			  @foreach($sitenavigations as $sitenavigation)
			  <tr id="row_{{ $sitenavigation->id }}">
				<td class='menu_name'>{{ $sitenavigation->menu_name }}</td>
				<td>
				  <form action="{{ action('SiteNavigationController@destroy', $sitenavigation['id']) }}" method="post">
					<a href="{{ action('SiteNavigationController@edit', $sitenavigation['id']) }}" data-title="{{ _lang('Update Site Navigation') }}" class="btn btn-warning btn-sm ajax-modal">{{ _lang('Edit') }}</a>
					<a href="{{ url('site_navigation_items/navigation/'.$sitenavigation['id']) }}"  class="btn btn-info btn-sm">{{ _lang('Manage') }}</a>
					{{ csrf_field() }}
					<input name="_method" type="hidden" value="DELETE">
					<button class="btn btn-danger btn-sm btn-remove" type="submit">{{ _lang('Delete') }}</button>
				  </form>
				</td>
			  </tr>
			  @endforeach
			</tbody>
		  </table>
			</div>
		</div>
	</div>
</div>

@endsection



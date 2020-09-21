@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><span class="panel-title">{{ _lang('List Chart Of Account') }}</span>
			<a class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add Chart Of Account') }}" href="{{route('chart_of_accounts.create')}}">{{ _lang('Add New') }}</a>
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
				<th>{{ _lang('Name') }}</th>
				<th>{{ _lang('Type') }}</th>
				<th>{{ _lang('Action') }}</th>
			  </tr>
			</thead>
			<tbody>
			  
			  @foreach($chartofaccounts as $chartofaccount)
			  <tr id="row_{{ $chartofaccount->id }}">
				<td class='name'>{{ $chartofaccount->name }}</td>
				<td class='type'>{{ ucwords($chartofaccount->type) }}</td>
				<td>
				  <form action="{{action('ChartOfAccountController@destroy', $chartofaccount['id'])}}" method="post">
					<a href="{{action('ChartOfAccountController@edit', $chartofaccount['id'])}}" data-title="{{ _lang('Update Chart Of Account') }}" class="btn btn-warning btn-sm ajax-modal">{{ _lang('Edit') }}</a>
					<a href="{{action('ChartOfAccountController@show', $chartofaccount['id'])}}" data-title="{{ _lang('View Chart Of Account') }}" class="btn btn-info btn-sm ajax-modal">{{ _lang('View') }}</a>
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



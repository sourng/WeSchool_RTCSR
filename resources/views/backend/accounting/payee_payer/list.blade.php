@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default no-export">
			<div class="panel-heading"><span class="panel-title">{{ _lang('List Payee / Payer') }}</span>
			<a class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add Payee / Payer') }}" href="{{route('payee_payers.create')}}">{{ _lang('Add New') }}</a>
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
					<th>{{ _lang('Note') }}</th>
					<th>{{ _lang('Action') }}</th>
				  </tr>
				</thead>
				<tbody>
				  
				  @foreach($payeepayers as $payeepayer)
				  <tr id="row_{{ $payeepayer->id }}">
					<td class='name'>{{ $payeepayer->name }}</td>
					<td class='type'>{{ ucwords($payeepayer->type) }}</td>
					<td class='note'>{{ $payeepayer->note }}</td>

					<td>
					  <form action="{{action('PayeePayerController@destroy', $payeepayer['id'])}}" method="post">
						<a href="{{action('PayeePayerController@edit', $payeepayer['id'])}}" data-title="{{ _lang('Update Information') }}" class="btn btn-warning btn-sm ajax-modal">{{ _lang('Edit') }}</a>
						<a href="{{action('PayeePayerController@show', $payeepayer['id'])}}" data-title="{{ _lang('View Payee / Payer') }}" class="btn btn-info btn-sm ajax-modal">{{ _lang('View') }}</a>
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



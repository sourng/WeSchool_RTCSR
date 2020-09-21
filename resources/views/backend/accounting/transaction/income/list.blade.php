@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><span class="panel-title">{{ _lang('List Income') }}</span>
			<a class="btn btn-primary btn-sm pull-right" data-title="{{ _lang('Add Income') }}" href="{{ url('transactions/add_income') }}">{{ _lang('Add New') }}</a>
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
				<th>{{ _lang('Date') }}</th>
				<th>{{ _lang('Account') }}</th>
				<th>{{ _lang('Amount') }}</th>
				<th>{{ _lang('Income Type') }}</th>
				<th>{{ _lang('Payer') }}</th>
				<th>{{ _lang('Payment Method') }}</th>
				<th>{{ _lang('Action') }}</th>
			  </tr>
			</thead>
			<tbody>
			  
			  @foreach($transactions as $transaction)
			  <tr id="row_{{ $transaction->id }}">
				<td class='trans_date'>{{ $transaction->trans_date }}</td>
				<td class='account_id'>{{ $transaction->account_name }}</td>
				<td class='amount'>{{ $transaction->amount }}</td>
				<td class='chart_id'>{{ $transaction->c_type }}</td>
				<td class='payee_payer_id'>{{ $transaction->payee_payer }}</td>
				<td class='payment_method_id'>{{ $transaction->payment_method }}</td>
				<td>
				  <form action="{{action('TransactionController@destroy', $transaction['id'])}}" method="post">
					<a href="{{action('TransactionController@edit', $transaction['id'])}}" data-title="{{ _lang('Update Income') }}" class="btn btn-warning btn-sm">{{ _lang('Edit') }}</a>
					<a href="{{action('TransactionController@show', $transaction['id'])}}" data-title="{{ _lang('View Income') }}" class="btn btn-info btn-sm ajax-modal">{{ _lang('View') }}</a>
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



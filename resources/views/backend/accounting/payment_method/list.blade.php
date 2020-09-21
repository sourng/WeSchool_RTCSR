@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default no-export">
			<div class="panel-heading"><span class="panel-title">{{ _lang('List Payment Method') }}</span>
			<a class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add Payment Method') }}" href="{{route('payment_methods.create')}}">{{ _lang('Add New') }}</a>
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
				<th>{{ _lang('Payment Method Name') }}</th>
				<th>{{ _lang('Action') }}</th>
			  </tr>
			</thead>
			<tbody>
			  
			  @foreach($paymentmethods as $paymentmethod)
			  <tr id="row_{{ $paymentmethod->id }}">
				<td class='name'>{{ $paymentmethod->name }}</td>
				<td>
				  <form action="{{action('PaymentMethodController@destroy', $paymentmethod['id'])}}" method="post">
					<a href="{{action('PaymentMethodController@edit', $paymentmethod['id'])}}" data-title="{{ _lang('Update Payment Method') }}" class="btn btn-warning btn-sm ajax-modal">{{ _lang('Edit') }}</a>
					<a href="{{action('PaymentMethodController@show', $paymentmethod['id'])}}" data-title="{{ _lang('View Payment Method') }}" class="btn btn-info btn-sm ajax-modal">{{ _lang('View') }}</a>
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



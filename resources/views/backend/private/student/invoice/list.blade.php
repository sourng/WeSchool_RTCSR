@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
			  <span class="panel-title">{{ _lang('My Invoice List') }}</span>
			  <a class="btn btn-primary btn-sm pull-right" data-title="{{ _lang('Add New Invoice') }}" href="{{route('invoices.create')}}">{{ _lang('Add New') }}</a>
			</div>

			<div class="panel-body">
			<table class="table table-bordered data-table">
			<thead>
			  <tr>
				<th>{{ _lang('ID') }}</th>
				<th>{{ _lang('Student') }}</th>
				<th>{{ _lang('Class') }} / {{ _lang('Section') }}</th>
				<th>{{ _lang('Roll') }}</th>
				<th>{{ _lang('Due Date') }}</th>
				<th>{{ _lang('Title') }}</th>
				<th>{{ _lang('Total') }}</th>
				<th>{{ _lang('Status') }}</th>
				<th>{{ _lang('Action') }}</th>
			  </tr>
			</thead>
			<tbody>
			  
			  @php $currency = get_option('currency_symbol') @endphp
			  @foreach($invoices as $invoice)
			  <tr id="row_{{ $invoice->id }}">
					<td>{{ $invoice->id }}</td>
					<td>{{ $invoice->first_name." ".$invoice->last_name }}</td>
					<td>{{ $invoice->class_name }} / {{ $invoice->section_name }}</td>
					<td>{{ $invoice->roll }}</td>
					<td>{{ date('d-M-Y', strtotime($invoice->due_date)) }}</td>
					<td style='max-width:250px;'>{{ $invoice->title }}</td>
					<td>{{ $currency." ".$invoice->total }}</td>
					<td>{!! $invoice->status=="Paid" ? '<i class="fa fa-circle paid"></i>'.$invoice->status : '<i class="fa fa-circle unpaid"></i>'.$invoice->status !!}</td>		
				<td>
				  <div class="dropdown">
					  <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">{{ _lang('Action') }}
					  <span class="caret"></span></button>					 
						<ul class="dropdown-menu">
						  <li><a href="{{ url('student/view_invoice/'.$invoice->id) }}" data-title="{{ _lang('View Invoice') }}" data-fullscreen="true" class="ajax-modal">{{ _lang('View Invoice') }}</a></li>
						    @if($invoice->status != "Paid")
								  @if(get_option('paypal_active')=="Yes")
									<li><a class="ajax-modal" data-title="{{ _lang('Pay Via PayPal') }}" href="{{ url('student/invoice_payment/paypal/'.$invoice->id) }}">{{ _lang('Pay Via PayPal') }}</a></li>
								  @endif
								  @if(get_option('stripe_active')=="Yes")
									<li><a class="ajax-modal" href="{{ url('student/invoice_payment/stripe/'.$invoice->id) }}">{{ _lang('Pay Via Stripe') }}</a></li>
								  @endif
							@endif  
					    </ul>
					</div>
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

@section('js-script')
<script>
function showClass(elem){
	if($(elem).val() == ""){
		return;
	}
	window.location = "<?php echo url('invoices/class') ?>/"+$(elem).val();
}
</script>
@stop



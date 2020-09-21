@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title">{{ _lang('List Student Payment') }}</span>
				<select id="class" class="select_class pull-right" onchange="showClass(this);">
				   <option value="">{{ _lang('Select Class') }}</option>
				   {{ create_option('classes','id','class_name',$class) }}
				</select>
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
				<th>{{ _lang('Invoice ID') }}</th>
				<th>{{ _lang('Date') }}</th>
				<th>{{ _lang('Amount') }}</th>
				<th>{{ _lang('Note') }}</th>
				<th>{{ _lang('Action') }}</th>
			  </tr>
			</thead>
			<tbody>
			  @php $currency = get_option('currency_symbol') @endphp
			  @foreach($studentpayments as $studentpayment)
			    <tr id="row_{{ $studentpayment->id }}">
					<td class='invoice_id'>{{ $studentpayment->invoice_id }}</td>
					<td class='date'>{{ date('d-M-Y', strtotime($studentpayment->date)) }}</td>
					<td class='amount'>{{ $currency." ".$studentpayment->amount }}</td>
					<td class='note'>{{ $studentpayment->note }}</td>
					<td>
					  <form action="{{action('StudentPaymentController@destroy', $studentpayment['id'])}}" method="post">
						<a href="{{action('StudentPaymentController@edit', $studentpayment['id'])}}" data-title="{{ _lang('Update Student Payment') }}" class="btn btn-warning btn-sm ajax-modal">{{ _lang('Edit') }}</a>
						<a href="{{action('StudentPaymentController@show', $studentpayment['id'])}}" data-title="{{ _lang('View Student Payment') }}" class="btn btn-info btn-sm ajax-modal">{{ _lang('View') }}</a>
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

@section('js-script')
<script>
function showClass(elem){
	if($(elem).val() == ""){
		return;
	}
	window.location = "<?php echo url('student_payments/class') ?>/"+$(elem).val();
}
</script>
@stop

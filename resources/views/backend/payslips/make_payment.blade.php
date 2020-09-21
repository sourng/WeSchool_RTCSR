@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Make Payment')}}
				</div>
			</div>
			<div class="panel-body">
				<form class="params-panel" action="{{ url('payslips/make_payment') }}" method="post">
					@csrf
					<div class="col-md-3 col-md-offset-3">
						<div class="form-group">
							<label for="date" class="control-label">{{ _lang('Month And Year') }}</label>
							<input type="text" name="month_year" class="form-control monthpicker" value="{{ $month_year }}" required>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<button type="submit" style="margin-top:27px;" class="btn btn-success btn-block">{{_lang('Next')}}</button>
						</div>
					</div>
				</form>
				@if(! empty($payslips))
				<form class="selection-form" action="{{ url('payslips/selection') }}" method="post">
					@csrf
					<header class="panel-heading">
						<span class="panel-title">{{ _lang('Payslips List') }}</span>
					</header>
					<div class="panel-body">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>{{ _lang('Employee Name') }}</th>
									<th>{{ _lang('Employee Id') }}</th>
									<th>{{ _lang('Net Salary') }}</th>
									<th class="text-center">
										<label class="c-container">{{_lang('Payment')}}
											<input type="checkbox" id="payment_all" onclick="payment(this)">
											<span class="checkmark"></span>
										</label>
									</th>
								</tr>
							</thead>
							<tbody>
								@php $i = 1; @endphp
								@foreach($payslips as $key => $data)
								<tr>
									<td>{{ $data->employee_name }}</td>
									<td>{{ $data->employee_id }}</td>
									<td>{{ get_option('currency_symbol') }}{{ $data->net_salary }}</td>
									<td class="text-center action">
										<label class="c-container">
											<input type="checkbox" name="id[{{$key}}]"  value="{{ $data->id }}" class="payment">
											<span class="checkmark"></span>
										</label>
									</td>
								</tr>
								@php $i++ @endphp
								@endforeach
							</tbody>
						</table>
						<div class="form-group text-right">
							<button type="submit" class="btn btn-primary">{{ _lang('Pay Now') }}</button>
						</div>
					</div>
				</form>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection

@section('js-script')
<script type="text/javascript">
	function payment(source) {
		var checkboxes = document.querySelectorAll('.payment');
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i] != source)
				checkboxes[i].checked = source.checked;
		}
	}
	//Ajax Modal Submit
	$(document).on("submit",".selection-form",function(){		 
		var link = $(this).attr("action");
		$.ajax({
			method: "POST",
			url: link,
			data:  new FormData(this),
			mimeType:"multipart/form-data",
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function(){
				$("#preloader").css("display","block");  
			},success: function(data){
				$("#preloader").css("display","none"); 
				if(data != 0){
					$('#main_modal .modal-title').html('Make Payment');
					$('#main_modal .modal-body').html(data);
					$('#main_modal').modal('show'); 
					$("#main_modal input:required, #main_modal select:required").prev().append("<span class='required'> *</span>");
				}else{
					Command: toastr['error']('{{ _lang('At least check one payslip.') }}');
					$('#main_modal').modal('hide');
				}
			}
		});
		return false;
	});
</script>
@stop
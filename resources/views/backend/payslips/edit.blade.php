@extends('layouts.backend')

@section('content')
<h4 class="panel-title" style="display: none;">{{ _lang('Edit') }}</h4>
<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-body">
				<div class="params-panel validate">
					@csrf
					<div class="col-md-4 col-md-offset-2">
						<div class="form-group">
							<label for="date" class="control-label">{{ _lang('Employee') }}</label>
							<select class="form-control select2" name="user_id" disabled required>
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_employee_option($payslip->user_id, ['status' => 1]) }}
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="date" class="control-label">{{ _lang('Month And Year') }}</label>
							<input type="text" name="month_year" class="form-control monthpicker" value="{{ $payslip->month_year }}" disabled required>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<form action="{{ route('payslips.update', $payslip->id) }}" class="ajax-submit2 payslips" autocomplete="off" method="post">
		@csrf
		@method('PUT')
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-body">
					<h3>{{ _lang('Basic Information') }}</h3>
					<hr>
					<div class="col-md-8 col-md-offset-2">
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label">{{ _lang('Current Salary') }} ({{ get_option('currency_symbol') }})</label>
								<input type="text" id="current_salary" class="form-control" name="current_salary" value="{{ $payslip->current_salary }}" readonly required>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label">{{ _lang('Expense Claim') }} ({{ get_option('currency_symbol') }})</label>
								<input type="text" id="expense_claim" class="form-control" name="expense_claim" value="{{ $payslip->expense_claim }}" readonly required>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label">{{ _lang('Absent Fine') }} ({{ get_option('currency_symbol') }})</label>
								<input type="text" id="absent_fine" class="form-control" name="absent_fine" value="{{ number_format($payslip->absent_fine, 2) }}" readonly required>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-body">
					<div class="col-md-6">
						<h3>{{ _lang('Allowances') }}</h3>
						<hr>
						@foreach($allowances AS $allowance)
						<div class="field_group">
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-control-label">{{ _lang('Title') }}</label>
									<input type="text" class="form-control allowance_title" name="allowance_title[]" value="{{ $allowance->title }}">
									<input type="hidden" class="id" name="allowance_id[]" value="{{ $allowance->id }}">
								</div>
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<label class="form-control-label">{{ _lang('Amount') }} ({{ get_option('currency_symbol') }})</label>
									<input type="number" class="form-control allowance_amount" name="allowance_amount[]" value="{{ $allowance->amount }}">
								</div>
							</div>
							<div class="col-md-1" style="padding-top: 31px;">
								<div class="form-group">
									<button type="button" class="btn btn-danger btn-xs remove-row" data-type="allowance">
										<i class="fa fa-minus" aria-hidden="true"></i>
									</button>
								</div>
							</div>
						</div>
						@endforeach
						@if(count($allowances) == 0)
						<div class="field_group">
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-control-label">{{ _lang('Title') }}</label>
									<input type="text" class="form-control deduction_title" name="deduction_title[]">
									<input type="hidden" class="id" name="deduction_id[]" value="">
								</div>
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<label class="form-control-label">{{ _lang('Amount') }} ({{ get_option('currency_symbol') }})</label>
									<input type="number" class="form-control deduction_amount" name="deduction_amount[]">
								</div>
							</div>
							<div class="col-md-1" style="padding-top: 31px;">
								<div class="form-group">
									<button type="button" class="btn btn-danger btn-xs remove-row">
										<i class="fa fa-minus" aria-hidden="true"></i>
									</button>
								</div>
							</div>
						</div>
						@endif
						<div class="field_group repeat_allowance" style="display: none;">
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-control-label">{{ _lang('Title') }}</label>
									<input type="text" class="form-control allowance_title" name="allowance_title[]">
									<input type="hidden" class="id" name="allowance_id[]" value="">
								</div>
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<label class="form-control-label">{{ _lang('Amount') }} ({{ get_option('currency_symbol') }})</label>
									<input type="number" class="form-control allowance_amount" name="allowance_amount[]">
								</div>
							</div>
							<div class="col-md-1" style="padding-top: 31px;">
								<div class="form-group">
									<button type="button" class="btn btn-danger btn-xs remove-row">
										<i class="fa fa-minus" aria-hidden="true"></i>
									</button>
								</div>
							</div>
						</div>
						<div class="col-md-12 allowance">
							<div class="form-group">
								<button type="button" id="add_allowance" class="btn btn-success btn-xs" title="{{ _lang('Add More') }}">
									<i class="fa fa-plus" aria-hidden="true"></i>
								</button>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<h3>{{ _lang('Deductions') }}</h3>
						<hr>
						@foreach($deductions AS $deduction)
						<div class="field_group">
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-control-label">{{ _lang('Title') }}</label>
									<input type="text" class="form-control deduction_title" name="deduction_title[]" value="{{ $deduction->title }}">
									<input type="hidden" class="id" name="deduction_id[]" value="{{ $deduction->id }}">
								</div>
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<label class="form-control-label">{{ _lang('Amount') }} ({{ get_option('currency_symbol') }})</label>
									<input type="number" class="form-control deduction_amount" name="deduction_amount[]" value="{{ $deduction->amount }}">
								</div>
							</div>
							<div class="col-md-1" style="padding-top: 31px;">
								<div class="form-group">
									<button type="button" class="btn btn-danger btn-xs remove-row" data-type="deduction">
										<i class="fa fa-minus" aria-hidden="true"></i>
									</button>
								</div>
							</div>
						</div>
						@endforeach
						@if(count($deductions) == 0)
						<div class="field_group">
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-control-label">{{ _lang('Title') }}</label>
									<input type="text" class="form-control deduction_title" name="deduction_title[]">
									<input type="hidden" class="id" name="deduction_id[]" value="">
								</div>
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<label class="form-control-label">{{ _lang('Amount') }} ({{ get_option('currency_symbol') }})</label>
									<input type="number" class="form-control deduction_amount" name="deduction_amount[]">
								</div>
							</div>
							<div class="col-md-1" style="padding-top: 31px;">
								<div class="form-group">
									<button type="button" class="btn btn-danger btn-xs remove-row">
										<i class="fa fa-minus" aria-hidden="true"></i>
									</button>
								</div>
							</div>
						</div>
						@endif
						<div class="field_group repeat_deduction" style="display: none;">
							<div class="col-md-6">
								<div class="form-group">
									<label class="form-control-label">{{ _lang('Title') }}</label>
									<input type="text" class="form-control deduction_title" name="deduction_title[]">
									<input type="hidden" class="id" name="deduction_id[]" value="">
								</div>
							</div>
							<div class="col-md-5">
								<div class="form-group">
									<label class="form-control-label">{{ _lang('Amount') }} ({{ get_option('currency_symbol') }})</label>
									<input type="number" class="form-control deduction_amount" name="deduction_amount[]">
								</div>
							</div>
							<div class="col-md-1" style="padding-top: 31px;">
								<div class="form-group">
									<button type="button" class="btn btn-danger btn-xs remove-row">
										<i class="fa fa-minus" aria-hidden="true"></i>
									</button>
								</div>
							</div>
						</div>
						<div class="col-md-12 deduction">
							<div class="form-group">
								<button type="button" id="add_deduction" class="btn btn-success btn-xs" title="{{ _lang('Add More') }}">
									<i class="fa fa-plus" aria-hidden="true"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-body">
					<h3>{{ _lang('Summary') }}</h3>
					<hr>
					<div class="col-md-8 col-md-offset-2">
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label">{{ _lang('Total Allowances') }} ({{ get_option('currency_symbol') }})</label>
								<input type="text" id="total_allowance" class="form-control" value="0.00" readonly required>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label">{{ _lang('Total Deductions') }} ({{ get_option('currency_symbol') }})</label>
								<input type="text" id="total_deduction" class="form-control" value="0.00" readonly required>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-control-label">{{ _lang('Net Salary') }} ({{ get_option('currency_symbol') }})</label>
								<input type="text" id="net_salary" class="form-control" name="net_salary" value="0.00" readonly required>
							</div>
						</div>
					</div>
					<div class="col-md-12 text-right">
						<div class="form-group">
							<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
@endsection
@section('js-script')
<script type="text/javascript">
	$('select[name=status]').val('{{ $payslip->status }}');
	$('select[name=employee_id]').on('change', function(){
		$('.payslips').remove();
	});
	$('#add_allowance').on('click',function(){
		var form = $('.repeat_allowance').clone().removeClass('repeat_allowance').css('display', 'unset');
		form.find('input').val('');
		$('.allowance').before(form);
	});
	$('#add_deduction').on('click',function(){
		var form = $('.repeat_deduction').clone().removeClass('repeat_deduction').css('display', 'unset');
		form.find('input').val('');
		$('.deduction').before(form);
	});
	$(document).on('click', '.remove-row', function(){
		var id = $(this).parent().parent().parent().find('.id').val();;
		if(typeof id != 'undefined' && id != ''){
			var c = confirm("Are you sure you want to permanently remove this record ?");
			if(! c){
				return false;
			}
			$(this).parent().parent().parent().remove();
			calculatingNetTotal();
			var type = $(this).data("type");
			$.ajax({
				url: '{{ url('payslips/remove') }}/' + type + '/' + id,
				type: 'GET',
				success: function(data){
					return true;
				} 
			});
		}else{
			$(this).parent().parent().parent().remove();
			calculatingNetTotal();
		}
	});

	calculatingNetTotal();
	$(document).on('change keyup blur','.allowance_amount,.deduction_amount', function(){
		calculatingNetTotal();
	});
	function calculatingNetTotal(){
		//calculating total_allowance
		var total_allowance = parseFloat($('#current_salary').val()) + parseFloat($('#expense_claim').val());
		$('.allowance_amount').each(function(){
			if($(this).val() != ''){
				total_allowance += parseFloat($(this).val());
			}
		});
		$('#total_allowance').val(total_allowance.toFixed(2));
		//calculating total_deduction
		var total_deduction = 0;
		if(typeof($('#absent_fine').val()) != 'undefined'){
			total_deduction += parseFloat($('#absent_fine').val());
		}
		$('.deduction_amount').each(function(){
			if($(this).val() != ''){
				total_deduction += parseFloat($(this).val());
			}
		});
		$('#total_deduction').val(total_deduction.toFixed(2));
		//calculating net_salary
		var net_salary = total_allowance - total_deduction;
		$('#net_salary').val(net_salary.toFixed(2));
	}
</script>
@stop




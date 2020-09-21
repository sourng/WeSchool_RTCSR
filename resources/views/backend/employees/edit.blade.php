@extends('layouts.backend')

@section('css-stylesheet')
<style type="text/css">
	.dropify-wrapper{
		height: 200px;
		width: 200px;
	}
	.remove-row{
		padding: 2px 4px;
	}
</style>
@stop

@section('content')
<div class="row">
	<span class="panel-title" style="display: none;">{{ _lang('Edit Details') }}</span>
	<form class="ajax-submit3" method="post" autocomplete="off" action="{{ route('employees.update', $employee->id) }}" enctype="multipart/form-data">
		@csrf
		@method('PUT')
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-body">
					<h3>{{ _lang('Personal Details') }}</h3>
					<hr>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Name') }}</label>
							<input type="text" name="name" class="form-control" value="{{ $employee->user->name }}" readonly>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Father Name') }}</label>
							<input type="text" name="father_name" class="form-control" value="{{ $employee->father_name }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Mother Name') }}</label>
							<input type="text" name="mother_name" class="form-control" value="{{ $employee->mother_name }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('DoB') }}</label>
							<input type="text" name="dob" class="form-control datepicker" value="{{ $employee->dob }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Street') }}</label>
							<input type="text" name="street" class="form-control" value="{{ $employee->street }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('State') }}</label>
							<input type="text" name="state" class="form-control" value="{{ $employee->state }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Zip Code') }}</label>
							<input type="text" name="zip_code" class="form-control" value="{{ $employee->zip_code }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Country') }}</label>
							<select class="form-control select2" name="country" required>
								<option value="">{{ _lang('Select One') }}</option>
								{{ get_country_list($employee->country) }}
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel">
				<div class="panel-body">
					<h3>{{ _lang('Company Details') }}</h3>
					<hr>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Employee Id') }}</label>
							<input type="text" name="employee_id" class="form-control" value="{{ $employee->employee_id }}" readonly required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Department') }}</label>
							<select class="form-control select2" name="department_id" required>
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option2('departments', 'id', 'department', $employee->department_id, ['status' => 'Active']) }}
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Designation') }}</label>
							<select class="form-control select2" name="designation_id" required>
								{{ create_option2('designations', 'id', 'designation', $employee->designation_id, ['department_id' => $employee->department_id]) }}
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Joining Date') }}</label>
							<input type="text" name="joining_date" class="form-control datepicker" value="{{ $employee->joining_date }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Exit Date') }}</label>
							<input type="text" name="exit_date" class="form-control datepicker" value="{{ $employee->exit_date }}">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Joining Salary') }} ({{ get_option('currency_symbol') }})</label>
							<input type="number" name="joining_salary" class="form-control" value="{{ ($employee->joining_salary != '') ? $employee->joining_salary : 0 }}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Current Salary') }} ({{ get_option('currency_symbol') }})</label>
							<input type="number" name="current_salary" class="form-control" value="{{ ($employee->current_salary != '') ? $employee->current_salary : 0 }}" required>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel">
				<div class="panel-body">
					<h3>{{ _lang('Bank Details') }}</h3>
					<hr>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Account Holder Name') }}</label>
							<input type="text" name="account_holder_name" class="form-control" value="{{ $employee->account_holder_name }}">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Account Number') }}</label>
							<input type="text" name="account_number" class="form-control" value="{{ $employee->account_number }}">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Bank Name') }}</label>
							<input type="text" name="bank_name" class="form-control" value="{{ $employee->bank_name }}">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Bank Identifier Code') }}</label>
							<input type="text" name="bank_identifier_code" class="form-control" value="{{ $employee->bank_identifier_code }}">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Branch Location') }}</label>
							<input type="text" name="branch_location" class="form-control" value="{{ $employee->branch_location }}">
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
						@foreach($default_allowances AS $allowance)
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
						@if(count($default_allowances) == 0)
						<div class="field_group">
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
						@foreach($default_deductions AS $deduction)
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
						@if(count($default_deductions) == 0)
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
					<h3>{{ _lang('Documents') }}</h3>
					<hr>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">{{ _lang('Resume') }}</label>
							<input type="file" class="form-control dropify" name="resume" data-allowed-file-extensions="doc docx pdf" data-default-file="{{ $employee->resume != '' ? asset('public/uploads/files/' . $employee->resume) : '' }}">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">{{ _lang('Joining Letter') }}</label>
							<input type="file" class="form-control dropify" name="joining_letter" data-allowed-file-extensions="doc docx pdf" data-default-file="{{ $employee->joining_letter != '' ? asset('public/uploads/files/' . $employee->joining_letter) : '' }}">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">{{ _lang('ID Card') }}</label>
							<input type="file" class="form-control dropify" name="id_card" data-allowed-file-extensions="doc docx pdf" data-default-file="{{ $employee->id_card != '' ? asset('public/uploads/files/' . $employee->id_card) : '' }}">
						</div>
					</div>
					
					<div class="col-md-12 text-right">
						<div class="form-group">
							<button type="submit" class="btn btn-primary">{{ _lang('Update') }}</button>
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
	$('select[name=department_id]').on('change', function(){
		var department_id = $(this).val();
		if(typeof department_id != 'undefined' && department_id != ''){
			$.ajax({
				url: '{{ url('departments/options') }}/' + department_id,
				type: 'GET',
				beforeSend: function(){
					$("#preloader").css("display","block"); 
				},
				success: function(data){
					$('#preloader').css('display', 'none');
					$('select[name=designation_id]').html(data);
				} 
			});
		}else{
			$('select[name=designation_id]').html('<option value="">{{ _lang('Select One') }}</option>');
		}
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
			var type = $(this).data("type");
			$.ajax({
				url: '{{ url('employees/remove') }}/' + type + '/' + id,
				type: 'GET',
				success: function(data){
					return true;
				} 
			});
		}else{
			$(this).parent().parent().parent().remove();
		}
	});
</script>
@stop
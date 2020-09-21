@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">
					{{ _lang('Details') }}
				</h2>
			</header>
			<div class="panel-body">
				<table class="table table-bordered">
					
					<tr>
						<td colspan="4" class="text-center"><img class="img-lg" src="{{ asset('public/uploads/images/' . $employee->user->image) }}" width="100"></td>
					</tr>
					<tr>
						<td>{{ _lang('Employee Id') }}</td>
						<td>{{ $employee->employee_id }}</td>
						<td>{{ _lang('Name') }}</td>
						<td>{{ $employee->user->name }}</td>
					</tr>
					<tr>
						<td>{{ _lang('Father Name') }}</td>
						<td>{{ $employee->father_name }}</td>
						<td>{{ _lang('Mother Name') }}</td>
						<td>{{ $employee->mother_name }}</td>
					</tr>
					<tr>
						<td>{{ _lang('Dob') }}</td>
						<td>{{ $employee->dob }}</td>
						<td>{{ _lang('Street') }}</td>
						<td>{{ $employee->street }}</td>
					</tr>
					<tr>
						<td>{{ _lang('State') }}</td>
						<td>{{ $employee->state }}</td>
						<td>{{ _lang('Zip Code') }}</td>
						<td>{{ $employee->zip_code }}</td>
					</tr>
					<tr>
						<td>{{ _lang('Country') }}</td>
						<td>{{ $employee->country }}</td>
						<td>{{ _lang('Department') }}</td>
						<td>
							@if (isset($employee->department) && isset($employee->designation))
								{{ $employee->department->department }} ({{ $employee->designation->designation }})
							@endif
						</td>
					</tr>
					<tr>
						<td>{{ _lang('Joining Salary') }}</td>
						<td>{{ get_option('currency_symbol') }}{{ $employee->joining_salary }}</td>
						<td>{{ _lang('Current Salary') }}</td>
						<td>{{ get_option('currency_symbol') }}{{ $employee->current_salary }}</td>
					</tr>
					<tr>
						<td>{{ _lang('Account Holder Name') }}</td>
						<td>{{ $employee->account_holder_name }}</td>
						<td>{{ _lang('Account Number') }}</td>
						<td>{{ $employee->account_number }}</td>
					</tr>
					<tr>
						<td>{{ _lang('Bank Name') }}</td>
						<td>{{ $employee->bank_name }}</td>
						<td>{{ _lang('Bank Identifier Code') }}</td>
						<td>{{ $employee->bank_identifier_code }}</td>
					</tr>
					<tr>
						<td>{{ _lang('Branch Location') }}</td>
						<td colspan="3">{{ $employee->branch_location }}</td>
					</tr>
					@if ($employee->resume != null)
					<tr>
						<td colspan="2">{{ _lang('Resume') }}</td>
						<td colspan="2">
							<a href="{{ asset('public/uploads/' . $employee->resume) }}" class="btn btn-default btn-xs" title="{{ _lang('Download') }}" target="_blank">
								<i class="fa fa-download"></i>
							</a>
						</td>
					</tr>
					@endif
					@if ($employee->joining_letter != null)
					<tr>
						<td colspan="2">{{ _lang('Joining Letter') }}</td>
						<td colspan="2">
							<a href="{{ asset('public/uploads/' . $employee->joining_letter) }}" class="btn btn-default btn-xs" title="{{ _lang('Download') }}" target="_blank">
								<i class="fa fa-download"></i>
							</a>
						</td>
					</tr>
					@endif
					@if ($employee->id_card != null)
					<tr>
						<td colspan="2">{{ _lang('ID Card') }}</td>
						<td colspan="2">
							<a href="{{ asset('public/uploads/' . $employee->id_card) }}" class="btn btn-default btn-xs" title="{{ _lang('Download') }}" target="_blank">
								<i class="fa fa-download"></i>
							</a>
						</td>
					</tr>
					@endif
				</table>
			</div>
		</div>
	</div>
</div>
@endsection



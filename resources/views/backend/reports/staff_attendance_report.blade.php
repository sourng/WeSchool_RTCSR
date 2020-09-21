@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title" >
					{{_lang('Staff Attendance Report')}}
				</span>
			</div>
			<div class="panel-body">
				<form id="search_form" class="params-panel validate" action="{{ url('reports/staff_attendance_report/view') }}" method="post" autocomplete="off" accept-charset="utf-8">
					@csrf
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">{{ _lang('Role') }}</label>
							<select name="user_type" class="form-control select2" required>
								<option value="">{{ _lang('Select One') }}</option>
								<option @if($user_type=='Admin') selected @endif value="Admin">{{ _lang('Admin') }}</option>
								<option @if($user_type=='Teacher') selected @endif value="Teacher">{{ _lang('Teacher') }}</option>
								<option @if($user_type=='Accountant') selected @endif value="Accountant">{{ _lang('Accountant') }}</option>
								<option @if($user_type=='Librarian') selected @endif value="Librarian">{{ _lang('Librarian') }}</option>
								<option @if($user_type=='Employee') selected @endif value="Employee">{{ _lang('Employee') }}</option>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">{{ _lang('Month') }}</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								<input type="text" class="form-control monthpicker" name="month" value="{{ $month }}" readOnly="true" required>
						    </div>
						</div>
					</div>
					

					<div class="col-sm-3">
						<div class="form-group">
							<button type="submit" style="margin-top:24px;" class="btn btn-primary btn-block rect-btn">{{_lang('View Report')}}</button>
						</div>
					</div>
				</form>
				
				@if( isset($report_data) )	
				<div class="col-md-12 params-panel" id="attendance">
                    <button type="button" data-print="attendance" class="btn btn-primary btn-sm pull-right print"><i class="fa fa-print"></i> {{ _lang('Print Report') }}</button>			
						<div class="text-center clear">
							{{ get_option('school_name') }}<br>
							{{ _lang('Attendance Report for') }} {{ $user_type }}<br>
							{{ $month }}</br></br>	
						</div>
						
					   <div class="table-responsive"> 
					    @if( !empty($report_data) )
							<table class="table table-bordered">
								<thead>
								   <th>{{  $user_type." "._lang('Name') }}</th>
								   @for($day = 1; $day <= $num_of_days; $day++)
									  <th>{{ $day }}</th>
								   @endfor
								</thead>
								<tbody>
								  @foreach($report_data as $key=>$value)
								   <tr>
									 <td>{{ $users[$key]->name }}</td>
									 @foreach($value as $user=>$attendance)
										<td class="text-center">{{ $attendance }}</td> 
									 @endforeach
								   </tr>
								  @endforeach
								</tbody>
							</table>
						@else	
							<h4 class="text-center">{{ _lang('No Records Found !') }}</h4>
						@endif	
					   </div>
						
					</div><!--End panel-->
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
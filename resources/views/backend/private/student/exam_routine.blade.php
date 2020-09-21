@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading panel-title">{{ _lang('Exam Routine') }}</div>

	<div class="panel-body">
		<form method="post" class="params-panel validate" autocomplete="off" action="{{url('student/exam_routine/view')}}">  
			{{ csrf_field() }}
			
			<div class="col-md-6">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Select Exam') }}</label>						
				<select class="form-control select2" name="exam_id" required>
				   <option value="">{{ _lang('Select One') }}</option>
				   {{ create_option("exams","id","name",$exam_id,array("session_id="=>get_option('academic_year'))) }}
				</select> 
			  </div>
			</div>
							
			<div class="col-md-6">
			  <div class="form-group">
				<button type="submit" style="margin-top:24px;" class="btn btn-primary btn-block rect-btn">{{ _lang('View Report') }}</button>
			  </div>
			</div>
		  </form>
		</div>
	  </div><!-- End Panel-->
  
		<!--For View Emam Routine-->
		@if (isset($subjects)) 
			@if (count($subjects)>0) 
				<div class="panel panel-default">
				<div class="panel-heading">
				   <span class="panel-title">{{ _lang('Exam Routine') }}</span>
				   <button type="button" data-print="exam_routine" class="btn btn-primary btn-sm pull-right print"><i class="fa fa-print"></i> {{ _lang('Print Routine') }}</button>
				</div>

				<div class="panel-body" id="exam_routine">
				
				<div class="table-responsive">
					<table class="table table-bordered">
						<tr>
						   <td colspan="100" class="text-center">
							  <span class="f-20">{{ get_option('school_name') }}</span></br>
							  <span class="f-18">{{ _lang('Exam Routine') }}</span></br> 
							  <span class="f-16">{{ _lang('Class') }}: {{ get_class_name($class_id) }}</span> 
						   </td>
						</tr>
					</table>	
					
					<table class="table table-bordered">		
						<tbody>  
							<thead>
								<th>{{ _lang('Subject') }}</th>
								<th>{{ _lang('Date') }}</th>
								<th>{{ _lang('Start Time') }}</th>
								<th>{{ _lang('End Time') }}</th>
								<th>{{ _lang('Room') }}</th>
							</thead>
							@foreach($subjects as $subject)
								<tr>
								  <td>{{ $subject->subject_name }}</td>
								  <td>{{ $subject->date }}</td>
								  <td>{{ $subject->start_time }}</td>
								  <td>{{ $subject->end_time }}</td>
								  <td>{{ $subject->room }}</td>
								</tr>
							@endforeach	
						</tbody>
					</table>
				</div>		
			</div>
		  </div> 
		   @else
			<div class="alert alert-danger">
			   <h5>{{ _lang('No Subject Assign for this class !') }}</h5>
			</div>
		  @endif	  
		@endif   
 </div>
</div>
@endsection



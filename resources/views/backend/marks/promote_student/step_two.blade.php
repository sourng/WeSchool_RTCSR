@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
	   <form class="params-panel validate" action="{{ url('students/promote/3') }}" method="post" autocomplete="off" accept-charset="utf-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title" >
					{{_lang('Promote Student')}}
				</span>
			</div>
			<div class="panel-body">			
				@csrf
				<div class="col-md-10">
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">{{ _lang('Selected Class') }}</label>
							<input type="hidden" name="class_id" value="{{ $class_id }}">
							<select name="disabled_class_id" class="form-control select2" disabled>
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option('classes','id','class_name',$class_id) }}
							</select>
						</div>
					</div>
					
					<div class="col-md-4">						
						<div class="form-group">
							<label class="control-label">{{ _lang('Promote Class') }}</label>
							<select name="promote_class_id" class="form-control select2" required>
								<option value="">{{ _lang('Select One') }}</option>
								@foreach(get_table("classes",array("id !="=>$class_id)) as $table)
									<option value="{{ $table->id }}">{{ $table->class_name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					
					<div class="col-md-4">						
						<div class="form-group">
							<label class="control-label">{{ _lang('Promote Session') }}</label>					
							<select class="form-control select2" name="promoted_session" required>
								<option value="">{{ _lang('Select One') }}</option>
								@foreach(get_table("academic_years",array("id !="=>get_option('academic_year'))) as $table)
									<option value="{{ $table->id }}">{{ $table->session }}</option>
								@endforeach
							</select>
						</div>
					</div>
					
				</div>
				
				<div class="col-md-2">
					<div class="form-group">
						<button type="submit" style="margin-top:24px;" class="btn btn-primary btn-block rect-btn">{{_lang('Promote')}}</button>
					</div>
				</div>
				

			</div>
		</div><!--End Panel-->
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title" >
					{{ _lang('Promotion Option') }}
				</span>
			</div>
			<div class="panel-body">

			   <div class="col-md-12">
				   <div class="alert alert-info">
					  <strong><h5>{{ _lang('Student Roll will be placed automatically based on their Result.') }}</h5></strong>
				   </div>
			   </div>			
				
			   <div class="col-md-12">		
				   <div class="alert alert-info">
					  <strong><h5>{{ _lang('Only Selected Subjects need pass mark or you can also change pass mark before promoting.') }}</h5></strong>
				   </div>
			   </div>
			   
			   @foreach(get_table('subjects',array("class_id=" => $class_id)) as $subject)
			     <div class="col-md-4">
					<label class="c-container"><input type="checkbox" checked="true" name="subject[{{ $subject->id }}]"><span class="checkmark"></span> {{ $subject->subject_name }} ( {{ _lang('Pass Mark')." = ".$subject->pass_mark }} )</label>
			     </div>
			   @endforeach

			</div>
		</div>
	  </form>
	</div>
</div>
@endsection
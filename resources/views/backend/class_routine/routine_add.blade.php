@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{!! _lang('Class')." : <b>". $class->class_name."</b>" !!} &nbsp;&nbsp; <span class="pull-right"> {!! _lang('Section')." : <b>".$section->section_name."" !!}</span>
				</div>
			</div>
			<div class="panel-body">
			  <div class="col-md-12">

					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				    @if(empty($routine))
						<div class="alert alert-danger">
					        <strong>{{ _lang('You must add subjects before adding class routine') }}</strong>
						</div>
					@endif
				
					@foreach($routine as $key=>$data)
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="heading-{{ $key }}">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{ $key }}" aria-expanded="false" aria-controls="collapse-{{ $key }}" class="collapsed">
									{{ $key }}
									</a>
								</h4>
							</div>
							<div id="collapse-{{ $key }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-{{ $key }}">
								<div class="panel-body">
									 <form action="{{url('class_routines/store')}}" class="appsvan-submit" autocomplete="off" method="post">
									 @csrf
									 <table class="table table-bordered">
									     <thead>
										    <th>Subject</th>
										    <th>Start Time</th>
										    <th>End Time</th>
										 </thead>
										 <tbody>
									   @foreach($data as $field)
									     <tr>
										    <td>{{ $field->subject_name }}</td>
											<input type="hidden" name="section_id[]" value="{{ $section->id }}">
											<input type="hidden" name="subject_id[]" value="{{ $field->s_id }}">
											<input type="hidden" name="routine_id[]" value="{{ $field->id }}">
											<input type="hidden" name="day[]" value="{{ $key}}">
										    <td><input type="text" class="form-control timepicker" name="start_time[]" value="{{ $field->start_time }}"></td>
										    <td><input type="text" class="form-control timepicker" name="end_time[]" value="{{ $field->end_time }}"></td>
										 </tr>
									   @endforeach
									   
									     <tr>
										    <td colspan="3"><button type="submit" class="btn btn-primary pull-right">Save {{ ucwords(strtolower($key)) }} Routine</button></td>
										 </tr>
									    </tbody>
									 </table>
									 </form>
								</div>
							</div>
						</div>
					@endforeach
					</div>

			   </div>	
			</div>
		</div>
	</div>
</div>
@endsection

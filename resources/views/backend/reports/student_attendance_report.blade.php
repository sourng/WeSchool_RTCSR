@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title" >
					{{_lang('Student Attendance Report')}}
				</span>
			</div>
			<div class="panel-body">
				<form id="search_form" class="params-panel validate" action="{{ url('reports/student_attendance_report/view') }}" method="post" autocomplete="off" accept-charset="utf-8">
					@csrf
					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label">{{ _lang('Class') }}</label>
							<select name="class_id" class="form-control select2" onChange="getData(this.value);" required>
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option('classes','id','class_name',$class_id) }}
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label">{{ _lang('Section') }}</label>
							<select name="section_id" class="form-control select2" required>
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option('sections','id','section_name',$section_id,array("class_id="=>$class_id)) }}
							</select>
						</div>
					</div>
					
					<div class="col-sm-3">
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
							{{ _lang('Attendance Report for Class') }} {{ $class }}<br>
							{{ _lang('Section')." ".$section }} </br>
							{{ $month }}</br></br>	
						</div>
						
					   <div class="table-responsive"> 
					    @if( !empty($report_data) )
							<table class="table table-bordered">
								<thead>
								   <th>{{ _lang('Student Name') }}</th>
								   <th>{{ _lang('Roll') }}</th>
								   @for($day = 1; $day <= $num_of_days; $day++)
									  <th>{{ $day }}</th>
								   @endfor
								</thead>
								<tbody>
								  @foreach($report_data as $key=>$value)
								   <tr>
									 <td>{{ $students[$key]->first_name." ".$students[$key]->last_name }}</td>
									 <td>{{ $students[$key]->roll }}</td>
									 @foreach($value as $student=>$attendance)
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
						
					</div>
				@endif
				</div><!--End panel-->
			</div>
		</div>
	</div>
</div>
@endsection

@section('js-script')
<script type="text/javascript">
	function getData(val) {
		var _token=$('input[name=_token]').val();
		var class_id=$('select[name=class_id]').val();
		$.ajax({
			type: "POST",
			url: "{{url('sections/section')}}",
			data:{_token:_token,class_id:class_id},
			beforeSend: function(){
				$("#preloader").css("display","block");
			},success: function(sections){
				$("#preloader").css("display","none");
				$('select[name=section_id]').html(sections);				
			}
		});
	}

</script>
@stop
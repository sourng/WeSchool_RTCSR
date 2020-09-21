@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title" >
					{{_lang('Progress Card')}}
				</span>
			</div>
			<div class="panel-body">
				<nav class="navbar navbar-default child-profile-menu">
				  <div class="container-fluid">
					<ul class="nav navbar-nav">
					  <li class="active"><a href="{{ url('parent/my_children/'.$student_id) }}">{{ _lang('Profile') }}</a></li>
					  <li><a href="{{ url('parent/children_attendance/'.$student_id) }}">{{ _lang('Attendance') }}</a></li>
					  <li><a href="{{ url('parent/progress_card/'.$student_id) }}">{{ _lang('Progress Card') }}</a></li>
					</ul>
				  </div>
				</nav>
				<!--Show Full Report Card-->
				  @if(!empty($exams))
					<div class="panel panel-default" id="progress_card">
						<div class="panel-heading">
							<span class="panel-title">{{ _lang('Progress Card') }}</span>
							<button type="button" data-print="progress_card" class="btn btn-primary btn-sm pull-right print"><i class="fa fa-print"></i> {{ _lang('Print Progress Card') }}</button>	
						</div>
						<div class="panel-body">
						   <table class="table table-bordered">
								<tr>
									<td colspan="4" style="text-align:center;"><img width="100px" style="border-radius: 8px; padding:5px; border:2px solid #ccc;" src="{{ asset('public/uploads/images/'.$student->image) }}"></td>
								</tr>
								<tr>
									<td><b>{{ _lang('School') }}</b></td>
									<td>{{ get_option('school_name') }}</td>
									<td><b>{{ _lang('Student Name') }}</b></td>
									<td>{{ $student->first_name." ".$student->last_name }}</td>
								</tr>
								<tr>
									<td><b>{{ _lang('Class') }}</b></td>
									<td>{{ $student->class_name }}</td>
									<td><b>{{ _lang('Section') }}</b></td>
									<td>{{ $student->section_name }}</td>
								</tr>
								<tr>
									<td><b>{{ _lang('Roll') }}</b></td>
									<td>{{ $student->roll }}</td>
									<td><b>{{ _lang('Reg No') }}</b></td>
									<td>{{ $student->register_no }}</td>
								</tr>
								<tr>
									<td><b>{{ _lang('Academic Year') }}</b></td>
									<td>{{ get_academic_year(get_option('academic_year')) }}</td>
									<td><b>{{ _lang('Group') }}</b></td>
									<td>{{ $student->group_name }}</td>
								</tr>
						   </table>
						   <div class="table-responsive">			   
							   <table class="table table-bordered report-card">
								  <thead>
									<tr>
									  <th rowspan="2">{{ _lang('Subject') }}</th> 				  
									  @foreach($exams as $exam) 					
									   <th colspan="{{ count($mark_head) }}" style="background:#bdc3c7;text-align:center"><b>{{ $exam->name }}</b></th>
									  @endforeach
									<th rowspan="2">{{ _lang('Total') }}</th> 
									<th rowspan="2">{{ _lang('Grade') }}</th> 
									<th rowspan="2">{{ _lang('Point') }}</th> 
									</tr>
									
									<tr>
										@foreach($exams as $exam)
											@foreach($mark_head as $mh)
											  <th style="background:#bdc3c7">{{ $mh->mark_type }}</th>
											@endforeach	
										@endforeach		
									</tr>
								  </thead>
								  <tbody>
								   
									  @php $total = 0; @endphp
									  @php $total_subject = 0; @endphp
									  
									  @foreach($subjects as $subject)
									   @php $row_total=0; @endphp
									   @php $point=0; @endphp
									   <tr> 
										   <td>{{ $subject->subject_name }}</td>
										   @foreach($exams as $exam) 
						
												@foreach($mark_details[$subject->id][$exam->exam_id] as $md)
												   @php 
												   $row_total = $row_total + $md->mark_value; 
												   $point = get_point($row_total/count($exams)); 
												   $grade = get_grade($row_total/count($exams)); 
												   @endphp
												  <td style="text-align:center">{{ $md->mark_value }}</td>
												@endforeach 	
										  @php $total_subject++  @endphp	
										  @endforeach
										  <td>{{ $row_total }}</td>
										  <td>{{ $grade }}</td>
										  <td>{{ $point }}</td>
									   </tr>
									   @php $total = $total + $row_total; @endphp
									@endforeach 
									<tr>
									  <td colspan="100%" style="text-align:center"><h5>{!! _lang('Total Marks')." : <b>".$total."</b>" !!}</h5></td>
									</tr>
									
									<tr>
									  <td colspan="100%" style="text-align:center"><h5>{!! _lang('Average Marks')." : <b>".($total/$total_subject)."</b>" !!}</h5></td>
									</tr>
									
									<tr>
									  <td colspan="100%" style="text-align:center"><h5>{!! _lang('Point')." : <b>".get_point($total/$total_subject)."</b>" !!}</h5></td>
									</tr>
									
									<tr>
									  <td colspan="100%" style="text-align:center"><h5>{!! _lang('Grade')." : <b>".get_grade($total/$total_subject)."</b>" !!}</h5></td>
									</tr>
									
								  </tbody>
							   </table>
						   </div>			   
						</div>
					</div>
				  @endif
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
	
	function get_students(){

		var class_id = "/"+$('select[name=class_id]').val();
		var section_id = "/"+$('select[name=section_id]').val();
		var link = "{{ url('students/get_students') }}"+class_id+section_id;
		$.ajax({
			url: link,
			beforeSend: function(){
				$("#preloader").css("display","block");
			},success: function(data){
				$("#preloader").css("display","none");
				var json =JSON.parse(data);
				   $('select[name=student_id]').html("");
				   
				jQuery.each( json, function( i, val ) {
				   $('select[name=student_id]').append("<option value='"+val['id']+"'>Roll "+val['roll']+" - "+val['first_name']+" "+val['last_name']+"</option>");
				});
			
			}
		});	
	}

</script>
@stop

@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title" >
					{{_lang('Exam Report')}}
				</span>
			</div>
			<div class="panel-body">
				<form id="search_form" class="params-panel validate" action="{{ url('reports/exam_report/view') }}" method="post" autocomplete="off" accept-charset="utf-8">
					@csrf
					<div class="col-md-3">
					  <div class="form-group">
						<label class="control-label">{{ _lang('Select Exam') }}</label>						
						<select class="form-control select2" name="exam_id" required>
						   <option value="">{{ _lang('Select One') }}</option>
						   {{ create_option("exams","id","name",$exam_id,array("session_id="=>get_option('academic_year'))) }}
						</select> 
					  </div>
					</div>
					
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
							<select name="section_id" onchange="get_students();" class="form-control select2" required>
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option('sections','id','section_name',$section_id,array("class_id="=>$class_id)) }}
							</select>
						</div>
					</div>
					
					<div class="col-sm-3">
					   <div class="form-group">
							<label class="control-label">{{ _lang('Select Student') }}</label>
							<select name="student_id" id="student_id" class="form-control select2">
								<option value="">{{ _lang('Select One') }}</option>
							</select>
						</div>
					</div>
					

					<div class="col-sm-3">
						<div class="form-group">
							<button type="submit" style="margin-top:24px;" class="btn btn-primary btn-block rect-btn">{{_lang('View Report')}}</button>
						</div>
					</div>
				</form>
				
				@if( isset($mark_details) )	
                    <div class="panel panel-default" id="report">
						<div class="panel-heading">
							<span class="panel-title">{{ $exam->name }}</span>
							<button type="button" data-print="report" class="btn btn-primary btn-sm pull-right print"><i class="fa fa-print"></i> {{ _lang('Print')." ".$exam->name." "._lang('Only') }}</button>	
						</div>
						<div class="panel-body">
						   <table class="table table-bordered">
								<tr>
									<td colspan="2" style="text-align:center;"><img width="100px" style="border-radius: 8px; padding:5px; border:2px solid #ccc;" src="{{ asset('public/uploads/images/'.$student->image) }}"></td>
								</tr>
								<tr>
									<td><b>{{ _lang('Name') }}</b>
									<td>{{ $student->first_name." ".$student->last_name }}</td>
								</tr>
								<tr>
									<td><b>{{ _lang('Class') }}</b></td>
									<td>{{ $student->class_name }}</td>
								</tr>
								<tr>
									<td><b>{{ _lang('Section') }}</b></td>
									<td>{{ $student->section_name }}</td>
								</tr>
								<tr>
									<td><b>{{ _lang('Roll') }}</b></td>
									<td>{{ $student->roll }}</td>
								</tr>
						   </table>
						   <table class="table table-bordered">
							  <thead>
								<th>{{ _lang('Subject') }}</th>
								@foreach($mark_head as $mh)
									<th style="text-align:center">{{ $mh->mark_type }}</th>
								@endforeach
								<th style="text-align:center">{{ _lang('Total') }}</th>
								<th style="text-align:center">{{ _lang('Grade') }}</th>
								<th style="text-align:center">{{ _lang('Point') }}</th>
							  </thead>
							  <tbody>
								@php $total = 0; @endphp
								@php $total_point = 0; @endphp
								@php $total_subject = 0; @endphp
								@php $fail = false; @endphp
								
								@foreach($subjects as $subject)
								   <tr>
									 <td>{{ $subject->subject_name }}</td>
									 
									 @php $row_total=0; @endphp
									 @php $point=0; @endphp
									 
									 @if(isset($mark_details[$subject->id][$exam->id]))
										 @foreach($mark_details[$subject->id][$exam->id] as $md)
										   @php 
											  $row_total = $row_total + $md->mark_value; 
											  $point = get_point($row_total); 
										   @endphp
										   <td style="text-align:center">{{ $md->mark_value }}</td>
										 @endforeach
									  @else
										@foreach($mark_head as $mh)
									       @php 
											  $row_total = $row_total + 0; 
											  $point = get_point($row_total);   
										   @endphp
										  <td style="text-align:center">{{ _lang('N/A') }}</td>
										@endforeach	
									  @endif
									 
									 <td style="text-align:center">{{ $row_total }}</td>
									 <td style="text-align:center">{{ get_grade($row_total) }}</td>
									 <td style="text-align:center">{{ $point }}</td>
								   </tr>
								   @php $total = $total + $row_total; @endphp
								   @php $total_point = $total_point + $point; @endphp
								   @php $total_subject++; @endphp
								   @php if($subject->pass_mark>$row_total){ $fail = true;} @endphp
								@endforeach
								
								   <tr>
									<td><b>{{ _lang('Total Marks') }}</b></td>
									@foreach($mark_head as $mh)
										<td style="text-align:center"></td>
									@endforeach
									<td style="text-align:center">{{ $total }}</td>
									<td style="text-align:center">{{ _lang("Avg Grade")." ".decimalPlace(($total_point/$total_subject)) }}</td>
									<td style="text-align:center">{{ decimalPlace($total_point) }}</td>
								  </tr>
								  <tr>
									<td colspan="100%">
									  @if ($fail == true)
										<div class="alert alert-danger"><h5>{{ _lang("Final Grade")." "._lang("FAIL") }}</h5></div>  
									  @else
										<div class="alert alert-success"><h5>{{ _lang("Final Grade")." ".get_final_grade(($total_point/$total_subject)) }}</h5></div>
									  @endif	  
									</td>
								  </tr>
							  </tbody>
						   </table>	
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
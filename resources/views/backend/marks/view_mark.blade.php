@extends('layouts.backend')

@section('content')

<div class="row" id="print">
	<div class="col-md-12">
	  @if(empty($exams))
		<div class="panel panel-default">
			<div class="panel-heading">
			   <span class="panel-title">{{ _lang('No Exam Found') }}</span>
			</div>
			<div class="panel-body">
			  <div class="alert alert-danger">
				  <h5>{{ _lang('Sorry No Exam Found !') }}</h5>
			  </div>
			</div>
		</div>	
	  @endif
	  
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
                                    @if(isset($mark_details[$subject->id][$exam->exam_id]))
										@foreach($mark_details[$subject->id][$exam->exam_id] as $md)
										   @php 
											  $row_total = $row_total + $md->mark_value; 
											  $point = get_point($row_total/count($exams)); 
											  $point = is_numeric($point) ? $point : 0.00;
											  $grade = get_grade($row_total/count($exams)); 
										   @endphp
										  <td style="text-align:center">{{ $md->mark_value }}</td>
										@endforeach
                                    @else
										@foreach($mark_head as $mh)
									       @php 
											  $row_total = $row_total + 0; 
											  $point = get_point($row_total/count($exams));
											  $point = is_numeric($point) ? $point : 0.00;
											  $grade = get_grade($row_total/count($exams)); 
										   @endphp
										  <td style="text-align:center">{{ _lang('N/A') }}</td>
										@endforeach	
								    @endif
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
	
	
	  <!--Show Seperate Result-->
	  @foreach($exams as $exam)
		<div class="panel panel-default" id="exam_{{ $exam->exam_id }}">
			<div class="panel-heading">
				<span class="panel-title">{{ $exam->name }}</span>
				<button type="button" data-print="exam_{{ $exam->exam_id }}" class="btn btn-primary btn-sm pull-right print"><i class="fa fa-print"></i> {{ _lang('Print')." ".$exam->name." "._lang('Only') }}</button>	
			</div>
			<div class="panel-body">
			   <table class="table table-bordered">
			        <tr>
						<td colspan="2" style="text-align:center;"><img width="100px" style="border-radius: 8px; padding:5px; border:2px solid #ccc;" src="{{ asset('public/uploads/images/'.$student->image) }}"></td>
					</tr>
					<tr>
						<td><b>{{ _lang('Name') }}</b></td>
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
						 
						 @if(isset($mark_details[$subject->id][$exam->exam_id]))
							 @foreach($mark_details[$subject->id][$exam->exam_id] as $md)
							   @php 
							   $row_total = $row_total + $md->mark_value; 
							   $point = get_point($row_total); 
							   $point = is_numeric($point) ? $point : 0.00;
							   @endphp
							   <td style="text-align:center">{{ $md->mark_value }}</td>
							 @endforeach
						 @else
							 @foreach($mark_head as $mh)
						        @php 
								  $row_total = $row_total + 0; 
								  $point = get_point($row_total/count($exams)); 
								  $point = is_numeric($point) ? $point : 0.00;
								  $grade = get_grade($row_total/count($exams)); 
							    @endphp
							    <td style="text-align:center">{{ _lang('N/A') }}</td>
							 @endforeach	 
						 @endif
						 <td style="text-align:center">{{ $row_total }}</td>
						 <td style="text-align:center">{{ get_grade($row_total) }}</td>
						 <td style="text-align:center">{{ $point }}</td>
					   </tr>
					   @php $total = $total + $row_total; @endphp
					   @php $total_point = is_numeric($point) ? $total_point + $point : $total_point + 0; @endphp
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
	  @endforeach	
	</div>
</div>

@endsection
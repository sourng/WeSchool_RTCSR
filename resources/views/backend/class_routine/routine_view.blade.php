@extends('layouts.backend')
@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<span class="panel-title" >
				{{ _lang('Class Routine Of') }} {!! _lang('Class')."  <b>". $class->class_name."</b>" !!} {!! _lang('Section')." <b>".$section->section_name."</b>" !!}
				</span>
				<button type="button" data-print="classic_routine" class="btn btn-primary btn-sm pull-right print"><i class="fa fa-print"></i> {{ _lang('Print Routine') }}</button>
			</div>
			<div class="panel-body">
			  <div class="col-md-12">
			    <ul class="nav nav-tabs">
				  <li class="active"><a data-toggle="tab" href="#modern">{{ _lang('Accordion View') }}</a></li>
				  <li><a data-toggle="tab" href="#classic">{{ _lang('Classic View') }}</a></li>
				</ul>
			  
			  
			    <div class="tab-content">
				
				  <div id="classic" class="tab-pane fade">
					<div class="table-responsive">
						<table class="table table-bordered routine-table" id="classic_routine">
							<tbody>
								<tr>
								   <td colspan="100" class="text-center">
									  <span class="f-20">{{ get_option('school_name') }}</span></br>
									  <span class="f-18">{{ _lang('Class Routine') }}</span></br> 
									  <span class="f-18">{{ _lang('Class') }}: {{ $class->class_name }}</span> | 
									  <span class="f-18">{{ _lang('Section') }}: {{ $section->section_name }}</span>
								   </td>
								</tr>
								@foreach($routine as $key=>$data)
								  <tr>
									<td>{{ $key }}</td>
									 @php 
									 $i = 1;
									 $j = 1; 
									 @endphp
									 
									 @foreach($data as $field)
										@if($field->start_time >0)					
											<td>
											{{ $field->subject_name }}</br>
											{{ _lang('Teacher') }} - {{ $field->teacher }}</br>
											{{ $field->start_time }} - {{ $field->end_time }}									
											</td>	
										   @php ($i++)									
										@endif
										
										
										@if($j == count($data))
										   @for ($l = $i; $l <= count($data); $l++)	   
											   <td>&nbsp;</br>&nbsp;</br>&nbsp;</td>
										   @endfor
										@endif
										
										@php ($j++)
									 @endforeach
									</tr>	
								@endforeach
							</tbody>
						</table>
                    </div>					
			      </div>
				 
				
				  <div id="modern" class="tab-pane fade in active">
					 <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					
						@foreach($routine as $key=>$data)
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="heading-{{ $key }}">
									<h4 class="panel-title">
										<a role="button" data-toggle="collapse" data-print="#accordion" href="#collapse-{{ $key }}" aria-expanded="false" aria-controls="collapse-{{ $key }}" class="collapsed">
										{{ $key }}
										</a>
									</h4>
								</div>
								<div id="collapse-{{ $key }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-{{ $key }}">
									<div class="panel-body">
										<div class="table-responsive"> 
										 <table class="table table-bordered">
											 <thead>
												<th>Subject</th>
												<th>Teacher</th>
												<th>Start Time</th>
												<th>End Time</th>
											 </thead>
											 <tbody>
										   @foreach($data as $field)
											  @if($field->start_time >0)
												 <tr>
													<td>{{ $field->subject_name }}</td>
													<td>{{ $field->teacher }}</td>
													<td>{{ $field->start_time }}</td>
													<td>{{ $field->end_time }}</td>
												 </tr>
											  @endif
										   @endforeach
										   
											</tbody>
										 </table>
										</div> 
									</div>
								</div>
							</div>
						@endforeach
					</div>
                 </div>
				</div> <!--End tab-->
			   </div>	
			</div>
		</div>
	</div>
</div>
@endsection

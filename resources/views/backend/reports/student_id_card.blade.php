@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title" >
					{{_lang('Student ID Card')}}
				</span>
			</div>
			<div class="panel-body">
				<form id="search_form" class="params-panel validate" action="{{ url('reports/student_id_card/view') }}" method="post" autocomplete="off" accept-charset="utf-8">
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
							<select name="section_id" class="form-control select2" onchange="get_students();" required>
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
							<button type="submit" style="margin-top:24px;" class="btn btn-primary btn-block rect-btn">{{_lang('Show ID Card')}}</button>
						</div>
					</div>
				</form>			
				
				@if( isset($student) )	
				<div class="col-md-12 params-panel">		
					<div id="id_card">
						<div class="card_header">
							<h5>{{ get_option('school_name')}}</h5>
							<p>{{ _lang('STUDENT IDENTITY CARD') }}</p>
						</div>
						<div class="image">
							<img src="{{ asset('public/uploads/images/'.$student->image) }}">
							<p><span>{{ $student->first_name." ".$student->last_name }}</span></p>
						</div>
						<div class="id-card">
							<p>
								<span class="lbl">{{ _lang('Class') }} :</span>	
								<span>{{ $student->class_name }}</span>
							</p>
							
							<p>
								<span class="lbl">{{ _lang('Section') }} :</span>	
								<span>{{ $student->section_name }}</span>
							</p>
							
							<p>
								<span class="lbl">{{ _lang('Roll No') }} :</span>	
								<span>{{ $student->roll }}</span>
							</p>
							<p>
								<span class="lbl">{{ _lang('Reg No') }} :</span>	
								<span>{{ $student->register_no }}</span>
							</p>
							<p>
								<span class="lbl">{{ _lang('Academic Year') }} :</span>	
								<span>{{ get_academic_year() }}</span>
							</p>
						</div>
						
						<div class="card_footer">	
							<p>{{ _lang('Emergency Contact') }} : {{ get_option('phone') }}</p>
						</div>

					</div>

					<p>&nbsp;</p>
					<div class="col-md-4 col-md-offset-4">
						<button type="button" class="btn btn-primary btn-block print" data-print="id_card">{{ _lang('Print ID Card') }}</button>
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
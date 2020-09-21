@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					<i class="entypo-plus-circled"></i>{{_lang('Update  Student')}}
				</div>
			</div>
			<div class="panel-body">
			  <div class="col-md-10">
				<form action="{{route('students.update',$student->id)}}" autocomplete="off" class="form-horizontal form-groups-bordered validate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
					@csrf
					{{ method_field('PATCH') }}
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('First Name')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="first_name" value="{{ $student->first_name }}" required>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Last Name')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="last_name" value="{{ $student->last_name }}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Guardian')}}</label>
						<div class="col-sm-9">
							<select name="guardian" class="form-control select2">
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option('parents','id','parent_name',$student->parent_id) }}
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Birthday')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control datepicker" name="birthday" value="{{$student->birthday}}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Gender')}}</label>
						<div class="col-sm-9">
							<select name="gender" class="form-control select2" required>
								<option @if($student->gender=='Male') selected @endif value="Male">Male</option>
								<option @if($student->gender=='Female') selected @endif value="Female">Female</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Blood Group')}}</label>
						<div class="col-sm-9">
							<select name="blood_group" class="form-control select2">
								<option value="">{{ _lang('Select One') }}</option>
								<option @if($student->blood_group=='N/A') selected @endif value="N/A">N/A</option>
								<option @if($student->blood_group=='A+') selected @endif value="A+">A+</option>
								<option @if($student->blood_group=='A-') selected @endif value="A-">A-</option>
								<option @if($student->blood_group=='B+') selected @endif value="B+">B+</option>
								<option @if($student->blood_group=='B-') selected @endif value="B-">B-</option>
								<option @if($student->blood_group=='AB+') selected @endif value="AB+">AB+</option>
								<option @if($student->blood_group=='AB-') selected @endif value="AB-">AB-</option>
								<option @if($student->blood_group=='O+') selected @endif value="O+">O+</option>
								<option @if($student->blood_group=='O+') selected @endif value="O-">O-</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Religion')}}</label>
						<div class="col-sm-9">
						    <select name="religion" class="form-control niceselect wide">
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option("picklists","value","value",$student->religion,array("type="=>"Religion")) }}	
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Phone')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="phone" value="{{ $student->phone }}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Address')}}</label>
						<div class="col-sm-9">
							<textarea class="form-control" name="address">{{$student->address}}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('State')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="state" value="{{$student->state}}">
						</div>
					</div>
					<input type="hidden" value="{{ $student->ss_id }}" name="ss_id">
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Country')}}</label>
						<div class="col-sm-9">
							<select name="country" class="form-control select2" required>
								{{ get_country_list($student->country) }}
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Class')}}</label>
						<div class="col-sm-9">
							<select name="class" class="form-control select2" id="class" required>
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option('classes','id','class_name',$student->class_id) }}
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Section')}}</label>
						<div class="col-sm-9">
							<select name="section" class="form-control niceselect wide" id="section" required>
								<option value="">{{ _lang('Select One') }}</option>
								@foreach($sections AS $data)
								<option data-class="{{$data->class_id}}" @if($student->section_id==$data->id) selected @endif value="{{$data->id}}">{{ $data->section_name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Group')}}</label>
						<div class="col-sm-9">
							<select name="group" class="form-control select2">
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option('student_groups','id','group_name',$student->group) }}
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Optional Subject')}}</label>
						<div class="col-sm-9">
							<select name="optional_subject" id="optional_subject" class="form-control select2">
								<option value="">{{ _lang('Select One') }}</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Register NO')}}</label>
						<div class="col-sm-9">
							<input type="number" class="form-control" name="register_no" value="{{$student->register_no}}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Roll')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="roll" value="{{$student->roll}}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Extra Curricular Activities ')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="activities" value="{{$student->activities}}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Remarks')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="remarks" value="{{$student->remarks}}">
						</div>
					</div>
					
					<hr>
					<div class="page-header">
					  <h4>Login Details</h4>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Email')}}</label>
						<div class="col-sm-9">
							<input type="email" class="form-control" name="email" value="{{$student->email}}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Password')}}</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" name="password">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Confirm Password')}}</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" name="password_confirmation">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Profile Picture')}}</label>
						<div class="col-sm-9">
							<input type="file" class="form-control dropify" data-default-file="{{ asset('public/uploads/images/'.$student->image) }}" name="image" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG">
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info">Update Student</button>
						</div>
					</div>
				</form>
			   </div>	
			</div>
		</div>
	</div>
</div>
@endsection

@section('js-script')
<script>
$(window).on('load', function() {
	//$("#section").next().find("ul li").css("display","none");

	
	var class_id = $("#class").val();
	$('#section option[data-class="' + class_id + '"]').each(function(){
		var section_id = $(this).val();
		$("#section").next().find("ul li[data-value='" + section_id + "']").css("display","block");
	});
	
	load_option_subject();
	
	$(document).on('change','#class',function(){
		load_option_subject();
	});
	
	
	function load_option_subject(){
		var class_id = $("#class").val();
		var link = "{{ url('students/get_subjects/') }}";
		$.ajax({
			url: link+"/"+class_id,
			success: function(data){		
				$('#optional_subject').html(data);	
                $('#optional_subject').val("{{ $student->optional_subject }}");				
			}
		});
	}

			
	$(document).on("change","#class",function(){
		$("#section").val("");
		$("#section").next().find(".current").html("{{ _lang('Select One') }}");
		$("#section").next().find("ul li:not(:first-child)").css("display","none");
		
		var class_id = $(this).val();
		$('#section option[data-class="' + class_id + '"]').each(function(){
			var section_id = $(this).val();
			$("#section").next().find("ul li[data-value='" + section_id + "']").css("display","block");
		});
		//$("#section").next().find("ul li").css("display","none");
		//$("#section").val("");
	});
});
</script>
@stop

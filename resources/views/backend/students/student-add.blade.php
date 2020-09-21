@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Add New Student')}}
				</div>
			</div>
			<div class="panel-body">
			  <div class="col-md-12">
				<form action="{{route('students.store')}}" autocomplete="off" class="form-horizontal form-groups-bordered validate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
					@csrf
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Last Name')}}</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="first_name" placeholder="សេង" value="{{ old('first_name') }}" required>
						</div>
						<label class="col-sm-2 control-label">{{_lang('First Name')}}</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="ស៊ង់" required>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Latin Name')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="latin_name" placeholder="SENG Sourng" value="{{ old('latin_name') }}" >
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Guardian')}}</label>
						<div class="col-sm-7">
							<select name="guardian" id="guardian" class="form-control">	
							</select>
						</div>
						<a href="{{route('parents.create')}}" data-title="{{ _lang('Add New Parent') }}" class="btn btn-primary btn-sm ajax-modal"><i class="fa fa-plus"></i>{{ _lang('Quick Add') }}</a>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Gender')}}</label>
						<div class="col-sm-4">
							<select name="gender" class="form-control niceselect wide" required>
								<option value="">{{ _lang('Select One') }}</option>
								<option value="Male">{{ _lang('Male') }}</option>
								<option value="Female">{{ _lang('Female') }}</option>
							</select>
						</div>

						<label class="col-sm-2 control-label">{{_lang('Birthday')}}</label>
						<div class="col-sm-3">
							<input type="text" class="form-control datepicker" name="birthday" value="{{ old('birthday') }}" required>
						</div>
					</div>
					<div class="form-group">
						{{-- <label class="col-sm-3 control-label">{{_lang('Gender')}}</label>
						<div class="col-sm-9">
							<select name="gender" class="form-control niceselect wide" required>
								<option value="">{{ _lang('Select One') }}</option>
								<option value="Male">{{ _lang('Male') }}</option>
								<option value="Female">{{ _lang('Female') }}</option>
							</select>
						</div> --}}
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Blood Group')}}</label>
						<div class="col-sm-9">
							<select name="blood_group" class="form-control select2">
								<option value="">{{ _lang('Select One') }}</option>
								<option value="A+">N/A</option>
								<option value="A+">A+</option>
								<option value="A-">A-</option>
								<option value="B+">B+</option>
								<option value="B-">B-</option>
								<option value="AB+">AB+</option>
								<option value="AB-">AB-</option>
								<option value="O+">O+</option>
								<option value="O-">O-</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{ _lang('Religion') }}</label>
						<div class="col-sm-9">
						    <select name="religion" class="form-control niceselect wide">
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option("picklists","value","value",old('religion'),array("type="=>"Religion")) }}	
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{ _lang('Phone') }}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Address')}}</label>
						<div class="col-sm-9">
							<textarea class="form-control" name="address">{{ old('address') }}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('State')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="state" value="{{ old('state') }}">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Country')}}</label>
						<div class="col-sm-9">
							<select name="country" class="form-control select2" required>
							 {{ get_country_list(old('country')) }}
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Class')}}</label>
						<div class="col-sm-9">
							<select name="class" class="form-control select2" id="class" required>
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option('classes','id','class_name',old('class')) }}
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Section')}}</label>
						<div class="col-sm-9">
							<select name="section" class="form-control niceselect wide" id="section" required>
								<option value="">{{ _lang('Select One') }}</option>
								@foreach($sections AS $data)
								<option data-class="{{ $data->class_id }}" value="{{ $data->id }}">{{$data->section_name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Group')}}</label>
						<div class="col-sm-9">
							<select name="group" class="form-control select2">
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option('student_groups','id','group_name',old('group')) }}
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
							<input type="number" class="form-control" name="register_no" value="{{ old('register_no') }}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Roll')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="roll" value="{{ old('roll') }}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Extra Curricular Activities ')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="activities" value="{{ old('activities') }}">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Remarks')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="remarks" value="{{ old('remarks') }}">
						</div>
					</div>
					
					<hr>
					<div class="page-header">
					  <h4>Login Details</h4>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Email')}}</label>
						<div class="col-sm-9">
							<input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Password')}}</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" name="password" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Confirm Password')}}</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" name="password_confirmation" required>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Profile Picture')}}</label>
						<div class="col-sm-9">
							<input type="file" class="form-control dropify" name="image" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG">
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info">Add Student</button>
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
	$("#section").next().find("ul li").css("display","none");
	$(document).on("change","#class",function(){
		$("#section").next().find("ul li").css("display","none");
		var class_id = $(this).val();
		$('#section option[data-class="' + class_id + '"]').each(function(){
			var section_id = $(this).val();
			$("#section").next().find("ul li[data-value='" + section_id + "']").css("display","block");
		});
	});
	
	
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
			}
		});
	}


	$('#guardian').select2({
		placeholder: "{{ _lang('Select One') }}",

		ajax: {
			dataType: "json",
			url: "{{ url('parents/get_parents') }}",
			delay: 400,
			data: function(params) {
				return {
					term: params.term
				}
			},
			processResults: function (data, page) {
			  return {
				results: data
			  };
			},
		}
    });
  
 });

 
 

</script>
@stop


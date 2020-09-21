@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					<i class="entypo-plus-circled"></i>{{_lang('Update Assignment')}}
				</div>
			</div>
			<div class="panel-body">
				<div class="col-md-10">
					<form action="{{route('assignments.update',$assignment->id)}}" class="form-horizontal form-groups-bordered validate" autocomplete="off" enctype="multipart/form-data" method="post" accept-charset="utf-8">
						@csrf
						{{ method_field('PATCH') }}
						<div class="form-group">
							<label class="col-sm-3 control-label">{{_lang('Title')}}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="title" value="{{$assignment->title }}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{_lang('Description')}}</label>
							<div class="col-sm-9">
								<textarea id="summernote" class="form-control" name="description">{{ $assignment->description }}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{_lang('Deadline')}}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control datepicker" name="deadline" value="{{ $assignment->deadline }}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{_lang('Class')}}</label>
							<div class="col-sm-6">
								<select class="form-control select2" name="class_id" onChange="getData(this.value);" required>
									<option value="">{{ _lang('Select One') }}</option>
									{{ create_option('classes','id','class_name',$assignment->class_id) }}
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{_lang('Section')}}</label>
							<div class="col-sm-6">
								<select name="section_id" class="form-control select2" required>
									<option value="">{{ _lang('Select One') }}</option>
									{{ create_option('sections','id','section_name',$assignment->section_id) }}
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{_lang('Subject')}}</label>
							<div class="col-sm-6">
								<select name="subject_id" class="form-control select2" required>
									<option value="">{{ _lang('Select One') }}</option>
									{{ create_option('subjects','id','subject_name',$assignment->subject_id) }}
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{_lang('File')}}</label>
							<div class="col-sm-6">
								<input type="file" class="form-control appsvan-file" data-value="{{ $assignment->file }}" name="file">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{_lang('File (Optional)')}}</label>
							<div class="col-sm-6">
								<input type="file" class="form-control appsvan-file" data-value="{{ $assignment->file_2 }}" name="file_2">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('File (Optional)') }}</label>
							<div class="col-sm-6">
								<input type="file" class="form-control appsvan-file" data-value="{{ $assignment->file_3 }}" name="file_3">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('File (Optional)') }}</label>
							<div class="col-sm-6"> 
								<input type="file" class="form-control appsvan-file" data-value="{{ $assignment->file_4 }}" name="file_4" >
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-5">
								<button type="submit" class="btn btn-info">{{ _lang('Update Assignment') }}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@section('js-script')
<script type="text/javascript">
	function getData(val) {
		var _token=$('input[name=_token]').val();
		var class_id=$('select[name=class_id]').val();
		$.ajax({
			type: "POST",
			url: "{{url('sections/section')}}",
			data:{_token:_token,class_id:class_id},
			success: function(sections){
				$('select[name=section_id]').html(sections);				
			}
		});
		$.ajax({
			type: "POST",
			url: "{{url('subjects/subject')}}",
			data:{_token:_token,class_id:class_id},
			success: function(subjects){
				$('select[name=subject_id]').html(subjects);				
			}
		});
	}
</script>
@stop
@endsection
@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					<i class="entypo-plus-circled"></i>{{_lang('Edit Syllabus')}}
				</div>
			</div>
			<div class="panel-body">
			  <div class="col-md-10">
				<form action="{{route('syllabus.update',$syllabus->id)}}" class="form-horizontal form-groups-bordered validate" autocomplete="off" enctype="multipart/form-data" method="post" accept-charset="utf-8">
					@csrf
					{{ method_field('PATCH') }}
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Title')}}</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="title" value="{{ $syllabus->title }}" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Description')}}</label>
						<div class="col-sm-9">
							<textarea id="summernote" class="form-control" name="description">{{ $syllabus->description }}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('Class')}}</label>
						<div class="col-sm-9">
							<select class="form-control select2" name="class_id" required>
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option('classes','id','class_name',$syllabus->class_id) }}
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-3 control-label">{{_lang('File')}}</label>
						<div class="col-sm-9">
							<input type="file" class="form-control appsvan-file" name="file" data-value="{{ $syllabus->file }}" required>
						</div>
					</div>					

					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-info">{{ _lang('Update Syllabus') }}</button>
						</div>
					</div>
				</form>
			   </div>	
			</div>
		</div>
	</div>
</div>
@endsection

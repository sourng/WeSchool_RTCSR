@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-10">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Edit Subject')}}
				</div>
			</div>
			<div class="panel-body">
				<form action="{{route('subjects.update',$subject->id)}}" class="validate" autocomplete="off" method="post" accept-charset="utf-8">
					@csrf
					{{ method_field('PATCH') }}
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">{{_lang('Subject Name')}}</label>
							<input type="text" class="form-control" name="subject_name" value="{{ $subject->subject_name }}"required>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">{{_lang('Subject Code')}}</label>
							<input type="text" class="form-control" name="subject_code" value="{{ $subject->subject_code }}" required>
						</div>
					</div>
					<div class="col-sm-6">
					    <div class="form-group">
						    <label class="control-label">{{_lang('Subject Type')}}</label>
							<select name="subject_type" class="form-control select2" required>
								<option value="">Select One</option>
								<option @if('Theory'==$subject->subject_type) selected @endif value="Theory">Theory</option>
								<option @if('Practical'==$subject->subject_type) selected @endif value="Practical">Practical</option>
							</select>
						</div>
					</div>
					<div class="col-sm-6">
					   <div class="form-group">
						    <label class="control-label">Class</label>
							<select name="class_id" class="form-control select2" required>
								<option value="">Select One</option>
								{{ create_option('classes','id','class_name',$subject->class_id) }}
							</select>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{_lang('Full Marks')}}</label>
							<input type="text" class="form-control int-field" name="full_mark" value="{{ $subject->full_mark }}" placeholder="Full Mark" required>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{_lang('Passing Marks')}}</label>
							<input type="text" class="form-control int-field" name="pass_mark" value="{{ $subject->pass_mark }}" placeholder="Pass Mark" required>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary">{{_lang('Update Subject')}}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
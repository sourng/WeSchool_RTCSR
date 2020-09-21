@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-10">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Add New Subject')}}
				</div>
			</div>
			<div class="panel-body">
				<form action="{{route('subjects.store')}}" class="validate" autocomplete="off" method="post" accept-charset="utf-8">
					@csrf
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{_lang('Subject Name')}}</label>
							<input type="text" class="form-control" name="subject_name" value="{{ old('subject_name') }}" placeholder="Subject Name" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{_lang('Subject Code')}}</label>
							<input type="text" class="form-control" name="subject_code" value="{{ old('subject_code') }}" placeholder="Subject Code" required>
						</div>
					</div>
					<div class="col-sm-6">
					    <div class="form-group">
						    <label class="control-label">{{_lang('Subject Type')}}</label>
							<select name="subject_type" class="form-control select2" required>
								<option value="">Select One</option>
								<option value="Theory">Theory</option>
								<option value="Practical">Practical</option>
							</select>
						</div>
					</div>
					<div class="col-sm-6">
					   <div class="form-group">
						    <label class="control-label">Class</label>
							<select name="class_id" class="form-control select2" required>
								<option value="">Select One</option>
								{{ create_option('classes','id','class_name',old('class_id')) }}
							</select>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{_lang('Full Marks')}}</label>
							<input type="text" class="form-control int-field" name="full_mark" value="{{ old('full_mark') }}" placeholder="Full Mark" required>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">{{_lang('Passing Marks')}}</label>
							<input type="text" class="form-control int-field" name="pass_mark" value="{{ old('pass_mark') }}" placeholder="Pass Mark" required>
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="form-group">
							<button type="submit" class="btn btn-primary">{{_lang('Add Subject')}}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
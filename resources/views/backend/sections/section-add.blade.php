@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<span class="panel-title" >
					{{_lang('Add New Section')}}
				</span>
			</div>
			<div class="panel-body">
				<form action="{{route('sections.store')}}" autocomplete="off" class="form-horizontal form-groups-bordered validate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
					@csrf
					<div class="form-group">
					    <div class="col-sm-12">
						    <label class="control-label">{{_lang('Name')}}</label>						
							<input type="text" class="form-control" name="section_name" required value="{{old('section_name')}}">
						</div>
					</div>
					
					<div class="form-group">
					    <div class="col-sm-12">
						    <label class="control-label">{{_lang('Room No/Name')}}</label>						
							<input type="text" class="form-control" name="room_no" required value="{{ old('room_no') }}">
						</div>
					</div>
					
					<div class="form-group">
					   <div class="col-sm-12">
						    <label class="control-label">Class</label>
							<select name="class_id" class="form-control select2" required>
								<option value="">Select One</option>
								{{ create_option('classes','id','class_name',old('class_id')) }}
							</select>
						</div>
					</div>
					<div class="form-group">
					    <div class="col-sm-12">
						    <label class="control-label">Teacher</label>
							<select name="class_teacher_id" class="form-control select2" required>
								<option value="">Select One</option>
								{{ create_option('teachers','id','name',old('class_teacher_id')) }}
							</select>
						</div>
					</div>
					
					<div class="form-group">
					    <div class="col-sm-12">
						    <label class="control-label">{{_lang('Rank')}}</label>						
							<input type="number" class="form-control" name="rank" min="1" required value="{{ old('rank') }}">
						</div>
					</div>
					
					<div class="form-group">
					    <div class="col-sm-12">
						    <label class="control-label">{{_lang('Capacity')}}</label>						
							<input type="number" class="form-control" min="1" name="capacity" value="{{ old('capacity') }}" required>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-5">
							<button type="submit" class="btn btn-info">{{_lang('Add Section')}}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-8">
	    <div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<span class="panel-title" >
					{{_lang('Section List')}}
				</span>
				
				<select id="class" class="select_class pull-right" onchange="showClass(this);">
				   <option value="">{{ _lang('Select Class') }}</option>
				   {{ create_option('classes','id','class_name',$class) }}
				</select>
			</div>
			<div class="panel-body no-export">
				<table class="table table-bordered data-table">
					<thead>
						<th>{{_lang('Class Name')}}</th>
						<th>{{_lang('Section Name')}}</th>
						<th>{{_lang('Rank')}}</th>
						<th>{{_lang('Class Teacher')}}</th>
						<th>{{_lang('Action')}}</th>
					</thead>
					<tbody>
						@foreach($sections AS $data)
						 <tr>
							<td>{{$data->class_name}}</td>
							<td>{{$data->section_name}}</td>
							<td>{{$data->rank}}</td>
							<td>{{$data->teacher_name}}</td>
							<td>
								<form action="{{route('sections.destroy',$data->id)}}" method="post">
								    <a href="{{route('sections.edit',$data->id)}}" class="btn btn-warning btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></a>
									{{ method_field('DELETE') }}
    								@csrf
    								<button type="submit" class="btn btn-danger btn-xs btn-remove"><i class="fa fa-eraser" aria-hidden="true"></i></button>
								</form>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js-script')
<script>
function showClass(elem){
	if($(elem).val() == ""){
		return;
	}
	window.location = "<?php echo url('sections/class') ?>/"+$(elem).val();
}
</script>
@stop
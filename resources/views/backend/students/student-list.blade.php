@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title">{{_lang('Students List')}}</span>
				<select id="class" class="select_class pull-right" onchange="showClass(this);">
				   <option value="">{{ _lang('Select Class') }}</option>
				   {{ create_option('classes','id','class_name',$class) }}
				  
				   

				</select>
				<a href="{{url('students/excel_import')}}" style="margin-left: 10px;" class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{_lang('Import Excel')}}">{{_lang('Import Excel')}}</a>
				<a href="{{route('students.create')}}" class="btn btn-primary btn-sm pull-right">{{_lang('Add New Student')}}</a>
			</div>
				
			<div class="panel-body">
				<table class="table table-bordered data-table">
					<thead>
						<th>{{ _lang('Profile') }}</th>
						<th>{{ _lang('Roll') }}</th>
						<th>{{ _lang('Name') }}</th>
						<th>{{ _lang('Class') }}</th>
						<th>{{ _lang('Section') }}</th>
						<th>{{ _lang('Email') }}</th>
						<th>{{ _lang('ID Card') }}</th>
						<th>{{ _lang('Action') }}</th>
					</thead>
					<tbody>
						@foreach($students AS $data)
						<tr>
							<td><img src="{{ asset('public/uploads/images/'.$data->image) }}" width="50px" alt=""></td>
							<td>{{ $data->roll }}</td>
							<td>{{ $data->name }}</td>
							<td>{{ $data->class_name }}</td>
							<td>{{ $data->section_name }}</td>
							<td>{{ $data->email }}</td>
							<td><a href="{{ url('students/id_card/'.$data->id) }}" class="btn btn-primary btn-sm ajax-modal">{{ _lang('View') }}</a></td>
							<td>	
								<form action="{{ route('students.destroy',$data->id) }}" method="post">
									<a href="{{ route('students.show',$data->id) }}" class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i></a>
								    <a href="{{ route('students.edit',$data->id) }}" class="btn btn-warning btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></a>
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
	window.location = "<?php echo url('students/class') ?>/"+$(elem).val();
}
</script>
@stop
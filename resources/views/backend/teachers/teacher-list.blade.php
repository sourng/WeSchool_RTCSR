@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title">{{_lang('Teachers List')}}</span>
			
				<a href="{{route('teachers.create')}}" class="btn btn-info btn-sm pull-right" style="margin-left: 10px;">{{_lang('Add New Teacher')}}</a>
				<a href="{{url('teachers/excel_import')}}" class="btn btn-info btn-sm pull-right ajax-modal" data-title="{{ _lang('Import Excel') }}">{{ _lang('Import Excel') }}</a>
			</div>
			<div class="panel-body">
				<table class="table table-bordered data-table">
					<thead>
						<th>{{_lang('Profile')}}</th>
						<th>{{_lang('Name')}}{{_lang('Teacher')}}</th>
						<th>{{_lang('Email')}}/{{_lang('Phone')}}</th>
						<th>{{_lang('Designation')}}</th>
						<th>{{_lang('Action')}}</th>
					</thead>
					<tbody>
						@foreach($teachers AS $data)
						<tr>
							<td><img src="{{ asset('public/uploads/images/'.$data->image) }}" width="50px" alt=""></td>
							<td>{{$data->name}} <br>{{$data->latin_name}}</td>
							<td>{{$data->email}} <br>{{$data->phone}}</td>
							<td>{{$data->designation}}</td>
							<td>	
								<form action="{{route('teachers.destroy',$data->id)}}" method="post">
									<a onclick="window.open('{{route('teachers.resume',$data->id)}}', '_blank', 'toolbar=0,location=0,menubar=0')" data-title="{{ _lang('Teacher Profile') }}" class="btn btn-sucess btn-xs"><i class="fa fa-print" aria-hidden="true"></i></a>
									
									<a href="{{route('teachers.show',$data->id)}}" data-title="{{ _lang('Teacher Profile') }}" class="btn btn-info btn-xs ajax-modal"><i class="fa fa-eye" aria-hidden="true"></i></a>
								    <a href="{{route('teachers.edit',$data->id)}}" class="btn btn-warning btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></a>
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
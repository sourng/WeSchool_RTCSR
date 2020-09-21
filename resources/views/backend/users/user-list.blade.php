@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<div class="col-md-6">
					<h4 class="title">{{ _lang('Users List') }}</h4>
				</div>
				<div class="col-md-6" style="text-align: right;">
					<a href="{{route('users.create')}}" class="btn btn-info btn-sm">{{ _lang('Add New User') }}</a>
				</div>
			</div>
			<div class="content no-export">
				<table class="table table-bordered data-table">
					<thead>
						<th>{{ _lang('Profile') }}</th>
						<th>{{ _lang('Name') }}</th>
						<th>{{ _lang('Email') }}</th>
						<th>{{ _lang('User Type') }}</th>
						<th>{{ _lang('Action') }}</th>
					</thead>
					<tbody>
						@foreach($users AS $data)
						<tr>
							<td><img src="{{ asset('public/uploads/images/'.$data->image) }}" width="50px" alt=""></td>
							<td>{{$data->name}}</td>
							<td>{{$data->email}}</td>
							<td>{{$data->user_type}}</td>
							<td>	
								<form action="{{route('users.destroy',$data->id)}}" method="post">
									<a href="{{route('users.show',$data->id)}}" class="btn btn-info btn-xs ajax-modal"><i class="fa fa-eye" aria-hidden="true"></i></a>
								    <a href="{{route('users.edit',$data->id)}}" class="btn btn-warning btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></a>
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
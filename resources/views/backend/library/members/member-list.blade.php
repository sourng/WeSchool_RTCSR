@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<div class="col-md-6">
					<h4 class="title">{{_lang('Members List')}}</h4>
				</div>
				<div class="col-md-6" style="text-align: right;">
					<a href="{{route('librarymembers.create')}}" class="btn btn-info btn-sm">{{_lang('Add New Member')}}</a>
				</div>
			</div>
			<div class="content no-export">
				<table class="table table-bordered data-table">
					<thead>
						<th>{{_lang('Profile')}}</th>
						<th>{{_lang('Name')}}</th>
						<th>{{_lang('Library Id')}}</th>
						<th>{{_lang('Email')}}</th>
						<th>{{_lang('Member Type')}}</th>
						<th>{{_lang('Action')}}</th>
					</thead>
					<tbody>
						@foreach($members AS $data)
						<tr>
							<td><img src="{{ asset('public/uploads/images/'.$data->image) }}" width="50px" alt=""></td>
							<td>{{$data->name}}</td>
							<td>{{$data->library_id}}</td>
							<td>{{$data->email}}</td>
							<td>{{$data->member_type}}</td>
							<td>	
								<form action="{{route('librarymembers.destroy',$data->id)}}" method="post">
									<a href="{{url('librarymembers/librarycard/'.$data->id)}}" class="btn btn-info btn-xs" data-title="{{ _lang('Library Card') }}"><i class="fa fa-id-card-o" aria-hidden="true"></i></a>
									<a href="{{route('librarymembers.show',$data->id)}}" class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i></a>
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

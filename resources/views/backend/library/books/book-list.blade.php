@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<div class="col-md-6">
					<h4 class="title">{{ _lang('Books List') }}</h4>
				</div>
				<div class="col-md-6" style="text-align: right;">
					<a href="{{route('books.create')}}" class="btn btn-info btn-sm">{{ _lang('Add New Book') }}</a>
				</div>
			</div>
			<div class="content no-export">
				<table class="table table-bordered data-table">
					<thead>
						<th>{{ _lang('Photo') }}</th>
						<th>{{ _lang('Name') }}</th>
						<th>{{ _lang('Category') }}</th>
						<th>{{ _lang('Author') }}</th>
						<th>{{ _lang('Publisher') }}</th>
						<th>{{ _lang('Quantity') }}</th>
						<th>{{ _lang('Action') }}</th>
					</thead>
					<tbody>
						@foreach($books AS $data)
						<tr>
							<td><img src="{{ asset('public/uploads/images/books/'.$data->photo) }}" width="50px" alt=""></td>
							<td>{{$data->name}}</td>
							<td>{{$data->category_name}}</td>
							<td>{{$data->author}}</td>
							<td>{{$data->publisher}}</td>
							<td>{{$data->quantity}}</td>
							<td>	
								<form action="{{route('books.destroy',$data->id)}}" method="post">
									<a href="{{route('books.show',$data->id)}}" class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i></a>
								    <a href="{{route('books.edit',$data->id)}}" class="btn btn-warning btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></a>
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
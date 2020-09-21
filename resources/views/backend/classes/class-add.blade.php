@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Add New Class')}}
				</div>
			</div>
			<div class="panel-body">
				<form action="{{route('class.store')}}" class="form-horizontal validate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
					@csrf
					<div class="form-group">
					    <div class="col-md-12">
						    <label class="control-label">{{_lang('Name')}}</label>
							<input type="text" class="form-control" name="class_name" value="{{ old('class_name') }}" placeholder="Class Name" required>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary">{{_lang('Add Class')}}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Class List')}}
				</div>
			</div>
			<div class="panel-body no-export">
				<table class="table table-bordered data-table">
					<thead>
						<th>{{_lang('Name')}}</th>
						<th>{{_lang('Action')}}</th>
					</thead>
					<tbody>
						@foreach($classes AS $data)
						 <tr>
							<td>{{$data->class_name}}</td>
							<td>
								<form action="{{route('class.destroy',$data->id)}}" method="post">
								    <a href="{{route('class.edit',$data->id)}}" class="btn btn-warning btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></a>
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
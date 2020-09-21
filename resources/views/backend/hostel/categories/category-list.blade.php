@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<div class="col-md-6">
					<h4 class="title">{{_lang('Categories List')}}</h4>
				</div>
				<div class="col-md-6" style="text-align: right;">
					<a href="{{route('hostelcategories.create')}}" class="btn btn-info btn-sm">{{_lang('Add New Category')}}</a>
				</div>
			</div>
			<div class="content">
				<table class="table table-bordered data-table">
					<thead>
						<th>#</th>
						<th>{{_lang('Hostel Name')}}</th>
						<th>{{_lang('Type')}}</th>
						<th>{{_lang('Standard')}}</th>
						<th>{{_lang('Hostel Fee')}}</th>
						<th>{{_lang('Note')}}</th>
						<th>{{_lang('Action')}}</th>
					</thead>
					<tbody>
						@php 
						$i = 1; 
						$currency = get_option('currency_symbol');
						@endphp
						
						@foreach($categories AS $data)
						<tr>
							<td>{{$i}}</td>
							<td>{{$data->hostel_name}}</td>
							<td>{{$data->type}}</td>
							<td>{{$data->standard}}</td>
							<td>{{$currency." ".$data->hostel_fee}}</td>
							<td>{{$data->note}}</td>
							<td>	
								<form action="{{route('hostelcategories.destroy',$data->id)}}" method="post">
								    <a href="{{route('hostelcategories.edit',$data->id)}}" class="btn btn-warning btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></a>
									{{ method_field('DELETE') }}
    								@csrf
    								<button type="submit" class="btn btn-danger btn-xs btn-remove"><i class="fa fa-eraser" aria-hidden="true"></i></button>
								</form>
							</td>
						</tr>
						@php $i++; @endphp
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
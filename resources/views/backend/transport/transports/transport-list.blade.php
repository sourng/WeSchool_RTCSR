@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<div class="col-md-6">
					<h4 class="title">{{_lang('Transports List')}}</h4>
				</div>
				<div class="col-md-6" style="text-align: right;">
					<a href="{{route('transports.create')}}" class="btn btn-info btn-sm">{{_lang('Add New Transport')}}</a>
				</div>
			</div>
			<div class="content">
				<table class="table table-bordered data-table">
					<thead>
						<th>#</th>
						<th>{{_lang('Road Name')}}</th>
						<th>{{_lang('Vehicle Serial No')}}</th>
						<th>{{_lang('Route Fare')}}</th>
						<th>{{_lang('Note')}}</th>
						<th>{{_lang('Action')}}</th>
					</thead>
					<tbody>
						@php 
						$i = 1;
						$currency = get_option('currency_symbol');
						@endphp
						@foreach($transports AS $data)
						<tr>
							<td>{{ $i }}</td>
							<td>{{ $data->road_name }}</td>
							<td>{{ $data->serial_number }}</td>
							<td>{{ $currency." ".$data->road_fare }}</td>
							<td>{{ $data->note }}</td>
							<td>	
								<form action="{{route('transports.destroy',$data->id)}}" method="post">
								    <a href="{{route('transports.edit',$data->id)}}" class="btn btn-warning btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></a>
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
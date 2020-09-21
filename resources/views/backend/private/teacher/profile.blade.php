@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('My Profile')}}
				</div>
			</div>
			<div class="panel-body">
				<table class="table table-striped table-bordered" width="100%">
					<tbody>
						<tr>
							<td style="text-align: center;" colspan="4"><img width="200px" style="border-radius: 7px;" src="{{ asset('public/uploads/images/'.$teacher->image) }}"></td>
						</tr>
						<tr>
							<td>{{_lang('Name')}}</td>
							<td>{{$teacher->name}}</td>
						</tr>
						<tr>
							<td>{{_lang('Designation')}}</td>
							<td>{{$teacher->designation}}</td>
						</tr>
						<tr>
							<td>{{_lang('Date Of Birth')}}</td>
							<td>{{ date('d M, Y',strtotime($teacher->birthday)) }}</td>
						</tr>
						<tr>
							<td>{{_lang('Gender')}}</td>
							<td>{{$teacher->gender}}</td>
						</tr>
						<tr>
							<td>{{_lang('Religion')}}</td>
							<td>{{$teacher->religion}}</td>
						</tr>
						<tr>
							<td>{{ _lang('Joining Date') }}</td>
							<td>{{ date('d M, Y',strtotime($teacher->joining_date)) }}</td>
						</tr>
						<tr>
							<td>{{ _lang('Address') }}</td>
							<td>{{$teacher->address}}</td>
						</tr>
						<tr>
							<td>{{_lang('Phone')}}</td>
							<td>{{$teacher->phone}}</td>
						</tr>
						<tr>
							<td>{{ _lang('Email') }}</td>
							<td>{{ $teacher->email }}</td>
						</tr>
					</tbody>
				</table>
            </div>
		</div>
	</div>
</div>
@endsection
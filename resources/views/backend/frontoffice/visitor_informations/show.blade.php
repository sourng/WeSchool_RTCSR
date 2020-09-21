@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Profile')}}
				</div>
			</div>
			<div class="panel-body">
				<table class="table table-bordered" width="100%">
					<tbody style="text-align: center;">
						<tr class="text-center">
							<td colspan="2"><img src="{{ asset('public/uploads/images/profile.png') }}" style="width: 100px; border-radius: 5px"></td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Purpose') }}</td>
							<td>{{ $visitor_information->purpose }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Name') }}</td>
							<td>{{ $visitor_information->name }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Phone') }}</td>
							<td>{{ $visitor_information->phone }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Date') }}</td>
							<td>{{ $visitor_information->date }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('In Time') }}</td>
							<td>{{ $visitor_information->in_time }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Out Time') }}</td>
							<td>{{ $visitor_information->out_time }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Number Of Person') }}</td>
							<td>{{ $visitor_information->number_of_person }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Id Card') }}</td>
							<td>{{ $visitor_information->id_card }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Note') }}</td>
							<td>{{ $visitor_information->note }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
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
							<td>{{ _lang('Complain Type') }}</td>
							<td>{{ $complain->complain_type }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Source') }}</td>
							<td>{{ $complain->source }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Complain By') }}</td>
							<td>{{ $complain->complain_by }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Phone') }}</td>
							<td>{{ $complain->phone }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Email') }}</td>
							<td>{{ $complain->email }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Date') }}</td>
							<td>{{ $complain->date }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Taken Action') }}</td>
							<td>{{ $complain->taken_action }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Note') }}</td>
							<td>{{ $complain->note }}</td>
						</tr>
						@if($complain->attach_document != '')
						<tr class="text-center">
							<td>{{ _lang('Attach Document') }}</td>
							<td><a href="{{ asset('public/uploads/files/complains/'.$complain->attach_document) }}"><i class="fa fa-download"></i></a></td>
						</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
<table class="table table-custom" width="100%">
	<tbody class="text-center">
		<tr>
			<td colspan="2"><img class="profile" src="{{ asset('public/uploads/images/profile.png') }}" style="width: 100px;height: 100px;"></td>
		</tr>
		<tr>
			<td>{{ _lang('Complain Type') }}</td>
			<td>{{ $complain->complain_type }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Source') }}</td>
			<td>{{ $complain->source }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Complain By') }}</td>
			<td>{{ $complain->complain_by }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Phone') }}</td>
			<td>{{ $complain->phone }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Email') }}</td>
			<td>{{ $complain->email }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Date') }}</td>
			<td>{{ $complain->date }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Taken Action') }}</td>
			<td>{{ $complain->taken_action }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Note') }}</td>
			<td>{{ $complain->note }}</td>
		</tr>
		@if($complain->attach_document != '')
		<tr>
			<td>{{ _lang('Attach Document') }}</td>
			<td><a href="{{ asset('public/uploads/files/complains/'.$complain->attach_document) }}"><i class="fa fa-download"></i></a></td>
		</tr>
		@endif
	</tbody>
</table>

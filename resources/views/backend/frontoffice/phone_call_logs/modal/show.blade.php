<table class="table table-custom" width="100%">
	<tbody class="text-center">
		<tr>
			<td colspan="2"><img class="profile" src="{{ asset('public/uploads/images/profile.png') }}" style="width: 100px;height: 100px;"></td>
		</tr>
		<tr>
			<td>{{ _lang('Purpose') }}</td>
			<td>{{ $visitor_information->purpose }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Name') }}</td>
			<td>{{ $visitor_information->name }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Phone') }}</td>
			<td>{{ $visitor_information->phone }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Date') }}</td>
			<td>{{ $visitor_information->date }}</td>
		</tr>
		<tr>
			<td>{{ _lang('In Time') }}</td>
			<td>{{ $visitor_information->in_time }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Out Time') }}</td>
			<td>{{ $visitor_information->out_time }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Number Of Person') }}</td>
			<td>{{ $visitor_information->number_of_person }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Id Card') }}</td>
			<td>{{ $visitor_information->id_card }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Note') }}</td>
			<td>{{ $visitor_information->note }}</td>
		</tr>
	</tbody>
</table>

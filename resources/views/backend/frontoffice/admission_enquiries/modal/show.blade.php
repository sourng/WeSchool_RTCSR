<table class="table table-custom" width="100%">
	<tbody class="text-center">
		<tr>
			<td colspan="2"><img class="profile" src="{{ asset('public/uploads/images/profile.png') }}" style="width: 100px;height: 100px;"></td>
		</tr>
		<tr>
			<td>{{ _lang('Name') }}</td>
			<td>{{ $admission_enquiry->first_name .' '. $admission_enquiry->last_name}}</td>
		</tr>
		<tr>
			<td>{{ _lang('Phone') }}</td>
			<td>{{ $admission_enquiry->phone }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Email') }}</td>
			<td>{{ $admission_enquiry->email }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Address') }}</td>
			<td>{{ $admission_enquiry->address }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Description') }}</td>
			<td>{{ $admission_enquiry->description }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Date') }}</td>
			<td>{{ $admission_enquiry->date }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Next Follow Up Date') }}</td>
			<td>{{ $admission_enquiry->next_follow_up_date }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Reference') }}</td>
			<td>{{ $admission_enquiry->reference }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Source') }}</td>
			<td>{{ $admission_enquiry->source }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Class') }}</td>
			<td>{{ $admission_enquiry->class_name }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Number Of Child') }}</td>
			<td>{{ $admission_enquiry->number_of_child }}</td>
		</tr>
	</tbody>
</table>

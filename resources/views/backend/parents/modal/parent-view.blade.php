<table class="table table-bordered">
	<tbody>
		<tr>
			<td style="text-align: center;" colspan="4"><img class="profile" src="{{ asset('public/uploads/images/'.$parent->image) }}"></td>
		</tr>
		<tr>
			<td>{{ _lang("Guardian's Name ") }}</td>
			<td>{{ $parent->parent_name }}</td>
		</tr>
		<tr>
			<td>{{ _lang("Student's Name ") }}</td>
			<td><a href="{{ route('students.show',$parent->student_id) }}">{{ $parent->first_name .' '.$parent->last_name }}</a></td>
		</tr>
		<tr>
			<td>{{ _lang("Father's Name ") }}</td>
			<td>{{ $parent->f_name  }}</td>
		</tr>
		<tr>
			<td>{{ _lang("Mother's Name ") }}</td>
			<td>{{ $parent->m_name }}</td>
		</tr>
		<tr>
			<td>{{ _lang("Father's Profession ") }}</td>
			<td>{{ $parent->f_profession }}</td>
		</tr>
		<tr>
			<td>{{ _lang("Mother's Profession ") }}</td>
			<td>{{ $parent->m_profession }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Phone') }}</td>
			<td>{{ $parent->phone }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Email') }}</td>
			<td>{{ $parent->email }}</td>
		</tr>
		<tr>
			<td>{{ _lang('Address') }}</td>
			<td>{{ $parent->address }}</td>
		</tr>
	</tbody>
</table>
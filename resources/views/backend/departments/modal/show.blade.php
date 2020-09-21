<table class="table table-bordered">
	
	<tr>
		<td>{{ _lang('Department') }}</td>
		<td>{{ $department->department }}</td>
	</tr>
	<tr>
		<td>{{ _lang('Designations') }}</td>
		<td>
			<ul>
				@foreach (get_table2('designations', ['department_id' => $department->id]) as $designation)
				<li>{{ $designation->designation }}</li>
				@endforeach
			</ul>
		</td>
	</tr>

</table>
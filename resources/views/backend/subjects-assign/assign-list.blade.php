
@foreach($subjects as $data)
<tr>
	<td>
		{{$data->subject_name}}
	</td>
	<td>
	    <input type="hidden" name="a_id[]" value="{{ $data->a_id }}">
	    <input type="hidden" name="subject_id[]" value="{{ $data->s_id }}">
	    <input type="hidden" name="section_id[]" value="{{ $section }}">
		<select name="teacher_id[]" class="form-control select2" required>
			<option value="">Select One</option>
			{{ create_option('teachers','id','name',$data->teacher_id) }}
		</select>
	</td>
</tr>
@endforeach

<tr>
   <td colspan="2">
	<button type="button" id="assign_teacher" class="btn btn-info btn-block">{{_lang('Save')}}</button>
   </td>
</tr>

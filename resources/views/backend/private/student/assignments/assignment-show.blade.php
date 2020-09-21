<div class="row">
	<div class="col-sm-12">
		<table class="table table-striped table-bordered" width="100%">
			<tbody>
				<tr>
					<td>{{_lang('Title')}}</td>
					<td colspan="5"><b>{{$assignment->title}}</b></td>
				</tr>
				<tr>
					<td>{{_lang("Class")}}</td>
					<td><b>{{$assignment->class_name}}</b></td>
					<td>{{_lang("Section")}}</td>
					<td><b>{{$assignment->section_name}}</b></td>
					<td>{{_lang("Subject")}}</td>
					<td><b>{{$assignment->subject_name}}</b></td>
				</tr>
				<tr>
					<td colspan="6" class="details-td">{!! $assignment->description !!}</td>
				</tr>
				<tr>
					<td>{{_lang("Assignment Files")}}</td>
					<td colspan="5">
						@if($assignment->file)
						<a class="btn btn-primary rect-btn" target="_blank" href="{{ asset('public/uploads/files/assignments/'.$assignment->file) }}">{{ _lang('Download File 1') }}</a>
						@endif
						@if($assignment->file_2) 
						<a class="btn btn-primary rect-btn" target="_blank" href="{{ asset('public/uploads/files/assignments/'.$assignment->file_2) }}">{{ _lang('Download File 2') }}</a>
						@endif
						@if($assignment->file_3) 
						<a class="btn btn-primary rect-btn" target="_blank" href="{{ asset('public/uploads/files/assignments/'.$assignment->file_3) }}">{{ _lang('Download File 3') }}</a>
						@endif
						@if($assignment->file_4) 
						<a class="btn btn-primary rect-btn" target="_blank" href="{{ asset('public/uploads/files/assignments/'.$assignment->file_4) }}">{{ _lang('Download File 4') }}</a>
						@endif	
					</td>
				</tr>
		</tbody>
	</table>
   </div>
</div>
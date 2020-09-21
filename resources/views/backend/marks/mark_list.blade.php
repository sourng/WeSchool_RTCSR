@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default no-export">
			<div class="panel-heading">
				<span class="panel-title">{{ _lang('View Marks') }}</span>
				<select id="class" class="select_class pull-right" onchange="showClass(this);">
				   <option value="">Select Class</option>
				   {{ create_option('classes','id','class_name',$class) }}
				</select>
			</div>

			<div class="panel-body">
				<table class="table table-bordered data-table">
					<thead>
						<th>{{_lang('Profile')}}</th>
						<th>{{_lang('Name')}}</th>
						<th>{{_lang('Class')}}</th>
						<th>{{_lang('Section')}}</th>
						<th>{{_lang('Roll')}}</th>
						<th>{{_lang('Email')}}</th>
						<th>{{_lang('Action')}}</th>
					</thead>
					<tbody>
						@foreach($students AS $data)
						<tr>
							<td><img src="{{ asset('public/uploads/images/'.$data->image) }}" width="50px" alt=""></td>
							<td>{{ $data->name }}</td>
							<td>{{ $data->class_name }}</td>
							<td>{{ $data->section_name }}</td>
							<td>{{ $data->roll }}</td>
							<td>{{ $data->email }}</td>
							<td>	
								<a href="{{ url('marks/view/'.$data->id.'/'.$data->class_id) }}" class="btn btn-primary btn-sm rect-btn"><i class="fa fa-eye"></i> {{ _lang('View Marks') }}</a>		
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection

@section('js-script')
<script>
function showClass(elem){
	if($(elem).val() == ""){
		return;
	}
	window.location = "<?php echo url('marks') ?>/"+$(elem).val();
}
</script>
@stop

@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title">{{_lang('Routine List')}}</span>
			
				<select id="class" class="select_class pull-right" onchange="showClass(this);">
				   <option value="">Select Class</option>
				   {{ create_option('classes','id','class_name',$class) }}
				</select>
			</div>
				
			<div class="panel-body">
				<table class="table table-bordered data-table">
					<thead>
						<th>{{_lang('Class')}}</th>
						<th>{{_lang('Section')}}</th>
						<th>{{_lang('Action')}}</th>
					</thead>
					<tbody>
						@foreach($routine_list AS $data)
						<tr>			
							<td>{{ $data->class_name }}</td>
							<td>{{ $data->section_name }}</td>	
							<td>	
								<a href="{{ url('class_routines/manage/'.$data->c_id.'/'.$data->s_id) }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> Manage Routine</a>
								<a href="{{ url('class_routines/show/'.$data->c_id.'/'.$data->s_id) }}" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> View Routine</a>
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
	window.location = "<?php echo url('class_routines/class/') ?>/"+$(elem).val();
}
</script>
@stop
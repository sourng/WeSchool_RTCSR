@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<span class="panel-title" >
					{{_lang('Subjects List')}}
				</span>
				<select id="class" class="select_class pull-right" onchange="showClass(this);">
				   <option value="">Select Class</option>
				   {{ create_option('classes','id','class_name',$class) }}
				</select>
				
				<a class="btn btn-primary btn-sm pull-right" data-title="Add Grade" href="{{ url('subjects/create') }}">{{ _lang('Add New Subject') }}</a>
			</div>
			<div class="panel-body no-export">
				<table class="table table-bordered data-table">
					<thead>
						<th>{{ _lang('Subject Name') }}</th>
						<th>{{ _lang('Subject Code') }}</th>
						<th>{{ _lang('Class') }}</th>
						<th>{{ _lang('Full mark') }}</th>
						<th>{{ _lang('Pass mark') }}</th>
						<th>{{ _lang('Action') }}</th>
					</thead>
					<tbody>
						@foreach($subjects AS $data)
						<tr>
							<td>{{ $data->subject_name }}</td>
							<td>{{ $data->subject_code }}</td>
							<td>{{ $data->class_name }}</td>
							<td>{{ $data->full_mark }}</td>
							<td>{{ $data->pass_mark }}</td>
							<td>
								<form action="{{route('subjects.destroy',$data->id)}}" method="post">
									<a href="{{route('subjects.edit',$data->id)}}" class="btn btn-warning btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></a>
									{{ method_field('DELETE') }}
									@csrf
									<button type="submit" class="btn btn-danger btn-xs btn-remove"><i class="fa fa-eraser" aria-hidden="true"></i></button>
								</form>
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
	window.location = "<?php echo url('subjects/class') ?>/"+$(elem).val();
}
</script>
@stop
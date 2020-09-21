@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default no-export">
			<div class="panel-heading">
				<span class="panel-title">{{ _lang('Student Rank') }}</span>
				<select id="class" class="select_class pull-right" onchange="showClass(this);">
				   <option value="">Select Class</option>
				   {{ create_option('classes','id','class_name',$class) }}
				</select>
			</div>

			<div class="panel-body">
				<table class="table table-bordered data-table">
					<thead>
						<th>{{ _lang('Profile') }}</th>
						<th>{{ _lang('Name') }}</th>
						<th>{{ _lang('Class') }}</th>
						<th>{{ _lang('Section') }}</th>
						<th>{{ _lang('Roll' )}}</th>
						<th>{{ _lang('Total Marks') }}</th>
						<th style="text-align:center">{{ _lang('Current Position') }}</th>
						<th>{{ _lang('Details') }}</th>
					</thead>
					<tbody>
					    @php $position = 1; @endphp
						@foreach($students as $data)
						<tr>
							<td><img src="{{ asset('public/uploads/images/'.$data->image) }}" width="50px" alt=""></td>
							<td>{{ $data->first_name." ".$data->last_name }}</td>
							<td>{{ $data->class_name }}</td>
							<td>{{ $data->section_name }}</td>
							<td>{{ $data->roll }}</td>
							<td>{{ $data->total_marks }}</td>
							<td style="text-align:center"><label class="label label-primary">{{ $position }}</label></td>
							<td>
							   <a href="{{ url('marks/view/'.$data->student_id.'/'.$class) }}" class="btn btn-primary btn-sm rect-btn"><i class="fa fa-eye"></i> {{ _lang('Details') }}</a>
							</td>
						</tr>
						@php $position ++; @endphp
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
	window.location = "<?php echo url('marks/rank') ?>/"+$(elem).val();
}
</script>
@stop

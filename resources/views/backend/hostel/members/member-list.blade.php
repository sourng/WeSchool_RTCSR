@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title">{{_lang('Hostel Members List')}}</span>
			
				<select id="class" class="select_class pull-right" onchange="showClass(this);">
				   <option value="">{{_lang('Select Class') }}</option>
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
							<td>{{$data->name}}</td>
							<td>{{$data->class_name}}</td>
							<td>{{$data->section_name}}</td>
							<td>{{$data->roll}}</td>
							<td>{{$data->email}}</td>
							<td>
                               @if($data->member_id == '')
									<a href="{{url('hostelmembers/create',$data->id)}}" class="btn btn-info btn-xs ajax-modal" data-title="{{ _lang('Add New Hostel Member') }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
								@else							
								<form action="{{route('hostelmembers.destroy',$data->member_id)}}" method="post">
									<a href="{{route('hostelmembers.show',$data->id)}}" class="btn btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i></a>

								    <a href="{{route('hostelmembers.edit',$data->member_id)}}" 
								    	class="btn btn-warning btn-xs ajax-modal" data-title="{{ _lang('Edit Hostel Member') }}">
								    	<i class="fa fa-pencil" aria-hidden="true" ></i></a>

									{{ method_field('DELETE') }}
    								@csrf
    								<button type="submit" class="btn btn-danger btn-xs btn-remove"><i class="fa fa-eraser" aria-hidden="true"></i></button>
    		
								</form>
								@endif
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
	window.location = "{{url('hostelmembers/class')}}/"+$(elem).val();
}
</script>
@stop
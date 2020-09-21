@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Assign Subjects')}}
				</div>
			</div>
			<div class="panel-body">
				<form id="search_form" action="" class="form-horizontal" method="post" accept-charset="utf-8">
					@csrf
					<div class="form-group">
						<div class="col-sm-12">
							<label class="control-label">{{_lang('Class')}}</label>
							<select name="class_id" class="form-control select2" onChange="getData(this.value);" required>
								<option value="">{{_lang('Select One') }}</option>
								{{ create_option('classes','id','class_name',old('class_id')) }}
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<label class="control-label">{{_lang('Section')}}</label>
							<select name="section_id" class="form-control select2" required>
								<option value="">{{_lang('Select One') }}</option>
							</select>
						</div>
					</div>
					<div>
						<button type="submit" id="search" class="btn btn-primary">{{_lang('Search')}}</button>
					</div>
				</form>			
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Assign Subjects')}}
				</div>
			</div>
			<div class="panel-body no-export">
				<form id="assign_teacher_form" action="{{route('assignsubjects.store')}}" method="post">
					@csrf
					<table class="table table-bordered">
						<thead>
							<th>{{_lang('Subject')}}</th>
							<th>{{_lang('Teacher')}}</th>
						</thead>		
						<tbody id="list">
							
						</tbody>
					</table>
				</form>
			</div>

		</div>
	</div>
</div>
@endsection

@section('js-script')
<script type="text/javascript">
	function getData(val) {
		var _token=$('input[name=_token]').val();
		var class_id=$('select[name=class_id]').val();
		$.ajax({
			type: "POST",
			url: "{{url('sections/section')}}",
			data:{_token:_token,class_id:class_id},
			success: function(sections){
				$('select[name=section_id]').html(sections);				
			}
		});
	}
	
	$("#search_form").validate({
		submitHandler: function(form) {
			search();
			return false;
		},invalidHandler: function(form, validator) {},
		  errorPlacement: function(error, element) {}
	}); 	


	$(document).on('click','#assign_teacher',function(){
        $(this).prop("disabled",true);
		$.ajax({
			type: "POST",
			url: $("#assign_teacher_form").attr("action"),
			data: $("#assign_teacher_form").serialize(),
            beforeSend: function(){
				$("#assign_teacher").html('<i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>');
			},success: function(data){
				var json = JSON.parse(JSON.stringify(data));
				if(json['result']=="success"){
					search();
					Command: toastr["success"](json['message']);
				}
				$("#assign_teacher").html('Save');
				$("#assign_teacher").attr('disabled',false);
			}
		});
		return false;
	});
	
	
	function search(){
		$.ajax({
			type: "POST",
			url: "{{url('assignsubjects/search')}}",
			data: $("#search_form").serialize(),
			success: function(data){
				$('#list').html(data);
				$(".select2").select2();
			}
		});
	}
	
	
</script>
@stop
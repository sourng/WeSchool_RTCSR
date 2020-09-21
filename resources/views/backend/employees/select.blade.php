@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{ _lang('Add New') }}
				</div>
			</div>
			<div class="panel-body">
				<form action="{{ url('employees/select') }}" class="validate" autocomplete="off" method="post">
					@csrf

					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('User Type') }}</label>
							<select name="user_type" class="form-control select2" required>
								<option value="">{{ _lang('Select One') }}</option>
								<option value="Admin">{{ _lang('Admin') }}</option>
								<option value="Teacher">{{ _lang('Teacher') }}</option>
								<option value="Accountant">{{ _lang('Accountant') }}</option>
								<option value="Librarian">{{ _lang('Librarian') }}</option>
								<option value="Employee">{{ _lang('Employee') }}</option>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('User') }}</label>
							<select class="form-control select2" name="user_id" required>
								<option value="">{{ _lang('Select One') }}</option>
							</select>
						</div>
					</div>
					<div class="col-md-12 text-right">
						<div class="form-group">
							<button type="submit" class="btn btn-primary">{{ _lang('Next') }}</button>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>
@endsection

@section('js-script')
<script type="text/javascript">
	$('select[name=user_type]').on('change', function(){
		if($(this).val() != ''){
			$.ajax({
				method: 'GET',
				url: '{{ url('users/get_users_option') }}/' + $(this).val(),
				beforeSend: function(){
					$("#preloader").css("display","block");  
				},success: function(data){
					$("#preloader").css("display","none");
					$('select[name=user_id]').html(data);
				}
			});
		}else{
			$('select[name=user_id]').html('<option value="">{{ _lang('Select One') }}</option>');
		}
	});
</script>
@stop
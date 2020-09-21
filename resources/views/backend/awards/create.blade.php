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
				<form action="{{ route('awards.store') }}" class="validate" autocomplete="off" method="post">
					@csrf

					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Award') }}</label>
							<select class="form-control select2" name="types_of_award_id" required>
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option('types_of_awards', 'id', 'title', old('types_of_award_id')) }}
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Employee') }}</label>
							<select class="form-control select2" name="user_id" required>
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_employee_option() }}
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Gift Item') }}</label>
							<input type="text" name="gift_item" class="form-control" value="{{ old('gift_item') }}" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Cash Price') }} ({{ get_option('currency_symbol') }})</label>
							<input type="number" name="cash_price" class="form-control" value="{{ old('cash_price') }}">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Month And Year') }}</label>
							<input type="text" name="month_year" class="form-control monthpicker" value="{{ old('month_year') }}" required>
						</div>
					</div>

					<div class="col-md-12 text-right">
						<div class="form-group">
							<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
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
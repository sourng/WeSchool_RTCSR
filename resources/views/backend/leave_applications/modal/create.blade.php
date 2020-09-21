<style type="text/css">
	.remove-row{
		padding: 2px 4px;
	}
</style>
<form method="post" class="ajax-submit" autocomplete="off" action="{{ route('leave_applications.store') }}">
	@csrf
	<div class="field_group">
		<div class="col-md-3">
			<div class="form-group">
				<label class="form-control-label">{{ _lang('Date') }}</label>
				<input type="text" name="date[]" class="form-control datepicker" required>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="form-control-label">{{ _lang('Leave Type') }}</label>
				<select class="form-control select2" name="leave_type_id[]" required>
					{{ create_leave_option() }}
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label class="form-control-label">{{ _lang('Absent Reason') }}</label>
				<input type="text" name="absent_reason[]" class="form-control">
			</div>
		</div>
		<div class="col-md-1" style="padding-top: 31px;">
			<div class="form-group">
				<button type="button" class="btn btn-danger remove-row" disabled>
					<i class="fa fa-minus" aria-hidden="true"></i>
				</button>
			</div>
		</div>
	</div>
	<div class="col-md-12 add">
		<div class="form-group">
			<button type="button" id="add_more" class="btn btn-success btn-xs" title="{{ _lang('Add More') }}">
				<i class="fa fa-plus" aria-hidden="true"></i>
			</button>
		</div>
	</div>
	<div class="col-md-12 text-right">
		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
		</div>
	</div>
</form>
<div class="field_group repeat" style="display: none;">
	<div class="col-md-3">
		<div class="form-group">
			<label class="form-control-label">{{ _lang('Date') }}</label>
			<input type="text" name="date[]" class="form-control datepicker" required>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label class="form-control-label">{{ _lang('Leave Type') }}</label>
			<select class="form-control" name="leave_type_id[]" required>
				{{ create_leave_option() }}
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label class="form-control-label">{{ _lang('Absent Reason') }}</label>
			<input type="text" name="absent_reason[]" class="form-control">
		</div>
	</div>
	<div class="col-md-1" style="padding-top: 31px;">
		<div class="form-group">
			<button type="button" class="btn btn-danger remove-row" disabled>
				<i class="fa fa-minus" aria-hidden="true"></i>
			</button>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#add_more').on('click',function(){
		var form = $('.repeat').clone().removeClass('repeat').css('display', 'block');
		form.find('input').val('');
		form.find('select').select2();
		form.find('.remove-row').attr('disabled', false);
		$('.add').before(form);
	});
	$(document).on('click','.remove-row',function(){
		$(this).parent().parent().closest('.field_group').remove();
	});
</script>
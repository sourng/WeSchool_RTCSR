@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">
					{{ _lang('Add New') }}
				</h2>
			</header>
			<div class="panel-body">
				<form method="post" class="ajax-submit" autocomplete="off" action="{{ route('departments.store') }}">
					@csrf

					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Department') }}</label>
							<input type="text" name="department" class="form-control" value="{{ old('department') }}" placeholder="Department" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group" id="designations">
							<div class="form-control-label">
								<span>{{ _lang('Designations') }}</span>
							</div>
							<div class="form-group repeat">
								<div class="input-group">
									<input type="text" name="designation[]" class="form-control" placeholder="Designation">
									<span class="input-group-addon btn-danger" disabled>
										<i class="fa fa-minus" aria-hidden="true"></i>
									</span>
								</div>
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
			</div>
		</div>
	</div>
</div>
@endsection

@section('js-script')
<script type="text/javascript">
	$('#add_more').on('click',function(){
		var form = $('.repeat').clone().removeClass('repeat');
		form.find('input').val('');
		form.find('span').addClass('remove-row').attr('disabled', false);
		$("#designations").append(form);
	});

	$(document).on('click','.remove-row',function(){
		$(this).parent().remove();
	});
</script>
@stop


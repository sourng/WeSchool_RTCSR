@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">
					{{ _lang('Edit') }}
				</h2>
			</header>
			<div class="panel-body">
				<form method="post" class="ajax-submit" autocomplete="off" action="{{ route('departments.update', $department->id) }}">
					@csrf
					@method('PUT')

					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Department') }}</label>
							<input type="text" name="department" class="form-control" value="{{ $department->department }}" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group" id="designations">
							<div class="form-control-label">
								<span>{{ _lang('Designations') }}</span>
							</div>
							@foreach (get_table2('designations', ['department_id' => $department->id], 'ASC') as $key => $data)
							<div class="form-group{{ ($key == 0) ? ' repeat' : '' }}">
								<div class="input-group">
									<input type="text" name="designation[]" class="form-control" value="{{ $data->designation }}">
									<input type="hidden" name="designation_id[]" class="form-control" value="{{ $data->id }}">
									<span class="input-group-addon btn-danger{{ ($key != 0) ? ' remove-row' : '' }}">
										<i class="fa fa-minus" aria-hidden="true"></i>
									</span>
								</div>
							</div>
							@endforeach
						</div>
					</div>
					<div class="col-md-12 add">
						<div class="form-group">
							<button type="button" id="add_more" class="btn btn-success btn-xs" title="{{ _lang('Add More') }}">
								<i class="fa fa-plus" aria-hidden="true"></i>
							</button>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">{{ _lang('Status') }}</label>
							<select class="form-control select2" name="status" required>
								<option value="Active">{{ _lang('Active') }}</option>
								<option value="In-Active">{{ _lang('In-Active') }}</option>
							</select>
						</div>
					</div>

					<div class="col-md-12 text-right">
						<div class="form-group">
							<button type="submit" class="btn btn-primary">{{ _lang('Update') }}</button>
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
	$('select[name=status]').val('{{ $department->status }}');
	$('#add_more').on('click', function(){
		var form = $('.repeat').clone().removeClass('repeat');
		form.find('input').val('');
		form.find('span').addClass('remove-row');
		$("#designations").append(form);
	});

	$(document).on('click', '.remove-row', function(){
		$(this).parent().remove();
		var designation_id = $(this).parent().find('.designation_id').val();
		if(typeof designation_id != 'undefined' && designation_id != ''){
			$.ajax({
				url: '{{ url('designations/destroy') }}/' + designation_id,
				type: 'GET',
				success: function(data){
					return true;
				} 
			});
		}
	});
</script>
@stop


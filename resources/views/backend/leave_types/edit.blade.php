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
				<form method="post" autocomplete="off" action="{{ route('leave_types.update', $leave_type->id) }}" enctype="multipart/form-data">
					@csrf
					@method('PUT')
					
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Title') }}</label>
							<input type="text" name="title" class="form-control" value="{{ $leave_type->title }}" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">{{ _lang('Off Type') }}</label>
							<select class="form-control select2" name="off_type" required>
								<option value="Full Day">{{ _lang('Full Day') }}</option>
								<option value="Half Day">{{ _lang('Half Day') }}</option>
							</select>
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
	$('select[name=type]').val('{{ $leave_type->type }}');
	$('select[name=status]').val('{{ $leave_type->status }}');
</script>
@stop
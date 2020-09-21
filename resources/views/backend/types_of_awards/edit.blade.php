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
				<form method="post" autocomplete="off" action="{{ route('types_of_awards.update', $types_of_award->id) }}">
					@csrf
					@method('PUT')
					
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Title') }}</label>
							<input type="text" name="title" class="form-control" value="{{ $types_of_award->title }}" required>
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
	$('select[name=status]').val('{{ $types_of_award->status }}');
</script>
@stop


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
				<form method="post" autocomplete="off" action="{{ route('types_of_awards.store') }}">
					@csrf
					
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Title') }}</label>
							<input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-control-label">{{ _lang('Status') }}</label>
							<input type="text" name="status" class="form-control" value="{{ old('status') }}" required>
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




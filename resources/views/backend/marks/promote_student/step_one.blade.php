@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<span class="panel-title" >
					{{_lang('Promote Student')}}
				</span>
			</div>
			<div class="panel-body">
				<form id="search_form" class="params-panel validate" action="{{ url('students/promote/2') }}" method="post" autocomplete="off" accept-charset="utf-8">
					@csrf
					<div class="col-md-8">
						<div class="form-group">
							<label class="control-label">{{ _lang('Select Class') }}</label>
							<select name="class_id" class="form-control select2" required>
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option('classes','id','class_name',$class_id) }}
							</select>
						</div>
					</div>

					
					<div class="col-md-4">
						<div class="form-group">
							<button type="submit" style="margin-top:24px;" class="btn btn-primary btn-block rect-btn">{{_lang('Next')}}</button>
						</div>
					</div>
				</form>
				

			</div>
		</div>
	</div>
</div>
@endsection
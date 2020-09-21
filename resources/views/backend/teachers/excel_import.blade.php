@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Import Excel')}}
				</div>
			</div>
			<div class="panel-body">
				<form method="post" action="{{url('teachers/excel_store')}}" enctype="multipart/form-data" class="validate">
					@csrf
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label">{{ _lang('File') }}</label>						
							<input type="file" class="form-control appsvan-file" name="excel_file" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<button type="submit" class="btn btn-primary rect-btn">{{ _lang('Import') }}</button>
						    <a href="{{ asset('public/excel/teachers_excel.xlsx') }}" class="btn btn-info pull-right rect-btn">{{ _lang('Download Excel File') }}</a>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>
@endsection

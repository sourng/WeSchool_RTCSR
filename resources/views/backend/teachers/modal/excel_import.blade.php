<form method="post" action="{{url('teachers/excel_store')}}" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="col-md-12">
	  <div class="form-group">					
		<input type="file" class="form-control dropify" name="excel_file" required>
	  </div>
	</div>		
	<div class="col-md-12">
		<div class="form-group">
			<button type="submit" class="btn btn-primary rect-btn">{{ _lang('Import') }}</button>
			<a href="{{ asset('public/excel/teachers_excel.xlsx') }}" class="btn btn-info pull-right rect-btn">{{ _lang('Download Excel File') }}</a>
		</div>
	</div>
</form>

@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('View Post Category') }}</div>

	<div class="panel-body">
	  <table class="table table-bordered">
		<tr><td>{{ _lang('Category Name') }}</td><td>{{ $postcategory->category }}</td></tr>
		<tr><td>{{ _lang('Note') }}</td><td>{{ $postcategory->note }}</td></tr>
		<tr><td>{{ _lang('Parent Category') }}</td><td>{{ $postcategory->parent_id }}</td></tr>		
	  </table>
	</div>
  </div>
 </div>
</div>
@endsection



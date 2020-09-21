@extends('layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-heading">{{ _lang('View Academic Year') }}</div>

		<div class="panel-body">
		  <table class="table table-bordered">
			<tr><td>{{ _lang('Session') }}</td><td>{{ $academicyear->session }}</td></tr>
			<tr><td>{{ _lang('Year') }}</td><td>{{ $academicyear->year }}</td></tr>		
		  </table>
		</div>
	  </div>
     </div>
    </div>
@endsection



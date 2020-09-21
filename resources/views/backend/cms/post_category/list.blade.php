@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default no-export">
			<div class="panel-heading"><span class="panel-title">{{ _lang('List Post Category') }}</span>
			<a class="btn btn-primary btn-sm pull-right" href="{{route('post_categories.create')}}">{{ _lang('Add New') }}</a>
			</div>

			<div class="panel-body">
			 @if (\Session::has('success'))
			  <div class="alert alert-success">
				<p>{{ \Session::get('success') }}</p>
			  </div>
			  <br />
			 @endif
			 {{ buildTree($postcategorys,0,"PostCategoryController@edit") }}
			</div>
		</div>
	</div>
</div>

@endsection



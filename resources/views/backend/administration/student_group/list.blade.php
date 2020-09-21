@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading"><span class="panel-title">{{ _lang('List Student Group') }}</span>
			<a class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add Student Group') }}" href="{{route('student_groups.create')}}">{{ _lang('Add New') }}</a>
			</div>

			<div class="panel-body">
			 @if (\Session::has('success'))
			  <div class="alert alert-success">
				<p>{{ \Session::get('success') }}</p>
			  </div>
			  <br />
			 @endif
			<table class="table table-bordered data-table">
			<thead>
			  <tr>
				<th>#</th>
				<th>{{ _lang('Group Name') }}</th>
				<th>{{ _lang('Action') }}</th>
			  </tr>
			</thead>
			<tbody>
			  
			  @foreach($studentgroups as $studentgroup)
			  <tr id="row_{{ $studentgroup->id }}">
				<td class='id'>{{ $studentgroup->id }}</td>
				<td class='group_name'>{{ $studentgroup->group_name }}</td>
					
				<td>
				  <form action="{{action('StudentGroupController@destroy', $studentgroup['id'])}}" method="post">
					<a href="{{action('StudentGroupController@edit', $studentgroup['id'])}}" data-title="{{ _lang('Update Student Group') }}" class="btn btn-warning btn-sm ajax-modal">{{ _lang('Edit') }}</a>
					{{ csrf_field() }}
					<input name="_method" type="hidden" value="DELETE">
					<button class="btn btn-danger btn-sm btn-remove" type="submit">{{ _lang('Delete') }}</button>
				  </form>
				</td>
			  </tr>
			  @endforeach
			</tbody>
		  </table>
			</div>
		</div>
	</div>
</div>

@endsection



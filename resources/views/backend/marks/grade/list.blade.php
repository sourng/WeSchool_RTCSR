@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading"><span class="panel-title">{{ _lang('List Grade') }}</span>
			<a class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add Grade') }}" href="{{route('grades.create')}}">{{ _lang('Add New') }}</a>
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
					<th>{{ _lang('Grade Name') }}</th>
					<th>{{ _lang('Marks From') }}</th>
					<th>{{ _lang('Marks To') }}</th>
					<th>{{ _lang('Point') }}</th>
					<th>{{ _lang('Point') }}</th>
					<th>{{ _lang('Action') }}</th>
				  </tr>
				</thead>
				<tbody>
				  
				  @foreach($grades as $grade)
				  <tr id="row_{{ $grade->id }}">
					<td class='grade_name'>{{ $grade->grade_name }}</td>
						<td class='marks_from'>{{ decimalPlace($grade->marks_from) }}</td>
						<td class='marks_to'>{{ decimalPlace($grade->marks_to) }}</td>
						<td class='point'>{{ decimalPlace($grade->point) }}</td>
					<td>
					  <form action="{{action('GradeController@destroy', $grade['id'])}}" method="post">
						<a href="{{action('GradeController@edit', $grade['id'])}}" data-title="{{ _lang('Update Grade') }}" class="btn btn-warning btn-sm ajax-modal">{{ _lang('Edit') }}</a>
						<a href="{{action('GradeController@show', $grade['id'])}}" data-title="{{ _lang('View Grade') }}" class="btn btn-info btn-sm ajax-modal">{{ _lang('View') }}</a>
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



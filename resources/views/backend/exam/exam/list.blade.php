@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default no-export">
			<div class="panel-heading"><span class="panel-title">{{ _lang('List Exam') }}</span>
			<a class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add Exam') }}" href="{{route('exams.create')}}">{{ _lang('Add New') }}</a>
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
						<th>{{ _lang('Name') }}</th>
						<th>{{ _lang('Note') }}</th>
						<th>{{ _lang('Action') }}</th>
					  </tr>
					</thead>
					<tbody>
					  
					  @foreach($exams as $exam)
					  <tr id="row_{{ $exam->id }}">
						<td class='name'>{{ $exam->name }}</td>
						<td class='note'>{{ $exam->note }}</td>				
						<td>
						  <form action="{{action('ExamController@destroy', $exam['id'])}}" method="post">
							<a href="{{action('ExamController@edit', $exam['id'])}}" data-title="{{ _lang('Update Exam') }}" class="btn btn-warning btn-sm ajax-modal">{{ _lang('Edit') }}</a>
							<a href="{{action('ExamController@show', $exam['id'])}}" data-title="{{ _lang('View Exam') }}" class="btn btn-info btn-sm ajax-modal">{{ _lang('View') }}</a>
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



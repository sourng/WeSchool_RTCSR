@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default no-export">
			<div class="panel-heading">
				<span class="panel-title">{{ _lang('List Notice') }}</span>
				<a class="btn btn-primary btn-sm pull-right" href="{{route('notices.create')}}">{{ _lang('Add New') }}</a>
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
							<th>{{ _lang('Heading') }}</th>
							<th>{{ _lang('Showing Area') }}</th>
							<th style="width:220px;">{{ _lang('Action') }}</th>
						</tr>
					</thead>
					<tbody>

						@foreach($notices as $notice)
						<tr id="row_{{ $notice->id }}">
							<td class='heading'>{{ $notice->heading }}</td>
							<td class='user_type'>{{ object_to_string($notice->user_type,'user_type') }}</td>

							<td>
								<form action="{{action('NoticeController@destroy', $notice['id'])}}" method="post">
									<a href="{{action('NoticeController@edit', $notice['id'])}}" class="btn btn-warning btn-sm">{{ _lang('Edit') }}</a>
									<a href="{{action('NoticeController@show', $notice['id'])}}" class="btn btn-info btn-sm">{{ _lang('View') }}</a>
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



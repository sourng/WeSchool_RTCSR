@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default no-export">
			<div class="panel-heading"><span class="panel-title">{{ _lang('All Events') }}</span>
			<a class="btn btn-primary btn-sm pull-right" data-title="{{ _lang('Add New Event') }}" href="{{route('events.create')}}">{{ _lang('Add New') }}</a>
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
				<th>{{ _lang('Start Date') }}</th>
				<th>{{ _lang('End Date') }}</th>
				<th>{{ _lang('Name') }}</th>
				<th>{{ _lang('Location') }}</th>
				<th>{{ _lang('Action') }}</th>
			  </tr>
			</thead>
			<tbody>
			  
			  @foreach($events as $event)
			  <tr id="row_{{ $event->id }}">
				<td class='start_date'>{{ date('d/M/Y - H:i' ,strtotime($event->start_date)) }}</td>
					<td class='end_date'>{{ date('d/M/Y - H:i',strtotime($event->end_date)) }}</td>
					<td class='name'>{{ $event->name }}</td>
					<td class='location'>{{ $event->location }}</td>	
					<td>
					  <form action="{{action('EventController@destroy', $event['id'])}}" method="post">
						<a href="{{action('EventController@edit', $event['id'])}}" class="btn btn-warning btn-sm">{{ _lang('Edit') }}</a>
						<a href="{{action('EventController@show', $event['id'])}}" data-title="{{ _lang('View Event') }}" class="btn btn-info btn-sm ajax-modal">{{ _lang('View') }}</a>
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



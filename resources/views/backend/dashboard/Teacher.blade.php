@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-lg-4 col-sm-6">
		<div class="card">
			<div class="content">
				<div class="row">
					<div class="col-xs-5">
						<div class="icon-big icon-warning text-center">
							<i class="ti-user"></i>
						</div>
					</div>
					<div class="col-xs-7">
						<div class="numbers">
							<p>{{ _lang('Total Student') }}</p>
							{{ $total_student }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-sm-6">
		<div class="card">
			<div class="content">
				<div class="row">
					<div class="col-xs-5">
						<div class="icon-big icon-success text-center">
							<i class="ti-ruler-pencil"></i>
						</div>
					</div>
					<div class="col-xs-7">
						<div class="numbers">
							<p>{{ _lang('My Subject') }}</p>
							{{ $my_subject_count }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-sm-6">
		<a href="{{ url('message/inbox') }}">
			<div class="card">
				<div class="content">
					<div class="row">
						<div class="col-xs-5">
							<div class="icon-big icon-danger text-center">
								<i class="ti-email"></i>
							</div>
						</div>
						<div class="col-xs-7">
							<div class="numbers">
								<p>{{ _lang('Unread Inbox') }}</p>
								{{ count_inbox() }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</a>
	</div>

</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title text-center">{{ _lang('Notice') }}</h4>
			</div>
			<div class="content no-export">
				<table class="table table-bordered data-table">
				   <thead>
				     <th>{{ _lang('Notice') }}</th>
				     <th>{{ _lang('Created') }}</th>
				     <th class="text-center">{{ _lang('View') }}</th>
				   </thead>
				   <tbody>
						@foreach(get_notices("Teacher",100) as $notice)
						  <tr>
							<td>{{ $notice->heading }}</td>
							<td>{{ date("d M, Y - H:i", strtotime($notice->created_at)) }}</td>
						    <td class="text-center"><a href="{{ action('NoticeController@show', $notice->id) }}" data-title="{{ _lang('View Notice') }}" class="btn btn-primary btn-sm ajax-modal">{{ _lang('View Notice') }}</a></td>
						  </tr>
						@endforeach
				   </tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title text-center">{{ _lang('Event Calendar') }}</h4>
			</div>
			<div class="content">
				<div id='event_calendar'></div>
			</div>
		</div>
	</div>
</div>


@endsection

@section('js-script')
<script>

  $(document).ready(function() {

    $('#event_calendar').fullCalendar({
		themeSystem: 'bootstrap4',	
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,basicWeek,basicDay'
		},
		//defaultDate: '2018-03-12',
		eventBackgroundColor: "#0984e3",
		navLinks: true, // can click day/week names to navigate views
		editable: true,
		eventLimit: true, // allow "more" link when too many events
		timeFormat: 'h:mm',
		events: [
			@foreach(get_events(100) as $event)
				{
				  title: '{{ $event->name }}',
				  start: '{{ $event->start_date }}',
				  end: '{{ $event->end_date }}',
				  url: '{{ action("EventController@show", $event->id) }}'
				},
			@endforeach
	   ],
	   eventRender: function eventRender(event, element, view) {
		   element.addClass('ajax-modal');
		   element.data("title","{{ _lang('View Event') }}");
	   }
    });
	
	

  });

</script>
@endsection
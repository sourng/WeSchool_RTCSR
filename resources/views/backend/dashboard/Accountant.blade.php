@extends('layouts.backend')
@section('content')
<div class="row">
   <div class="col-md-4">
		<div class="card">
			<div class="content">
				<div class="row">
					<div class="col-md-5">
						<div class="icon-big icon-primary text-center">
							<i class="ti-credit-card"></i>
						</div>
					</div>
					<div class="col-md-7">
						<div class="numbers">
							<p>{{ _lang('Monthly Student Payments') }}</p>
								{{ $currency." ".$student_payments }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

   <div class="col-md-4">
		<div class="card">
			<div class="content">
				<div class="row">
					<div class="col-md-5">
						<div class="icon-big icon-success text-center">
							<i class="ti-credit-card"></i>
						</div>
					</div>
					<div class="col-md-7">
						<div class="numbers">
							<p>{{ _lang('Current Month Income') }}</p>
							{{ $currency." ".$monthly_income }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

   <div class="col-md-4">
		<div class="card">
			<div class="content">
				<div class="row">
					<div class="col-md-5">
						<div class="icon-big icon-danger text-center">
							<i class="ti-credit-card"></i>
						</div>
					</div>
					<div class="col-md-7">
						<div class="numbers">
							<p>{{ _lang('Current Month Expense') }}</p>
							{{ $currency." ".$monthly_expense }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title text-center">{{ _lang('Income and Expense Summary of')." ".date("Y") }}</h4>
			</div>
			<div class="content">
				<div id="income_vs_expense_chart" style="width: 100%; height:400px;"></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="header">
				<h4 class="title text-center">{{ _lang('Awards') }}</h4>
			</div>
			<div class="content no-export">
				<table class="table table-bordered data-table">
					<thead>
						<th>#</th>
						<th>{{ _lang('Award') }}</th>
						<th>{{ _lang('Gift Item') }}</th>
						<th>{{ _lang('Cash Price') }}</th>
						<th>{{ _lang('Month') }}</th>
						<th>{{ _lang('Year') }}</th>
						<th class="text-center">{{ _lang('Action') }}</th>
					</thead>
					<tbody>
						@php $i = 1; @endphp
						@foreach($awards AS $award)
						<tr>
							<td>{{ $i }}</td>
							
							<td>
								@if (isset($award->award_type))
								{{ $award->award_type->title }}
								@endif
							</td>
							<td>{{ $award->gift_item }}</td>
							<td>{{ $award->cash_price != null ? get_option('currency_symbol') . $award->cash_price : '' }}</td>
							<td>{{ month_number_to_name($award->month) }}</td>
							<td>{{ $award->year }}</td>
							
							<td class="text-center">	
								<a href="{{ route('awards.show', $award->id) }}" class="btn btn-info btn-xs ajax-modal" data-title="{{ _lang('Details') }}"><i class="fa fa-eye" aria-hidden="true"></i>
								</a>
							</td>
						</tr>
						@php $i++; @endphp
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
						@foreach(get_notices("Accountant",100) as $notice)
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

<script type="text/javascript">
  var yearly_income = {{ $yearly_income }};
  var yearly_expense = {{ $yearly_expense }};
</script>

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
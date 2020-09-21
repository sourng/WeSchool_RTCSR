<ul class="nav metismenu" id="menu">
	<li @if(Request::is('dashboard')) class="active" @endif>
		<a href="{{route('dashboard')}}">
			<i class="fa fa-desktop"></i>
			{{ _lang('Dashboard') }}
		</a>
	</li>
	
	<li @if(Request::is('my_leave_applications') || Request::is('my_leave_applications/*')) class="active" @endif>
		<a href="{{url('my_leave_applications')}}">
			<i class="fa fa-paper-plane"></i>
			{{ _lang('My Leave Applications') }}
		</a>
	</li>

	<li @if(Request::is('my_expenses') || Request::is('my_expenses/*')) class="active" @endif>
		<a href="{{url('my_expenses')}}">
			<i class="fa fa-money"></i>
			{{ _lang('My Expenses') }}
		</a>
	</li>
	
	<li @if(Request::is('my_payslips') || Request::is('my_payslips/*')) class="active" @endif>
		<a href="{{url('my_payslips')}}">
			<i class="fa fa-bitcoin"></i>
			{{ _lang('Payslips') }}
		</a>
	</li>
	@include('layouts.menus.menus')
</ul>	
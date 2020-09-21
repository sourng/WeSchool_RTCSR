@php $locale = app()->getLocale(); @endphp

<ul class="nav metismenu" id="menu">	
	@switch($locale)
		@case('khmer')
			<li>
				<a href="{{url('lang/english')}}">
					<i class="fa fa-language"></i>
					{{ _lang('Language') }} <img src="{{asset('flags/en.png')}}" width="30px" height="20x"> English
				</a>
			</li>
		@break

		@default
		<li>
			<a href="{{url('lang/khmer')}}">
				<i class="fa fa-language"></i>
				{{ _lang('Language') }} <img src="{{asset('flags/kh.png')}}" width="30px" height="20x"> Khmer
			</a>
		</li>
	@endswitch

	<li @if(Request::is('dashboard')) class="active" @endif>
		<a href="{{ route('dashboard') }}">
			<i class="fa fa-desktop"></i>
			{{ _lang('Dashboard') }}
		</a>
	</li>

	<li @if(Request::is('student/my_assignment')) class="active" @endif>
		<a href="{{ url('student/my_assignment') }}">
			<i class="fa fa-hourglass-half"></i>
			{{ _lang('Academic Assignment') }}
		</a>
	</li>

	<li @if(Request::is('student/my_syllabus')) class="active" @endif>
		<a href="{{ url('student/my_syllabus') }}">
			<i class="fa fa-file"></i>
			{{ _lang('Academic Syllabus') }}
		</a>
	</li>	
	
	<li @if(Request::is('student/my_profile')) class="active" @endif>
		<a href="{{ url('student/my_profile') }}">
			<i class="fa fa-user-circle-o"></i>
			{{ _lang('My Profile') }}
		</a>
	</li>
	
	<li @if(Request::is('student/my_subjects')) class="active" @endif>
		<a href="{{ url('student/my_subjects') }}">
			<i class="fa fa-briefcase"></i>
			{{ _lang('My Subjects') }}
		</a>
	</li>
	
	<li @if(Request::is('student/class_routine')) class="active" @endif>
		<a href="{{ url('student/class_routine') }}">
			<i class="fa fa-calendar"></i>
			{{ _lang('Class Routine') }}
		</a>
	</li>
	
	<li @if(Request::is('student/exam_routine')) class="active" @endif>
		<a href="{{ url('student/exam_routine') }}">
			<i class="fa fa-calendar"></i>
			{{ _lang('Exam Routine') }}
		</a>
	</li>
	
	<li @if(Request::is('student/progress_card')) class="active" @endif>
		<a href="{{ url('student/progress_card') }}">
			<i class="fa fa-bar-chart"></i>
			{{ _lang('Progress Card') }}
		</a>
	</li>
	
	
	 <li>   
		<a href="#"><i class="fa fa-file-text"></i>{{ _lang('My Invoice') }}</a>
		<ul>
		   <li @if(Request::is('student/my_invoice')) class="active" @endif>
				<a href="{{ url('student/my_invoice') }}">
					{{ _lang('Unpaid Invoice') }}
				</a>
			</li>
	
			<li @if(Request::is('student/my_invoice/paid')) class="active" @endif>
				<a href="{{ url('student/my_invoice/paid') }}">
					{{ _lang('Paid Invoice') }}
				</a>
			</li>
		</ul>
	 </li>
	
	<li @if(Request::is('student/payment_history')) class="active" @endif>
		<a href="{{ url('student/payment_history') }}">
			<i class="fa fa-cc"></i>
			{{ _lang('Payment History') }}
		</a>
	</li>
	
	<li @if(Request::is('student/library_history')) class="active" @endif>
		<a href="{{ url('student/library_history') }}">
			<i class="fa fa-book"></i>
			{{ _lang('Library History') }}
		</a>
	</li>
	
	@include('layouts.menus.menus')
</ul>	
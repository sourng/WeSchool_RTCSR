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
	
	<li @if(Request::is('parent/my_profile')) class="active" @endif>
		<a href="{{ url('parent/my_profile') }}">
			<i class="fa fa-user-circle-o"></i>
			{{ _lang('My Profile') }}
		</a>
	</li>
	
	{!! get_children('My Children', 'parent/my_children', 'fa fa-users') !!}
	
	@include('layouts.menus.menus')
</ul>	
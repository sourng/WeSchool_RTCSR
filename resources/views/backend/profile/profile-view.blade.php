@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-10">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Profile')}}
				</div>
			</div>
			<div class="panel-body">
				
				<table class="table " style="boder:0 !important;" width="100%">
					<tbody style="text-align: center; border:none !important">
											
						<tr class="text-center">
							<td style="border:none !important;text-align:left;">
								<br>
								<br>
								<div>
									<p>ក្រសួងការងារ និងបណ្តុះបណ្តាលវិជ្ជាជីវៈ</p>
									<p>វិទ្យាស្ថានពហុបច្ចេកទេសភូមិភាគតេជោសែន</p>
									<p>សៀមរាប</p>
								</div>
								
							
							</td>
							
							<td style="border:none !important"><img src="{{ asset('public/uploads/images/'.$profile->image) }}" style="width: 120px; border-radius: 5px;position: absolute; left: 600px;top: 120px;"></td>
							
							<br>
						</tr>
						<tr>
							<td style="border:none !important" colspan="4">
								<div style="text-align:center;">
								<p style="position: absolute;left: 340px;top: 90px; font-family:'Khmer OS Muol Light';">ព្រះរាជាណាចក្រកម្ពុជា</p>
								<p style="position: absolute;left: 325px;top: 130px;font-family:'Khmer OS Muol Light';">ជាតិ  សាសនា  ព្រះមហាក្សត្រ</p>
							
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="4" style="border:none !important;text-align:center;">
								<h3 style="position: absolute;left: 335px;top: 200px; font-family:'Khmer OS Muol Light';">ប្រវត្តិរូបសង្ខេប</h3>
							</td>
						</tr>
						
						<tr>
							<td colspan="4" style="border:none !important;text-align:left;">
								<h3>{{_lang('personal_profile')}}</h3>
							</td>
						</tr>
						
						<tr>
							<td colspan="4" style="border:none !important;text-align:left;">
								<div style="font-size:16px; line-height: 12px;">
								<span>១.</span> {{ _lang('khmer_name') }} <strong style="color:blue;" title="{{ _lang('User Type') }}:{{ $profile->user_type }}">{{ $profile->name }}</strong> &nbsp;&nbsp; &nbsp;&nbsp;
												  {{_lang('latin_name') }} <strong style="color:blue;">{{$teachers[0]->latin_name}}</strong> &nbsp;&nbsp; &nbsp;&nbsp; 
												  {{_lang('gender')}} <strong style="color:blue;">{{_lang($teachers[0]->gender)}}</strong> &nbsp;&nbsp; &nbsp;&nbsp;
												  {{_lang('nick_name')}} <strong style="color:blue;">{{$teachers[0]->nick_name}}</strong> &nbsp;&nbsp; &nbsp;&nbsp;
								</div>
							</td>
						</tr>
						
						<tr>
							<td colspan="4" style="border:none !important;text-align:left;">
								<div style="font-size:16px; line-height: 12px;">
								<span>២.</span> {{ _lang('date_of_birth') }} <strong style="color:blue;">{{ \Carbon\Carbon::parse($teachers[0]->birthday)->format('d-m-Y')}}</strong> &nbsp;&nbsp; &nbsp;&nbsp;
												  {{_lang('nationals') }} <strong style="color:blue;">{{$teachers[0]->latin_name}}</strong> &nbsp;&nbsp; &nbsp;&nbsp; 
												  {{_lang('nationality')}} <strong style="color:blue;">{{_lang($teachers[0]->gender)}}</strong> &nbsp;&nbsp; &nbsp;&nbsp;
												  {{_lang('religion')}} <strong style="color:blue;">{{$teachers[0]->religion}}</strong> &nbsp;&nbsp; &nbsp;&nbsp;
								</div>
							</td>
						</tr>
						<tr>
							<td colspan="4" style="border:none !important;text-align:left;">
								<div style="font-size:16px; line-height: 12px;">
								<span>៣.</span> {{ _lang('place_of_birth') }} <strong style="color:blue;">{{ $address[0]->home }} {{ $address[0]->street }} {{ $address[0]->village }} {{ $address[0]->commune }} {{ $address[0]->district }} {{ $address[0]->province }}</strong> &nbsp;&nbsp; &nbsp;&nbsp;
												  {{_lang('phone_no') }} <strong style="color:blue;">{{$teachers[0]->phone}}</strong> &nbsp;&nbsp; &nbsp;&nbsp; 
												 
								</div>
							</td>
						</tr>
						
						
						
						
						<tr class="text-center">
							<td >{{ _lang('khmer_name') }}</td>
							<td>{{ $profile->name }}</td>
							<td>{{_lang('latin_name') }}  </td>
							
							<td> </td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('User Type') }}</td>
							<td>{{ $profile->user_type }}</td>
						</tr>
						<tr class="text-center">
							<td>{{ _lang('Email') }}</td>
							<td>{{ $profile->email }}</td>
						</tr>
						<tr class="text-center">
							<td colspan="2">
								<ul class="social-link">
									<li><a href="{{ $profile->facebook }}"><i class="fa fa-facebook"></i></a></li>
									<li><a href="{{ $profile->twitter }}"><i class="fa fa-twitter"></i></a></li>
									<li><a href="{{ $profile->linkedin }}"><i class="fa fa-linkedin"></i></a></li>
									<li><a href="{{ $profile->google_plus }}"><i class="fa fa-google-plus"></i></a></li>
								</ul>
							</td>
						</tr>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
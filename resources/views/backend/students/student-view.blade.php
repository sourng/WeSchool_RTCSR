@extends('layouts.backend')
@section('content')
<div class="row">
	<strong class="panel-title" style="display: none;">{{ _lang('Student Details') }}</strong>
	<div class="col-md-4">
		<div class="card card-user">
			<div class="image">
				<img src="{{ asset('public/uploads/images/background/background.jpg') }}" alt="...">
			</div>
			<div class="content">
				<div class="author">
					<img class="avatar border-white" src="{{ asset('public/uploads/images/'.$student->image) }}" alt="{{ $student->first_name }}">
					<h4 class="title">{{ $student->first_name .' '.$student->last_name }}</h4>
				</div>
			</div>
			<hr>
			<div class="text-center">
				<div class="row">
					<div class="col-md-3 col-md-offset-1">
						<h5>{{ _lang('Class') }}<br><small>{{ $student->class_name }}</small></h5>
					</div>
					<div class="col-md-4">
						<h5>{{ _lang('Section') }}<br><small>{{ $student->section_name }}</small></h5>
					</div>
					<div class="col-md-3">
						<h5>{{ _lang('Roll') }}<br><small>{{ $student->roll }}</small></h5>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<ul class="nav nav-tabs setting-tab">
			<li class="active">
				<a data-toggle="tab" href="#profile" aria-expanded="true">{{ _lang('Profile') }}</a>
			</li>
			<li>
				<a data-toggle="tab" href="#parent" aria-expanded="false">{{ _lang('Parent') }}</a>
			</li>
			<li>
				<a data-toggle="tab" href="#invoices" aria-expanded="false">{{ _lang('Invoices') }}</a>
			</li>
			<li>
				<a data-toggle="tab" href="#payments_history" aria-expanded="false">{{ _lang('Payments History') }}</a>
			</li>
			<li class="pull-right">
				<div style="padding: 7px;">
					<a href="{{ route('students.edit',$student->id) }}" class="btn btn-primary rect-btn btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i>{{ _lang('Edit') }}</a>
				</div>
			</li>
		</ul>
		<div class="tab-content">
			<div id="profile" class="tab-pane fade in active">
				<div class="panel panel-default">
					<div class="panel-body">
						<table class="table table-custom" width="100%">
							<tbody>
								<tr>
									<td>{{ _lang('Register NO') }}</td>
									<td>{{ $student->register_no }}</td>
								</tr>
								@if($student->group != '')
								<tr>
									<td>{{ _lang('Group') }}</td>
									<td>{{ $student->group }}</td>
								</tr>
								@endif
								@if($student->optional_subject != '')
								<tr>
									<td>{{ _lang('Optional Subject') }}</td>
									<td>{{ $student->optional_subject }}</td>
								</tr>
								@endif
								<tr>
									<td>{{ _lang('Date Of Birth') }}</td>
									<td>{{ date('d M, Y', strtotime($student->birthday)) }}</td>
								</tr>
								<tr>
									<td>{{ _lang('Gender') }}</td>
									<td>{{ $student->gender  }}</td>
								</tr>
								<tr>
									<td>{{ _lang('Blood Group') }}</td>
									<td>{{ $student->blood_group }}</td>
								</tr>
								<tr>
									<td>{{ _lang('Religion') }}</td>
									<td>{{ $student->religion }}</td>
								</tr>
								<tr>
									<td>{{ _lang('Phone') }}</td>
									<td>{{ $student->phone }}</td>
								</tr>
								<tr>
									<td>{{ _lang('Address') }}</td>
									<td>{{ $student->address }}</td>
								</tr>
								<tr>
									<td>{{ _lang('State') }}</td>
									<td>{{ $student->state }}</td>
								</tr>
								<tr>
									<td>{{ _lang('Country') }}</td>
									<td>{{ $student->country }}</td>
								</tr>
								@if($student->activities != '')
								<tr>
									<td>{{ _lang('Extra Curricular Activities') }}</td>
									<td>{{ $student->activities }}</td>
								</tr>
								@endif
								@if($student->remarks != '')
								<tr>
									<td>{{ _lang('Remarks') }}</td>
									<td>{{ $student->remarks }}</td>
								</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div id="parent" class="tab-pane fade">
				<div class="panel panel-default">
					<div class="panel-body">
						<table class="table table-custom" width="100%">
							<tbody>
							  @if(!empty($parent))
									<tr>
										<td>{{ _lang("Father's Name") }}</td>
										<td>{{ $parent->f_name  }}</td>
									</tr>
									<tr>
										<td>{{ _lang("Mother's Name") }}</td>
										<td>{{ $parent->m_name }}</td>
									</tr>
									<tr>
										<td>{{ _lang("Father's Profession") }}</td>
										<td>{{ $parent->f_profession }}</td>
									</tr>
									<tr>
										<td>{{ _lang("Mother's Profession") }}</td>
										<td>{{ $parent->m_profession }}</td>
									</tr>
									<tr>
										<td>{{ _lang("Guardian's Name") }}</td>
										<td>{{ $parent->parent_name }}</td>
									</tr>
									<tr>
										<td>{{ _lang('Phone') }}</td>
										<td>{{ $parent->phone }}</td>
									</tr>
									<tr>
										<td>{{ _lang('Email') }}</td>
										<td>{{ $parent->email }}</td>
									</tr>
									<tr>
										<td>{{ _lang('Address') }}</td>
										<td>{{ $parent->address }}</td>
									</tr>
								@else
									<tr>
										<td colspan="2">{{ _lang('No Data Found') }}</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div id="invoices" class="tab-pane fade">
				<div class="panel panel-default">
					
					<div class="panel-body">
						<div class="content no-export">
							<table class="table table-bordered data-table">
								<thead>
									<tr>
										<th>{{ _lang('Due Date') }}</th>
										<th>{{ _lang('Title') }}</th>
										<th>{{ _lang('Total') }}</th>
										<th>{{ _lang('Paid') }}</th>
										<th>{{ _lang('Status') }}</th>
									</tr>
								</thead>
								<tbody>
									@php $currency = get_option('currency_symbol') @endphp
									@foreach($invoices as $invoice)
									<tr>
										<td>{{ date('d M, Y', strtotime($invoice->due_date)) }}</td>
										<td style='max-width:250px;'>{{ $invoice->title }}</td>
										<td>{{ $currency." ".$invoice->total }}</td>
										<td>{{ $currency." ".$invoice->paid }}</td>
										<td>
											{!! $invoice->status=="Paid" ? '<i class="fa fa-circle paid"></i>'.$invoice->status : '<i class="fa fa-circle unpaid"></i>'.$invoice->status !!}
										</td>
									</tr>		
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div id="payments_history" class="tab-pane fade">
				<div class="panel panel-default">

					<div class="panel-body">
						<div class="content no-export">
							<table class="table table-bordered data-table">
								<thead>
									<tr>
										<th>{{ _lang('Date') }}</th>
										<th>{{ _lang('Amount') }}</th>
										<th>{{ _lang('Note') }}</th>
									</tr>
								</thead>
								<tbody>
									@php $currency = get_option('currency_symbol') @endphp
									@foreach($payments_history as $data)
									<tr>
										<td class='date'>{{ date('d M, Y', strtotime($data->date)) }}</td>
										<td class='amount'>{{ $currency." ".$data->amount }}</td>
										<td class='note'>{{ $data->note }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>  
	</div>
</div>
@endsection
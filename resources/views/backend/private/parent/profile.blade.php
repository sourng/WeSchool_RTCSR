@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('My Profile')}}
				</div>
			</div>
			<table class="table table-striped table-bordered" width="100%">
				<tbody>
					<tr>
						<td style="text-align: center;" colspan="4"><img width="200px" style="border-radius: 7px;" src="{{ asset('public/uploads/images/'.$parent->image) }}"></td>
					</tr>
					<tr>
						<td colspan="2">{{ _lang('Name') }}</td>
						<td colspan="2">{{ $parent->parent_name }}</td>
					</tr>
					<tr>
						<td colspan="2">{{ _lang('Student Name') }}</td>
						<td colspan="2">{{ $parent->first_name." ".$parent->last_name }}</td>
					</tr>
					<tr>
						<td>{{ _lang('Class') }}</td>
						<td>{{ $parent->class_name }}</td>
						<td>{{ _lang('Section') }}</td>
						<td>{{ $parent->section_name }}</td>
					</tr>
					<tr>
						<td>{{ _lang('Roll No') }}</td>
						<td>{{ $parent->roll }}</td>
						<td>{{ _lang('Register No') }}</td>
						<td>{{ $parent->register_no }}</td>
					</tr>
					<tr>
						<td>{{ _lang("Father's Name") }}</td>
						<td>{{ $parent->f_name }}</td>
						<td>{{ _lang("Mother's Name") }}</td>
						<td>{{ $parent->m_name }}</td>
					</tr>
					<tr>
						<td>{{ _lang("Father's Profession") }}</td>
						<td>{{ $parent->f_profession }}</td>
						<td>{{ _lang("Mothers's Profession") }}</td>
						<td>{{ $parent->m_profession }}</td>
					</tr>
					<tr>
						<td colspan="2">{{_lang('Address') }}</td>
						<td colspan="2">{{ $parent->address }}</td>
					</tr>
					<tr>
						<td>{{ _lang('Phone') }}</td>
						<td>{{ $parent->phone }}</td>
						<td>{{ _lang('Email') }}</td>
						<td>{{ $parent->email }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
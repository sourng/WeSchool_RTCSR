@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-sm-8">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Book Issue')}}
				</div>
			</div>
			<table class="table table-striped table-bordered" width="100%">
				<tbody style="text-align: center;">
					<tr>
						<td colspan="4">
							<img src="{{ asset('public/uploads/images/books/'.$issue->photo) }}" style="border-radius: 5px;" width="160px" alt="">
						</td>
					</tr>
					<tr>
						<td>{{_lang('Mamber Name')}}</td>
						<td>{{$issue->member_name}}</td>
						<td>{{_lang('Library Id')}}</td>
						<td>{{$issue->library_id}}</td>
					</tr>
					<tr>
						<td>{{_lang('Book Name')}}</td>
						<td>{{$issue->name}}</td>
						<td>{{_lang('Category')}}</td>
						<td>{{$issue->category_name}}</td>
					</tr>
					<tr>
						<td>{{_lang('Issue Date')}}</td>
						<td>{{$issue->issue_date}}</td>
						<td>{{_lang('Due Date')}}</td>
						<td>{{$issue->due_date}}</td>
					</tr>
					<tr>
						<td>{{_lang('Return Date')}}</td>
						<td>{{$issue->return_date}}</td>
						<td>{{_lang('Status')}}</td>
						<td>@if($issue->status == '1') <span class="badge badge-danger">{{_lang('Not Return')}}</span> @else <span class="badge badge-success">{{'Returned'}}</span> @endif</td>
					</tr>
					<tr>
						<td colspan="2">{{_lang('Note')}}</td>
						<td colspan="2">{{$issue->note}}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
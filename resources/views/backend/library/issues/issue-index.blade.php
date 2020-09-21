@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Book Issues')}}
				</div>
			</div>
			<div class="panel-body">
				<form id="search_form" class="params-panel validate" action="{{ url('bookissues/list') }}" method="post" autocomplete="off" accept-charset="utf-8">
					@csrf
					<div class="col-md-4 col-md-offset-3">
						<div class="form-group">
							<label for="date" class="control-label">{{ _lang('Library Id') }}</label>
							<select name="library_id" class="form-control select2" required>
								<option value="">{{ _lang('Select One') }}</option>
								{{ create_option('library_members','library_id','library_id',$library_id) }}
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<input class="btn btn-primary btn-block rect-btn" style="margin-top:24px" value="Search" type="submit">
					</div>
				</form>
				@if( !empty($issues) )
				<div class="col-md-12">
					<div class="panel-heading text-center">
						<div class="panel-title" >
							{{ _lang('Book Issues Of') }}<br>
							{{ _lang('Member Name - ') }}{{ $member->name }}<br>
							{{ _lang('Library Id - ') }}{{ $member->library_id }}<br>
						</div>
					</div>

					<table class="table table-bordered data-table">
						<thead>
							<tr>
								<th>#</th>
								<th>{{_lang('Book Name')}}</th>
								<th>{{_lang('Category')}}</th>
								<th>{{_lang('Issue Date')}}</th>
								<th>{{_lang('Due Date')}}</th>
								<th>{{_lang('Return Date')}}</th>
								<th>{{_lang('Status')}}</th>
								<th>{{_lang('Action')}}</th>
							</tr>
						</thead>
						<tbody>
							@php $i=1; @endphp
							@foreach($issues AS $data)
							<tr>
								<td>{{$i}}</td>
								<td>{{$data->name}}</td>
								<td>{{$data->category_name}}</td>
								<td>{{date('d-M-Y', strtotime($data->issue_date))}}</td>
								<td>{{date('d-M-Y', strtotime($data->due_date))}}</td>
								<td>@if($data->return_date != '' ){{date('d-M-Y', strtotime($data->return_date))}}@endif</td>
								<td>@if($data->status == '1') <span class="badge badge-danger">{{_lang('Not Return')}}</span> @else <span class="badge badge-success">{{'Returned'}}</span> @endif</td>
								<td>
									<form action="{{route('bookissues.destroy',$data->id)}}" method="post">
										<a href="{{route('bookissues.show',$data->id)}}" class="btn btn-success btn-xs"><i class="fa fa-eye" aria-hidden="true" title="edit book issue"></i></a>
										<a href="{{route('bookissues.edit',$data->id)}}" class="btn btn-warning btn-xs"><i class="fa fa-pencil" aria-hidden="true" title="edit book issue"></i></a>
										{{ method_field('DELETE') }}
										@csrf
										@if($data->status == '1')
										<a href="{{route('bookissues.return',$data->id)}}" class="btn btn-info btn-xs"><i class="fa fa-share" aria-hidden="true" title="book return"></i></a>
										@endif
										<button type="submit" class="btn btn-danger btn-xs btn-remove"><i class="fa fa-eraser" aria-hidden="true" title="return book"></i></button>
									</form>
								</td>
							</tr>
							@php $i++; @endphp
							@endforeach
						</tbody>
					</table>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-sm-8">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Book')}}
				</div>
			</div>
			<table class="table table-striped table-bordered" width="100%">
				<tbody style="text-align: center;">
					<tr>
						<td colspan="4">
							<img src="{{ asset('public/uploads/images/books/'.$book->photo) }}" style="border-radius: 5px;" width="160px" alt="">
						</td>
					</tr>
					<tr>
						<td colspan="2">{{_lang('Name')}}</td>
						<td colspan="2">{{$book->name}}</td>
					</tr>
					<tr>
						<td>{{_lang('Subject')}}</td>
						<td>{{$book->subject}}</td>
						<td>{{_lang('Author')}}</td>
						<td>{{$book->author}}</td>
					</tr>
					<tr>
						<td>{{_lang('Publisher')}}</td>
						<td>{{$book->publisher}}</td>
						<td>{{_lang('Rack No')}}</td>
						<td>{{$book->rack_no}}</td>
					</tr>
					<tr>
						<td>{{_lang('Publisher')}}</td>
						<td>{{$book->publisher}}</td>
						<td>{{_lang('Quantity')}}</td>
						<td>{{$book->quantity}}</td>
					</tr>
					<tr>
						<td>{{ _lang('Description') }}</td>
						<td>{{$book->description}}</td>
						<td>{{ _lang('Publish Date') }}</td>
						<td>{{$book->publish_date}}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
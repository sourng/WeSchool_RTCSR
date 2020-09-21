@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default no-export">
			<div class="panel-heading"><span class="panel-title">{{ _lang('List Fee Type') }}</span>
			<a class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add Fee Type') }}" href="{{route('fee_types.create')}}">{{ _lang('Add New') }}</a>
			</div>

			<div class="panel-body">
			 @if (\Session::has('success'))
			  <div class="alert alert-success">
				<p>{{ \Session::get('success') }}</p>
			  </div>
			  <br />
			 @endif
			<table class="table table-bordered data-table">
			<thead>
			  <tr>
				<th>{{ _lang('Fee Type') }}</th>
				<th>{{ _lang('Fee Code') }}</th>
				<th>{{ _lang('Note') }}</th>
				<th>{{ _lang('Action') }}</th>
			  </tr>
			</thead>
			<tbody>
			  
			  @foreach($feetypes as $feetype)
			  <tr id="row_{{ $feetype->id }}">
				<td class='fee_type'>{{ $feetype->fee_type }}</td>
				<td class='fee_code'>{{ $feetype->fee_code }}</td>
				<td class='note'>{{ $feetype->note }}</td>

				<td>
				  <form action="{{action('FeeTypeController@destroy', $feetype['id'])}}" method="post">
					<a href="{{action('FeeTypeController@edit', $feetype['id'])}}" data-title="{{ _lang('Update Fee Type') }}" class="btn btn-warning btn-sm ajax-modal">{{ _lang('Edit') }}</a>
					<a href="{{action('FeeTypeController@show', $feetype['id'])}}" data-title="{{ _lang('View Fee Type') }}" class="btn btn-info btn-sm ajax-modal">{{ _lang('View') }}</a>
					{{ csrf_field() }}
					<input name="_method" type="hidden" value="DELETE">
					<button class="btn btn-danger btn-sm btn-remove" type="submit">{{ _lang('Delete') }}</button>
				  </form>
				</td>
			  </tr>
			  @endforeach
			</tbody>
		  </table>
			</div>
		</div>
	</div>
</div>

@endsection



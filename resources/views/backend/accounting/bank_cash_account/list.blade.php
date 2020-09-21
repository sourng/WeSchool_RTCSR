@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default no-export">
			<div class="panel-heading"><span class="panel-title">{{ _lang('List Account') }}</span>
			<a class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add Account') }}" href="{{route('accounts.create')}}">{{ _lang('Add New') }}</a>
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
				<th>{{ _lang('Account Name') }}</th>
				<th>{{ _lang('Opening Balance') }}</th>
				<th>{{ _lang('Note') }}</th>
				<th>{{ _lang('Action') }}</th>
			  </tr>
			</thead>
			<tbody>
			  @php $currency = get_option('currency_symbol') @endphp
			  @foreach($accounts as $account)
			  <tr id="row_{{ $account->id }}">
				<td class='account_name'>{{ $account->account_name }}</td>
				<td class='opening_balance'>{{ $currency." ".decimalPlace($account->opening_balance) }}</td>
				<td class='note'>{{ $account->note }}</td>
				<td>
				  <form action="{{action('AccountController@destroy', $account['id'])}}" method="post">
					<a href="{{action('AccountController@edit', $account['id'])}}" data-title="{{ _lang('Update Account') }}" class="btn btn-warning btn-sm ajax-modal">{{ _lang('Edit') }}</a>
					<a href="{{action('AccountController@show', $account['id'])}}" data-title="{{ _lang('View Account') }}" class="btn btn-info btn-sm ajax-modal">{{ _lang('View') }}</a>
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
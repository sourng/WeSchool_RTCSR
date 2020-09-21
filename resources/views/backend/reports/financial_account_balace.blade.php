@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title" >
					{{_lang('Financial Account Balance')}}
				</span>
			</div>
			<div class="panel-body">	
				@if( isset($report_data) )	
				<div class="col-md-12 params-panel" id="report">
                    <button type="button" data-print="report" class="btn btn-primary btn-sm pull-right print"><i class="fa fa-print"></i> {{ _lang('Print Report') }}</button>			
						<div class="text-center clear">
							{{ get_option('school_name') }}<br>
							{{ _lang('Financial Account Balance') }}<br></br>	
						</div>

					    @if( !empty($report_data) )
							@php $currency = get_option('currency_symbol') @endphp
							<table class="table table-bordered">
								<thead>
								    <th>{{ _lang('Created') }}</th>
									<th>{{ _lang('Account Name') }}</th>
									<th>{{ _lang('Opening Balance') }}</th>
									<th>{{ _lang('Current Balance') }}</th>
								</thead>
								<tbody>
								  @foreach($report_data as $account)
									<tr>
										<td>{{ date('d /M /Y - H:m', strtotime($account->created_at)) }}</td>
										<td>{{ $account->account_name }}</td>
										<td>{{ $currency." ".$account->opening_balance }}</td>
										<td>{{ $currency." ".$account->current_balance }}</td>
									  </tr>
								  @endforeach 
								</tbody>
							</table>
						@else	
							<h4 class="text-center">{{ _lang('No Records Found !') }}</h4>
						@endif		
					</div><!--End panel-->
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
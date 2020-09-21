@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title" >
					{{_lang('Income Report')}}
				</span>
			</div>
			<div class="panel-body">
				<form id="search_form" class="params-panel validate" action="{{ url('reports/income_report/view') }}" method="post" autocomplete="off" accept-charset="utf-8">
					@csrf
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">{{ _lang('Date From') }}</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								<input type="text" class="form-control datepicker" name="date1" value="{{ $date1 }}" readOnly="true" required>
						    </div>
						</div>
					</div>
					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">{{ _lang('Date From') }}</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								<input type="text" class="form-control datepicker" name="date2" value="{{ $date2 }}" readOnly="true" required>
						    </div>
						</div>
					</div>
					

					<div class="col-sm-3">
						<div class="form-group">
							<button type="submit" style="margin-top:24px;" class="btn btn-primary btn-block rect-btn">{{_lang('View Report')}}</button>
						</div>
					</div>
				</form>
				
				@if( isset($report_data) )	
				<div class="col-md-12 params-panel" id="report">
                    <button type="button" data-print="report" class="btn btn-primary btn-sm pull-right print"><i class="fa fa-print"></i> {{ _lang('Print Report') }}</button>			
						<div class="text-center clear">
							{{ get_option('school_name') }}<br>
							{{ _lang('Income Report from') }} {{ $date1." "._lang("to")." ".$date2 }}<br></br>	
						</div>

					    @if( !empty($report_data) )
							@php $currency = get_option('currency_symbol') @endphp
							<table class="table table-bordered">
								<thead>
								    <th>{{ _lang('Date') }}</th>
									<th>{{ _lang('Account') }}</th>
									<th>{{ _lang('Amount') }}</th>
									<th>{{ _lang('Income Type') }}</th>
									<th>{{ _lang('Payer') }}</th>
									<th>{{ _lang('Payment Method') }}</th>
								</thead>
								<tbody>
								  @foreach($report_data as $transaction)
									<tr>
										<td>{{ $transaction->trans_date }}</td>
										<td>{{ $transaction->account_name }}</td>
										<td>{{ $currency." ".$transaction->amount }}</td>
										<td>{{ $transaction->c_type }}</td>
										<td>{{ $transaction->payee_payer }}</td>
										<td>{{ $transaction->payment_method }}</td>
									  </tr>
								  @endforeach 
									<tr>
										<td></td>
										<td>{{ _lang('Total') }}</td>
										<td>{{ $currency." ".$summary->total }}</td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
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
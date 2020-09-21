@extends('layouts.backend')

@section('css.stylesheet')
<style type="text/css">
	/* Invoice */
	.invoice {
		padding: 0 15px 15px;
	}

	/* Invoice Address Tag */
	.invoice address {
		color: #7F8597;
		line-height: 1.5em;
	}

	/* Invoice header */
	.invoice header {
		border-bottom: 1px solid #DADADA;
		margin-bottom: 15px;
	}
	.invoice header .h2,
	.invoice header .h4 {
		letter-spacing: 0;
	}

	/* Invoice Billing Information */
	.invoice .bill-to,
	.invoice .bill-data {
		padding: 15px 0;
	}
	.invoice .bill-data .value {
		display: inline-block;
		margin-left: 10px;
		width: 90px;
	}

	/* Invoice table */
	.invoice table.table {
		table-layout: fixed;
	}
	.invoice table.table > thead:first-child > tr > th {
		background-color: #F8F8F8;
		border-bottom: 1px solid #DADADA;
		border-top: 1px solid #DADADA;
	}
	.invoice table.table > tbody tr > td {
		border-color: #DADADA;
	}

	/* Invoice table items */
	.invoice .invoice-items > tbody tr:last-child > td {
		border-bottom: 1px solid #DADADA;
	}
	.invoice .invoice-items #cell-id {
		width: 10%;
	}
	.invoice .invoice-items #cell-item {
		width: 20%;
	}
	.invoice .invoice-items #cell-desc {
		width: 20%;
	}
	.invoice .invoice-items #cell-price {
		width: 10%;
	}
	.invoice .invoice-items #cell-qty {
		width: 10%;
	}
	.invoice .invoice-items #cell-total {
		width: 10%;
	}

	/* Invoice summary */
	.invoice-summary .col-sm-4 {
		padding-left: 0;
	}

	/* Invoice Responsiveness */
	@media only screen and (max-width: 991px) {
		.invoice .table-responsive > table.table {
			table-layout: auto;
		}

		.invoice-summary .col-sm-4 {
			padding-left: 15px;
		}
	}

	.bill-info{
		padding-bottom: 20px;
	}
	/* Invoice Print */
	@media print {
		.invoice .table-responsive {
			border: none !important;
			overflow: visible !important;
			width: auto !important;
		}
		.invoice table.table.invoice-items {
			table-layout: auto;
		}
		.invoice header .col-sm-6:first-child,
		.invoice header .col-sm-6:last-child,
		.invoice .bill-info .col-md-6 {
			float: left !important;
		}
		.invoice header .col-sm-6:first-child {
			width: 25% !important;
		}
		.invoice header .col-sm-6:last-child {
			width: 75% !important;
		}
		.invoice .bill-info .col-md-6 {
			width: 50% !important;
		}
		.invoice .invoice-summary .col-sm-4 {
			float: right;
			padding: 0;
			width: 40%;
		}
	}
	/* dark */
	html.dark .invoice header {
		border-bottom-color: #282d36;
	}
	html.dark .invoice table.table > thead:first-child > tr > th {
		background-color: #282d36;
		border-bottom-color: #282d36;
		border-top-color: #282d36;
	}
	html.dark .invoice table.table > tbody tr > td {
		border-color: #282d36;
	}

	.invoice .logo img{
		width: 200px;
		height: 150px;
	}
</style>
@endsection

@section('content')
<section class="panel">
	<div class="panel-body">
		<div class="invoice" id="invoice">
			<header class="clearfix">
				<div class="row">
					<div class="col-md-6">
						<div class="logo">
							<img src="{{ get_logo() }}" alt="{{ _lang('Logo') }}" />
						</div>
					</div>
					<div class="col-md-6 text-right">
						<address class="text-dark">
							<h4>{{ get_option('company_name') }}</h4>
							<br/>
							{{ get_option('address') }}
							<br/>
							{{ _lang('Phone') }} : {{ get_option('phone') }}
							<br/>
							{{ _lang('Email') }} : {{ get_option('email') }}
						</address>
					</div>
				</div>
			</header>
			<div class="col-md-12 bill-info text-center">
				<h3>
					{{ _lang('PAYSLIP') }}<br>
					{{ _lang('Salary Of') }} {{ month_number_to_name($payslip->month) }} - {{ $payslip->year }}
				</h3>
			</div>
			<div class="col-md-12 bill-info text-center">
				<div class="text-dark">
					<p style="line-height: 0px;">
						<b>{{ _lang('Employee') }} :</b>
						{{ $payslip->name }} ({{ $payslip->employee_id }})
					</p>
					<p>
						<b>{{ _lang('Department') }} :</b>
						{{ $payslip->department }} ({{ $payslip->designation }})
					</p>
				</div>
			</div>
			<div class="col-md-12">
				<table class="table text-dark invoice-items">
					<tbody>
						<tr>
							<td colspan="2"><b>{{ _lang('Current Salary') }}</b></td>
							<td class="text-right">
								{{ get_option('currency_symbol') }}{{ $payslip->current_salary }}
							</td>
						</tr>
						<tr>
							<td colspan="2"><b>{{ _lang('Expense Claim') }}</b></td>
							<td class="text-right">
								{{ get_option('currency_symbol') }}{{ $payslip->expense_claim }}
							</td>
						</tr>
						<tr>
							<td colspan="2"><b>{{ _lang('Absent Fine') }}</b></td>
							<td class="text-right">
								{{ get_option('currency_symbol') }}{{ $payslip->absent_fine }}
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-md-6">
				<h3>{{ _lang('Allowances') }}</h3>
				<table class="table">
					<tr>
						<th>{{ _lang('Title') }}</th>
						<th>{{ _lang('Amount') }}</th>
					</tr>
					@php
					$total_allowance = 0;
					@endphp
					@foreach ($allowances as $allowance)
					<tr>
						<td>{{ $allowance->title }}</td>
						<td class="text-right">
							@php
							$total_allowance += $allowance->amount;
							@endphp
							{{ get_option('currency_symbol') }}{{ $allowance->amount }}
						</td>
					</tr>
					@endforeach
				</table>
			</div>
			<div class="col-md-6">
				<h3>{{ _lang('Deductions') }}</h3>
				<table class="table">
					<tr>
						<th>{{ _lang('Title') }}</th>
						<th>{{ _lang('Amount') }}</th>
					</tr>
					@php
					$total_deduction = 0;
					@endphp
					@foreach ($deductions as $deduction)
					<tr>
						<td>{{ $deduction->title }}</td>
						<td class="text-right">
							@php
							$total_deduction += $deduction->amount;
							@endphp
							{{ get_option('currency_symbol') }}{{ $deduction->amount }}
						</td>
					</tr>
					@endforeach
				</table>
			</div>
			<div class="invoice-summary">
				<div class="col-md-6 col-md-offset-6">
					<h3>{{ _lang('Summary') }}</h3>
					<table class="table text-dark">
						<tbody>
							<tr>
								<td colspan="2">{{ _lang('Total Allowances') }}</td>
								<td class="text-right">
									@php
									$total_allowance += $payslip->current_salary + $payslip->expense_claim;
									@endphp
									{{ get_option('currency_symbol') }}{{ number_format($total_allowance, 2) }}
								</td>
							</tr>
							<tr>
								<td colspan="2">{{ _lang('Total Deductions') }}</td>
								<td class="text-right">
									@php
									$total_deduction += $payslip->absent_fine;
									@endphp
									{{ get_option('currency_symbol') }}{{ number_format($total_deduction, 2) }}
								</td>
							</tr>
							<tr>
								<td colspan="2">{{ _lang('Net Salary') }}</td>
								<td class="text-right">
									{{ get_option('currency_symbol') }}{{ number_format($total_allowance - $total_deduction, 2) }}
								</td>
							</tr>
							<tr>
								<td colspan="2">{{ _lang('Status') }}</td>
								<td class="text-right">
									@if ($payslip->status != 1)
									<span class="badge btn-danger">{{ _lang('Unpaid') }}</span>
									@else
									<span class="badge btn-success">{{ _lang('Paid') }}</span>
									@endif
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-12 text-right mr-lg">
			<button class="btn btn-primary ml-sm print" data-print="invoice">
				<i class="fa fa-print"></i>
				{{ _lang('Print') }}
			</button>
		</div>
	</div>
</section>
@endsection



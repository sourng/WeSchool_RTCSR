@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading panel-title">{{ _lang('View Invoice') }}</div>
   
	<div class="panel-body">
	    <!--Invoice Information-->
		<div class="invoice-box">
		 @php $currency = get_option('currency_symbol') @endphp
		 <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <b>{{ _lang('Invoice ID') }}: {{ $invoice->id }}</b><br>
                                <b>{{ _lang('Invoice No') }}: {{ strrev ( date('Ym', strtotime( $invoice->due_date ))) }}{{ $invoice->id }}</b><br>
                                {{ _lang('Due Date') }} : {{ date('d-M-Y', strtotime( $invoice->due_date )) }}
								<div class="invoice-status">{{ _lang('Payment Status') }} : <b class="{{ $invoice->status }}">{{ $invoice->status }}</b></div>
                            </td>
							
							 <td class="title">
                                <img src="{{ get_logo() }}" style="width:100px;">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
			
			<tr>
			  <td><h4 align="center">{{ $invoice->title }}</h4></td>
			</tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
							    <h4><b>{{ _lang('Invoice To') }}</b></h4>
								{{ _lang("Name")." : ".$invoice->first_name." ".$invoice->last_name }}
								</br>
                                {{ _lang("Class")." : ".$invoice->class_name }}, 
                                {{ _lang("Section")." : ".$invoice->section_name }}<br>
                                {{ _lang("Roll")." : ".$invoice->roll }}<br>
                            </td>
							
							 <!--School Address-->
                            <td>
							   <h4><b>{{ get_option("school_name") }}</b></h4>
                                {{ _lang('Address')." : ".get_option("address") }}<br>
                                {{ _lang('Email')." : ".get_option('email') }}<br>
								</br>
								<!--Invoice Payment Information-->
								<h4>{{ _lang('Invoice Total') }} : &nbsp;{{ $currency." ".decimalPlace($invoice->total) }}</h4>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
		</table>	
		
		<!--End Invoice Information-->
			
		<!--Invoice Product-->
		<div class="col-md-12"> 
		    <table class="table">
				<thead style="background:#dce9f9;">
					<th>{{ _lang('Fee Type') }}</th>
					<th style="text-align:right">{{ _lang('Amount')." ".get_option('currency_symbol') }}</th>
					<th style="text-align:right">{{ _lang('Discount')." ".get_option('currency_symbol') }}</th>
					<th style="text-align:right">{{ _lang('Total')." ".get_option('currency_symbol') }}</th>		  
				</thead>
				<tbody id="invoice">	
					@foreach($invoiceItems as $item)				
					   <tr>
						 <td width="40%">{{ $item->fee_type }}</td>
						 <td style="text-align:right">{{ $currency." ".$item->amount }}</td>
						 <td style="text-align:right">{{ $currency." ".$item->discount }}</td>
						 <td style="text-align:right">{{ $currency." ".($item->amount-$item->discount) }}</td>
					   </tr>
					@endforeach
				</tbody>
			  </table>
		 </div> 
        <!--End Invoice Product-->	

        <!--Summary Table-->
		<div class="col-md-4 pull-right" style="background:#dce9f9">
			<table class="table" width="100%">
			 <tr><td>{{ _lang('Total') }}</td><td style="text-align:right; width:120px;">{{ $currency." ".decimalPlace($invoice->total) }}</td></tr>
			 <tr><td>{{ _lang('Paid') }}</td><td style="text-align:right; width:120px;">{{ $currency." ".decimalPlace($invoice->paid) }}</td></tr>
			 <tr><td>{{ _lang('Amount Due') }}</td><td style="text-align:right; width:120px;">{{ $currency." ".decimalPlace($invoice->total-$invoice->paid) }}</td></tr>
			</table>  	
        </div>
        <!--End Summary Table-->
		<div class="clear"></div>
		 
		<!--related Transaction-->
		@if( count($transactions) > 0 )
		   <table class="table table-bordered" style="margin-top:30px">
		       <thead>
			      <th colspan="3" style="text-align: center;">{{ _lang('Related Transaction') }}</th>
			   </thead>
			   <thead>
			      <th>{{ _lang('Date') }}</th>
			      <th>{{ _lang('Note') }}</th>
			      <th style="text-align: right;">{{ _lang('Amount') }}</th>
			   </thead>
			   <tbody>
			@foreach($transactions as $trans)
			   <tr>
			      <td>{{ date('d/M/Y - H:m', strtotime($trans->created_at)) }}</td>
			      <td style="text-align: left;">{{ $trans->note }}</td>
			      <td style="text-align: right;">{{ $currency." ".decimalPlace($trans->amount) }}</td>
			   </tr>
			@endforeach
			  </tbody>
		   </table>
		@endif
		<!--End related Transaction-->  
	
		 
		<!--Invoice Note-->
		@if( $invoice->description !="" )
		<div class="invoice-note">{{ $invoice->description }}</div>
		@endif
		<!--End Invoice Note--> 
		
	  </div><!--End Invoice Box-->
    </div>
  </div>
 </div>
</div>
@endsection



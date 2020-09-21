@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title">{{ _lang('List Invoice') }}</span>
				<select id="class" class="select_class pull-right" onchange="showClass(this);">
					<option value="">{{ _lang('Select Class') }}</option>
					{{ create_option('classes','id','class_name',$class) }}
				</select>
				<a class="btn btn-primary btn-sm pull-right" data-title="{{ _lang('Add New Invoice') }}" href="{{route('invoices.create')}}">{{ _lang('Add New') }}</a>
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
							<th>{{ _lang('ID') }}</th>
							<th>{{ _lang('Student') }}</th>
							<th>{{ _lang('Class') }} / {{ _lang('Section') }}</th>
							<th>{{ _lang('Roll') }}</th>
							<th>{{ _lang('Due Date') }}</th>
							<th>{{ _lang('Title') }}</th>
							<th>{{ _lang('Total') }}</th>
							<th>{{ _lang('Status') }}</th>
							<th>{{ _lang('Action') }}</th>
						</tr>
					</thead>
					<tbody>
						
						@foreach($invoices as $invoice)
						<tr id="row_{{ $invoice->id }}">
							<td>{{ $invoice->id }}</td>
							<td>{{ $invoice->first_name." ".$invoice->last_name }}</td>
							<td>{{ $invoice->class_name }} / {{ $invoice->section_name }}</td>
							<td>{{ $invoice->roll }}</td>
							<td>{{ date('d-M-Y', strtotime($invoice->due_date)) }}</td>
							<td style='max-width:250px;'>{{ $invoice->title }}</td>
							<td>{{ $invoice->total }}</td>
							<td>{!! $invoice->status=="Paid" ? '<i class="fa fa-circle paid"></i>'.$invoice->status : '<i class="fa fa-circle unpaid"></i>'.$invoice->status !!}</td>		
							<td>
								<div class="dropdown">
									<button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">{{ _lang('Action') }}
										<span class="caret"></span></button>
										
										<form action="{{action('InvoiceController@destroy', $invoice['id'])}}" method="post">			
											{{ csrf_field() }}
											<input name="_method" type="hidden" value="DELETE">
											<ul class="dropdown-menu">
												<li><a href="{{ action('InvoiceController@edit', $invoice['id']) }}">{{ _lang('Edit') }}</a></li>
												<li><a href="{{ action('InvoiceController@show', $invoice['id']) }}" data-title="{{ _lang('View Invoice') }}" data-fullscreen="true" class="ajax-modal">{{ _lang('View Invoice') }}</a></li>
												<li><a href="{{ url('student_payments/create/'.$invoice['id']) }}" data-title="{{ _lang('Add Payment') }}" class="ajax-modal">{{ _lang('Take Payment') }}</a></li>
												<li><button class="btn-remove link-btn" type="submit">{{ _lang('Delete') }}</button></li>
											</ul>
										</form>
									</div>
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

	@section('js-script')
	<script>
		function showClass(elem){
			if($(elem).val() == ""){
				return;
			}
			window.location = "<?php echo url('invoices/class') ?>/"+$(elem).val();
		}
	</script>
	@stop



@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<header class="panel-heading">
				<span class="panel-title">{{ _lang('Expenses List') }}</span>
				<a class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add New') }}" href="{{ route('expenses.create') }}">
					{{ _lang('Add New') }}
				</a>
			</header>
			<div class="panel-body">
				<table class="table table-bordered data-table">
					<thead>
						<tr>
							<th>#</th>
							<th>{{ _lang('Item Name') }}</th>
							<th>{{ _lang('Amount') }}</th>
							<th>{{ _lang('Date') }}</th>
							<th>{{ _lang('Status') }}</th>
							<th>{{ _lang('Employee Name') }}</th>
							<th>{{ _lang('Employee Id') }}</th>
							<th class="text-center">{{ _lang('Action') }}</th>
						</tr>
					</thead>
					<tbody>
						@php $i = 1; @endphp
						@foreach($expenses as $data)
						<tr>
							<td>{{ $i }}</td>
							
							<td>{{ $data->name }}</td>
							<td>{{ get_option('currency_symbol') }}{{ $data->amount }}</td>
							<td>{{ date('d F Y', strtotime($data->date)) }}</td>
							<td>
								@if ($data->status == 0)
								<span class="badge btn-warning ">{{ _lang('Pending') }}</span>
								@elseif($data->status == 1)
								<span class="badge btn-success">{{ _lang('Approved') }}</span>
								@elseif($data->status == 2)
								<span class="badge btn-danger">{{ _lang('Rejected') }}</span>
								@endif
							</td>
							<td>
								@if(isset($data->employee))
								{{ $data->employee->user->name }}
								@endif
							</td>
							<td>
								@if(isset($data->employee))
								{{ $data->employee->employee_id }}
								@endif
							</td>
							<td class="text-center">
								<form action="{{ route('expenses.destroy', $data->id) }}" method="post" class="ajax-delete">
									<a href="{{ route('expenses.show', $data->id) }}" class="btn btn-info btn-xs ajax-modal" data-title="{{ _lang('Details') }}">
										<i class="fa fa-eye"></i>
									</a>
									@if ($data->status == 0)
									<a href="{{ url('expenses/selection/' . $data->id) }}" class="btn btn-success btn-xs selection-form" title="{{ _lang('Approve') }}">
										<i class="fa fa-check"></i>
									</a>
									<a href="{{ url('expenses/status/' . '/' . $data->id . '/2') }}" class="btn btn-danger btn-xs" title="{{ _lang('Reject') }}">
										<i class="fa fa-times"></i>
									</a>
									@csrf
									@method('DELETE')
									<button class="btn btn-danger btn-xs btn-remove" type="submit">
										<i class="fa fa-eraser"></i>
									</button>
									@endif
								</form>
							</td>
						</tr>
						@php $i++ @endphp
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js-script')
<script type="text/javascript">
	//Ajax Modal Submit
	$(document).on("click",".selection-form",function(){		 
		var link = $(this).attr("href");
		$.ajax({
			method: "GET",
			url: link,
			beforeSend: function(){
				$("#preloader").css("display","block");  
			},success: function(data){
				$("#preloader").css("display","none"); 
				if(data != 0){
					$('#main_modal .modal-title').html('Make Payment');
					$('#main_modal .modal-body').html(data);
					$('#main_modal').modal('show'); 
					$("#main_modal input:required, #main_modal select:required").prev().append("<span class='required'> *</span>");
				}
			}
		});
		return false;
	});
</script>
@stop


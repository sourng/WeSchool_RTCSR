@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title" >
					{{_lang('Inbox')}}
				</span>
				<a href="{{ url('message/compose') }}" class="btn btn-primary btn-sm pull-right">{{_lang('New Message')}}</a>
			</div>
			<div class="panel-body no-export">
				<table class="table table-bordered">
					<thead>
						<th>{{ _lang('Date') }}</th>
						<th>{{ _lang('Sender') }}</th>
						<th>{{ _lang('Subject') }}</th>
						<th>{{ _lang('View') }}</th>
					</thead>
					<tbody>
						@foreach($messages as $data)
						<tr {{ $data->read =='n' ? "style=font-weight:bold" : "" }}>
							<td>{{ date('d/M/Y - H:m', strtotime($data->date)) }}</td>
							<td>{{ $data->sender }}</td>
							<td>{{ $data->subject }}</td>
							<td><a href="{{ url('message/inbox/'.$data->id) }}" data-title="{{ _lang('View Message') }}" class="btn btn-primary btn-sm ajax-modal">{{ _lang('View') }}</a></td>
						</tr>
						@endforeach
					</tbody>
				</table>
				
				<div class="pull-right">
					{{ $messages->links() }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js-script')
<script>
$(document).on('click','.ajax-modal',function(){
	$(this).parent().parent().css("font-weight","normal");
	var inbox_count = parseInt($(".inbox-count").html());
	if(inbox_count == 1){
	   $(".inbox-count").remove();
	}else{
	   $(".inbox-count").html(inbox_count-1);
	}
	
});
</script>
@stop

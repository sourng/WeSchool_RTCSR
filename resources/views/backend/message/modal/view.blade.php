<div class="panel panel-default">
<div class="panel-body">
   <h5 class="params-panel">{{ _lang("Date ") }} : {{ date('d/M/Y - H:m', strtotime($message->date)) }}</h5>
   <h5 class="params-panel">{{ $message->subject }}</h5>
   <div class="params-panel">
		{!! $message->body !!}
   </div>
</div>
</div>

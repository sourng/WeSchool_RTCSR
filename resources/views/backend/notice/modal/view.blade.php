<table class="table table-bordered">
	<tr>
		<td><h4>{{ $notice->heading }}</h4></td></tr>
		<tr><td class="details-td">{!! $notice->content !!}</td></tr>
		<tr><td>{{ _lang("Notice Can See Only") }} : {{ object_to_string($notice->user_type,'user_type') }}</td>
	</tr>	
</table>



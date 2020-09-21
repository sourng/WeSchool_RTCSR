<div class="panel panel-default">
<div class="panel-body">
  <table class="table table-bordered">
	 <tr><td>{{ _lang('Account Name') }}</td><td>{{ $account->account_name }}</td></tr>
	 <tr><td>{{ _lang('Opening Balance') }}</td><td>{{ get_option('currency_symbol')." ".$account->opening_balance }}</td></tr>
	 <tr><td>{{ _lang('Note') }}</td><td>{{ $account->note }}</td></tr>		
  </table>
</div>
</div>

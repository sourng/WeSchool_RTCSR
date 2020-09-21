<form method="post" class="phone_call_logs" autocomplete="off" action="{{ route('phone_call_logs.update',$phone_call_log->id) }}" enctype="multipart/form-data">
	{{ csrf_field() }}
	@method('PUT')
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Name') }}</label>	
			<input type="text" class="form-control" name="name" value="{{ $phone_call_log->name }}" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Phone') }}</label>						
			<input type="text" class="form-control" name="phone" value="{{ $phone_call_log->phone }}" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Call Type') }}</label>	
			<select name="call_type" class="form-control select2" required>
				<option value="">{{ _lang('Select Type') }}</option>
				<option {{ ($phone_call_log->call_type == 'Incoming') ? 'selected' : '' }}>Incoming</option>
				<option {{ ($phone_call_log->call_type == 'Outgoing') ? 'selected' : '' }}>Outgoing</option>
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Date') }}</label>						
			<input type="text" class="form-control datepicker" name="date" value="{{ ($phone_call_log->date) ? $phone_call_log->date : Carbon\Carbon::now()->toDateString()}}" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Start Time') }}</label>						
			<input type="text" class="form-control timepicker" name="start_time" value="{{ $phone_call_log->start_time }}">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('End Time') }}</label>						
			<input type="text" class="form-control timepicker" name="end_time" value="{{ $phone_call_log->end_time }}">
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Note') }}</label>						
			<textarea class="form-control" name="note">{{ $phone_call_log->note }}</textarea>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _lang('Update') }}</button>
		</div>
	</div>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on("submit",".phone_call_logs",function(){			 
			var link = $(this).attr("action");
			$.ajax({
				method: "POST",
				url: link,
				data:  new FormData(this),
				mimeType:"multipart/form-data",
				contentType: false,
				cache: false,
				processData:false,
				beforeSend: function(){
					
				},success: function(data){
					var json = JSON.parse(data);
					if(json['result'] == "success"){
						$("#main_modal .alert-success").html(json['message']);
						$("#main_modal .alert-success").css("display","block");
						window.setTimeout(function(){window.location = link}, 1000);
					}else{
						jQuery.each( json['message'], function( i, val ) {
							$("#main_modal .alert-danger").append("<p>"+val+"</p>");
						});
						$("#main_modal .alert-danger").css("display","block");
					}
				}
			});
			return false;
		});
	});
</script>
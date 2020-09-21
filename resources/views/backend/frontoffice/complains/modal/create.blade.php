<form method="post" class="complains" autocomplete="off" action="{{ route('complains.store') }}" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Complain Type') }}</label>						
			<select class="form-control select2" name="complain_type" required>
				<option value="">{{ _lang('Select One') }}</option>
				{{ create_option("picklists","value","value",old('complain_type'),array("type="=>"Complain")) }}	
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Source') }}</label>						
			<select class="form-control select2" name="source" required>
				<option value="">{{ _lang('Select One') }}</option>
				{{ create_option("picklists","value","value",old('source'),array("type="=>"Source")) }}	
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Complain By') }}</label>	
			<input type="text" class="form-control" name="complain_by" value="{{ old('complain_by') }}" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Phone') }}</label>						
			<input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Email') }}</label>						
			<input type="email" class="form-control" name="email" value="{{ old('email') }}">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Date') }}</label>						
			<input type="text" class="form-control datepicker" name="date" value="{{ (old('date')) ? old('date') : Carbon\Carbon::now()->toDateString() }}" required>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Taken Action') }}</label>						
			<textarea class="form-control" name="taken_action">{{ old('taken_action') }}</textarea>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Note') }}</label>						
			<textarea class="form-control" name="note">{{ old('note') }}</textarea>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Attach Document') }}</label>
			<input type="file" class="form-control dropify" name="attach_document">
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
			<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
		</div>
	</div>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on("submit",".complains",function(){			 
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
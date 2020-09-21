<form method="post" class="complains" autocomplete="off" action="{{ route('complains.update',$complain->id) }}" enctype="multipart/form-data">
	{{ csrf_field() }}
	@method('PUT')
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Complain Type') }}</label>						
			<select class="form-control select2" name="complain_type" required>
				<option value="">{{ _lang('Select One') }}</option>
				{{ create_option("picklists","value","value",$complain->complain_type,array("type="=>"Complain")) }}	
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Source') }}</label>						
			<select class="form-control select2" name="source" required>
				<option value="">{{ _lang('Select One') }}</option>
				{{ create_option("picklists","value","value",$complain->source,array("type="=>"Source")) }}	
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Complain By') }}</label>	
			<input type="text" class="form-control" name="complain_by" value="{{ $complain->complain_by }}" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Phone') }}</label>						
			<input type="text" class="form-control" name="phone" value="{{ $complain->phone }}">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Email') }}</label>						
			<input type="email" class="form-control" name="email" value="{{ $complain->email }}">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Date') }}</label>						
			<input type="text" class="form-control datepicker" name="date" value="{{ $complain->date }}" required>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Taken Action') }}</label>						
			<textarea class="form-control" name="taken_action">{{ $complain->taken_action }}</textarea>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Note') }}</label>						
			<textarea class="form-control" name="note">{{ $complain->note }}</textarea>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{_lang('Attach Document')}}</label>
			<input type="file" class="form-control" name="attach_document" value="{{ asset('public/uploads/files/complains/'.$complain->attach_document) }}">
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
<form method="post" class="admission_enquiries" autocomplete="off" action="{{route('admission_enquiries.store')}}" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('First Name') }}</label>	
			<input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Last Name') }}</label>	
			<input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Phone') }}</label>						
			<input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
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
			<label class="control-label">{{ _lang('Address') }}</label>						
			<textarea class="form-control" name="address">{{ old('address') }}</textarea>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Description') }}</label>						
			<textarea class="form-control" name="description">{{ old('description') }}</textarea>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Date') }}</label>						
			<input type="text" class="form-control datepicker" name="date" value="{{ old('date') }}" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Next Follow Up Date') }}</label>						
			<input type="text" class="form-control datepicker" name="next_follow_up_date" value="{{ old('next_follow_up_date') }}">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Reference') }}</label>						
			<select class="form-control select2" name="reference">
				<option value="">{{ _lang('Select One') }}</option>
				{{ create_option("picklists","value","value",old('reference'),array("type="=>"Reference")) }}	
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
			<label class="control-label">{{ _lang('Class') }}</label>						
			<select class="form-control select2" name="class_id">
				<option value="">{{ _lang('Select One') }}</option>
				{{ create_option('classes','id','class_name',old('class_id')) }}
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Number Of Child') }}</label>						
			<input type="number" class="form-control" name="number_of_child" value="{{ old('number_of_child') }}">
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
		$(document).on("submit",".admission_enquiries",function(){			 
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
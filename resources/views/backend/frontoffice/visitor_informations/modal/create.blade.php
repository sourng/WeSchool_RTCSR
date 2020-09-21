<form method="post" class="visitor_informations" autocomplete="off" action="{{route('visitor_informations.store')}}" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Purpose') }}</label>						
			<select class="form-control select2" name="purpose" required>
				<option value="">{{ _lang('Select One') }}</option>
				{{ create_option("picklists","value","value",old('purpose'),array("type="=>"Purpose")) }}	
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Name') }}</label>	
			<input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
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
			<label class="control-label">{{ _lang('Date') }}</label>						
			<input type="text" class="form-control datepicker" name="date" value="{{ (old('date')) ? old('date') : Carbon\Carbon::now()->toDateString()}}" required>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('In Time') }}</label>						
			<input type="text" class="form-control timepicker" name="in_time" value="{{ old('in_time') }}">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Out Time') }}</label>						
			<input type="text" class="form-control timepicker" name="out_time" value="{{ old('out_time') }}">
		</div>
	</div>
	
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Number Of Person') }}</label>						
			<input type="number" class="form-control" name="number_of_person" value="{{ old('number_of_person') }}">
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label">{{ _lang('Id Card') }}</label>						
			<input type="text" class="form-control" name="id_card" value="{{ old('id_card') }}">
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
			<button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
			<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
		</div>
	</div>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on("submit",".visitor_informations",function(){			 
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
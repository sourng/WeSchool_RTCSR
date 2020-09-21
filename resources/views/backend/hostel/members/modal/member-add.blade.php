<form method="post" autocomplete="off" action="{{route('hostelmembers.store')}}" enctype="multipart/form-data">
	{{ csrf_field() }}
	<input type="hidden" name="student_id" value="{{$id}}">
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Hostel Name') }}</label>	
			<select class="form-control select2" name="hostel_id" required>
				<option value="">{{ _lang('Select One') }}</option>
				{{ create_option("hostels","id","hostel_name",old('hostel_id'))}}	
			</select>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Standard') }}</label>	
			<select class="form-control select2" name="hostel_category_id" required>
				<option value="">{{ _lang('Select One') }}</option>	
			</select>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Hostel Fee') }}</label>						
			<input type="text" class="form-control" name="hostel_fee" value="" disabled required>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _lang('Add Member') }}</button>
		</div>
	</div>
</form>
<script type="text/javascript">
	$('document').ready(function(){
		$('select[name=hostel_id]').on('change',function(){
			var _token=$('input[name=_token]').val();
			var hostel_id = $('select[name=hostel_id]').val();
			$.ajax({
				type: "POST",
				url: "{{url('hostelmembers/standard')}}",
				data:{_token:_token,hostel_id:hostel_id},
				success: function(data){
					$('select[name=hostel_category_id]').html(data);							
				}
			});
		});
		$('select[name=hostel_category_id]').on('change',function(){
			var _token=$('input[name=_token]').val();
			var hostel_category_id = $('select[name=hostel_category_id]').val();
			$.ajax({
				type: "POST",
				url: "{{url('hostelmembers/hostel_fee')}}",
				data:{_token:_token,hostel_category_id:hostel_category_id},
				success: function(data){
					$('input[name=hostel_fee]').val(data);										
				}
			});
		});
	});
</script>

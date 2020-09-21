@extends('layouts.backend')

@section('content')
<div class="row">
<form method="post" class="validate" autocomplete="off" action="{{url('invoices')}}" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	<div class="col-md-8">
	<div class="panel panel-default">
	<div class="panel-heading panel-title">{{ _lang('Add New Invoice') }}</div>

		<div class="panel-body">  	
			<div class="col-md-6">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Class') }}</label>						
				<select name="class_id" id="class_id" class="form-control select2" onchange="getSection();" required>
					<option value="">{{_lang('Select One') }}</option>
					{{ create_option('classes','id','class_name',old('class_id')) }}
				</select>
			  </div>
			</div>

			<div class="col-md-6">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Section') }}</label>						
				<select name="section_id" id="section_id" onchange="get_students();" class="form-control select2" required>
					<option value="">{{_lang('Select One') }}</option>
				</select>
			  </div>
			</div>
			
			<div class="col-md-6">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Select Student') }}</label>						
				<select name="student_id" id="student_id" class="form-control select2" onchange="get_all_students();" required>
					<option value="">{{_lang('Select One') }}</option>
				</select>
			  </div>
			</div>


			<div class="col-md-6">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Due Date') }}</label>						
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
					<input type="text" class="form-control datepicker" name="due_date" value="{{ old('due_date') }}" required>
				</div>
			  </div>
			</div>

			<div class="col-md-12">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Title') }}</label>						
				<input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
			  </div>
			</div>

			<div class="col-md-12">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Description') }}</label>						
				<textarea class="form-control" name="description">{{ old('description') }}</textarea>
			  </div>
			</div>

			<div class="col-md-6">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Status') }}</label>						
				<select class="form-control niceselect wide" name="status">
				  <option>{{ _lang('Unpaid') }}</option>
				  <option>{{ _lang('Paid') }}</option>
				</select>
			  </div>
			</div>
			
			<div class="col-md-6">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Total') }}</label>						
				<input type="text" class="form-control" id="total" name="total" value="{{ old('total') }}" readOnly="true" required>
			  </div>
			</div>

		</div>
	  </div>
	</div>
 
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">{{ _lang('Student List') }}</div>
			<div class="panel-body" id="student_list">    
			</div>
		</div>	
	</div>
	
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span>{{ _lang('Invoice Items') }}</span>
				<button type="button" class="btn btn-danger pull-right" id="add-item-row" style="margin-top:-7px;margin-left:10px;">{{ _lang('Add New Row') }}</button>
			    <button type="submit" class="btn btn-primary pull-right" style="margin-top:-7px;">{{ _lang('Save Invoice') }}</button>
			</div>

			<div class="panel-body">
			    
			  <table class="table">
				<thead style="background:#dce9f9;">
					<th>{{ _lang('Fee Type') }}</th>
					<th style="text-align:left">{{ _lang('Amount')." ".get_option('currency_symbol') }}</th>
					<th style="text-align:left">{{ _lang('Discount')." ".get_option('currency_symbol') }}</th>
					<th style="text-align:left">{{ _lang('Total')." ".get_option('currency_symbol') }}</th>		  
				</thead>
				<tbody id="invoice">		  
				   <tr>
				     <td width="40%">{!! get_fee_selectbox('select2') !!}</td>
				     <td><input type="text" class="form-control float-field amount" name="amount[]"value="0" required></td>
				     <td><input type="text" class="form-control float-field discount" name="discount[]"value="0" required></td>
				     <td><input type="text" class="form-control float-field total" name="sub_total[]"value="0" readOnly="true" required></td>
				   </tr>
				</tbody>
			  </table>
			  
			</div>
			
		</div>
	</div>
 
</form>

<table style="display:none;">
	<tr id="fee_row">
	   <td width="40%">{!! get_fee_selectbox() !!}</td>
	   <td><input type="text" value="0" class="form-control float-field amount" name="amount[]" required></td>
	   <td><input type="text" value="0" class="form-control float-field discount" name="discount[]" required></td>
	   <td><input type="text" value="0" class="form-control float-field total" name="sub_total[]" readOnly="true" required></td>
	</tr>
</table>
 
</div>
@endsection

@section('js-script')
<script type="text/javascript">

	function getSection() {
		var _token=$('input[name=_token]').val();
		var class_id=$('select[name=class_id]').val();
		$.ajax({
			type: "POST",
			url: "{{ url('sections/section') }}",
			data:{_token:_token,class_id:class_id},
			beforeSend: function(){
			    $("#preloader").css("display","block");
			},success: function(data){
				$("#preloader").css("display","none");
				$('select[name=section_id]').html(data);				
			}
		});
	}
	
	
	function get_students(){		
		var class_id = "/"+$('select[name=class_id]').val();
		var section_id = "/"+$('select[name=section_id]').val();
		var link = "{{ url('students/get_students') }}"+class_id+section_id;
		$.ajax({
			url: link,
			beforeSend: function(){
			    $("#preloader").css("display","block");
			},success: function(data){
				$("#preloader").css("display","none");
				var json =JSON.parse(data);
				   $('select[name=student_id]').html("");
				   $('#student_list').html(""); 
				   
				jQuery.each( json, function( i, val ) {
				   $('select[name=student_id]').append("<option value='"+val['id']+"'>"+val['roll']+" - "+val['first_name']+" "+val['last_name']+"</option>");
				});

				if( $('#student_id').has('option').length > 0 ) {
					$('select[name=student_id]').prepend("<option value='all'>{{ _lang('All Student') }}</option>");
				}				
			}
		});
	}
	
	function get_all_students(){
		if($("#student_id").val()=="all"){		
			var class_id = "/"+$('select[name=class_id]').val();
			var section_id = "/"+$('select[name=section_id]').val();
			var link = "{{ url('students/get_students') }}"+class_id+section_id;
			$.ajax({
				url: link,
				beforeSend: function(){
					$("#preloader").css("display","block");
				},success: function(data){
					$("#preloader").css("display","none");
					var json =JSON.parse(data);
					$('#student_list').html(""); 
					
					jQuery.each( json, function( i, val ) {
					   $('#student_list')
					   .append('<div class="col-md-12">'+
									'<label class="c-container">'+
									   '<input type="checkbox" value="'+val['id']+'" name="students[]" checked="true">'+val['roll']+" - "+val['first_name']+" "+val['last_name']+
									   '<span class="checkmark"></span>'+
									'</label>'+
								'</div>');
					});
	
				}
			});
		}else{
		  $('#student_list').html("");
		}
	}
	
	$(document).on('click','#add-item-row',function(){
		var row = $("#fee_row").clone();		
		$(row).removeAttr( "id" );		
		$(row).find('select').select2();		
		$("#invoice").append(row);		
	});
	
	$(document).on('keyup','.amount,.discount',function(){
		var amount = parseFloat($(this).closest("tr").find(".amount").val());
		var discount = parseFloat($(this).closest("tr").find(".discount").val());
		$(this).closest("tr").find(".total").val(amount-discount);
        
		//Show Total Amount
		var total = 0;
		jQuery("#invoice > tr").each(function () {
		    var sub_total = parseFloat($(this).find(".total").val());
			total +=sub_total;
		});	

        $("#total").val(total);		
	});
	
		
</script>
@stop


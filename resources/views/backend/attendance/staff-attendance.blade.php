@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					{{_lang('Staff Attendance')}}
				</div>
			</div>
			<div class="panel-body">
				<form id="search_form" class="params-panel validate" action="{{ url('staff/attendance') }}" method="post" autocomplete="off" accept-charset="utf-8">
					@csrf
					<div class="col-sm-4">
						<div class="form-group">
							<label class="control-label">{{ _lang('Role') }}</label>
							<select name="user_type" class="form-control select2" required>
								<option value="">{{ _lang('Select One') }}</option>
								<option @if($user_type=='Admin') selected @endif value="Admin">{{ _lang('Admin') }}</option>
								<option @if($user_type=='Teacher') selected @endif value="Teacher">{{ _lang('Teacher') }}</option>
								<option @if($user_type=='Accountant') selected @endif value="Accountant">{{ _lang('Accountant') }}</option>
								<option @if($user_type=='Librarian') selected @endif value="Librarian">{{ _lang('Librarian') }}</option>
								<option @if($user_type=='Employee') selected @endif value="Employee">{{ _lang('Employee') }}</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label for="date" class="control-label">{{ _lang('Date') }}</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								<input type="text" class="form-control datepicker" name="date" value="{{ $date }}" required>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<button type="submit" style="margin-top:24px;" class="btn btn-primary btn-block rect-btn">{{_lang('Manage Attendance')}}</button>
						</div>
					</div>
				</form>
				@if( !empty($attendance) )
				<div class="col-md-12">	
					<div class="panel-heading text-center">
						<div class="panel-title" >
							{{ _lang('Attendance Details') }}<br>
							{{ date('d-M-Y', strtotime($date)) }}<br>
						</div>
					</div>
					<form action="{{url('staff/attendance/save')}}" class="appsvan-submit-validate" method="post" accept-charset="utf-8">
						@csrf
						<table class="table table-bordered">
							<thead>
								<th class="col-md-2">{{_lang('Name')}}</th>
								<th class="col-md-1">
									<label class="c-container">{{_lang('Present')}}
										<input type="checkbox" id="present_all" onclick="present(this)">
										<span class="checkmark"></span>
									</label>
								</th>
								<th class="col-md-1">
									<label class="c-container">{{_lang('Absent')}}
										<input type="checkbox" id="absent_all" onclick="absent(this)">
										<span class="checkmark"></span>
									</label>
								</th>
								<th class="col-md-1">
									<label class="c-container">{{_lang('Late')}}
										<input type="checkbox" id="late_all" onclick="late(this)">
										<span class="checkmark"></span>
									</label>
								</th>
								<th class="col-md-1">
									<label class="c-container">{{_lang('Holiday')}}
										<input type="checkbox" id="holiday_all" onclick="holiday(this)">
										<span class="checkmark"></span>
									</label>
								</th>
								<th class="col-md-1">{{_lang('Leave')}}</th>
								<th class="col-md-2">{{_lang('Leave Type')}}</th>
							</thead>
							<tbody>
								@foreach($attendance AS $key => $data)
								<tr>
									<td>{{$data->name}}</td>
									<input type="hidden" name="date" value="{{$date}}">
									<input type="hidden" name="attendance_id[]" value="{{ $data->attendance_id }}">
									<input type="hidden" name="user_id[]" value="{{ $data->user_id }}">
									<td>
										<label class="c-container">
											<input type="checkbox" name="attendance[{{$key}}][]" @if($data->attendance=='1') checked @endif value="1" class="present">
											<span class="checkmark"></span>
										</label>
									</td>
									<td>
										<label class="c-container">
											<input type="checkbox" name="attendance[{{$key}}][]" @if($data->attendance=='2') checked @endif value="2" class="absent">
											<span class="checkmark"></span>
										</label>
									</td>
									<td>
										<label class="c-container">
											<input type="checkbox" name="attendance[{{$key}}][]" @if($data->attendance=='3') checked @endif value="3" class="late">
											<span class="checkmark"></span>
										</label>
									</td>
									<td>
										<label class="c-container">
											<input type="checkbox" name="attendance[{{$key}}][]" @if($data->attendance=='4') checked @endif value="4" class="holiday">
											<span class="checkmark"></span>
										</label>
									</td>
									<td>
										<label class="c-container">
											<input type="checkbox" name="attendance[{{$key}}][]" @if($data->attendance=='5') checked @endif value="5" class="leave">
											<span class="checkmark"></span>
										</label>
									</td>
									<td>
										<div class="form-group leave_type" @if($data->attendance != '5')style="display: none;" @endif>
											<select class="form-control select2" name="leave_type_id[]" required>
												{{ create_leave_option($data->leave_type_id) }}
											</select>
										</div>
									</td>
								</tr>
								@endforeach
								<tr>
									<td colspan="100"><button type="submit" class="btn btn-primary pull-right">{{_lang('Save Attendance')}}</button></td>
								</tr>
							</tbody>
						</table>
					</form>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection

@section('js-script')
<script type="text/javascript">
	$("input:checkbox").on('click', function() {
		var $box = $(this);
		if ($box.is(":checked")) {
			var group = "input:checkbox[name='" + $box.attr("name") + "']";
			$(group).prop("checked", false);
			$box.prop("checked", true);
		} else {
			$box.prop("checked", false);
		}
	});
	$('.leave').on('click', function(){
		var box = $(this);
		if(box.is(':checked')){
			$(this).parent().parent().parent().find('.leave_type').css('display', 'unset');
		}else{
			$(this).parent().parent().parent().find('.leave_type').css('display', 'none');
		}
	});
	$('.absent,.late,.present,.holiday').on('click', function(){
		var box = $(this);
		if(box.is(':checked')){
			$(this).parent().parent().parent().find('.leave_type').css('display', 'none');
		}
	});

	function present(source) {
		$(".absent,.late,.present,.holiday,#late_all,#absent_all,#leave_all,#holiday_all").prop("checked",false);
		var ignore = document.querySelectorAll('.leave');
		var checkboxes = document.querySelectorAll('.present');
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i] != source && !$(ignore[i]).is(":checked")   )
				checkboxes[i].checked = source.checked;
		}
	}
	function absent(source) {
		$(".absent,.late,.present,.holiday,#present_all,#late_all,#leave_all,#holiday_all").prop("checked",false);
		var ignore = document.querySelectorAll('.leave');
		var checkboxes = document.querySelectorAll('.absent');
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i] != source && !$(ignore[i]).is(":checked")   )
				checkboxes[i].checked = source.checked;
		}
	}
	function late(source) {
		$(".absent,.late,.present,.holiday,#present_all,#absent_all,#leave_all,#holiday_all").prop("checked",false);
		var ignore = document.querySelectorAll('.leave');
		var checkboxes = document.querySelectorAll('.late');
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i] != source && !$(ignore[i]).is(":checked")   )
				checkboxes[i].checked = source.checked;
		}
	}
	function holiday(source) {
		$(".absent,.late,.present,.holiday,#present_all,#late_all,#absent_all,#leave_all").prop("checked",false);
		var ignore = document.querySelectorAll('.leave');
		var checkboxes = document.querySelectorAll('.holiday');
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i] != source && !$(ignore[i]).is(":checked")   )
				checkboxes[i].checked = source.checked;
		}
	}
</script>
@stop
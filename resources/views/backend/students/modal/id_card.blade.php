<div id="id_card">
	<div class="card_header">
		<h5>{{ get_option('school_name')}}</h5>
		<p>{{ _lang('STUDENT IDENTITY CARD') }}</p>
	</div>
	<div class="image">
		<img src="{{ asset('public/uploads/images/'.$student->image) }}">
	    <p><span>{{ $student->first_name." ".$student->last_name }}</span></p>
	</div>
	<div class="id-card">
		<p>
			<span class="lbl">{{ _lang('Class') }} :</span>	
			<span>{{ $student->class_name }}</span>
		</p>
		
		<p>
			<span class="lbl">{{ _lang('Section') }} :</span>	
			<span>{{ $student->section_name }}</span>
		</p>
		
		<p>
			<span class="lbl">{{ _lang('Roll No') }} :</span>	
			<span>{{ $student->roll }}</span>
		</p>
		<p>
			<span class="lbl">{{ _lang('Reg No') }} :</span>	
			<span>{{ $student->register_no }}</span>
		</p>
		<p>
			<span class="lbl">{{ _lang('Academic Year') }} :</span>	
			<span>{{ get_academic_year() }}</span>
		</p>
	</div>
	
	<div class="card_footer">	
		<p>{{ _lang('Emergency Contact') }} : {{ get_option('phone') }}</p>
	</div>

</div>

<p>&nbsp;</p>
<div class="col-md-4 col-md-offset-4">
	<button type="button" class="btn btn-primary btn-block print" data-print="id_card">{{ _lang('Print Card') }}</button>
</div>
@if (has_permission('frontoffice.main_screen',Auth::User()->role_id))	
	<li @if((Request::is('frontoffice'))OR(Request::is('frontoffice/*'))) class="active" @endif>
		<a href="{{url('frontoffice')}}">
			<i class="fa fa-building-o"></i>
			{{ _lang('Front Office') }}
		</a>
	</li>
@endif


<li>
	<a href="#"><i class="fa fa-user-o"></i>{{ _lang('Profile') }}</a>
		<ul>
			<li>
				<a href="{{ url('profile/my_profile')}}">
				{{ _lang('Profile') }}
				</a>
			</li>
			<li>
				<a href="{{ url('profile/edit')}}">
				{{ _lang('Update Profile') }}
				</a>
			</li>
			
			<li>
				<a href="{{ url('profile/edit')}}">
				{{ _lang('Family Profile') }}
				</a>
			</li>
			<li>
				<a href="{{ url('profile/edit')}}">
				{{ _lang('Working Histories') }}
				</a>
			</li>
			
			<li>
				<a href="{{ url('profile/edit')}}">
				{{ _lang('Study History') }}
				</a>
			</li>
			<li>
				<a href="{{ url('profile/edit')}}">
				{{ _lang('Skills') }}
				</a>
			</li>
			
			<li>
				<a href="{{ url('profile/edit')}}">
				{{ _lang('Speak Language') }}
				</a>
			</li>
			
			<li>
				<a href="{{ url('profile/changepassword') }}">
				{{ _lang('Change Password') }}
				</a>
			</li>
			<li>
				<a class="dropdown-item" href="{{ route('logout') }}"
				onclick="event.preventDefault();
				document.getElementById('logout-form2').submit();">
				{{ __('Logout') }}
			</a>
		</li>
		<form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
			@csrf
		</form>
	</ul>
</li>



<li>   
	<a href="#"><i class="fa fa-address-card"></i>{{ _lang('Students') }}</a>
	<ul class="new">
		@if (has_permission('students.index',Auth::User()->role_id))	
			<li @if((Request::is('students'))OR(Request::is('students/create'))OR(Request::is('students/edit'))) class="active" @endif>
				<a href="{{ route('students.index') }}">
					{{ _lang('Students') }}
				</a>
			</li>
		@endif
		
		@if (has_permission('students.promote',Auth::User()->role_id))
		<li @if(Request::is('students/promote')) class="active" @endif>
			<a href="{{ url('students/promote') }}">
				{{ _lang('Promote Students') }}
			</a>
		</li>
		@endif
	</ul>
</li>

@if (has_permission('Parents.index',Auth::User()->role_id))
<li @if((Request::is('parents'))OR(Request::is('parents/*'))) class="active" @endif>
	<a href="{{route('parents.index')}}">
		<i class="fa fa-user-circle-o"></i>
		{{ _lang('Parents') }}
	</a>
</li>
@endif

@if (has_permission('teachers.index',Auth::User()->role_id))
<li @if((Request::is('teachers'))OR(Request::is('teachers/*'))) class="active" @endif>
	<a href="{{route('teachers.index')}}">
		<i class="fa fa-address-book"></i>
		{{ _lang('Teachers') }}
	</a>
</li>
@endif

<li>   
	<a href="#"><i class="fa fa-building-o"></i>{{ _lang('Academic') }}</a>
	<ul>
		@if (has_permission('class.index',Auth::User()->role_id))
		<li @if((Request::is('class'))OR(Request::is('class/*'))) class="active" @endif>
			<a href="{{route('class.index')}}">
				{{ _lang('Class') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('sections.index',Auth::User()->role_id))
		<li @if((Request::is('sections'))OR(Request::is('sections/*'))) class="active" @endif>
			<a href="{{route('sections.index')}}">
				{{ _lang('Sections') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('subjects.index',Auth::User()->role_id))
		<li @if((Request::is('subjects'))OR(Request::is('subjects/*'))) class="active" @endif>
			<a href="{{route('subjects.index')}}">
				{{ _lang('Subjects') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('assignsubjects.index',Auth::User()->role_id))
		<li @if((Request::is('assignsubjects'))OR(Request::is('assignsubjects/*'))) class="active" @endif>
			<a href="{{route('assignsubjects.index')}}">
				{{ _lang('Assign Subjects') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('syllabus.index',Auth::User()->role_id))
		<li @if((Request::is('syllabus'))OR(Request::is('syllabus/*'))) class="active" @endif>
			<a href="{{route('syllabus.index')}}">
				{{ _lang('Syllabus') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('assignments.index',Auth::User()->role_id))
		<li @if((Request::is('assignments'))OR(Request::is('assignments/*'))) class="active" @endif>
			<a href="{{route('assignments.index')}}">
				{{ _lang('Assignments') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('class_routines.index',Auth::User()->role_id))
		<li @if((Request::is('class_routines'))) class="active" @endif>
			<a href="{{url('class_routines')}}">
				{{ _lang('Class Routine') }}
			</a>
		</li>
		@endif
	</ul>
 </li> 
 
 <li>   
	<a href="#"><i class="fa fa-calendar-check-o"></i>Attendance</a>
	<ul>
	   @if (has_permission('student_attendance.create',Auth::User()->role_id))
	   <li @if((Request::is('student'))OR(Request::is('student/*'))) class="active" @endif>
			<a href="{{url('student/attendance')}}">
				{{ _lang('Student Attendance') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('staff_attendance.create',Auth::User()->role_id))
		<li @if((Request::is('staff'))OR(Request::is('staff/*'))) class="active" @endif>
			<a href="{{url('staff/attendance')}}">
				{{ _lang('Staff Attendance') }}
			</a>
		</li>
		@endif
	</ul>
 </li>
 
 <li>   
	<a href="#"><i class="fa fa-university"></i>{{ _lang('Bank / Cash Account') }}</a>
	<ul>
	   @if (has_permission('accounts.index',Auth::User()->role_id))
	   <li @if(Request::is('accounts')) class="active" @endif>
			<a href="{{url('accounts')}}">
				{{ _lang('Accounts') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('accounts.create',Auth::User()->role_id))
		<li @if(Request::is('accounts/create')) class="active" @endif>
			<a href="{{url('accounts/create')}}">
				{{ _lang('Add New') }}
			</a>
		</li>
		@endif
	</ul>
 </li>
 
 <li>   
	<a href="#"><i class="fa fa-money"></i>{{ _lang('Transaction') }}</a>
	<ul>
	   @if (has_permission('transactions.manage_income',Auth::User()->role_id))
	   <li @if(Request::is('transactions/income')) class="active" @endif>
			<a href="{{ url('transactions/income') }}">
				{{ _lang('Income') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('transactions.manage_expense',Auth::User()->role_id))
	   <li @if(Request::is('transactions/expense')) class="active" @endif>
			<a href="{{ url('transactions/expense') }}">
				{{ _lang('Expense') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('chart_of_accounts.index',Auth::User()->role_id))
	   <li @if(Request::is('chart_of_accounts')) class="active" @endif>
			<a href="{{ url('chart_of_accounts') }}">
				{{ _lang('Chart Of Accounts') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('payment_methods.index',Auth::User()->role_id))
	   <li @if(Request::is('payment_methods')) class="active" @endif>
			<a href="{{ url('payment_methods') }}">
				{{ _lang('Payment Methods') }}
			</a>
	   </li>
	   @endif
	   
	   
	   @if (has_permission('payee_payers.index',Auth::User()->role_id))
	   <li @if(Request::is('payee_payers')) class="active" @endif>
			<a href="{{ url('payee_payers') }}">
				{{ _lang('Payee & Payers') }}
			</a>
	   </li>
	   @endif
	</ul>
 </li>
 
 <li>   
	<a href="#"><i class="fa fa-credit-card"></i>{{ _lang('Student Fees') }}</a>
	<ul>
	   @if (has_permission('fee_types.index',Auth::User()->role_id))
	   <li @if(Request::is('fee_types')) class="active" @endif>
			<a href="{{url('fee_types')}}">
				{{ _lang('Fees Type') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('invoices.create',Auth::User()->role_id))
	   <li @if(Request::is('invoices/create')) class="active" @endif>
			<a href="{{url('invoices/create')}}">
				{{ _lang('Generate Invoice') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('invoices.index',Auth::User()->role_id))
	   <li @if(Request::is('invoices')) class="active" @endif>
			<a href="{{url('invoices')}}">
				{{ _lang('Student Invoices') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('student_payments.index',Auth::User()->role_id))
	   <li @if(Request::is('student_payments')) class="active" @endif>
			<a href="{{url('student_payments')}}">
				{{ _lang('Payment History') }}
			</a>
	   </li>
	   @endif
								  
	</ul>
 </li>
 
 <li>   
	<a href="#"><i class="fa fa-book"></i>{{ _lang('Library') }}</a>
	<ul>
	
	   @if (has_permission('librarymembers.index',Auth::User()->role_id))
	   <li @if((Request::is('librarymembers'))OR(Request::is('librarymembers/*'))) class="active" @endif>
			<a href="{{url('librarymembers')}}">
				{{ _lang('Members') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('books.index',Auth::User()->role_id))
		<li @if((Request::is('books'))OR(Request::is('books/*'))) class="active" @endif>
			<a href="{{url('books')}}">
				{{ _lang('Books') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('bookcategories.index',Auth::User()->role_id))
		<li @if((Request::is('bookcategories'))OR(Request::is('bookcategories/*'))) class="active" @endif>
			<a href="{{url('bookcategories')}}">
				{{ _lang('Book Categories') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('bookissues.index',Auth::User()->role_id))
		<li @if((Request::is('bookissues'))OR(Request::is('bookissues/list'))OR(Request::is('bookissues/list/*'))OR(Request::is('bookissues/*/edit'))) class="active" @endif>
			<a href="{{url('bookissues')}}">
				{{ _lang('Issues') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('bookissues.create',Auth::User()->role_id))
		<li @if((Request::is('bookissues/create'))) class="active" @endif>
			<a href="{{url('bookissues/create')}}">
				{{ _lang('Add Issues') }}
			</a>
		</li>
		@endif
	</ul>
 </li>
 <li>   
	<a href="#"><i class="fa fa-car"></i>{{ _lang('Transport') }}</a>
	<ul>
	   @if (has_permission('transportvehicles.index',Auth::User()->role_id))
	   <li @if((Request::is('transportvehicles'))OR(Request::is('transportvehicles/*'))) class="active" @endif>
			<a href="{{url('transportvehicles')}}">
				{{ _lang('Vehicles') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('transports.index',Auth::User()->role_id))
		<li @if((Request::is('transports'))OR(Request::is('transports/*'))) class="active" @endif>
			<a href="{{url('transports')}}">
				{{ _lang('Transports') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('transportmembers.index',Auth::User()->role_id))
		<li @if((Request::is('transportmembers'))OR(Request::is('transportmembers/*'))) class="active" @endif>
			<a href="{{url('transportmembers')}}">
				{{ _lang('Members') }}
			</a>
		</li>
		@endif
	</ul>
 </li>
 <li>   
	<a href="#"><i class="fa fa-building-o"></i>{{ _lang('Hostel') }}</a>
	<ul>
	   @if (has_permission('hostels.index',Auth::User()->role_id))
	   <li @if((Request::is('hostels'))OR(Request::is('hostels/*'))) class="active" @endif>
			<a href="{{url('hostels')}}">
				{{ _lang('Hostel') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('hostelcategories.index',Auth::User()->role_id))
		<li @if((Request::is('hostelcategories'))OR(Request::is('hostelcategories/*'))) class="active" @endif>
			<a href="{{url('hostelcategories')}}">
				{{ _lang('Categories') }}
			</a>
		</li>
		@endif
		
		
		@if (has_permission('hostelmembers.index',Auth::User()->role_id))
		<li @if((Request::is('hostelmembers'))OR(Request::is('hostelmembers/*'))) class="active" @endif>
			<a href="{{url('hostelmembers')}}">
				{{ _lang('Members') }}
			</a>
		</li>
		@endif
	</ul>
 </li>
 
 <li>   
	<a href="#"><i class="fa fa-newspaper-o"></i>{{ _lang('Examinations') }}</a>
	<ul>
	   @if (has_permission('exams.index',Auth::User()->role_id))
	   <li @if(Request::is('exams')) class="active" @endif>
			<a href="{{url('exams')}}">
				{{ _lang('Exam List') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('exams.store_exam_schedule',Auth::User()->role_id))
	   <li @if(Request::is('exams/schedule/create')) class="active" @endif>
			<a href="{{url('exams/schedule/create')}}">
				{{ _lang('Exam Schedule') }}
			</a>
	   </li>
	   @endif
	   
	   
	   @if (has_permission('exams.view_schedule',Auth::User()->role_id))
	   <li @if(Request::is('exams/schedule')) class="active" @endif>
			<a href="{{url('exams/schedule')}}">
				{{ _lang('Exam Routine') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('exams.store_exam_attendance',Auth::User()->role_id))
	   <li @if(Request::is('exams/attendance')) class="active" @endif>
			<a href="{{url('exams/attendance')}}">
				{{ _lang('Exam Attendance') }}
			</a>
	   </li>
	   @endif
	   
	</ul>
 </li>
 
 
 <li>   
	<a href="#"><i class="fa fa-balance-scale"></i>{{ _lang('Marks') }}</a>
	<ul>
	   @if (has_permission('marks.index',Auth::User()->role_id))
	   <li @if(Request::is('marks')) class="active" @endif>
			<a href="{{ url('marks') }}">
				{{ _lang('Marks') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('marks.view_student_rank',Auth::User()->role_id))
	   <li @if(Request::is('marks/rank')) class="active" @endif>
			<a href="{{ url('marks/rank') }}">
				{{ _lang('Student Rank') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('marks.create',Auth::User()->role_id))
	   <li @if(Request::is('marks/create')) class="active" @endif>
			<a href="{{ url('marks/create') }}">
				{{ _lang('Mark Register') }}
			</a>
	   </li>
	   @endif
	   
	   
	   @if (has_permission('grades.index',Auth::User()->role_id))
	   <li @if(Request::is('grades')) class="active" @endif>
			<a href="{{ url('grades') }}">
				{{ _lang('Grade Setup') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('mark_distributions.index',Auth::User()->role_id))
	   <li @if(Request::is('mark_distributions')) class="active" @endif>
			<a href="{{ url('mark_distributions') }}">
				{{ _lang('Mark Distribution') }}
			</a>
	   </li>
	   @endif
	   
	</ul>
 </li>
 
 <li>   
	<a href="#"><i class="fa fa fa-briefcase"></i>{{ _lang('HRM') }}</a>
	<ul>
	    @if (has_permission('employees.index',Auth::User()->role_id))
		<li @if(Request::is('employees') || Request::is('employees/*')) class="active" @endif>
			<a href="{{ url('employees') }}">
				{{ _lang('Employees') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('departments.index',Auth::User()->role_id))
		<li @if(Request::is('departments') || Request::is('departments/*')) class="active" @endif>
			<a href="{{ url('departments') }}">
				{{ _lang('Departments') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('leave_types.index',Auth::User()->role_id))
		<li @if(Request::is('leave_types') || Request::is('leave_types/*')) class="active" @endif>
			<a href="{{ url('leave_types') }}">
				{{ _lang('Leave Types') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('leave_applications.index',Auth::User()->role_id))
		<li @if(Request::is('leave_applications') || Request::is('leave_applications/*')) class="active" @endif>
			<a href="{{ url('leave_applications') }}">
				{{ _lang('Leave Applications') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('types_of_awards.index',Auth::User()->role_id))
		<li @if(Request::is('types_of_awards') || Request::is('types_of_awards/*')) class="active" @endif>
			<a href="{{ url('types_of_awards') }}">
				{{ _lang('Types Of Awards') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('awards.index',Auth::User()->role_id))
		<li @if(Request::is('awards') || Request::is('awards/*')) class="active" @endif>
			<a href="{{ url('awards') }}">
				{{ _lang('Awards Giving') }}
			</a>
		</li>
		@endif
	</ul>
</li>
<li>   
	<a href="#"><i class="fa fa fa-bitcoin"></i>{{ _lang('Payroll') }}</a>
	<ul>
	    @if (has_permission('expenses.index',Auth::User()->role_id))
		<li @if(Request::is('expenses') || Request::is('expenses/*')) class="active" @endif>
			<a href="{{ url('expenses') }}">
				{{ _lang('Expenses') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('payslips.create',Auth::User()->role_id))
		<li @if(Request::is('payslips/create') || Request::is('payslips')) class="active" @endif>
			<a href="{{ url('payslips/create') }}">
				{{ _lang('Generate Payslip') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('payslips.payment',Auth::User()->role_id))
		<li @if(Request::is('payslips/make_payment')) class="active" @endif>
			<a href="{{ url('payslips/make_payment') }}">
				{{ _lang('Make Payment') }}
			</a>
		</li>
		@endif
		
		@if (has_permission('payslips.index',Auth::User()->role_id))
		<li @if(Request::is('manage_payslips')) class="active" @endif>
			<a href="{{ url('manage_payslips') }}">
				{{ _lang('Manage Payslips') }}
			</a>
		</li>
		@endif
	</ul>
</li>
 
 <li>   
	<a href="#"><i class="fa fa-envelope-open"></i>{{ _lang('Message') }} {!! count_inbox() > 0 ? '<span class="label label-danger inbox-count">'.count_inbox().'</span>' : '' !!}</a>
	<ul>	   
	   <li @if(Request::is('message/compose')) class="active" @endif>
			<a href="{{ url('message/compose') }}">
				{{ _lang('New Message') }}
			</a>
	   </li>
	   
	   <li @if(Request::is('message/inbox')) class="active" @endif>
			<a href="{{ url('message/inbox') }}">
				{{ _lang('Inbox Items') }}
			</a>
	   </li>
	        
	   <li @if(Request::is('message/outbox')) class="active" @endif>
			<a href="{{ url('message/outbox') }}">
				{{ _lang('Send Items') }}
			</a>
	   </li>
	   
	</ul>
 </li>
 
  <li>   
	<a href="#"><i class="fa fa-envelope-o"></i>{{ _lang('Email & SMS') }}</a>
	<ul>
	   @if (has_permission('email.compose',Auth::User()->role_id))
	   <li @if(Request::is('email/compose')) class="active" @endif>
			<a href="{{ url('email/compose') }}">
				{{ _lang('Send Email') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('email.view_logs',Auth::User()->role_id))
	   <li @if(Request::is('email/logs')) class="active" @endif>
			<a href="{{ url('email/logs') }}">
				{{ _lang('Email Log') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('sms.compose',Auth::User()->role_id))
	   <li @if(Request::is('sms/compose')) class="active" @endif>
			<a href="{{ url('sms/compose') }}">
				{{ _lang('Send SMS') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('sms.view_logs',Auth::User()->role_id))
	   <li @if(Request::is('sms/logs')) class="active" @endif>
			<a href="{{ url('sms/logs') }}">
				{{ _lang('SMS Log') }}
			</a>
	   </li>
	   @endif
	</ul>
 </li>
 
<li>   
	<a href="#"><i class="fa fa-calendar"></i>{{ _lang('Notice') }}</a>
	<ul>
	   @if (has_permission('notices.index',Auth::User()->role_id))
	   <li @if(Request::is('notices')) class="active" @endif>
			<a href="{{ route('notices.index') }}">
				{{ _lang('All Notice') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('notices.create',Auth::User()->role_id))
	   <li @if(Request::is('notices/create')) class="active" @endif>
			<a href="{{ route('notices.create') }}">
				{{ _lang('New Notice') }}
			</a>
	   </li>
	   @endif
	</ul>
 </li>
 
 <li>   
	<a href="#"><i class="fa fa-newspaper-o"></i>{{ _lang('Events') }}</a>
	<ul>
	   @if (has_permission('events.index',Auth::User()->role_id))
	   <li @if(Request::is('events')) class="active" @endif>
			<a href="{{ route('events.index') }}">
				{{ _lang('All Events') }}
			</a>
	   </li>
	   @endif
		  
	   @if (has_permission('events.create',Auth::User()->role_id))  
	   <li @if(Request::is('events/create')) class="active" @endif>
			<a href="{{ route('events.create') }}">
				{{ _lang('Add New Event') }}
			</a>
	   </li>
	   @endif
	</ul>
 </li>
 
 <li>   
	<a href="#"><i class="fa fa-bar-chart"></i>{{ _lang('Reports') }}</a>
	<ul>
	   @if (has_permission('reports.student_attendance_report',Auth::User()->role_id))
	   <li @if(Request::is('reports/student_attendance_report') || Request::is('reports/student_attendance_report/view')) class="active" @endif>
			<a href="{{ url('reports/student_attendance_report') }}">
				{{ _lang('Student Attendance') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('reports.staff_attendance_report',Auth::User()->role_id))
	   <li @if(Request::is('reports/staff_attendance_report') || Request::is('reports/staff_attendance_report/view')) class="active" @endif>
			<a href="{{ url('reports/staff_attendance_report') }}">
				{{ _lang('Staff Attendance') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('reports.student_id_card',Auth::User()->role_id))
	   <li @if(Request::is('reports/student_id_card') || Request::is('reports/student_id_card/view')) class="active" @endif>
			<a href="{{ url('reports/student_id_card') }}">
				{{ _lang('Student ID Card') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('reports.exam_report',Auth::User()->role_id))
	   <li @if(Request::is('reports/exam_report') || Request::is('reports/exam_report/view')) class="active" @endif>
			<a href="{{ url('reports/exam_report') }}">
				{{ _lang('Exam Report') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('reports.progress_card',Auth::User()->role_id))
	   <li @if(Request::is('reports/progress_card') || Request::is('reports/progress_card/view')) class="active" @endif>
			<a href="{{ url('reports/progress_card') }}">
				{{ _lang('Progress Card') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('reports.class_routine',Auth::User()->role_id))
	   <li @if(Request::is('reports/class_routine') || Request::is('reports/class_routine/view')) class="active" @endif>
			<a href="{{ url('reports/class_routine') }}">
				{{ _lang('Class Routine') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('reports.exam_routine',Auth::User()->role_id))
	   <li @if(Request::is('reports/exam_routine') || Request::is('reports/exam_routine/view')) class="active" @endif>
			<a href="{{ url('reports/exam_routine') }}">
				{{ _lang('Exam Routine') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('reports.income_report',Auth::User()->role_id))
	   <li @if(Request::is('reports/income_report') || Request::is('reports/income_report/view')) class="active" @endif>
			<a href="{{ url('reports/income_report') }}">
				{{ _lang('Income Report') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('reports.expense_report',Auth::User()->role_id))
	   <li @if(Request::is('reports/expense_report') || Request::is('reports/expense_report/view')) class="active" @endif>
			<a href="{{ url('reports/expense_report') }}">
				{{ _lang('Expense Report') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('reports.account_balance',Auth::User()->role_id))
	   <li @if(Request::is('reports/account_balance')) class="active" @endif>
			<a href="{{ url('reports/account_balance') }}">
				{{ _lang('Financial Account Balance') }}
			</a>
	   </li>
	   @endif
	</ul>
 </li>
 
 @if (has_permission('users.index',Auth::User()->role_id))
 <li @if((Request::is('users'))OR(Request::is('users/*'))) class="active" @endif>
		<a href="{{route('users.index')}}">
		<i class="fa fa-users"></i>
			{{ _lang('User Management') }}
		</a>
 </li>
 @endif
 
 <li>   
	<a href="#"><i class="fa fa-cogs"></i>{{ _lang('Administration') }}</a>
	<ul>
	   @if (has_permission('general_settings.update',Auth::User()->role_id))
	   <li @if((Request::is('administration/general_settings'))) class="active" @endif>
			<a href="{{ url('administration/general_settings') }}">
				{{ _lang('System Settings') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('academic_years.index',Auth::User()->role_id))	   
	   <li @if((Request::is('academic_years'))OR(Request::is('academic_years/*'))) class="active" @endif>
			<a href="{{route('academic_years.index')}}">
				{{ _lang('Adademic Session') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('student_groups.index',Auth::User()->role_id))   
	   <li @if((Request::is('student_groups'))OR(Request::is('student_groups/*'))) class="active" @endif>
			<a href="{{route('student_groups.index')}}">
				{{ _lang('Student Group') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('picklists.index',Auth::User()->role_id))   
	   <li @if((Request::is('picklists'))) class="active" @endif>
			<a href="{{route('picklists.index')}}">
				{{ _lang('Picklist Editor') }}
			</a>
	   </li>
	   @endif


	   @if (has_permission('permission_roles.index',Auth::User()->role_id))
	   <li @if((Request::is('permission_roles'))OR(Request::is('permission_roles/*'))) class="active" @endif>
			<a href="{{route('permission_roles.index')}}">
				{{ _lang('User Role') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('permission.manage',Auth::User()->role_id))  
	   <li @if((Request::is('permission/control'))) class="active" @endif>
			<a href="{{url('permission/control')}}">
				{{ _lang('Permission Control') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('backup_database',Auth::User()->role_id))  
	   <li @if((Request::is('administration/backup_database'))) class="active" @endif>
			<a href="{{url('administration/backup_database')}}">
				{{ _lang('Database Backup') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('languages.index',Auth::User()->role_id))
	   <li @if(Request::is('languages') || Request::is('languages.*')) class="active" @endif>
			<a href="{{ route('languages.index') }}">
				{{ _lang('Languages') }}
			</a>
	   </li>
	   @endif
	</ul>
 </li>
 
 <li>   
	<a href="#"><i class="fa fa-newspaper-o"></i>{{ _lang('Website CMS') }}</a>
	<ul>
	   @if (has_permission('posts.index',Auth::User()->role_id))  
	   <li @if(Request::is('posts') || Request::is('posts/*')) class="active" @endif>
			<a href="{{ route('posts.index') }}">
				{{ _lang('Posts') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('post_categories.index',Auth::User()->role_id))
	   <li @if(Request::is('post_categories') || Request::is('post_categories/*')) class="active" @endif>
			<a href="{{ route('post_categories.index') }}">
				{{ _lang('Post Category') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('pages.index',Auth::User()->role_id))
	   <li @if(Request::is('pages') || Request::is('pages/*')) class="active" @endif>
			<a href="{{ route('pages.index') }}">
				{{ _lang('Pages') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('site_navigations.index',Auth::User()->role_id))
	   <li @if(Request::is('site_navigations') || Request::is('site_navigations/*')) class="active" @endif>
			<a href="{{ route('site_navigations.index') }}">
				{{ _lang('Site Menu') }}
			</a>
	   </li>
	   @endif
	   
	   @if (has_permission('website.theme_option',Auth::User()->role_id))
	   <li @if(Request::is('website/theme_option')) class="active" @endif>
			<a href="{{ url('website/theme_option') }}">
				{{ _lang('Theme Option') }}
			</a>
	   </li>
	   @endif
	   
	</ul>
 </li>

 
 
 

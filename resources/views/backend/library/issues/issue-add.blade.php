@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					<i class="entypo-plus-circled"></i>{{_lang('Add New Issue')}}
				</div>
			</div>
			<div class="panel-body">
				<div class="col-md-6">
					<form action="{{route('bookissues.store')}}" class="form-horizontal form-groups-bordered validate" enctype="multipart/form-data" autocomplete="off" method="post" accept-charset="utf-8">
						@csrf
						<div class="form-group">
							<label class="col-sm-3 control-label">{{_lang('Library Id')}}</label>
							<div class="col-sm-9">
								<select name="library_id" class="form-control select2" required>
									<option value="">{{ _lang('Select One') }}</option>
									{{ create_option('library_members','library_id','library_id',old('member_id')) }}
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{_lang('Book')}}</label>
							<div class="col-sm-9">
								<select name="book_id" class="form-control select2" required>
									<option value="">{{ _lang('Select One') }}</option>
									{{ create_option('books','id','name',old('book_id')) }}
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{_lang('Due Date')}}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control datepicker" name="due_date" value="{{ old('due_date') }}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{_lang('Note')}}</label>
							<div class="col-sm-9">
								<textarea class="form-control" name="note">{{ old('note') }}</textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-5">
								<button type="submit" class="btn btn-info">{{_lang('Add Issue')}}</button>
							</div>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>
</div>
@endsection

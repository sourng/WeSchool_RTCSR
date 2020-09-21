@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="panel panel-default">
	<div class="panel-heading">{{ _lang('Add Navigation') }}</div>

	<div class="panel-body">
	   <form method="post" autocomplete="off" action="{{route('site_navigation_items.store')}}" enctype="multipart/form-data">
			{{ csrf_field() }}
						
			<input type="hidden" name="navigation_id" value="{{ $navigation_id }}" required>

			<div class="col-md-6">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Menu Label') }}</label>						
				<input type="text" class="form-control" name="menu_label" value="{{ old('menu_label') }}" required>
			  </div>
			</div>

			<div class="col-md-6">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Custom Link URL') }}</label>						
				<input type="text" class="form-control" name="link" value="{{ old('link') }}">
			  </div>
			</div>

			<div class="col-md-6">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Select Page') }}</label>						
				<select class="form-control select2" name="page_id">
				   <option value="">{{ _lang('Select One') }}</option>
					 @foreach($pages as $page)
						<option value="{{ $page->id }}">{{ $page->content[0]->page_title }}</option>
					 @endforeach
				</select>
			  </div>
			</div>

			<div class="col-md-6">
			  <div class="form-group">
				<label class="control-label">{{ _lang('Parent Menu') }}</label>						
				<select class="form-control select2" name="parent_id">
				   <option value="">{{ _lang('Select One') }}</option>
				   {{ navigationOptionTree("site_navigation_items", $navigation_id, 0) }}
				</select>
			  </div>
			</div>
			
			<div class="col-md-6">
			  <div class="form-group">
				<label class="control-label">{{ _lang('CSS Class') }}</label>						
				<input type="text" class="form-control" name="css_class" value="{{ old('css_class') }}">
			  </div>
			</div>

			<div class="col-md-6">
			  <div class="form-group">
				<label class="control-label">{{ _lang('CSS ID') }}</label>						
				<input type="text" class="form-control" name="css_id" value="{{ old('css_id') }}">
			  </div>
			</div>
						
			<div class="col-md-12">
			  <div class="form-group">
				<button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
				<button type="submit" class="btn btn-primary pull-right">{{ _lang('Save Menu') }}</button>
			  </div>
			</div>
		</form>
	</div>
  </div>
 </div>
</div>
@endsection



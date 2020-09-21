@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title">{{ _lang('Update Navigation') }}</span>
				
				<form action="{{ action('NavigationItemController@destroy', $id) }}" method="post">
					{{ csrf_field() }}
					<input name="_method" type="hidden" value="DELETE">
					<button style="margin-top:-28px;" class="btn btn-danger pull-right btn-remove" type="submit">{{ _lang('Delete') }}</button>
				</form>	
			</div>

			<div class="panel-body">
			<form method="post" autocomplete="off" action="{{action('NavigationItemController@update', $id)}}">
				{{ csrf_field()}}
				<input name="_method" type="hidden" value="PATCH">				
									
				<input type="hidden" name="navigation_id" value="{{ $navigationitem->navigation_id }}" required>

				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Menu Label') }}</label>						
					<input type="text" class="form-control" name="menu_label" value="{{ $navigationitem->menu_label }}" required>
				 </div>
				</div>

				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Custom Link URL') }}</label>						
					<input type="text" class="form-control" name="link" value="{{ $navigationitem->link }}">
				 </div>
				</div>

				<div class="col-md-6">
				  <div class="form-group">
					<label class="control-label">{{ _lang('Select Page') }}</label>						
					<select class="form-control select2" name="page_id">
					   <option value="">{{ _lang('Select One') }}</option>
						 @foreach($pages as $page)
							<option value="{{ $page->id }}" {{ $navigationitem->page_id==$page->id ? "selected" : "" }}>{{ $page->content[0]->page_title }}</option>
						 @endforeach
					</select>
				  </div>
				</div>

				<div class="col-md-6">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Parent Menu') }}</label>						
					<select class="form-control select2" name="parent_id">
					   <option value="">{{ _lang('Select One') }}</option>
					   {{ create_option("site_navigation_items","id","menu_label",$navigationitem->parent_id,array("id !=" =>$navigationitem->id, "AND IFNULL(parent_id,0) !="=>$navigationitem->id, "AND navigation_id="=>$navigationitem->navigation_id)) }}
					</select>
				 </div>
				</div>
				
				<div class="col-md-6">
				  <div class="form-group">
					<label class="control-label">{{ _lang('CSS Class') }}</label>						
					<input type="text" class="form-control" name="css_class" value="{{ $navigationitem->css_class }}">
				  </div>
				</div>

				<div class="col-md-6">
				  <div class="form-group">
					<label class="control-label">{{ _lang('CSS ID') }}</label>						
					<input type="text" class="form-control" name="css_id" value="{{ $navigationitem->css_id }}">
				  </div>
				</div>

							
				<div class="form-group">
				  <div class="col-md-12">
					<button type="submit" class="btn btn-primary">{{ _lang('Update') }}</button> 
				  </div>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>

@endsection



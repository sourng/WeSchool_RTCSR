@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title" >
					<i class="entypo-plus-circled"></i>{{ _lang('Edit Book') }}
				</div>
			</div>
			<div class="panel-body">
				<div class="col-md-8">
					<form action="{{route('books.update',$book->id)}}" class="form-horizontal form-groups-bordered validate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
						@csrf
						{{ method_field('PATCH') }}
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Name') }}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="name" value="{{$book->name}}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Category') }}</label>
							<div class="col-sm-9">
								<select name="category_id" class="form-control select2" id="class" required>
									<option value="">{{ _lang('Select One') }}</option>
									{{ create_option('book_categories','id','category_name',$book->category_id) }}
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Author') }}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="author" value="{{$book->author}}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Publisher') }}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="publisher" value="{{$book->publisher}}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Rack No') }}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="rack_no" value="{{$book->rack_no}}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Quantity') }}</label>
							<div class="col-sm-9">
								<input type="number" class="form-control" name="quantity" value="{{$book->quantity}}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Description') }}</label>
							<div class="col-sm-9">
								<textarea name="description" class="form-control">{{$book->description}}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Publish Date') }}</label>
							<div class="col-sm-9">
								<input type="text" class="form-control datepicker" name="publish_date" value="{{$book->publish_date}}" required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">{{ _lang('Photo') }}</label>
							<div class="col-sm-9">
								<input type="file" class="form-control dropify" data-default-file="{{ asset('public/uploads/images/books/'.$book->photo) }}" name="photo" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-4 col-sm-9">
								<button type="submit" class="btn btn-info">{{ _lang('Update Book') }}</button>
							</div>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>
</div>
@endsection
@extends('layouts.backend')

@section('content')
<style>.well{overflow: hidden;}</style>
    <div class="row">
        <div class="col-md-12">
		  <ul class="nav nav-tabs setting-tab">
			  <li class="active"><a data-toggle="tab" href="#general" aria-expanded="true">{{ _lang('General') }}</a></li>
			  <li class=""><a data-toggle="tab" href="#slider" aria-expanded="true">{{ _lang('Content Slider') }}</a></li>
			  <li class=""><a data-toggle="tab" href="#social" aria-expanded="true">{{ _lang('Social And Contact') }}</a></li>
			  <li class=""><a data-toggle="tab" href="#custom_css" aria-expanded="false">{{ _lang('Custom CSS') }}</a></li>
			  <li class=""><a data-toggle="tab" href="#custom_js" aria-expanded="false">{{ _lang('Custom JS') }}</a></li>
		  </ul>
		  <div class="tab-content">
		  
		       <div id="general" class="tab-pane fade in active">
				  <div class="panel panel-default">
				  <div class="panel-heading"><span class="panel-title">{{ _lang('General Settings') }}</span></div>

					  <div class="panel-body">
					    <form method="post" class="appsvan-submit params-panel" autocomplete="off" action="{{ url('administration/theme_option/update') }}" enctype="multipart/form-data">
						{{ csrf_field() }}
						
						    <div class="col-md-6">
							  <div class="form-group">
								<label class="control-label">{{ _lang('Home Page') }}</label>						
								<select class="form-control select2" name="home_page">
									<option value="">{{ _lang('Select One') }}</option>
									@foreach(get_pages() as $page)
									   <option value="{{ $page->id }}" {{ $page->id == get_option('home_page') ? "selected" : "" }}>{{ $page->content[0]->page_title }}</option>
									@endforeach
								</select>
							  </div>
							</div>
							
							<div class="col-md-6">
							  <div class="form-group">
								<label class="control-label">{{ _lang('Disabled Website') }}</label>						
								<select class="form-control select2" name="disabled_website">
									<option value="no" {{ get_option('disabled_website')=="no" ? "selected" : "" }}>{{ _lang('No') }}</option>
									<option value="yes" {{ get_option('disabled_website')=="yes" ? "selected" : "" }}>{{ _lang('Yes') }}</option>
								</select>
							  </div>
							</div>

							<div class="col-md-12">
							  <div class="form-group">
								<label class="control-label">{{ _lang('Home Page Banner') }}</label>						
								<input type="file" class="form-control dropify" name="hero_image" data-max-file-size="8M" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG" data-default-file="{{ get_option('hero_image') != "" ? asset('public/uploads/media/'.get_option('hero_image')) : "" }}">
							  </div>
							</div>
							
							<div class="col-md-12">
							  <div class="form-group">
								<label class="control-label">{{ _lang('Copyright Text') }}</label>						
								<input type="text" class="form-control" name="copyright_text" value="{{ get_option('copyright_text') }}">
							  </div>
							</div>
														
							<div class="form-group">
							  <div class="col-md-12">
								<button type="submit" class="btn btn-primary">{{ _lang('Save Settings') }}</button>
							  </div>
							</div>
							
						</form>	
					  </div>
				  </div>
			   </div>
			   
		      <div id="slider" class="tab-pane">
				  <div class="panel panel-default">
				  <div class="panel-heading"><span class="panel-title">{{ _lang('Content Slider') }}</span></div>

					  <div class="panel-body">
					    <form method="post" class="appsvan-submit params-panel" autocomplete="off" action="{{ url('administration/theme_option/update') }}" enctype="multipart/form-data">
						{{ csrf_field() }}
		                    <button type="button" id="add_slide" class="btn btn-info rect-btn">{{ _lang('Add New Slide') }} + </button>
		                    <p>&nbsp;</p>
							@php $slider = unserialize(get_option('slider')); @endphp
							
							@if(empty($slider))
								<div class="well repeat">
									<button type="button" class="remove-row btn btn-danger btn-sm pull-right">{{ _lang('Remove') }}</button>
									<div class="col-md-12">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Slider Heading') }}</label>						
										<input type="text" class="form-control" name="slider[slider_heading][]" required>
									  </div>
									</div>
									
									<div class="col-md-12">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Slider Content') }}</label>						
										<input type="text" class="form-control" name="slider[slider_content][]" required>
									  </div>
									</div>
									
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Button Link') }}</label>						
										<input type="text" class="form-control" name="slider[button_link][]">
									  </div>
									</div>
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Button Text') }}</label>						
										<input type="text" class="form-control" name="slider[button_text][]">
									  </div>
									</div>
								</div>
							
							@else
							
							@for($i = 0; $i < count($slider['slider_heading']); $i++)
							<div class="well {{ $i==0 ? 'repeat' : "" }}">
						        <button type="button" class="remove-row btn btn-danger btn-sm pull-right">{{ _lang('Remove') }}</button>
								<div class="col-md-12">
								  <div class="form-group">
									<label class="control-label">{{ _lang('Slider Heading') }}</label>						
									<input type="text" class="form-control" value="{{ $slider['slider_heading'][$i] }}" name="slider[slider_heading][]" required>
								  </div>
								</div>
								
								<div class="col-md-12">
								  <div class="form-group">
									<label class="control-label">{{ _lang('Slider Content') }}</label>						
									<input type="text" class="form-control" value="{{ $slider['slider_content'][$i] }}" name="slider[slider_content][]" required>
								  </div>
								</div>
								
								<div class="col-md-6">
								  <div class="form-group">
									<label class="control-label">{{ _lang('Button Link') }}</label>						
									<input type="text" class="form-control" value="{{ $slider['button_link'][$i] }}" name="slider[button_link][]">
								  </div>
								</div>
								<div class="col-md-6">
								  <div class="form-group">
									<label class="control-label">{{ _lang('Button Text') }}</label>						
									<input type="text" class="form-control" value="{{ $slider['button_text'][$i] }}" name="slider[button_text][]">
								  </div>
								</div>
							</div>
							@endfor	
							@endif							
														
							<div class="form-group" id="slider_submit">
							  <div class="col-md-12">
								<button type="submit" class="btn btn-primary">{{ _lang('Save Settings') }}</button>
							  </div>
							</div>
							
						</form>	
					  </div>
				  </div>
			  </div>

			  <div id="social" class="tab-pane">
				  <div class="panel panel-default">
				  <div class="panel-heading"><span class="panel-title">{{ _lang('Social And Contact') }}</span></div>

				  <div class="panel-body">
					  <form method="post" class="appsvan-submit params-panel" autocomplete="off" action="{{ url('administration/theme_option/update') }}" enctype="multipart/form-data">
						{{ csrf_field() }}
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Facebook') }}</label>						
							<input type="text" class="form-control" name="facebook_link" value="{{ get_option('facebook_link') }}">
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Twitter') }}</label>						
							<input type="text" class="form-control" name="twitter_link" value="{{ get_option('twitter_link') }}">
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Google Plus') }}</label>						
							<input type="text" class="form-control" name="google_plus_link" value="{{ get_option('google_plus_link') }}">
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Instagram') }}</label>						
							<input type="text" class="form-control" name="instagram_link" value="{{ get_option('instagram_link') }}">
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Youtube') }}</label>						
							<input type="text" class="form-control" name="youtube_link" value="{{ get_option('youtube_link') }}">
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Linkedin') }}</label>						
							<input type="text" class="form-control" name="linkedin_link" value="{{ get_option('linkedin_link') }}">
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Contact Email') }}</label>						
							<input type="text" class="form-control" name="contact_email" value="{{ get_option('contact_email') }}">
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Contact Phone') }}</label>						
							<input type="text" class="form-control" name="contact_phone" value="{{ get_option('contact_phone') }}">
						  </div>
						</div>
						
						<div class="col-md-12">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Contact Address') }}</label>						
							<textarea class="form-control" name="contact_address">{{ get_option('contact_address') }}</textarea>
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Google MAP API') }}</label>						
							<input type="text" class="form-control" name="google_map_api" value="{{ get_option('google_map_api') }}">
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Google MAP Latitude') }}</label>						
							<input type="text" class="form-control" name="google_map_latitude" value="{{ get_option('google_map_latitude') }}">
						  </div>
						</div>
						
						<div class="col-md-6">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Google MAP Longitude') }}</label>						
							<input type="text" class="form-control" name="google_map_longitude" value="{{ get_option('google_map_longitude') }}">
						  </div>
						</div>
							
						<div class="form-group">
						  <div class="col-md-12">
							<button type="submit" class="btn btn-primary">{{ _lang('Save Settings') }}</button>
						  </div>
						</div>
					  </form>
				  </div>
				  </div>
			  </div>
			 
			
			  <div id="custom_css" class="tab-pane fade">
				<div class="panel panel-default">
				  <div class="panel-heading"><span class="panel-title">{{ _lang('Custom CSS') }}</span></div>
				  <div class="panel-body">
					<form method="post" class="appsvan-submit params-panel" autocomplete="off" action="{{ url('administration/theme_option/update') }}" enctype="multipart/form-data">
						{{ csrf_field() }}
						
						<div class="col-md-12">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Custom CSS') }}</label>						
							<textarea rows="10" class="form-control" name="custom_css">{{ get_option('custom_css') }}</textarea>
						  </div>
						</div>
						
						<div class="form-group">
						  <div class="col-md-12">
							<button type="submit" class="btn btn-primary">{{ _lang('Save Settings') }}</button>
						  </div>
						</div>		
					</form>
				   </div>
				 </div>
			  </div>
			  
			  <div id="custom_js" class="tab-pane fade">
				<div class="panel panel-default">
				  <div class="panel-heading"><span class="panel-title">{{ _lang('Custom JS') }}</span></div>
				  <div class="panel-body">
					<form method="post" class="appsvan-submit params-panel" autocomplete="off" action="{{ url('administration/theme_option/update') }}" enctype="multipart/form-data">
						{{ csrf_field() }}
						
						<div class="col-md-12">
						  <div class="form-group">
							<label class="control-label">{{ _lang('Custom JS') }}</label>						
							<textarea rows="10" class="form-control" name="custom_js">{{ get_option('custom_js') }}</textarea>
						  </div>
						</div>
					
						
						<div class="form-group">
						  <div class="col-md-12">
							<button type="submit" class="btn btn-primary">{{ _lang('Save Settings') }}</button>
						  </div>
						</div>		
					</form>
				   </div>
				 </div>
			  </div>
			  
		   </div>  
		</div>
	  </div>
     </div>
    </div>
@endsection

@section('js-script')
<script type="text/javascript">
if($("#mail_type").val() != "smtp"){
	$(".smtp").prop("disabled",true);
}
$(document).on("change","#mail_type",function(){
	if( $(this).val() != "smtp" ){
		$(".smtp").prop("disabled",true);
	}else{
		$(".smtp").prop("disabled",false);
	}
});

$(document).on('click','#add_slide',function(){
	$form = $(".repeat").clone().removeClass("repeat");
	$form.find("input,textarea").val("");
	$("#slider_submit").before($form);
});

$(document).on('click','.remove-row',function(){
	$(this).parent().remove();
});

</script>
@stop


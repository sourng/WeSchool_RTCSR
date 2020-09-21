@extends('layouts.backend')

@section('content')
<style type="text/css">
#library_card::after {
    background-image: url({{ get_logo() }}) !important;
}

</style>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title" >
				{{ _lang('Library Card') }}
				</span>
				<button type="button" style="margin-top:-4px;" class="btn btn-primary print pull-right" data-print="library_card">{{ _lang('Print Card') }}</button>
			</div>
			<div class="panel-body">
				<div id="library_card">
					<div class="card_header">
						<h5>{{ get_option('school_name')}}</h5>
						<p>{{ _lang('Library Card') }}</p>
					</div>
					<div class="image">
						<img src="{{ asset('public/uploads/images/'.$library->image) }}">
					    <p>{{ $library->name }}</p>
					</div>
					<div class="library-card">
						<table>
							<tr>
								<td class="lbl">{{ _lang('Member Type') }}</td>
							</tr>	
								<td>{{ $library->member_type }}</td>
							</tr>
							<tr>
								<td class="lbl">{{ _lang('Library ID') }}</td>
							</tr>	
								<td>{{ $library->library_id }}</td>
							</tr>
						</table>
					</div>
					
					<div class="card_footer">	
						<p>{{ _lang('Emergency Contact') }} : {{ get_option('phone') }}</p>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection

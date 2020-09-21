@extends('layouts.backend')

@section('content')


<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default no-export">
			<div class="panel-heading"><span class="panel-title">{{ _lang('Navigation Item') }}</span>
			<a class="btn btn-primary btn-sm pull-right" data-title="{{ _lang('Add Navigation') }}" href="{{ url('site_navigation_items/create/'.$navigation_id) }}">{{ _lang('Add New') }}</a>
			</div>

			<div class="panel-body">
			 @if (\Session::has('success'))
			  <div class="alert alert-success">
				<p>{{ \Session::get('success') }}</p>
			  </div>
			  <br />
			 @endif
			 
			  <div class="dd"> 
				  {{ navigationTree($navigationitems, 0, 'NavigationItemController@edit') }}
			  </div>
			  
			  
			  <form method="post" action="{{ url('website/menu_sorting') }}">
				{{ csrf_field() }}
				<textarea class="form-control" style="display:none" name="sortable_menu" id="nestable-output"></textarea>
				</br>
				<button type="submit" class="btn btn-primary" id="save">{{ _lang('Save Menu') }}</button>
			  </form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('js-script')
<script>

var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target), 
		   output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };
	
    // activate Nestable
    $('.dd').nestable({
        group: 1,
		maxDepth: 3,
    }).on('change', updateOutput);

    updateOutput($('.dd').data('output', $('#nestable-output')));
 
</script>
@stop

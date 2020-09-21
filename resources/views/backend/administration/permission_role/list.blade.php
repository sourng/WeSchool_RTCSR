@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default no-export">
			<div class="panel-heading"><span class="panel-title">{{ _lang('List Permission Role') }}</span>
			<a class="btn btn-primary btn-sm pull-right ajax-modal" data-title="{{ _lang('Add Permission Role') }}" href="{{route('permission_roles.create')}}">{{ _lang('Add New') }}</a>
			</div>

			<div class="panel-body">
			 @if (\Session::has('success'))
			  <div class="alert alert-success">
				<p>{{ \Session::get('success') }}</p>
			  </div>
			  <br />
			 @endif
			 <table class="table table-bordered data-table">
				<thead>
				  <tr>
					<th>{{ _lang('Role Name') }}</th>
					<th>{{ _lang('Note') }}</th>
					<th>{{ _lang('Action') }}</th>
				  </tr>
				</thead>
				<tbody>
				  
				  @foreach($roles as $role)
				  <tr id="row_{{ $role->id }}">
					<td class='role_name'>{{ $role->role_name }}</td>
					<td class='note'>{{ $role->note }}</td>
						
					<td>
					  <form action="{{action('RoleController@destroy', $role['id'])}}" method="post">
						<a href="{{action('RoleController@edit', $role['id'])}}" data-title="{{ _lang('Update Permission Role') }}" class="btn btn-warning btn-sm ajax-modal">{{ _lang('Edit') }}</a>
						<a href="{{action('RoleController@show', $role['id'])}}" data-title="{{ _lang('View Permission Role') }}" class="btn btn-info btn-sm ajax-modal">{{ _lang('View') }}</a>
						{{ csrf_field() }}
						<input name="_method" type="hidden" value="DELETE">
						<button class="btn btn-danger btn-sm btn-remove" type="submit">{{ _lang('Delete') }}</button>
					  </form>
					</td>
				  </tr>
				  @endforeach
				</tbody>
			  </table>
			</div>
		</div>
	</div>
</div>

@endsection



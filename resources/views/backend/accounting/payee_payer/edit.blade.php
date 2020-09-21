@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">{{ _lang('Update Information') }}</div>

			<div class="panel-body">
			<form method="post" class="validate" autocomplete="off" action="{{action('PayeePayerController@update', $id)}}" enctype="multipart/form-data">
				{{ csrf_field()}}
				<input name="_method" type="hidden" value="PATCH">				
				
				<div class="col-md-12">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Name') }}</label>						
					<input type="text" class="form-control" name="name" value="{{ $payeepayer->name }}" required>
				 </div>
				</div>

				<div class="col-md-12">
				  <div class="form-group">
					<label class="control-label">{{ _lang('Type') }}</label>						
					<select class="form-control" name="type" required>
					   <option value="payer" @php $payeepayer->type=="payer" ? "selected" : "" @endphp>Payer</option>
					   <option value="payee" @php $payeepayer->type=="payee" ? "selected" : "" @endphp>Payee</option>
					</select>
				  </div>
				</div>

				<div class="col-md-12">
				 <div class="form-group">
					<label class="control-label">{{ _lang('Note') }}</label>						
					<textarea class="form-control" name="note">{{ $payeepayer->note }}</textarea>
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



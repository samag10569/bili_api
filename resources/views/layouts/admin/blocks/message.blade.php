	
	@if($errors->any() || Session::has('error'))
		<div class="alert alert-danger  alert-dismissable" style="margin: 10px;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			{!!Session::get('error')!!}
			@if(isset($errors))
				@foreach($errors->all() as $error )
					 &nbsp;&nbsp;{!! $error !!}
					<br/>
				@endforeach
			@endif
		</div>
	@endif
	
	@if(Session::has('success'))
		<div class="alert alert-success  alert-dismissable" style="margin: 10px;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			{!!Session::get('success')!!}
		</div>
	@endif
	
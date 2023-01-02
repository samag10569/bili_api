
<!DOCTYPE html>
<html lang="en">
@include('layouts.site.blocks.head')
<body>
	@include('layouts.site.blocks.header')
	<style>
	
	.btn-sub{
		color: #37add9;
		background: #fff;
		border: 2px solid #37add9;
		padding: 20px;
		font-size: 25px;
		position: relative;
		top: 200px;
		border-radius: 10px;
	}
	
	
	</style>
	<section>
		<div class="container-fluid">
			<div class="row error-page">
				<!----------------------------------- RIGHT SIDE ------------------------------->
				<div class="col-md-12">
					{!! Form::open(array('action' => array('Site\HomeController@postUnSubscribe'))) !!}
							{!! Form::hidden('email',$email) !!}
							{!! Form::hidden('type',$type) !!}
							{!! Form::hidden('type_id',$type_id) !!}
						<button type="submit" class="btn-sub">جهت عدم دریافت ایمیل ها اینجا کلیک کنید.</button>
						
					{!!Form::close()!!}
				</div>

			</div>
		</div>
	</section>

	@include('layouts.site.blocks.footer')

	@include('layouts.site.blocks.modal')

</body>
@include('layouts.site.blocks.script')
</html>
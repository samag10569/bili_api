
<!DOCTYPE html>
<html lang="en">
@include('layouts.site.blocks.head')
<body>
	@include('layouts.site.blocks.header')
	<section>
		<div class="container-fluid">
			<div class="row error-page">
				<!----------------------------------- RIGHT SIDE ------------------------------->
				<div class="col-md-12">
					
					<a href="{!! URL::action('Site\HomeController@getIndex') !!}">صفحه نخست سایت</a>
					
				</div>

			</div>
		</div>
	</section>

	@include('layouts.site.blocks.footer')

	@include('layouts.site.blocks.modal')

</body>
@include('layouts.site.blocks.script')
</html>
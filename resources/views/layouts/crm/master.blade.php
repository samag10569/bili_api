<!DOCTYPE html>
<html lang="en">
@include('layouts.site.blocks.head')
<body>
	@include('layouts.site.blocks.header')

	@include('layouts.crm.blocks.slider_inner')

	@include('layouts.site.blocks.news')
	
	@yield('map')
	
	@include('layouts.site.blocks.message')
	
	@if(Auth::check())
		@include('layouts.site.blocks.notic')
	@endif
	
	<section>
		<div class="container-fluid">
			<div class="row main-content">
				@yield('content')
			</div>
		</div>
	</section>
	
	@include('layouts.site.blocks.footer')

	@include('layouts.site.blocks.modal')

</body>
@include('layouts.site.blocks.script')
</html>
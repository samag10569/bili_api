<!DOCTYPE html>
<html lang="en">
@include('layouts.site.blocks.head')
<body>
	@include('layouts.site.blocks.header')
	
	@if(count(Request::segments()))
		@include('layouts.crm.blocks.slider_inner')
	@endif
	
	@include('layouts.site.blocks.news')
	
	@yield('map')
	
	@include('layouts.site.blocks.message')
	
	@if(Auth::check())
		@include('layouts.site.blocks.notic')
	@endif

	@yield('content')

	@include('layouts.site.blocks.footer')

	@include('layouts.site.blocks.modal')

</body>
@include('layouts.site.blocks.script')
</html>
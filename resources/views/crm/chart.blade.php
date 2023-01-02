<!DOCTYPE html>
<html lang="en">
@include('layouts.site.blocks.head')
<body>
@include('layouts.site.blocks.header')	
<section>
	<div class="container-fluid">
		<div class="row page-navigator">
			<div class="col-md-12">
				<ul>
					<li><img src="{!! asset('assets/site/images/location.png') !!}" alt=""></li>
					<li><a href="">صفحه اصلی</a></li><span>/</span>
					<li><a href="">پروفایل {{Auth::user()->name.' '.Auth::user()->family}}</a></li>
				</ul>
			</div>
		</div>
		<!-- /.page-navigator -->
	</div>
</section>
<style>
html, body, svg { width: 100%; height: 100%;}
body {
	background:#53abed
}
</style>
<div id="chart-detials">
	<img src="" id="src" style="width:70px;height:70px;">
    <div id="name"></div>
    <div id="field"> </div>
</div>
<script src="{!! asset('assets/site/js/chartScript.js') !!}"></script>
</body>
@include('layouts.site.blocks.script')
</html>


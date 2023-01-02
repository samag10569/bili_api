@extends('layouts.crm.master')

@section('map')
<section>
	<div class="container-fluid">
		<div class="row page-navigator">
			<div class="col-md-12">
				<ul>
					<li><img src="{!! asset('assets/site/images/location.png') !!}" alt=""></li>
					<li><a href="{{URL::action('Site\HomeController@getIndex')}}">صفحه اصلی</a></li><span>/</span>
					<li><a href="">هیات علمی</a></li>
				</ul>
			</div>
		</div>
		<!-- /.page-navigator -->
	</div>
</section>
@stop

@section('content')


	<!----------------------------------- RIGHT SIDE ------------------------------->
		
	<div class="col-md-8">
		@include('layouts.site.blocks.help')
		<div class="box" style="margin-top:30px;">
			<div class="head">
				<h4>هیات علمی </h4>

			</div>
			<!-- .head -->
			<div class="body">

				@foreach($groups as $row)
				<div class="list">
					<div class="row">
						<div class="col-md-12">
							<h3> {{ $row->title }}
								
							<a href="{{URL::action('Crm\CoreScientificController@getList',$row->id)}}"  class="link green link-hover pull-left">مشاهده اعضا هیات علمی</a>
							</h3>
						</div>
					</div>
				</div><!-- /.list -->
				@endforeach


			</div>
			<!-- .body -->
		</div>
		<!-- .box -->



	</div>
	@include('layouts.crm.blocks.sidebar')

@endsection

@extends('layouts.crm.master')

@section('map')
<section>
	<div class="container-fluid">
		<div class="row page-navigator">
			<div class="col-md-12">
				<ul>
					<li><img src="{!! asset('assets/site/images/location.png') !!}" alt=""></li>
					<li><a href="{{URL::action('Site\HomeController@getIndex')}}">صفحه اصلی</a></li><span>/</span>
					<li><a href="">جستجو در شبکه</a></li>
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
				<h4>شبکه اتصال به اعضای خود را گسترش دهید </h4>

			</div>
			<!-- .head -->
			<div class="body">
			<!---------------------- ACCORDION -------------------->
				<div class="row profile-network">
					<div class="col-md-9">
						<div class="accordion-content" id="accordion-content">
							
							<div id="content3" class="content" style="display: block;">
							{!! Form::open(array('action' => array('Crm\NetworkController@postIntroduction'),'role' => 'form','id' => 'network_form')) !!}
                              
								<div class="form-group form-inline">
								  <label> نام  :</label>
								  <input class="form-control" name="name" placeholder="نام" type="text">
								</div>
								<div class="form-group form-inline">
								  <label> ایمیل  :</label>
								  <input class="form-control" name="email" placeholder="ایمیل" type="text">
								</div>
								<button href="" class="link green link-hover "> ارسال دعوت نامه  </button>
							{!! Form::close() !!}
							</div><!-- /#content3 -->
						
						</div><!-- /#accordion-content -->
					</div>
					<div class="col-md-3">
						<ul id="myaccordion" class="accordion">
							<li class="nochild deactive" id="1"><a href="{{URL::action('Crm\NetworkController@getIndex')}}">اتصالات شما</a></li>
							<li class="nochild deactive" id="2"><a href="{{URL::action('Crm\NetworkController@getFriendRequest')}}">درخواست های ارسالی</a></li>
							<li class="nochild deactive" id="2"><a href="{{URL::action('Crm\NetworkController@getFriendRequestOther')}}">درخواست های دریافتی</a></li>
							<li class="nochild deactive" id="4"><a href="{{URL::action('Crm\NetworkController@getSearch')}}">جستجو در شبکه</a></li>
							<li class="nochild active" id="5"><a href="{{URL::action('Crm\NetworkController@getIntroduction')}}">دعوت دوستان</a></li>
						</ul><!-- /.myaccordion -->
						
					</div>
				</div>
				<!---------------------- ACCORDION -------------------->
			
			</div>
			<!-- .body -->
		</div>
		<!-- .box -->



	</div>
	@include('layouts.crm.blocks.sidebar')

@endsection


@section('js')
	<script type="text/javascript">
		(function($,W,D)
		{
			var JQUERY4U = {};

			JQUERY4U.UTIL =
			{
				setupFormValidation: function()
				{
					//form validation rules
					$("#network_form").validate({
						rules: {
							name: "required",
							email: {
								required: true,
								email: true
							},
							agree: "required"
						},
						messages: {
							name: "این فیلد الزامی است.",
							email: "لطفا یک آدرس ایمیل معتبر وارد کنید."
						},
						submitHandler: function(form) {
							form.submit();
						}
					});
				}
			}

			//when the dom has loaded setup form validation rules
			$(D).ready(function($) {
				JQUERY4U.UTIL.setupFormValidation();
			});

		})(jQuery, window, document);

		
	
	</script>
@stop

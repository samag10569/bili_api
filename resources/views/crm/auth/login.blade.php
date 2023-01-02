@extends('layouts.crm.master')

@section('map')
<section>
	<div class="container-fluid">
		<div class="row page-navigator">
			<div class="col-md-12">
				<ul>
					<li><img src="images/location.png{!! asset('assets/site/images/logo.png') !!}" alt=""></li>
					<li><a href="{{URL::action('Site\HomeController@getIndex')}}">صفحه اصلی</a></li><span>/</span>
					<li><a href="">ورود به سامانه</a></li>
				</ul>
			</div>
		</div>
		<!-- /.page-navigator -->
	</div>
</section>
@stop

@section('content')


	<!----------------------------------- RIGHT SIDE ------------------------------->
	<div class="col-md-3">
	</div>
	<div class="col-md-6">
		<div class="box hasForm steps">
			<div class="head">
				<h4>ورود به سامانه</h4>
			</div>
			<!-- .head -->
			<div class="body">
				<div class="profile">
					{!! Form::open(array('action' => 'Auth\LoginController@postCrmLogin', 'class' => 'form','id' => 'ejavan_form')) !!}
						<div class="form-group form-inline">
							<label>ایمیل :</label>
							<input class="form-control" type="email" placeholder="ایمیل خود را وارد نمایید . . ." id="email" name="email">
						</div>
						<div class="form-group form-inline">
							<label>رمز عبور :</label>
							<input class="form-control" type="password" placeholder="رمز عبور را وارد نمایید . . ." id="password" name="password">
						</div>
						
						<div class="form-group form-inline">
							<label>کد امنیتی :</label>
							<input class="form-control" type="text" placeholder="کد امنیتی" id="captcha" name="captcha" autocomplete="off">
						</div>
						
						<div class="form-group form-inline">
							<label></label>
							<span class="refereshrecapcha">
								{!! \Mews\Captcha\Facades\Captcha::img() !!}
							</span>
							<a href="javascript:void(0)" onclick="refreshCaptcha()"><i class="fa fa-refresh"></i></a>
						</div>
  
						<p><a href="{{URL::action('Auth\ForgotPasswordController@getResetPassword')}}">فراموشی رمز عبور</a></p>

						<a href="{{URL::action('Site\RegisterController@getStep1')}}" class="link blue link-hover pull-left">ثبت نام</a>
						<button type="submit" class="link green link-hover pull-left">ورود</button>
						<a id="btn-fblogin" href="{{URL::action('Auth\LoginController@redirectToProvider')}}" class="btn btn-danger">
							ورود / ثبت نام با اکانت گوگل در سامانه
						</a>


					{!! Form::close() !!}
				</div>
				<!-- /.profile -->

			</div>
			<!-- .body -->
		</div>
		<!-- .box -->
	</div>
	<div class="col-md-3">
	</div>
				
@endsection
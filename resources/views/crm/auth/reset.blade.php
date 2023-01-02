@extends('layouts.crm.master')

@section('map')
<section>
	<div class="container-fluid">
		<div class="row page-navigator">
			<div class="col-md-12">
				<ul>
					<li><img src="images/location.png{!! asset('assets/site/images/logo.png') !!}" alt=""></li>
					<li><a href="{{URL::action('Site\HomeController@getIndex')}}">صفحه اصلی</a></li><span>/</span>
					<li><a href="">بازیابی رمز عبور</a></li>
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
				<h4>بازیابی رمز عبور</h4>
			</div>
			<!-- .head -->
			<div class="body">
				<div class="profile">
					{!! Form::open(array('action' => 'Auth\ForgotPasswordController@postResetPassword', 'class' => 'form','id' => 'ejavan_form')) !!}
						<div class="form-group form-inline">
							<input type="hidden" value="{{$token}}" name="token">
							<label>{{$user->email}}</label>
							</br>
							<label>{{$user->name.' '.$user->family}}</label>
							</br>
							
							<div class="form-group form-inline">
								<label>رمز عبور :</label>
								<input class="form-control" type="password" placeholder="رمز عبور را وارد نمایید . . ." id="password" name="password">
							</div>
							
							<div class="form-group form-inline">
								<label>تکرار رمز عبور :</label>
								<input class="form-control" type="password" placeholder="تکرار رمز عبور را وارد نمایید . . ." id="repassword" name="repassword">
							</div>
							
						</div>
						
						
						
						
						
						<button type="submit" class="link green link-hover pull-left">تغییر رمز</button>


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
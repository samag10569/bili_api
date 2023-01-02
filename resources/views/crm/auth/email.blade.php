@extends('layouts.crm.master')

@section('map')
<section>
	<div class="container-fluid">
		<div class="row page-navigator">
			<div class="col-md-12">
				<ul>
					<li><img src="images/location.png{!! asset('assets/site/images/logo.png') !!}" alt=""></li>
					<li><a href="{{URL::action('Site\HomeController@getIndex')}}">صفحه اصلی</a></li><span>/</span>
					<li><a href="">فراموشی رمز عبور</a></li>
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
				<h4>فراموشی رمز عبور</h4>
			</div>
			<!-- .head -->
			<div class="body">
				<div class="profile">
					{!! Form::open(array('action' => 'Auth\ForgotPasswordController@postSendEmail', 'class' => 'form','id' => 'ejavan_form')) !!}
						<div class="form-group form-inline">
							<label>ایمیل :</label>
							<input class="form-control" type="email" placeholder="ایمیل خود را وارد نمایید . . ." id="email" name="email">
						</div>
						
						<button type="submit" class="link green link-hover pull-left">ارسال ایمیل</button>


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
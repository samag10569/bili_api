<!DOCTYPE html>

<html>
  <head>
    <meta charset="UTF-8">
    <title>ورود به پنل مدیریت</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="{{ asset('assets/admin/img/favicon.png')}}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link rel="stylesheet" href="{{asset('assets/admin/bootstrap/css/bootstrap.min.css')}}">
    <!-- ejavan css -->
    <link rel="stylesheet" href="{{asset('assets/admin/css/ejavan_style.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/admin/css/font-awesome.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/admin/dist/css/AdminLTE.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/admin/dist/fonts/fonts-fa.css')}}">
    <script src="{{ asset('assets/admin/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets/admin/js/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('assets/admin/bootstrap/js/bootstrap.min.js')}}"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    <div class="login-box" style="direction: rtl;">
	@include('layouts.admin.blocks.message')
      <div class="login-logo">
		<img src="{{ asset('assets/admin/img/logo.jpg')}}" style="width: 30%;"/>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">شبکه رشد علم جوان</p>
		{!! Form::open(array('action' => 'Auth\LoginController@postLogin', 'role' => 'form','id' => 'ejavan_form')) !!}
          <div class="form-group has-feedback">
            <input type="text" id="email" name="email" class="form-control" placeholder="ایمیل" autofocus>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" id="password" name="password" class="form-control" placeholder="رمز ورود">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group row">
			  <div class="col-md-2" style="margin-top: 9px;">
				<a  href="javascript:void(0)" onclick="refreshCaptcha()"><i class="fa fa-refresh"></i></a>
			  </div>
			  <div class="col-md-5 refereshrecapcha">
				{!! \Mews\Captcha\Facades\Captcha::img() !!}
			  </div>
			  <div class="col-md-5 ">
				<input type="captcha" id="captcha" name="captcha" class="form-control" placeholder="کد امنیتی">
			  </div>
          </div>
		  <div class="row">
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">ورود</button>
            </div><!-- /.col -->
            <div class="col-xs-8">
            </div><!-- /.col -->
          </div>
        {!! Form::close() !!}

        <a href="#">فراموشی رمز عبور</a><br>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
	
	<script>
	
	function refreshCaptcha(){
		$.ajax({
			url: "{{asset('refereshcapcha')}}",
			type: 'get',
			  dataType: 'html',        
			  success: function(json) {
				$('.refereshrecapcha').html(json);
			  },
			  error: function(data) {
				alert('Try Again.');
			  }
		});
	}
	
</script>		

  </body>
</html>

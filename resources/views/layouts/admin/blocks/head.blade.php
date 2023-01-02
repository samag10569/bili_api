
<head>
    <meta charset="UTF-8">
    <title>@yield('title' , 'پنل مدیریت')</title>
	<!-- Favicon -->
	<link rel="shortcut icon" href="{{ asset('assets/admin/img/favicon.png')}}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link rel="stylesheet" href="{{asset('assets/admin/bootstrap/css/bootstrap.min.css')}}">
    <!-- ejavan css -->
    <link rel="stylesheet" href="{{asset('assets/admin/css/ejavan_style.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/admin/css/font-awesome.min.css')}}">
    <!-- Ionicons 2.0.0 -->
    <link rel="stylesheet" href="{{asset('assets/admin/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/admin/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('assets/admin/dist/css/skins/_all-skins.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/iCheck/flat/blue.css')}}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/morris/morris.css')}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">
    <!-- Date Picker 
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/datepicker/datepicker3.css')}}">
   
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/daterangepicker/daterangepicker-bs3.css')}}">
	-->
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{asset('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/admin/dist/fonts/fonts-fa.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/dist/css/bootstrap-rtl.min.css')}}">
	
	

	<!-- jQuery 2.1.4 -->
    <script src="{{ asset('assets/admin/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets/admin/js/jquery-ui.min.js')}}"></script>
    <!-- Validation -->
    <script src="{{ asset('assets/admin/js/jquery.validate.min.js')}}"></script>
    <!-- CKEditor -->
    <script src="{{ asset('assets/ckeditor/ckeditor.js')}}"></script>
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->
	@yield('css')
  </head>
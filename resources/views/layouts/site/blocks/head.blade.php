<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>
        @yield('title',$setting->title)
    </title>

    <meta name="author" content="{{$setting->title}}">
    <meta name="description" content="@yield('description' , $setting->description)">
    <meta name="keywords" content="@yield('keywords' , $setting->keyword)">
    <meta property="og:image" content="{!!asset('assets/uploads/setting/'.$setting->logo_header)!!}">

    <!-- Mobile specific metas
        ============================================ -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Favicon
    ============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="{!!asset('assets/uploads/setting/'.$setting->favicon)!!}">

    <!-- STYLES -->
    <link rel="stylesheet" href="{!! asset('assets/site/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/site/css/bootstrap-rtl.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/site/css/font-awesome.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/site/css/animation.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/site/css/base.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/site/css/style.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/site/css/responsive.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/site/css/jquery.powertip.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/site/css/bootstrap-select.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/site/css/select2.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/site/css/ejavan_style.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/site/css/toastr.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/site/css/chart.css') !!}">
    <script src="{!! asset('assets/site/js/jquery.js') !!}"></script>
    <script src="{!! asset('assets/site/js/toastr.js') !!}"></script>
    <script src="{!! asset('assets/site/js/chart.js') !!}"></script>
    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "3000",
            "hideDuration": "10000",
            "timeOut": "50000",
            "extendedTimeOut": "10000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    </script>
    @yield('css')

</head>
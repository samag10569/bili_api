@extends ("layouts.admin.master")
@section('title','آمارگیر پیشرفته')
@section('part','آمارگیر پیشرفته')
@section('content')
    @include('layouts.admin.blocks.message')
    <div class="row">

        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title" style="color: #3c8dbc;">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                        &nbsp;&nbsp;
                        آمارهای ثبت نام کاربران
                    </h3>
                    <div class="box-tools"> <i class="fa fa-minus minimize"></i> </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th> کاربران ثبت نام شده کل</th>
                            <th>{{$users_active+$users_notactive+$users_notregister}}</th>
                        </tr>

                        <tr>
                            <th>کاربران فعال شده </th>
                            <th>{{$users_active}}</th>
                        </tr>

                        <tr>
                            <th>کاربران غیر فعال </th>
                            <th>{{$users_notactive}}</th>
                        </tr>

                        <tr>
                            <th>کاربران تکمیل عضویت نکرده </th>
                            <th>{{$users_notregister}}</th>
                        </tr>

                        <tr>
                            <th>فروشگاه های فعال </th>
                            <th>{{$shops_active}}</th>
                        </tr>

                        <tr>
                            <th>فروشگاه های  غیر فعال </th>
                            <th>{{$shops_notactive}}</th>
                        </tr>

                    </table>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>

    <div class="row">

        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title" style="color: #3c8dbc;">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                        &nbsp;&nbsp;
                        آمار بازدید یک ماه گذشته
                    </h3>
                    <div class="box-tools"><i class="fa fa-plus minimize"></i>  </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding closed" style="display: none">
                    <table class="table table-hover">
                        <tr>
                            <th>عنوان</th>
                            <th>تعداد</th>
                        </tr>

                            <tr>
                                <td>ویدیو</td>
                                <td>{{$counts['this_month_ads_video_hits']}}</td>
                            </tr>
                        <tr>
                            <td>تصاویر</td>
                            <td>{{$counts['this_month_ads_image_hits']}}</td>
                        </tr>
                        <tr>
                            <td>بیلبورد</td>
                            <td>{{$counts['this_month_ads_billboard_hits']}}</td>
                        </tr>
                        <tr>
                            <td>متن</td>
                            <td>{{$counts['this_month_ads_text_hits']}}</td>
                        </tr>
                        <tr>
                            <td>اپ</td>
                            <td>{{$counts['this_month_ads_apps_hits']}}</td>
                        </tr>



                    </table>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>

    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title" style="color: #3c8dbc;">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    &nbsp;&nbsp;
                    آمار بازدید ماه قبل
                </h3>
                <div class="box-tools"><i class="fa fa-plus minimize"></i>  </div>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive no-padding closed" style="display: none">
                <table class="table table-hover">
                    <tr>
                        <th>عنوان</th>
                        <th>تعداد</th>
                    </tr>

                    <tr>
                        <td>ویدیو</td>
                        <td>{{$counts['before_month_ads_video_hits']}}</td>
                    </tr>
                    <tr>
                        <td>تصاویر</td>
                        <td>{{$counts['before_month_ads_image_hits']}}</td>
                    </tr>
                    <tr>
                        <td>بیلبورد</td>
                        <td>{{$counts['before_month_ads_billboard_hits']}}</td>
                    </tr>
                    <tr>
                        <td>متن</td>
                        <td>{{$counts['before_month_ads_text_hits']}}</td>
                    </tr>
                    <tr>
                        <td>اپ</td>
                        <td>{{$counts['before_month_ads_apps_hits']}}</td>
                    </tr>



                </table>

            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>


    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title" style="color: #3c8dbc;">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    &nbsp;&nbsp;
                    آمار بازدید  12 ماه قبل
                </h3>
                <div class="box-tools"><i class="fa fa-plus minimize"></i>  </div>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive no-padding closed" style="display: none">
                <table class="table table-hover">
                    <tr>
                        <th>عنوان</th>
                        <th>تعداد</th>
                    </tr>

                    <tr>
                        <td>ویدیو</td>
                        <td>{{$counts['one_year_ads_video_hits']}}</td>
                    </tr>
                    <tr>
                        <td>تصاویر</td>
                        <td>{{$counts['one_year_ads_image_hits']}}</td>
                    </tr>
                    <tr>
                        <td>بیلبورد</td>
                        <td>{{$counts['one_year_ads_billboard_hits']}}</td>
                    </tr>
                    <tr>
                        <td>متن</td>
                        <td>{{$counts['one_year_ads_text_hits']}}</td>
                    </tr>
                    <tr>
                        <td>اپ</td>
                        <td>{{$counts['one_year_ads_apps_hits']}}</td>
                    </tr>



                </table>

            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>

    </div>
    <div class="row">

        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title" style="color: #3c8dbc;">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                        &nbsp;&nbsp;
                        آمارهای ثبت نام کاربران - روزانه
                    </h3>
                    <div class="box-tools"><i class="fa fa-plus minimize"></i>  </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding closed" style="display: none">
                    <table class="table table-hover">
                        <tr>
                            <th>تاریخ</th>
                            <th>کاربران ثبت نام شده</th>
                        </tr>
                        @foreach($users as $key=>$user)

                        <tr>
                            <td>{{$key}}</td>
                            <td>{{$user}}</td>
                        </tr>


                            @endforeach

                    </table>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>



    <div class="row">

        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title" style="color: #3c8dbc;">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                        &nbsp;&nbsp;
                        آمارهای بازدید تصاویر - روزانه
                    </h3>
                    <div class="box-tools"> <i class="fa fa-plus minimize"></i> </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding closed" style="display: none">
                    <table class="table table-hover">
                        <tr>
                            <th>تاریخ</th>
                            <th>تعداد</th>
                        </tr>
                        @foreach($ads_image_hits as $key=>$count)

                            <tr>
                                <td>{{$key}}</td>
                                <td><span class="label-success label" >{{$count}}</span></td>
                            </tr>


                        @endforeach

                    </table>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>


    <div class="row">

        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title" style="color: #3c8dbc;">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                        &nbsp;&nbsp;
                        آمارهای بازدید ویدیو - روزانه
                    </h3>
                    <div class="box-tools"> <i class="fa fa-plus minimize"></i> </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding closed" style="display: none">
                    <table class="table table-hover">
                        <tr>
                            <th>تاریخ</th>
                            <th>تعداد</th>
                        </tr>
                        @foreach($ads_video_hits as $key=>$count)

                            <tr>
                                <td>{{$key}}</td>
                                <td><span class="label-success label" >{{$count}}</span></td>
                            </tr>


                        @endforeach

                    </table>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>


    <div class="row">

        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title" style="color: #3c8dbc;">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                        &nbsp;&nbsp;
                        آمارهای بازدید متن - روزانه
                    </h3>
                    <div class="box-tools"> <i class="fa fa-plus minimize"></i> </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding closed" style="display: none">
                    <table class="table table-hover">
                        <tr>
                            <th>تاریخ</th>
                            <th>تعداد</th>
                        </tr>
                        @foreach($ads_text_hits as $key=>$count)

                            <tr>
                                <td>{{$key}}</td>
                                <td><span class="label-success label" >{{$count}}</span></td>
                            </tr>


                        @endforeach

                    </table>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>


    <div class="row">

        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title" style="color: #3c8dbc;">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                        &nbsp;&nbsp;
                        آمارهای بازدید بیلبورد - روزانه
                    </h3>
                    <div class="box-tools"> <i class="fa fa-plus minimize"></i> </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding closed" style="display: none">
                    <table class="table table-hover">
                        <tr>
                            <th>تاریخ</th>
                            <th>تعداد</th>
                        </tr>
                        @foreach($ads_billboard_hits as $key=>$count)

                            <tr>
                                <td>{{$key}}</td>
                                <td><span class="label-success label" >{{$count}}</span></td>
                            </tr>


                        @endforeach

                    </table>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>


    <div class="row">

        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title" style="color: #3c8dbc;">
                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                        &nbsp;&nbsp;
                        آمارهای بازدید اپ - روزانه
                    </h3>
                    <div class="box-tools"> <i class="fa fa-plus minimize"></i> </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding closed" style="display: none">
                    <table class="table table-hover">
                        <tr>
                            <th>تاریخ</th>
                            <th>تعداد</th>
                        </tr>
                        @foreach($ads_apps_hits as $key=>$count)

                            <tr>
                                <td>{{$key}}</td>
                                <td><span class="label-success label" >{{$count}}</span></td>
                            </tr>


                        @endforeach

                    </table>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>



@stop

@section('css')
    <link href="{{ asset('assets/admin/css/jquery.pdtp.css')}}" rel="stylesheet">
    <style>
        ul {
            padding: 0px;
            margin: 0px;
        }

        #response {
            padding: 10px;
            direction: rtl;
            background-color: lawngreen;
            border: 2px solid #396;
            margin-bottom: 20px;
        }

        #list li {
            margin: 0 0 3px;
            direction: rtl;
            padding: 8px;
            background-color: #70ab31;
            color: #000;
            list-style: none;
        }
    </style>
    <input type="hidden" id="csrf-token" value="{!! csrf_token() !!}"/>
@stop


@section('js')

    <script src="{{ asset('assets/admin/js/jalaali.js')}}"></script>
    <script src="{{ asset('assets/admin/js/jquery.pdtp.js')}}"></script>

    <script>
       $( document ).ready(function() {
            $('#task1').on('click',function(){
                $.ajax({
                    method: "POST",
                    dataType: 'json',
                    url: '{!!URL::action('Admin\ReportProController@postTask1')!!}',
                    data: { _token: $('#csrf-token').val() ,date: $('#Date1').val() },
                    success: function(row) {
                        if(row.status=='1')
                            $('#inputStandard').val(row.data)
                        else {
                            $('#inputStandard').val(row.error.date)
                        }
                    }
                });
                return false;
            });
           $('#task2').on('click',function(){
               $.ajax({
                   method: "POST",
                   dataType: 'json',
                   url: '{!!URL::action('Admin\ReportProController@postTask2')!!}',
                   data: { _token: $('#csrf-token').val() ,start: $('#Date2').val(),end: $('#Date3').val() },
                   success: function(row) {
                       if(row.status=='1')
                           $('#inputStandard2').html(row.data).show();
                       else {
                           $('#inputStandard2').html(row.error.date).show();
                       }
                   }
               });
               return false;
           });
        });

        $(document).ready(function () {
            $('#check-all').change(function () {
                $(".delete-all").prop('checked', $(this).prop('checked'));
            });
        });

        $(document).ready(function () {
            function slideout() {
                setTimeout(function () {
                    $("#response").slideUp("slow", function () {
                    });

                }, 2000);
            }

            $("#response").hide();
            $(function () {
                $("#list ul").sortable({
                    opacity: 0.8, cursor: 'move', update: function () {
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        var order = $(this).sortable("serialize") + '&update=update' + '&_token=' + CSRF_TOKEN;
                        //	alert(order);
                        $.post("{!!URL::action('Admin\AllotmentController@postSort')!!} ", order, function (theResponse) {
                            $("#response").html(theResponse);
                            $("#response").slideDown('slow');
                            slideout();
                        });

                    }
                });
            });

        });
    </script>

@stop
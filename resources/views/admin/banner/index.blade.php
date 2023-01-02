@extends ("layouts.admin.master")
@section('title','بنرها')
@section('part','بنرها')
@section('content')
    <div class="row">
        @include('layouts.admin.blocks.message')
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">لیست بنرها</h3>
                    {!! Form::open(array('action' => array('Admin\BannerController@postDelete'),'style'=>'float: left')) !!}
                    <div class="box-tools">
                        <a href="#" data-toggle="modal" data-target="#search"  class="btn btn-info btn-xs">
                            <i class="fa fa-search"></i> جستجو
                        </a>

                        <a class="btn btn-success btn-xs" href="{{URL::action('Admin\BannerController@getAdd')}}" data-toggle="tooltip"
                           data-original-title="آیتم جدید">
                            <i class="fa fa-plus"></i> جدید
                        </a>



                        <button type="submit" onclick="return confirm('آیا از حذف اطلاعات مطمئن هستید.');"
                                data-toggle="tooltip"
                                data-original-title="حذف موارد انتخابی"
                                class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> حذف انتخاب شده ها
                        </button>


                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>
                                <center>
                                    <input id="check-all" style="opacity: 1;position:static;" type="checkbox"/>
                                </center>
                            </th>
                            <th>عنوان</th>
                            <th>لینک</th>
                            <th>قسمت</th>
                            <th>تصویر</th>
                            <th>وضعیت</th>
                            <th>تاریخ ثبت</th>
                            <th>عملیات</th>
                        </tr>
                        @foreach($data as $row)

                            <tr>
                                <td>
                                    <center>
                                        <input style="opacity: 1;position:static;" name="deleteId[]" class="delete-all"
                                               type="checkbox"
                                               value="{{$row['id']}}"/>

                                    </center>
                                </td>
                                <td>{{$row->title}}</td>
                                <td>{{$row->link}}</td>
                                <td>{{$row->section}}</td>


                                <td>
                                    @if(file_exists('assets/uploads/banner/medium/'.$row->image))
                                        <img src="{!! asset('assets/uploads/banner/medium/'.$row->image) !!}"
                                             class="img-rounded"
                                             style="width: 100px; height: 60px;">
                                    @else
                                        <img src="{!! asset('assets/uploads/notFound.jpg') !!}"
                                             class="img-rounded"
                                             style="width: 100px; height: 60px;">
                                    @endif
                                </td>
                                <td>
                                    <center>
                                        @if($row->status==1)
                                            <span class='label label-success'>فعال</span>
                                        @else
                                            <span class='label label-danger'>غیر فعال</span>
                                        @endif
                                    </center>
                                </td>
                                <td>{{jdate('Y/m/d',$row->created_at->timestamp)}}</td>

                                <td>
                                    <center>
                                        <a href="{{URL::action('Admin\BannerController@getEdit',$row->id)}}" data-toggle="tooltip"
                                           data-original-title="ویرایش " class="btn btn-warning  btn-xs">
                                            ویرایش
                                            <i class="fa fa-edit"></i> </a>
                                    </center>
                                </td>

                            </tr>

                        @endforeach

                    </table>
                    {!!Form::close()!!}
                    <center>
                        @if(count($data))
                            {!! $data->appends(Request::except('page'))->render() !!}
                        @endif
                    </center>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>

    <div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
        {!! Form::open(array(URL::current(),'class' => 'form-horizontal','method' => 'GET')) !!}
        {!! Form::hidden('search','search') !!}
        <div class="modal-dialog" style="direction: rtl;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="messageModalLabel"
                        style="direction: rtl; text-align: right; padding-right: 20px;"><i class="fa fa-search"></i> جستجو
                    </h4>
                </div>
                <div class="modal-body" style="text-align: justify;">
                    <div class="widget flat radius-bordered">
                        <div class="widget-body">
                            <div id="registration-form">
                                <div class="form-group">
                                    {!! Form::label('start','ازتاریخ',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-9">
                                        {!! Form::text('start',null,array('class'=>'form-control date','placeholder' => 'ازتاریخ')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('end','تا تاریخ',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-9">
                                        {!! Form::text('end',null,array('class'=>'form-control date' ,'placeholder' => 'تا تاریخ')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('title','عنوان',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-9">
                                        {!! Form::text('title',null,array('class'=>'form-control','placeholder' => 'نام')) !!}
                                    </div>

                                </div>




                            </div>
                        </div>
                    </div>
                    <button type="submit" data-toggle="tooltip" data-original-title="جستجو" class="btn btn-blue">جستجو
                    </button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@stop

@section('css')
    <link href="{{ asset('assets/admin/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
@stop


@section('js')

    <script src="{{ asset('assets/admin/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-datepicker.fa.min.js')}}"></script>

    <script>

        $(".date").datepicker({
            changeMonth: true,
            changeYear: true,
            isRTL: true
        });

        function caller(x) {
            $.ajax({
                url: x,
                success: function (x) {
                    var data = JSON.parse(x);
                    $("#"+data.id).html(data.phone_call);
                }
            });
        }

        $(document).ready(function () {
            $('#check-all').change(function () {
                $(".delete-all").prop('checked', $(this).prop('checked'));
            });
        });

        (function($,W,D)
        {
            var JQUERY4U = {};

            JQUERY4U.UTIL =
            {
                setupFormValidation: function()
                {
                    //form validation rules
                    $("#ejavan_form").validate({
                        rules: {
                            title: "required",
                            image: "required",

                        },
                        messages: {
                            title: "این فیلد الزامی است.",
                            image: "این فیلد الزامی است.",

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
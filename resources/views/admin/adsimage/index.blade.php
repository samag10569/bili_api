@extends ("layouts.admin.master")
@section('title','لیست تبلیغات تصویری')
@section('part','لیست تبلیغات تصویری')
@section('content')
    <div class="row">
        @include('layouts.admin.blocks.message')
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">لیست</h3>
                    {!! Form::open(array('action' => array('Admin\AdsImageController@postDelete'),'style'=>'float: left')) !!}
                    <div class="box-tools">
                        <a href="#" data-toggle="modal" data-target="#search" class="btn btn-info btn-xs">
                            <i class="fa fa-search"></i> جستجو
                        </a>

                        {{--<a class="btn btn-success btn-xs" href="{{URL::action('Admin\AdsImageController@getAdd')}}"
                           data-toggle="tooltip"
                           data-original-title="آیتم جدید">
                            <i class="fa fa-plus"></i> جدید
                        </a>--}}

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
                            <th>متن پیام</th>
                            <th>تصویر</th>
                            <th>وضعیت</th>
                            <td>نام و نام خانوادگی ثبت کننده</td>
                            <td>شماره تماس ثبت کننده</td>
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
                                <td>{{str_limit(strip_tags($row->content),40)}}</td>
                                <td>
                                    @if(file_exists('assets/uploads/ads_image/medium/'.$row->image))
                                        <img src="{!! asset('assets/uploads/ads_image/medium/'.$row->image) !!}"
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
                                            <span class='label label-success'>تکمیل شده</span>
                                        @elseif($row->status ==2)
                                            <span class='label label-warning'>در انتظار بررسی</span>
                                        @elseif($row->status ==0)
                                            <span class='label label-danger'>رد شده</span>
                                        @endif
                                    </center>
                                </td>
                                <td>{{$row->user->name}}</td>
                                <td>{{$row->user->mobile}}</td>
                                <td>{{jdate('Y/m/d',$row->created_at->timestamp)}}</td>

                                <td>
                                    <center>
                                        <a href="{{URL::action('Admin\AdsImageController@getEdit',$row->id)}}"
                                           data-toggle="tooltip"
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

    <div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel"
         aria-hidden="true">
        {!! Form::open(array(URL::current(),'class' => 'form-horizontal','method' => 'GET')) !!}
        {!! Form::hidden('search','search') !!}
        <div class="modal-dialog" style="direction: rtl;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="messageModalLabel"
                        style="direction: rtl; text-align: right; padding-right: 20px;"><i class="fa fa-search"></i>
                        جستجو
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
                    $("#" + data.id).html(data.phone_call);
                }
            });
        }

        $(document).ready(function () {
            $('#check-all').change(function () {
                $(".delete-all").prop('checked', $(this).prop('checked'));
            });
        });
    </script>

@stop
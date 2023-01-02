@extends ("layouts.admin.master")
@section('title','لیست   تبلیغات')
@section('part','لیست   تبلیغات')
@section('content')

    <div class="row">
        @include('layouts.admin.blocks.message')
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">لیست</h3>
                    <div class="box-tools">
                        <a href="#" data-toggle="modal" data-target="#search" class="btn btn-info btn-xs">
                            <i class="fa fa-search"></i> جستجو
                        </a>

                        {{--<a class="btn btn-success btn-xs" href="{{URL::action('Admin\AdsOrderController@getAdd')}}"
                           data-toggle="tooltip"
                           data-original-title="آیتم جدید">
                            <i class="fa fa-plus"></i> جدید
                        </a>--}}



                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>

                            <td> ثبت کننده</td>
                            <td>کد شناسه کاربری</td>
                            <th>نوع سفارش</th>
                            <th>مقدار هزینه</th>
                            <td>شماره تماس ثبت کننده</td>
                            <th>تاریخ ثبت</th>
                        </tr>
                        @foreach($data as $row)
                            <tr>


                                <td>{{$row->user->name}}</td>
                                <td>{{$row->user->id}}</td>
                                <td>{{$row->type}} - {{$row->title}}</td>
                                <td><a href="{{route('admin.allads.list2',[$row->type,$row->id])}}">{{$row->price ? $row->price : 0}}</a> </td>

                                <td>{{$row->user->mobile}}</td>
                                <td>{{jdate('Y/m/d',$row->created_at)}}</td>


                            </tr>

                        @endforeach

                    </table>
                    {{--<center>
                        @if(count($data))
                            {!! $data->appends(Request::except('page'))->render() !!}
                        @endif
                    </center>--}}
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
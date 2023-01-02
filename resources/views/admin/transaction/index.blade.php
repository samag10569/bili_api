@extends ("layouts.admin.master")
@section('title','لاگ حساب کاربران')
@section('part','لاگ حساب کاربران')
@section('content')
    <div class="row">
        @include('layouts.admin.blocks.message')
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                    <div class="box-tools">
                        {{--<a href="#" data-toggle="modal" data-target="#search"  class="btn btn-info btn-xs">
                            <i class="fa fa-search"></i> جستجو
                        </a>





--}}
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>#</th>
                            <th>کاربر</th>
                            <th>کد شناسه کاربری</th>
                            <th>مبلغ</th>
                            <th>وضعیت</th>
                            <th>شماره تماس</th>
                            <th>ایمیل</th>

                            {{--<th>نوع</th>
                            <th>توضیحات</th>

                            <th>روش</th>
                            <th>شماره تراکنش</th>--}}
                            <th>تاریخ تراکنش</th>

                        </tr>
                        @php($i=1)
                        @foreach($data as $row)

                            <tr>
                                <td>{{$i++}}</td>
                                <td><a href="{{URL::action('Admin\SearchMemberController@getEdit',$row->user->id)}}">{{$row->user->name}}</a></td>
                                <td>{{$row->user->id}}</td>
                                <td>{{$row->amount}}</td>
                                <td><span class="label-success label">موفق</span></td>

                                <td>{{$row->user->mobile}}</td>
                                <td>{{$row->user->email}}</td>

                                {{--<td>{{$row->type}}</td>
                                <td>{{$row->description}}</td>

                                <td>{{$row->method}}</td>
                                <td>{{$row->transaction_number}}</td>--}}

                                <td>{{$row->action_at}}</td>


                            </tr>

                        @endforeach

                    </table>
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
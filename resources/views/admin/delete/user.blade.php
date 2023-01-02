@extends ("layouts.admin.master")
@section('title','  مدیریت حذف ')
@section('part','مدیریت حذف ')
@section('content')

    <div class="row">
        @include('layouts.admin.blocks.message')
        <div class="col-xs-12">



            <div class="box">



                <div class="box-header">
                    <h3 class="box-title"></h3>
                    {!! Form::open(array('action' => array('Admin\DeleteController@postUser'),'style'=>'float: left')) !!}
                    <div class="box-tools">
                        <a href="#" data-toggle="modal" data-target="#search"  class="btn btn-info btn-xs">
                            <i class="fa fa-search"></i> جستجو
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
							<th>نام</th>
							<th>شناسه کاربری</th>
							<th>ثبت کننده</th>
							<th>وضعیت</th>
							<th>شماره تماس</th>
							<th>ایمیل</th>
							{{--<th>تاریخ عضویت</th>--}}
							<th>تاریخ مصاحبه</th>
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
								<td>{{$row->name.' '.$row->family}}</td>
								<td>{{$row->user_code}}</td>
								<td>
								{{@$row->admin->name.' '.@$row->admin->family}}
								&nbsp;&nbsp;&nbsp;
								@if($row->register_id == '-1')
									- عضویت آنلاین 
								@elseif($row->register_id != '-1' and $row->register_id != null)
									 - معرفی شده توسط {{@$row->register->name.' '.@$row->register->family}}
								@endif
								</td>
								<td>{{@$row->userStatus->title}}</td>
								<td>{{$row->mobile}}</td>
								<td>{{$row->email}}</td>

									{{--<td>{{jdate('Y/m/d',$row->created_at->timestamp)}}</td>--}}
								<td>
								{{jdate('Y/m/d',$row->date_interview)}}
								</td>

                                <td>
                                    <center>
                                        <a href="{{URL::action('Admin\DeleteController@getCancelUser',$row->id)}}" data-toggle="tooltip"
                                           data-original-title=" لغو این کاربر از حذف موقت " class="btn btn-warning  btn-xs">
                                            لغو
                                            <i class="fa fa-close"></i> </a>
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
                                    {!! Form::label('start','ازتاریخ حضور',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-9">
                                        {!! Form::text('start',null,array('class'=>'form-control date','placeholder' => 'ازتاریخ')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('end','تا تاریخ حضور',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-9">
                                        {!! Form::text('end',null,array('class'=>'form-control date' ,'placeholder' => 'تا تاریخ')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('name','  نام',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-9">
                                        {!! Form::text('name',null,array('class'=>'form-control','placeholder' => 'نام')) !!}
                                    </div>

                                </div>

<div class="form-group">
                                    {!! Form::label('family','  نام خانوادگی',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-9">
                                        {!! Form::text('family',null,array('class'=>'form-control','placeholder' => '  نام خانوادگی')) !!}
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
    <meta name="csrf-token" content="{!! csrf_token() !!}"/>
@stop

@section('css')
    <link href="{{ asset('assets/admin/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">

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


                        },
                        messages: {
                            title: "این فیلد الزامی است.",


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

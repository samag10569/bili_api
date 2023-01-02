@extends ("layouts.admin.master")
@section('title','آپلودر')
@section('part','آپلودر')
@section('content')
    <div class="row">
        @include('layouts.admin.blocks.message')
        <div class="col-xs-12">
            <div class="box">
                <div class="box box-primary">
                    <!-- form start -->
                    {!! Form::open(array('action' => array('Admin\UploaderController@postAdd'), 'role' => 'form','id' => 'ejavan_form', 'files'=> true)) !!}
                    <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>عنوان:</label>
                                    {!! Form::text('title',null,array(
                                        'class'=>'form-control',
                                        'placeholder'=>'عنوان را وارد کنید . . .')) !!}
                                </div>
                                <div class="col-md-4">
                                    <label>فایل :</label>
                                    {!! Form::file('image',null,array(
                                        'class'=>'form-control',
                                        'placeholder'=>'فایل را وارد کنید . . .')) !!}
                                </div>
                                <div class="col-md-4 ejavan_col">
                                   <button type="submit" class="btn btn-primary">ذخیره</button>
                                </div>
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div><!-- /.box -->
                </div>


                <div class="box-header">
                    <h3 class="box-title">لیست فایل ها</h3>
                    {!! Form::open(array('action' => array('Admin\UploaderController@postDelete'),'style'=>'float: left')) !!}
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
                            <th>عنوان</th>
                            <th>تصویر</th>
                            <th>آدرس</th>
                            <th>تاریخ ثبت</th>

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
								  <td>
									@php
										$ext = explode('.',$row->image); 
										$extAll = ['jpg', 'jpeg', 'png'];
									@endphp
									@if(isset($ext[1]) and in_array($ext[1], $extAll))
										<img src="{!! asset('assets/uploads/uploader/'.$row->image) !!}" 
											class="img-rounded"
											style="width: 100px; height: 60px;">
									@else
										فایل می باشد
									@endif
								</td>
                                <td><a target="_blank" href="{!! asset('assets/uploads/uploader/'.$row->image) !!}">
                                        {!! asset('assets/uploads/uploader/'.$row->image) !!}
                                    </a> </td>
                                <td>{{jdate('Y/m/d',$row->created_at->timestamp)}}</td>


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
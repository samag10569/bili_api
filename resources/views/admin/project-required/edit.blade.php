@extends ("layouts.admin.master")
@section('title','پروژه  موظفی')
@section('part','پروژه  موظفی')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">پروژه موظفی</h3>
                    <h3 class="box-title" style="float: left;">
                        <button class="btn btn-block bg-olive btn-lg">{{$data->user->user_code}}</button>
                    </h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                @include('layouts.admin.blocks.message')
                {!! Form::model($data,array('action' => array('Admin\ProjectRequiredController@postEdit',$data->id),'role' => 'form','id' => 'ejavan_form')) !!}

				
				@php
					if(Auth::user()->hasPermission('project-required.editProject'))
						$disabled = [];
					else
						$disabled = ['disabled'=>''];
				@endphp
											
                <div class="box-body">
                    <div class="form-group">
                        <label>وضعیت:</label>
                        @foreach($status as $item)
                            &nbsp;&nbsp;&nbsp;
                            {!!Form::radio('status_id', $item->id)!!}
                            <label>{{$item->title}}</label>
                        @endforeach

                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8">
                                <label>عنوان:</label>
                                {!! Form::text('title',null,array(
                                    'class'=>'form-control',
                                    'placeholder'=>'عنوان را وارد کنید . . .')+$disabled) !!}
                            </div>
                            <div class="col-md-2 ejavan_col">
                                @if(file_exists('assets/uploads/required/'.$data->file) and $data->file != '' and $data->file != null)
                                    <a href="{!! asset('assets/uploads/required/'.$data->file) !!}" target="_blank">
                                        دانلود فایل
                                        <i class="fa fa-download"></i>
                                    </a>
                                @else
                                    فایلی برای دانلود وجود ندارد
                                @endif
                            </div>
                            <div class="col-md-2 ejavan_col">
                                <a href="{{URL::action('Admin\ProjectRequiredController@getPdf',$data->id)}}">
                                    دانلود pdf پروژه
                                    <i class="fa fa-download"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label> چکیده</label>
                                {!! Form::textarea('abstract',null,array(
                                'class'=>'form-control',
                                'rows'=>'3',
                                'placeholder'=>'چکیده را وارد کنید . . .')+$disabled) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>متن پروژه</label>
                                {!! Form::textarea('content',null,array(
                                'class'=>'form-control',
                                'rows'=>'3',
                                'placeholder'=>'متن پروژه را وارد کنید . . .')+$disabled) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label> منابع</label>
                                {!! Form::textarea('source',null,array(
                                'class'=>'form-control',
                                'rows'=>'3',
                                'placeholder'=>'منابع را وارد کنید . . .')+$disabled) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label> توضیحات اضافی</label>
                                {!! Form::textarea('description_extra',null,array(
                                'class'=>'form-control',
                                'rows'=>'3',
                                'placeholder'=>'توضیحات اضافی را وارد کنید . . .')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">ذخیره</button>
                    </div>

                    {!! Form::close() !!}
                </div><!-- /.box -->
            </div>
        </div>
        @stop

        @section('js')
            <script type="text/javascript">

                (function ($, W, D) {
                    var JQUERY4U = {};

                    JQUERY4U.UTIL =
                    {
                        setupFormValidation: function () {
                            //form validation rules
                            $("#ejavan_form").validate({
                                rules: {
                                    title: "required",
                                    family: "required",
                                    agree: "required"
                                },
                                messages: {
                                    title: "این فیلد الزامی است.",
                                    family: "این فیلد الزامی است."
                                },
                                submitHandler: function (form) {
                                    form.submit();
                                }
                            });
                        }
                    }

                    //when the dom has loaded setup form validation rules
                    $(D).ready(function ($) {
                        JQUERY4U.UTIL.setupFormValidation();
                    });

                })(jQuery, window, document);


            </script>
@endsection
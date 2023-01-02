@extends ("layouts.admin.master")
@section('title','ویرایش  درجه علمی')
@section('part','ویرایش درجه علمی ')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> ویرایش درجه علمی </h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                @include('layouts.admin.blocks.message')
                {!! Form::model($data,array('action' => array('Admin\DegreeController@postEdit',$data->id),'role' => 'form','files' => 'true','id' => 'ejavan_form')) !!}
                @include('admin.degree.form')
                {!! Form::close() !!}
            </div><!-- /.box -->
        </div>
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
                            min: "required",
                            max: "required"


                        },
                        messages: {
                            title: "این فیلد الزامی است.",
                            min: "این فیلد الزامی است.",
                            max: "این فیلد الزامی است."


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

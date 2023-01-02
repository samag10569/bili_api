@extends ("layouts.admin.master")
@section('title','ویرایش نوع عضویت')
@section('part','ویرایش نوع عضویت')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> ویرایش نوع عضویت</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                @include('layouts.admin.blocks.message')
                {!! Form::model($data,array('action' => array('Admin\MembershipTypeController@postEdit',$data->id),'role' => 'form','files' => 'true','id' => 'ejavan_form')) !!}
                @include('admin.membership-type.form')
                {!! Form::close() !!}
            </div><!-- /.box -->
        </div>
    </div>
@stop



@section('js')

    <script>
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
                            price: "required",
                            time: "required",
                            image: "required"


                        },
                        messages: {
                            title: "این فیلد الزامی است.",
                            price: "این فیلد الزامی است.",
                            time: "این فیلد الزامی است.",
                            image: "این فیلد الزامی است."


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
@endsection
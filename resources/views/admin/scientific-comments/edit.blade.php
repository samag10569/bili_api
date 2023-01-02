@extends ("layouts.admin.master")
@section('title','ویرایش نظر مطالب علمی')
@section('part','ویرایش نظر مطالب علمی')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> ویرایش</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                @include('layouts.admin.blocks.message')
                {!! Form::model($data,array('action' => array('Admin\ScientificCommentsController@postEdit',$data->id),'role' => 'form','files' => 'true','id' => 'ejavan_form')) !!}
                @include('admin.scientific-comments.form')
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
                                    content: "required",

                                },
                                messages: {
                                    title: "این فیلد الزامی است.",
                                    content: "این فیلد الزامی است.",

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
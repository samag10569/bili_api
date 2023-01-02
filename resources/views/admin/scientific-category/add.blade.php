@extends ("layouts.admin.master")
@section('title',' مجموعه مطالب علمی جدید')
@section('part','مجموعه مطالب علمی جدید')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">جدید</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                @include('layouts.admin.blocks.message')
                {!! Form::open(array('action' => array('Admin\ScientificCategoryController@postAdd'), 'role' => 'form','id' => 'ejavan_form', 'files'=> true)) !!}
                @include('admin.scientific-category.form')
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
                                title: "required"

                            },
                            messages: {
                                title: "این فیلد الزامی است."

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
@extends ("layouts.out.master")
@section('title','درخواست های ارسال شده به هسته علمی')
@section('part','درخواست های ارسال شده به هسته علمی')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">درخواست های ارسال شده به هسته علمی</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                @include('layouts.out.blocks.message')
                @if($data->status ==2)
                <div class="alert alert-danger  alert-dismissable" style="margin: 10px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

                    این درخواست بسته شده است
                    <br/>

                </div>
@endif

                {!! Form::model($data,array('action' => array('Out\MessageCoreController@postView',$data->id),'role' => 'form','files' => 'true','id' => 'ejavan_form')) !!}
                @include('out.message-core.form')
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
                            reply: "required"


                        },
                        messages: {
                            reply: "این فیلد الزامی است."


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
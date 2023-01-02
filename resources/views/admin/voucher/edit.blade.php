@extends ("layouts.admin.master")
@section('title','ویرایش ')
@section('part','ویرایش ')
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
                {!! Form::model($data,array('action' => array('Admin\VoucherController@postEdit',$data->id),'role' => 'form','files' => 'true','id' => 'ejavan_form')) !!}
                <div class="box-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>عنوان:</label>
                                {!! Form::text('title',null,array(
                                    'class'=>'form-control',
                                    'placeholder'=>'عنوان را وارد کنید . . .')) !!}
                            </div>
                            <div class="col-md-6">
                                <label>وضعیت:</label>
                                {!! Form::select('status',$status,null,array(
                                    'class'=>'form-control')) !!}
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label>کد  </label>
                                {!! Form::text('code',null,array(
                                    'class'=>'form-control')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>مبلغ تخفیف  </label>
                                {!! Form::number('price',null,array(
                                    'class'=>'form-control')) !!}
                            </div>
                            <div class="col-md-6">
                                <label>درصد تخفیف  </label>
                                {!! Form::number('discount',null,array(
                                    'class'=>'form-control')) !!}
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>از تاریخ  </label>
                                {!! Form::text('from_date',jdate('d/m/Y',$data->from_date,'','','en'),array(
                                    'class'=>'form-control date')) !!}
                            </div>
                            <div class="col-md-6">
                                <label>تا تاریخ  </label>
                                {!! Form::text('to_date',jdate('d/m/Y',$data->to_date,'','','en'),array(
                                    'class'=>'form-control date')) !!}
                            </div>
                        </div>
                    </div>




                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">ذخیره</button>
                    </div>
                </div>
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

    <script type="text/javascript">
        $(document).ready(function(){
            $(".date").datepicker({
                changeMonth: true,
                changeYear: true,
                isRTL: true
            });
        });

    </script>

@stop
@extends ("layouts.admin.master")
@section('title','فروشگاه ها')
@section('part','فروشگاه ها')
@section('content')
    <div class="row">
        @include('layouts.admin.blocks.message')
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">لیست فروشگاه ها</h3>
                    <div class="box-tools">
                        <a href="#" data-toggle="modal" data-target="#search"  class="btn btn-info btn-xs">
                            <i class="fa fa-search"></i> جستجو
                        </a>





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
                            <th>نام مالک</th>
                            <th>تصویر</th>
                            <th>دسته بندی</th>

                            <th>تاریخ ثبت</th>
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
                                <td>{{$row->name}}</td>
                                <td>{{$row->user->mobile}}</td>
                                <td>{{$row->user->name}}</td>
                                <td>
                                    @if(file_exists('assets/uploads/shop/medium/'.$row->image))
                                        <img src="{!! asset('assets/uploads/shop/medium/'.$row->image) !!}"
                                             class="img-rounded"
                                             style="width: 100px; height: 60px;">
                                    @else
                                        <img src="{!! asset('assets/uploads/notFound.jpg') !!}"
                                             class="img-rounded"
                                             style="width: 100px; height: 60px;">
                                    @endif
                                </td>
                                <td>{{@$row->category->title}}</td>

                                <td>{{jdate('Y/m/d',$row->created_at->timestamp)}}</td>

                                <td>
                                    <center>
                                        <a href="{{URL::action('Admin\ShopController@getEdit',$row->id)}}" data-toggle="tooltip"
                                           data-original-title="ویرایش " class="btn btn-warning  btn-xs">
                                            ویرایش
                                            <i class="fa fa-edit"></i> </a>
                                    </center>
                                </td>
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
                                    <div class="col-md-12">
                                        <label>انتخاب دسته یندی  </label>
                                        {!! Form::select('category',$category,null,array(
                                            'class'=>'form-control')) !!}
                                    </div>
                                </div>


                                <div class="form-group">
                                    {!! Form::label('name','نام فروشگاه',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-9">
                                        {!! Form::text('name',null,array('class'=>'form-control','placeholder' => 'نام')) !!}
                                    </div>

                                </div>

                                <div class="form-group">
                                    {!! Form::label('mobile','شناسه کاربری',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-9">
                                        {!! Form::text('mobile',null,array('class'=>'form-control','placeholder' => 'نام')) !!}
                                    </div>

                                </div>
                                <div class="form-group">
                                    {!! Form::label('user','مالک فروشگاه',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-9">
                                        {!! Form::text('user',null,array('class'=>'form-control','placeholder' => 'نام')) !!}
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
    </script>

@stop
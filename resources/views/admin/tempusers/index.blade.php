@extends ("layouts.admin.master")
@section('title','افراد در انتظار تایید')
@section('part','افراد در انتظار تایید')
@section('content')
    <div class="row">
		@include('layouts.admin.blocks.message-ajax')
		@include('layouts.admin.blocks.message')
        {!! Form::open(array('action' => array('Admin\UserController@postDelete'))) !!}
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">

                    <h3 class="box-title">افراد در انتظار تایید</h3>
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
                            <th>کد یکتا</th>
                            <th>نام و نام خانوادگی </th>

                            <th>وضعیت پروفایل</th>
                            <th>شماره تماس</th>
                            <th>ایمیل</th>
                            <th>عملیات</th>
                        </tr>
                        @foreach($data as $row)

                            <tr>
                                <td>{{$row->id}}</td>
                                <td></td>
                                <td>
                                    <center>
                                        <input style="opacity: 1;position:static;" name="deleteId[]" class="delete-all"
                                               type="checkbox"
                                               value="{{$row['id']}}"/>

                                    </center>
                                </td>


                                <td><span class="label-danger">تکمیل نشده</span></td>
                                <td>{{$row->mobile}}</td>

                                <td>{{$row->email}}</td>

                                {{--<td>{{jdate('Y/m/d',$row->created_at->timestamp)}}</td>--}}

                                <td>
                                    <center>

                                            <a href="{{URL::action('Admin\SearchMemberController@getEdit',[$row->id])}}" data-toggle="tooltip"
                                               target="_blank" data-original-title="ویرایش اطلاعات" class="btn btn-warning  btn-xs" id="edit{{$row->id}}"><i
                                                        class="fa fa-edit"></i> ویرایش </a>


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
        {!!Form::close()!!}
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
                                    {!! Form::label('start','عضویت ازتاریخ',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-3">
                                        {!! Form::text('start',null,array('class'=>'form-control date','placeholder' => 'ازتاریخ')) !!}
                                    </div>
                                    {!! Form::label('end','عضویت تا تاریخ',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-3">
                                        {!! Form::text('end',null,array('class'=>'form-control date','placeholder' => 'تا تاریخ')) !!}
                                    </div>
                                </div>



                                <div class="form-group">

                                    {!! Form::label('mobile','شماره همراه',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-3">
                                        {!! Form::text('mobile',null,array('class'=>'form-control')) !!}
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
    <input type="hidden" id="csrf-token" value="{!! csrf_token() !!}"/>
@stop


@section('js')

    <script src="{{ asset('assets/admin/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ asset('assets/admin/js/bootstrap-datepicker.fa.min.js')}}"></script>

    <script type="text/javascript">

		$(document).ready(function () {
			$(".date").datepicker({
				changeMonth: true,
				changeYear: true,
				isRTL: true
			});
		
			$('.loading').hide();
			$('.msgno').hide();
			$('.msgok').hide();
            $('.confirmemail').on('click', function () {
				var id = $(this).attr('data-val');
				$('#loading'+id).show();
				$('#confirmemail'+id).hide();
                var btn=$(this);
                $.ajax({
                    method: "POST",
                    dataType: 'json',
                    url: '{!!URL::action('Admin\TempUsersController@postSendConfirmEmail')!!}',
                    data: {_token: $('#csrf-token').val(), user: $(this).attr('data-val')},
                    success: function (x) {
						$('.msg'+x.status).show();
						$("#msg"+x.status).html(x.msg);
						$('#loading'+id).hide();
                        if (x.status == 'no') {
							$('#confirmemail'+id).show();
                        }
                    }
                });
                return false;
            });
            $('.confirmphone').on('click', function () {
				var id = $(this).attr('data-val');
				$('#loading'+id).show();
				$('#confirmphone'+id).hide();
                var btn=$(this);
                $.ajax({
                    method: "POST",
                    dataType: 'json',
                    url: '{!!URL::action('Admin\TempUsersController@postSendConfirmPhone')!!}',
                    data: {_token: $('#csrf-token').val(), user: $(this).attr('data-val')},
                    success: function (x) {
						$('.msg'+x.status).show();
						$("#msg"+x.status).html(x.msg);
						$('#loading'+id).hide();
                        if (x.status == 'no') {
							$('#confirmphone'+id).show();
                        }
                    }
                });
                return false;
            });
        });


    </script>

@stop
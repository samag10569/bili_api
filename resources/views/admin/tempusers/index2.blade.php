@extends ("layouts.admin.master")
@section('title','افراد در انتظار تایید')
@section('part','افراد در انتظار تایید')
@section('content')
    <div class="row">
		@include('layouts.admin.blocks.message-ajax')
		@include('layouts.admin.blocks.message')
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">افراد در انتظار تایید</h3>
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
                                <input id="check-all" style="opacity: 1;position:static;" type="checkbox"/>
                            </th>
                            <th>نام و نام خانوادگی</th>
                            <th>کد شناسه کاربری</th>
                            <th>وضعیت پروفایل</th>
                            <th>شماره تماس</th>
                            <th>ایمیل</th>
                            <th>ارسال مجدد</th>
                            <th>تایید مدیر</th>
                            <th>تاریخ حضور</th>
                        </tr>
                        @foreach($data as $row)
                            <tr>
                                <td>
                                    <input style="opacity: 1;position:static;" name="deleteId[]" class="delete-all"
                                               type="checkbox"
                                               value="{{$row['id']}}"/>
                                </td>
                                <td>{{$row->name.' '.$row->family}}</td>
                                <td>{{$row->user_code }}</td>
                                <td>
                                    @if($row->profile_complete==1)
                                        <span class='label label-success'>کامل</span>
                                    @else
                                        <span class='label label-danger'>ناتمام</span>
                                    @endif
								</td>
                                <td>
                                    {{$row->mobile}}
                                </td>
                                <td>
                                    {{$row->email}}
                                </td>
                                <td>
                                    
                                    @if($row->phone_confirm==0)
                                        <button class="confirmphone btn btn-danger btn-xs" data-val="{{$row->id}}" data-toggle="tooltip"
											data-original-title="ارسال SMS"  id="confirmphone{{$row->id}}">
											<i class="fa fa-phone"></i>
                                        </button>
                                    @endif
									
                                    @if($row->email_confirm==0)
                                        <button class="confirmemail btn btn-danger btn-xs" data-val="{{$row->id}}" data-toggle="tooltip"
											data-original-title="ارسال Email" id="confirmemail{{$row->id}}">
											<i class="fa fa-envelope"></i>
                                        </button>
                                    @endif
									
									<center class="loading" id="loading{{$row->id}}">
										<img src="{{ asset('assets/admin/img/loading.gif')}}" width="30" height="30"/>
									</center>
										
                                </td>
                                <td>
                                    
                                    @if($row->phone_confirm==0)
                                        <a class="btn btn-info btn-xs" data-toggle="tooltip"
											data-original-title="تایید شماره همراه" href="{{URL::action('Admin\TempUsersController@getMobile',$row->id)}}">
											<i class="fa fa-phone"></i>
                                        </a>
                                    @endif
									
                                    @if($row->email_confirm==0)
                                        <a class="btn btn-info btn-xs" data-toggle="tooltip"
											data-original-title="تایید ایمیل" href="{{URL::action('Admin\TempUsersController@getEmail',$row->id)}}">
											<i class="fa fa-envelope"></i>
                                        </a>
                                    @endif
                                </td>

                                <td>{{jdate('Y/m/d',$row->created_at->timestamp)}}</td>


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
                                    {!! Form::label('start_interview','تاریخ مصاحبه از',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-3">
                                        {!! Form::text('start_interview',null,array('class'=>'form-control date','placeholder' => 'ازتاریخ')) !!}
                                    </div>
                                    {!! Form::label('end_interview','تاریخ مصاحبه تا',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-3">
                                        {!! Form::text('end_interview',null,array('class'=>'form-control date','placeholder' => 'تا تاریخ')) !!}
                                    </div>
                                </div>

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
                                    {!! Form::label('name','نام',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-3">
                                        {!! Form::text('name',null,array('class'=>'form-control','placeholder' => 'نام')) !!}
                                    </div>
                                    {!! Form::label('family','نام خانوادگی',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-3">
                                        {!! Form::text('family',null,array('class'=>'form-control','placeholder' => 'نام خانوادگی')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('user_code','کد شناسه کاربری',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-3">
                                        {!! Form::text('user_code',null,array('class'=>'form-control','placeholder' => 'کد شناسه کاربری')) !!}
                                    </div>
                                    {!! Form::label('id','کد یکتا',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-3">
                                        {!! Form::text('id',null,array('class'=>'form-control','placeholder' => 'کد یکتا')) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('email','ایمیل',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-3">
                                        {!! Form::text('email',null,array('class'=>'form-control')) !!}
                                    </div>
                                    {!! Form::label('mobile','شماره همراه',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-3">
                                        {!! Form::text('mobile',null,array('class'=>'form-control')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('state_id','استان',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-3">
                                        {!! Form::select('state_id',$state_id,null,array('class'=>'form-control')) !!}
                                    </div>
                                    {!! Form::label('sort','مرتب سازی',array('class'=>'col-lg-3 control-label')) !!}
                                    <div class="col-lg-3">
                                        {!! Form::select('sort',$sort,null,array('class'=>'form-control')) !!}
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
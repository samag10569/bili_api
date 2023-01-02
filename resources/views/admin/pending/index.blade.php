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
			  <h3 class="box-title"></h3>
			  
			@if(Auth::user()->hasPermission('pending-member.delete'))
			  {!! Form::open(array('action' => array('Admin\PendingMemberController@postDelete'),'style'=>'float: left')) !!}
		  
				@endif
			  <div class="box-tools">
				<a href="#" data-toggle="modal" data-target="#search"  class="btn btn-info btn-xs">
					<i class="fa fa-search"></i> جستجو
				</a>
				@if(Auth::user()->hasPermission('pending-member.add'))
					<a class="btn btn-success btn-xs" href="{{URL::action('Admin\PendingMemberController@getAdd')}}" data-toggle="tooltip"
									   data-original-title="آیتم جدید">
						<i class="fa fa-plus"></i> جدید 
					</a>
				@endif
				
				@if(Auth::user()->hasPermission('pending-member.delete'))
					
					<button type="submit" onclick="return confirm('آیا از حذف اطلاعات مطمئن هستید.');"
					data-toggle="tooltip"
									   data-original-title="حذف موارد انتخابی"
						class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> حذف انتخاب شده ها
					</button>
					
				@endif
				
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
					<th>ثبت کننده</th>
					<th>وضعیت</th>
					<th>شماره تماس</th>
					<th>ایمیل</th>
					{{--<th>تاریخ عضویت</th>--}}
					<th>تاریخ مصاحبه</th>
					<th>عملیات</th>
				</tr>
				@foreach($data as $row)

					<tr @if($row->mobile == null) class="danger" @endif>
						<td>
							<center>
								<input style="opacity: 1;position:static;" name="deleteId[]" class="delete-all"
									   type="checkbox"
									   value="{{$row['id']}}"/>

							</center>
						</td>
						<td>{{$row->name.' '.$row->family}}</td>
						<td>{{$row->user_code}}</td>
						<td>
						{{@$row->admin->name.' '.@$row->admin->family}}
						&nbsp;&nbsp;&nbsp;
						@if($row->register_id == '-1')
							- عضویت آنلاین 
						@elseif($row->register_id != '-1' and $row->register_id != null)
							 - معرفی شده توسط {{@$row->register->name.' '.@$row->register->family}}
						@endif
						</td>
						<td>{{@$row->userStatus->title}}</td>
						<td>{{$row->mobile}}</td>
						<td>{{$row->email}}</td>

							{{--<td>{{jdate('Y/m/d',$row->created_at->timestamp)}}</td>--}}
						<td>
						{{jdate('Y/m/d',$row->date_interview)}}
						</td>
						<td>
							<center>
							
								@if(Auth::user()->hasPermission('pending-member.edit'))
									<a href="{{URL::action('Admin\PendingMemberController@getEdit',[$row->id])}}" data-toggle="tooltip"
									   data-original-title="ویرایش اطلاعات" class="btn btn-warning  btn-xs" id="edit{{$row->id}}"><i
												class="fa fa-edit"></i> ویرایش </a>
								@endif
								<a data-toggle="tooltip" data-original-title="ارسال دعوت نامه" class="btn btn-info btn-xs email_btn" id="email_btn{{$row->id}}"
								   style="cursor:pointer" onclick="emailSend('{{URL::action('Admin\PendingMemberController@getEmail',$row->id)}}',{{$row->id}})" ><i
											class="fa fa-envelope"></i> </a>
								<center class="loading" id="loading{{$row->id}}">
								<img src="{{ asset('assets/admin/img/loading.gif')}}" width="30" height="30"/>
								در حال ارسال ایمیل لطفا شکیبا باشید.
								</center>
								<a style="cursor:pointer" data-toggle="tooltip"
								   data-original-title="شمارنده تماس" class="btn btn-danger  btn-xs" id="btn_caller{{$row->id}}"
								   onclick="caller('{{URL::action('Admin\PendingMemberController@getCaller',$row->id)}}',{{$row->id}})" ><i
											class="fa fa-phone"></i> 
									<span class="phone_call" id="{{$row->id}}">
									 {{$row->phone_call}}
									 </span>
								</a>
								<span class="loading-call" id="loading-call{{$row->id}}">
								<img src="{{ asset('assets/admin/img/loading.gif')}}" width="30" height="30"/>
								</span>
							</center>
						</td>
					</tr>

				@endforeach
				
			  </table>
			@if(Auth::user()->hasPermission('pending-member.delete'))
			  {!!Form::close()!!}
			@endif
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
                                    {!! Form::text('email',null,array('class'=>'form-control','placeholder' => 'ایمیل')) !!}
                                </div>
                                {!! Form::label('mobile','شماره همراه',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-3">
                                    {!! Form::text('mobile',null,array('class'=>'form-control','placeholder' => 'شماره همراه')) !!}
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
		$('.loading').hide();
		$('.loading-call').hide();
		$('.msgno').hide();
		$('.msgok').hide();
		
		$('#check-all').change(function () {
			$(".delete-all").prop('checked', $(this).prop('checked'));
		});
	});
	
		
		function emailSend(x,id) {
			$('#loading'+id).show();
			$('#btn_caller'+id).hide();
			$('#edit'+id).hide();
			$('.email_btn').hide();
			$.ajax({
				url: x,
				success: function (x) {
					$('#loading'+id).hide();
					$('#btn_caller'+id).show();
					$('#edit'+id).show();
					$('.email_btn').show();
						var data = JSON.parse(x);
						$('.msg'+data.status).show();
						$("#msg"+data.status).html(data.msg);
				},
				error: function(error_thrown){
					alert(error_thrown);
				}
			});
		}
		
		
		function caller(x,id) {
			$('#loading-call'+id).show();
			$('#btn_caller'+id).hide();
			$.ajax({
				url: x,
				success: function (x) {
					$('#loading-call'+id).hide();
					$('#btn_caller'+id).show();
					var data = JSON.parse(x);
					$("#"+data.id).html(data.phone_call);
				}
			});
		}
            
    </script>

@stop
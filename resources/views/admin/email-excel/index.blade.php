@extends ("layouts.admin.master")
@section('title','لیست ایمیل های ثبت شده')
@section('part','لیست ایمیل های ثبت شده')
@section('content')
	<div class="row">
		@include('layouts.admin.blocks.message')
		<div class="col-xs-12">
		  <div class="box">
			<div class="box-header">
			  <h3 class="box-title"></h3>
			  {!! Form::open(array('action' => array('Admin\EmailExcelController@postDeleteError'),'style'=>'float: left')) !!}
			  <div class="box-tools">
				<a href="#" data-toggle="modal" data-target="#search"  class="btn btn-info btn-xs">
					<i class="fa fa-search"></i> جستجو
				</a>
				<a class="btn bg-olive btn-flat btn-xs" href="{{URL::action('Admin\EmailExcelController@getEmail')}}" data-toggle="tooltip"
								   data-original-title="لیست ایمیل ها">
					<i class="fa fa-list"></i>&nbsp;&nbsp; ایمیل های ارسالی 
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
					<th>کد</th>
					<th>نام</th>
					<th>ایمیل</th>
					<th>معرفی شده توسط </th>
					<th>دعوت نامه </th>
					<th>عضویت </th>
					<th>تاریخ</th>
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
						<td>{{$row->id}}</td>
						<td>{{$row->name}}</td>
						<td>{{$row->email}}</td>
						<td>{{@$row->user->name.' '.@$row->user->family}}</td>
						 <td>
							<center>
								@if($row->send_email==1)
									<span class='label label-success'>ارسال شد</span>
								@else
									<span class='label label-danger'>ارسال نشده</span>
								@endif
							</center>
						</td>

						 <td>
							<center>
								@if($row->status==1)
									<span class='label label-success'>فعال</span>
								@else
									<span class='label label-danger'>غیر فعال</span>
								@endif
							</center>
						</td>

						<td>
						{{jdate('Y/m/d H:i',$row->created_at->timestamp)}}
						</td>
					</tr>

				@endforeach
				
			  </table>
			   {!!Form::close()!!}
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
                                {!! Form::label('start','از تاریخ',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-3">
                                    {!! Form::text('start',null,array('class'=>'form-control date','placeholder' => 'از تاریخ')) !!}
                                </div>
                                {!! Form::label('end',' تا تاریخ',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-3">
                                    {!! Form::text('end',null,array('class'=>'form-control date','placeholder' => 'تا تاریخ')) !!}
                                </div>
                            </div>
							
							
							<div class="form-group">
                                {!! Form::label('name','نام',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-3">
                                    {!! Form::text('name',null,array('class'=>'form-control','placeholder' => 'نام')) !!}
                                </div>
                                {!! Form::label('user_id','کد یکتا معرف',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-3">
                                    {!! Form::text('user_id',null,array('class'=>'form-control','placeholder' => 'کد یکتا معرف')) !!}
                                </div>
                            </div>
							
                           <div class="form-group">
                                {!! Form::label('email','ایمیل',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-9">
                                    {!! Form::text('email',null,array('class'=>'form-control')) !!}
                                </div>
                            </div>
							
							
							<div class="form-group">
                                {!! Form::label('status','عضویت',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-3">
                                   {!! Form::select('status',$status,null,array('class'=>'form-control')) !!}
                                </div>
                                {!! Form::label('send_email','دعوت نامه',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-3">
                                   {!! Form::select('send_email',$send_email,null,array('class'=>'form-control')) !!}
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
		 $(document).ready(function () {
            $('#check-all').change(function () {
                $(".delete-all").prop('checked', $(this).prop('checked'));
            });
        });
    </script>

@stop
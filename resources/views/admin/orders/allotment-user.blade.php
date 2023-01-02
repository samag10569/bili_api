@extends ("layouts.admin.master")
@section('title','لیست کاربران')
@section('part',' لیست کاربران '.@$data[0]->allotment->title)
@section('content')
	<div class="row">
		@include('layouts.admin.blocks.message')
		<div class="col-xs-12">
		  <div class="box">
			<div class="box-header">
			  <h3 class="box-title"></h3>
			  <div class="box-tools">
				<a href="#" data-toggle="modal" data-target="#search"  class="btn btn-info btn-xs">
					<i class="fa fa-search"></i> جستجو
				</a>
				
			  </div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
			  <table class="table table-hover">
					<th>شماره فاکتور</th>
					<th>کاربر</th>
					<th>کد شناسه کاربری</th>
					<th>مبلغ پرداختی</th>
					<th>وضعیت</th>
					<th>شماره تماس</th>
					<th>ایمیل</th>
					<th>تاریخ پرداخت</th>
					<th>عملیات</th>
				</tr>
				@foreach($data as $row)
					<tr>
						<td>{{$row->id}}</td>
						<td>{{@$row->orders->user->name.' '.@$row->orders->user->family}}</td>
						<td>{{@$row->orders->user->user_code}}</td>
						<td>{{number_format($row->total_price)}}</td>
						<td>
							<center>
								@if($row->status)
									<span class='label label-success'>پرداخت شده</span>
								@else
									<span class='label label-danger'>پرداخت نشده</span>
								@endif
							</center>
						</td>
						<td>{{@$row->orders->user->mobile}}</td>
						<td>{{@$row->orders->user->email}}</td>
						<td>{{jdate('Y/m/d H:i',$row->created_at->timestamp)}}</td>
						<td>
							<center>
								<a href="{{URL::action('Admin\OrdersController@getFactor',[$row->id])}}" data-toggle="tooltip"
								   data-original-title="مشاهده فاکتور" class="btn btn-info  btn-xs"><i
											class="fa fa-file"></i> مشاهده فاکتور </a>
								<a href="{{URL::action('Admin\SearchMemberController@getEdit',[$row->user_id])}}" data-toggle="tooltip"
								   data-original-title="ویرایش کاربر" class="btn btn-warning  btn-xs"><i
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
                                {!! Form::label('start','تاریخ از',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-3">
                                    {!! Form::text('start',null,array('class'=>'form-control date','placeholder' => 'ازتاریخ')) !!}
                                </div>
                                {!! Form::label('end','تاریخ تا',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-3">
                                    {!! Form::text('end',null,array('class'=>'form-control date','placeholder' => 'تا تاریخ')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('user_code','کد کاربری',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-3">
                                    {!! Form::text('user_code',null,array('class'=>'form-control','placeholder' => 'کد کاربری')) !!}
                                </div>
                                {!! Form::label('user_id','کد یکتا',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-3">
                                    {!! Form::text('user_id',null,array('class'=>'form-control','placeholder' => 'کد یکتا')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('email','ایمیل',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-9">
                                    {!! Form::text('email',null,array('class'=>'form-control','placeholder' => 'ایمیل')) !!}
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
		});
    </script>

@stop
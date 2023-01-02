@extends ("layouts.admin.master")
@section('title','اعضای طلایی و الماسی')
@section('part','اعضای طلایی و الماسی')
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
				<tr>
					<th>نام</th>
					<th>شناسه کاربری</th>
					<th>ثبت کننده</th>
					<th>نوع عضویت</th>
					<th>وضعیت</th>
					<th>شماره تماس</th>
					<th>ایمیل</th>
					{{--<th>تاریخ عضویت</th>--}}
					<th>تاریخ مصاحبه</th>
					<th>عملیات</th>
				</tr>
				@foreach($data as $row)

					<tr>
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
						<td>
							{{@$row->info->membershipType->title}}
							@if($row->info->date_membership_type != null)
								- {{jdate('Y/m/d',$row->info->date_membership_type)}}
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
								<a href="{{URL::action('Admin\OrdersController@getEdit',[$row->id])}}" data-toggle="tooltip"
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
                                <div class="col-lg-9">
                                    {!! Form::text('email',null,array('class'=>'form-control')) !!}
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
		});
			
    </script>

@stop
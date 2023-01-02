@extends ("layouts.admin.master")
@section('title','تراکنش ها')
@section('part','تراکنش ها')
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
					<th>شماره تراکنش</th>
					<th>کاربر</th>
					<th>کد کاربری</th>
					<th>شماره تماس</th>
					<th>بانک</th>
					<th>کد پیگیری</th>
					<th>مبلغ پرداختی</th>
					<th>وضعیت</th>
					<th>تاریخ</th>
				</tr>
				@foreach($data as $row)
					<tr @if($row->status == 'SUCCEED') class="success" @else class="danger" @endif>
						<td>{{$row->id}}</td>
						<td>
						@if($row->type == 'allotment')
							{{@$row->orders->user->name .' '.@$row->orders->user->family}} - خدمات
						@elseif($row->type == 'membership')	
							{{@$row->ordersMembershipType->user->name .' '.@$row->ordersMembershipType->user->family}} - عضویت ویژه
						@endif
						</td>
						<td>
						@if($row->type == 'allotment')
							{{@$row->orders->user->user_code}}
						@elseif($row->type == 'membership')	
							{{@$row->ordersMembershipType->user->user_code}}
						@endif
						</td>
						<td>
						@if($row->type == 'allotment')
							{{@$row->orders->user->mobile}}
						@elseif($row->type == 'membership')	
							{{@$row->ordersMembershipType->user->mobiley}}
						@endif
						</td>
						<td>{{$row->port}}</td>
						<td>{{$row->tracking_code}}</td>
						<td>{{number_format($row->price)}}</td>
						<td>
							<center>
								@if($row->status == 'SUCCEED')
									<span class='label label-success'>پرداخت شده</span>
								@elseif($row->status == 'INIT')
									<span class='label label-warning'>مشکل از درگاه</span>
								@else
									<span class='label label-danger'>پرداخت نشده</span>
								@endif
							</center>
						</td>
						<td>{{$row->created_at}}</td>
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
                                 {!! Form::label('price','مبلغ پرداختی',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-3">
                                    {!! Form::text('price',null,array('class'=>'form-control','placeholder' => 'مبلغ پرداختی')) !!}
                                </div>
                                {!! Form::label('tracking_code','کد رهگیری',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-3">
                                    {!! Form::text('tracking_code',null,array('class'=>'form-control','placeholder' => 'کد رهگیری')) !!}
                                </div>
                            </div>
							
                            <div class="form-group">
                                {!! Form::label('status','وضعیت',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-9">
                                   {!! Form::select('status',$status,null,array('class'=>'form-control')) !!}
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
@extends ("layouts.admin.master")
@section('title','ارسال SMS به کاربران')
@section('part','ارسال SMS به کاربران')
@section('content')
	<div class="row">
		@include('layouts.admin.blocks.message')
		<div class="col-xs-12">
		  <div class="box">
			<div class="box-header">
			  <h3 class="box-title"></h3>
			  {!! Form::open(array('action' => array('Admin\SmsSendController@postDelete'),'style'=>'float: left')) !!}
			  <div class="box-tools">
				<a href="#" data-toggle="modal" data-target="#search"  class="btn btn-info btn-xs">
					<i class="fa fa-search"></i> جستجو
				</a>
				
				<a class="btn btn-success btn-xs" href="{{URL::action('Admin\SmsSendController@getAdd')}}" data-toggle="tooltip"
								   data-original-title="آیتم جدید">
					<i class="fa fa-plus"></i> جدید 
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
					<th>متن</th>
					<th>تعداد ارسالی درهر بار </th>
					<th>کل </th>
					<th>ارسال شده </th>
					<th>در صف </th>
					<th>روند تکمیل ارسال </th>
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
						<td>{{$row->content}}</td>
						<td>{{$row->count}}</td>
						<td>{{count($row->smsUser)}}</td>
						<td>{{count($row->smsUserSuccess)}}</td>
						<td>{{count($row->smsUserFaild)}}</td>
						<td>
						@php
							if(count($row->smsUser) == 0)
								$persent = 0;
							else
								$persent = (count($row->smsUserSuccess)*100)/count($row->smsUser);
						@endphp
						<span>
							{{round($persent)}} درصد 
						</span>
							<div class="progress progress-sm active">
								<div class="progress-bar @if($persent == 100) progress-bar-success @else progress-bar-warning @endif progress-bar-striped" role="progressbar" 
									aria-valuenow="{{count($row->smsUserSuccess)}}" aria-valuemin="0" aria-valuemax="{{count($row->smsUser)}}"
									style="width: {{$persent}}%">
									<span class="sr-only"></span>
								</div>
							</div>
						</td>
						<td>
						{{jdate('Y/m/d',$row->created_at->timestamp)}}
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
                                {!! Form::label('start','ازتاریخ',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-9">
                                    {!! Form::text('start',null,array('class'=>'form-control date','placeholder' => 'ازتاریخ')) !!}
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('end','تا تاریخ',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-9">
                                    {!! Form::text('end',null,array('class'=>'form-control date' ,'placeholder' => 'تا تاریخ')) !!}
                                </div>
                            </div>
							
                            <div class="form-group">
                                {!! Form::label('subject','عنوان',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-9">
                                    {!! Form::text('subject',null,array('class'=>'form-control')) !!}
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
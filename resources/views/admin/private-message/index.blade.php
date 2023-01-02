@extends ("layouts.admin.master")
@section('title','مدیریت پیام های خصوصی')
@section('part','مدیریت پیام های خصوصی')
@section('content')
	<div class="row">
		@include('layouts.admin.blocks.message')
		<div class="col-xs-12">
		  <div class="box">
			<div class="box-header">
			  <h3 class="box-title"></h3>
			  {!! Form::open(array('action' => array('Admin\PrivateMessagesController@postDelete'),'style'=>'float: left')) !!}
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
					<th>فرستنده</th>
					<th>گیرنده</th>
					<th>موضوع</th>
					<th>تاریخ</th>
					<th>عملیات</th>
				</tr>
				@foreach($data as $row)

					<tr>
						<td>
								<input style="opacity: 1;position:static;" name="deleteId[]" class="delete-all"
									   type="checkbox"
									   value="{{$row['id']}}"/>
						</td>
						<td>
							@if($row->sender)
							{{$row->sender->name.' '.$row->sender->family}}
							@endif
						</td>
						<td>
							@if($row->receiver)
							{{$row->receiver->name.' '.$row->receiver->family}}
							@endif
						</td>
						<td>{{$row->subject}}</td>
						<td>
							{{jdate('Y/m/d H:i:s',$row->created_at->timestamp)}}
						</td>
						<td>
								<a href="{{URL::action('Admin\PrivateMessagesController@getEdit',[$row->id])}}" data-toggle="tooltip"
								   data-original-title="ویرایش اطلاعات" class="btn btn-warning  btn-xs" id="edit{{$row->id}}"><i
											class="fa fa-edit"></i> ویرایش </a>
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
								{!! Form::label('name','نام فرستنده',array('class'=>'col-lg-3 control-label')) !!}
								<div class="col-lg-3">
									{!! Form::text('name',null,array('class'=>'form-control','placeholder' => 'نام')) !!}
								</div>
								{!! Form::label('family','نام خانوادگی فرستنده',array('class'=>'col-lg-3 control-label')) !!}
								<div class="col-lg-3">
									{!! Form::text('family',null,array('class'=>'form-control','placeholder' => 'نام خانوادگی')) !!}
								</div>
							</div>
							<div class="form-group">
								{!! Form::label('name2','نام گیرنده',array('class'=>'col-lg-3 control-label')) !!}
								<div class="col-lg-3">
									{!! Form::text('name2',null,array('class'=>'form-control','placeholder' => 'نام')) !!}
								</div>
								{!! Form::label('family2','نام خانوادگی گیرنده',array('class'=>'col-lg-3 control-label')) !!}
								<div class="col-lg-3">
									{!! Form::text('family2',null,array('class'=>'form-control','placeholder' => 'نام خانوادگی')) !!}
								</div>
							</div>

							<div class="form-group">
								{!! Form::label('start','از تاریخ',array('class'=>'col-lg-3 control-label')) !!}
								<div class="col-lg-3">
									{!! Form::text('start',null,array('class'=>'form-control date','placeholder' => 'از تاریخ')) !!}
								</div>
								{!! Form::label('end','تا تاریخ',array('class'=>'col-lg-3 control-label')) !!}
								<div class="col-lg-3">
									{!! Form::text('end',null,array('class'=>'form-control date','placeholder' => 'تا تاریخ')) !!}
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
			
			$('#check-all').change(function () {
				$(".delete-all").prop('checked', $(this).prop('checked'));
			});
		});
		
		
    </script>

@stop
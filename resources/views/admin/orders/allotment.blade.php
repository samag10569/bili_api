@extends ("layouts.admin.master")
@section('title','خدمات')
@section('part','خدمات')
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
					<th>کد</th>
					<th>عنوان خدمت</th>
					<th>عملیات</th>
				</tr>
				@foreach($allotment as $row)
					<tr>
						<td>{{$row->id}}</td>
						<td>{{$row->title}}</td>
						<td>
							<center>
								<a href="{{URL::action('Admin\OrdersController@getAllotmentUser',[$row->id])}}" data-toggle="tooltip"
								   data-original-title="لیست کاربران" class="btn bg-purple margin btn-xs"><i
											class="fa fa-list"></i> لیست کاربران </a>
							</center>
						</td>
					</tr>

				@endforeach
				
			  </table>
			 
				<center>
					@if(count($allotment))
						{!! $allotment->appends(Request::except('page'))->render() !!}
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
                                {!! Form::label('id','کد',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-3">
                                    {!! Form::text('id',null,array('class'=>'form-control','placeholder' => 'کد ')) !!}
                                </div>
                                {!! Form::label('title','عنوان',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-3">
                                    {!! Form::text('title',null,array('class'=>'form-control','placeholder' => 'عنوان')) !!}
                                </div>
                            </div>
							
                            <div class="form-group">
                                {!! Form::label('category_id','دسته',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-9">
                                   {!! Form::select('category_id',$allotment_category,null,array('class'=>'form-control')) !!}
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
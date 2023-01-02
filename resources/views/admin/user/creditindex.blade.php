@extends ("layouts.admin.master")
@section('title','اعضای دارای حساب شارژ شده ')
@section('part','اعضای دارای حساب شارژ شده ')
@section('content')
	<div class="row">
		@include('layouts.admin.blocks.message')
		<div class="col-xs-12">
		  <div class="box">
			<div class="box-header">
				<h3 class="box-title"></h3>
				

			</div><!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
			  <table class="table table-hover">
				<tr>
                    <th>کاربر</th>
					<th>کد شناسه کاربری</th>

					<th>موبایل</th>
					<th>مبلغ شارژ</th>
					<th>تاریخ عضویت</th>
                    <th>شماره تماس</th>
                    <th>ایمیل</th>
					<th>وضعیت</th>
				</tr>
				@foreach($data as $row)

					<tr>
                        <td><a href="{{URL::action('Admin\SearchMemberController@getEdit',$row->id)}}">{{$row->name.' '.$row->family}}</a></td>
						<td>{{$row->id}}</td>
						<td>{{$row->mobile}}</td>
                        <td><a class=" label label-success" href="{{URL::action('Admin\TransactionController@getIndex',['user'=>$row->id])}}">{{$row->credit}} ریال </a></td>


						<td>
						{{jdate('Y/m/d',$row->created_at->timestamp)}}
						</td>
                        <td>{{$row->mobile}}</td>
                        <td>{{$row->email}}</td>
						<td>
							<center>
								@if($row->status==1)
									<span class='label label-success'>فعال</span>
								@else
									<span class='label label-danger'>غیر فعال</span>
								@endif
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
                                {!! Form::label('name','نام',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-9">
                                    {!! Form::text('name',null,array('class'=>'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('family','نام خانوادگی',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-9">
                                    {!! Form::text('family',null,array('class'=>'form-control')) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('email','ایمیل',array('class'=>'col-lg-3 control-label')) !!}
                                <div class="col-lg-9">
                                    {!! Form::text('email',null,array('class'=>'form-control')) !!}
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
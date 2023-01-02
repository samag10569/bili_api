@extends ("layouts.admin.master")
@section('title',' جزییات فاکتور '. $order->id)
@section('part',' جزییات فاکتور '.$order->id)
@section('content')
	<div class="row">
		@include('layouts.admin.blocks.message')
		<div class="col-xs-12">
		  <div class="box">
			<div class="box-header">
			  <h3 class="box-title"></h3>
			  <div class="box-tools">
			  </div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
			
			<div class="col-xs-6">
				  <div class="box">
					<div class="box-header">
						<h3 class="box-title" style="color: #3c8dbc;">
							<i class="fa fa-list" aria-hidden="true"></i>
							&nbsp;&nbsp;
							اطلاعات پرداخت کننده
						</h3>
					  <div class="box-tools">  </div>
					</div><!-- /.box-header -->
					<div class="box-body table-responsive no-padding">
					  <table class="table table-hover">
						
						<tr>
							<th>نام کاربر</th>
							<th>{{@$order->user->name.' '.@$order->user->family.' - '.$order->user_id}}</th>
						</tr>
						<tr>
							<th>تاریخ خرید</th>
							<th>{{jdate('Y/m/d H:i',$order->created_at->timestamp)}}</th>
						</tr>
								
					  </table>
					  
					</div><!-- /.box-body -->
				  </div><!-- /.box -->
			</div>
	  			 
			<div class="col-xs-6">
				  <div class="box">
					<div class="box-header">
						<h3 class="box-title" style="color: #3c8dbc;">
							&nbsp;&nbsp;
							
						</h3>
					  <div class="box-tools">  </div>
					</div><!-- /.box-header -->
					<div class="box-body table-responsive no-padding">
					  <table class="table table-hover">
						
						<tr>
							<th>کد پیگیری</th>
							<th>{{$order->tracking_code}}</th>
						</tr>
						<tr>
							<th>وضعیت پرداخت</th>
							<th>
								@if($order->status)
									<span class='label label-success'>پرداخت شده</span>
								@else
									<span class='label label-danger'>پرداخت نشده</span>
								@endif
							</th>
						</tr>
								
					  </table>
					  
					</div><!-- /.box-body -->
				  </div><!-- /.box -->
			</div>
	  			 
			 </br>
			 </br>
			 </br>
			 <table class="table table-hover">
				<tr style="background: beige;">
					<th>کد خدمت</th>
					<th>عنوان</th>
					<th>مبلغ خدمت</th>
					<th>مبلغ خدمت اعضا طلایی</th>
					<th>مبلغ پرداختی</th>
				</tr>
				@foreach($order->item as $row)
					<tr>
						<td>{{$row->allotment_id}}</td>
						<td>{{$row->allotment->title}}</td>
						<td>{{number_format($row->price)}}</td>
						<td>{{number_format($row->gold_price)}}</td>
						<td style="background: whitesmoke;">{{number_format($row->total_price)}}</td>
					</tr>
				@endforeach

					<tr>
						<td colspan="3"></td>
						<td>مبلغ پرداخت شده</td>
						<td style="background: whitesmoke;">{{number_format($order->payments)}}</td>
					</tr>

				
			  </table>						
			</div><!-- /.box-body -->
		  </div><!-- /.box -->
		</div>
	  </div>


@stop

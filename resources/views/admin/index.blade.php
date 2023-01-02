@extends ("layouts.admin.master")
	@section('content')
	
	<!-- Small boxes (Stat box) -->
	  <div class="row">
	  @include('layouts.admin.blocks.message')

	  </div><!-- /.row -->
	  

	  
	  <div class="col-xs-6">
		  <div class="box">
			<div class="box-header">
				<h3 class="box-title" style="color: #3c8dbc;">
					<i class="fa fa-sign-in" aria-hidden="true"></i>
					&nbsp;&nbsp;
					اطلاعات ورود به پنل مدیریت
				</h3>
			  <div class="box-tools">  </div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
			  <table class="table table-hover">
				<tr>
					<th>آی پی آخرین ورود</th>
					<th>{{@$log_user[1]->ip}}</th>
				</tr>
				
				<tr>
					<th>شناسه کاربری</th>
					<th>{{Auth::user()->email}}</th>
				</tr>
				
				<tr>
					<th>وضعیت آخرین ورود</th>
					<th>{{@$log_user[1]->title}}</th>
				</tr>
				
				<tr>
					<th>تاریخ و ساعت آخرین ورود</th>
					<th>{{jdate('Y/m/d - H:i',@$log_user[1]->created_at->timestamp)}}</th>
				</tr>
				
			  </table>
			  
			</div><!-- /.box-body -->
		  </div><!-- /.box -->
		</div>
	  <!-- Main row -->
	  <div class="row">

		<div class="col-xs-6">
		  <div class="box">
			<div class="box-header">
				<h3 class="box-title" style="color: #3c8dbc;">
					<i class="fa fa-bar-chart" aria-hidden="true"></i>
					&nbsp;&nbsp;
					آمار بازدید سایت
				</h3>
			  <div class="box-tools">  </div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
			  <table class="table table-hover">
				<tr>
					<th>بازدید دیروز</th>
					<th>{{@$tracker_yesterday->count}}</th>
				</tr>
				
				<tr>
					<th>بازدید امروز</th>
					<th>{{@$tracker_current_day->count}}</th>
				</tr>
				
				<tr>
					<th>افراد آنلاین</th>
					<th>{{$online_user}}</th>
				</tr>
				
			  </table>
			  
			</div><!-- /.box-body -->
		  </div><!-- /.box -->
		</div>
	  </div><!-- /.row (main row) -->
	@stop
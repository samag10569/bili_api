@extends('layouts.crm.master')
@section('map')
<section>
	<div class="container-fluid">
		<div class="row page-navigator">
			<div class="col-md-12">
				<ul>
					<li><img src="{!! asset('assets/site/images/location.png') !!}" alt=""></li>
					<li><a href="{{URL::action('Site\HomeController@getIndex')}}">صفحه اصلی</a></li><span>/</span>
					<li><a href="">پیام خصوصی</a></li>
				</ul>
			</div>
		</div>
		<!-- /.page-navigator -->
	</div>
</section>
@stop
@section('content')
	<!----------------------------------- left SIDE -------------------------------->
	<div class="col-md-3 col-sm-12 col-xs-12">
		<div id="right-sidebar">
			<div class="box mainbox" style="margin-bottom:20px;">
				<div class="head">
					<h4>منوی بخش پیام ها </h4>
				</div>
				<!-- .head -->
				<div class="body">
					<ul>
						<li class="default active"><a href="{{URL::action('Crm\PrivateMessagesController@getInbox')}}">دریافت شده</a></li>
						<li class="default"><a href="{{URL::action('Crm\PrivateMessagesController@getOutbox')}}">ارسال شده</a></li>
						<li class="default"><a href="{{URL::action('Crm\NetworkController@getIndex')}}">لیست دوستان</a></li>
						<li class="send link-hover"><a href="{{URL::action('Crm\PrivateMessagesController@getSend')}}">ارسال پیام خصوصی جدید</a></li>
					</ul>
				</div>
				<!-- .body -->
			</div>
			<!-- .box -->


		</div>
		<!-- /#left-sidebar -->
	</div>
	<!----------------------------------- left SIDE -------------------------------->
	<!----------------------------------- RIGHT SIDE ------------------------------->
	<div class="col-md-9">

		<div class="box mailbox-details">
			<div class="head">
				<h4> پیام های دریافت شده</h4>

			</div>
			<!-- .head -->
			<div class="body">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="box-body table-responsive no-padding">
						  <table class="table table-hover">
							<tr>
								<th>فرستنده</th>
								<th>موضوع</th>
								<th>تاریخ</th>
							</tr>
							@foreach($data as $row)
								<tr @if(!$row->status) class="warning" @endif>
									<td class='clickable-row' data-href="{{URL::action('Crm\PrivateMessagesController@getReplay',['to',$row->id])}}" style="cursor:pointer;"> 
										@if($row->sender)
										{{$row->sender->name.' '.$row->sender->family}}
										@endif

									</td>
								
									<td class='clickable-row' data-href="{{URL::action('Crm\PrivateMessagesController@getReplay',['to',$row->id])}}" style="cursor:pointer;">{{$row->subject}}</td>
									<td class='clickable-row' data-href="{{URL::action('Crm\PrivateMessagesController@getReplay',['to',$row->id])}}" style="cursor:pointer;">
									{{jdate('Y/m/d H:i:s',$row->created_at->timestamp)}}
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
					</div>
				</div>
			</div>
			<!-- .body -->
		</div>
		<!-- .box -->




	</div>
	<!----------------------------------- RIGHT SIDE ------------------------------->

@stop


@section('js')
<script>

	jQuery(document).ready(function($) {
		$(".clickable-row").click(function() {
			window.location = $(this).data("href");
		});
	});

</script>
@stop
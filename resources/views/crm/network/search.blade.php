@extends('layouts.crm.master')

@section('map')
<section>
	<div class="container-fluid">
		<div class="row page-navigator">
			<div class="col-md-12">
				<ul>
					<li><img src="{!! asset('assets/site/images/location.png') !!}" alt=""></li>
					<li><a href="{{URL::action('Site\HomeController@getIndex')}}">صفحه اصلی</a></li><span>/</span>
					<li><a href="">جستجو در شبکه</a></li>
				</ul>
			</div>
		</div>
		<!-- /.page-navigator -->
	</div>
</section>
@stop

@section('content')


	<!----------------------------------- RIGHT SIDE ------------------------------->
		
	<div class="col-md-8">
	
		@include('layouts.site.blocks.help')
		<div class="box" style="margin-top:30px;">
			<div class="head">
				<h4>شبکه اتصال به اعضای خود را گسترش دهید </h4>

			</div>
			<!-- .head -->
			<div class="body">
			<!---------------------- ACCORDION -------------------->
				<div class="row profile-network">
					<div class="col-md-9">
						<div class="accordion-content" id="accordion-content">
							
							<div id="content3" class="content" style="display: block;">
							{!! Form::open(array(URL::current(),'method' => 'GET')) !!}
							{!! Form::hidden('search','search') !!}
								<div class="form-group form-inline">
								  <label> نام  :</label>
								  <input class="form-control" name="name" placeholder="نام" type="text">
								</div>
								<div class="form-group form-inline">
								  <label> نام خانوادگی  :</label>
								  <input class="form-control" name="family" placeholder="نام خانوادگی" type="text">
								</div>
								<div class="form-group form-inline">
								  <label> رشته تحصیلی  :</label>
								  <input class="form-control" name="branch" placeholder="رشته تحصیلی" type="text">
								</div>
								<button href="" class="link green link-hover "> جستجو  </button>
							{!! Form::close() !!}
								@foreach($searchUser as $item)
									<div class="connect clearfix">
										@if(is_file( public_path() . '/assets/uploads/user/medium/' . $item->image))
											<img src="{!!asset('assets/uploads/user/medium/'.$item->image)!!}" alt="{{$item->name.' '.$item->family}}">
										@else
											<img src="{!! asset('assets/site/images/avatar.png') !!}"  alt="{{$item->name.' '.$item->family}}">
										@endif
										<h3>{{$item->name.' '.$item->family}}</h3>
										<p>{{@$item->category->title.' - '.@$item->branchInfo->title.' - '.@$item->info->branch}}</p>
										<a href="{{URL::action('Crm\NetworkController@getSendFriendRequest',$item->id)}}" class="link blue link-hover"> درخواست اتصال </a>
										<a href="{{URL::action('Crm\PrivateMessagesController@getSend',$item->id)}}" class="link green link-hover"> ارسال پیام خصوصی </a>

									</div><!-- /.connect -->
								@endforeach
								
								
								 <center>
									@if(count($searchUser))
										{!! $searchUser->appends(Request::except('page'))->render() !!}
									@endif
								</center>
							</div><!-- /#content3 -->
						
						</div><!-- /#accordion-content -->
					</div>
					<div class="col-md-3">
						<ul id="myaccordion" class="accordion">
							<li class="nochild deactive" id="1"><a href="{{URL::action('Crm\NetworkController@getIndex')}}">اتصالات شما</a></li>
							<li class="nochild deactive" id="2"><a href="{{URL::action('Crm\NetworkController@getFriendRequest')}}">درخواست های ارسالی</a></li>
							<li class="nochild deactive" id="2"><a href="{{URL::action('Crm\NetworkController@getFriendRequestOther')}}">درخواست های دریافتی</a></li>
							<li class="nochild active" id="4"><a href="{{URL::action('Crm\NetworkController@getSearch')}}">جستجو در شبکه</a></li>
							<li class="nochild deactive" id="5"><a href="{{URL::action('Crm\NetworkController@getIntroduction')}}">دعوت دوستان</a></li>
						</ul><!-- /.myaccordion -->
						
					</div>
				</div>
				<!---------------------- ACCORDION -------------------->
			
			</div>
			<!-- .body -->
		</div>
		<!-- .box -->



	</div>
	@include('layouts.crm.blocks.sidebar')

@endsection

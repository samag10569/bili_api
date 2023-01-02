@extends('layouts.crm.master')

@section('map')
<section>
	<div class="container-fluid">
		<div class="row page-navigator">
			<div class="col-md-12">
				<ul>
					<li><img src="{!! asset('assets/site/images/location.png') !!}" alt=""></li>
					<li><a href="{{URL::action('Site\HomeController@getIndex')}}">صفحه اصلی</a></li><span>/</span>
					<li><a href="">{{$factualy->title}}</a></li>
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
				<h4>{{$factualy->title}} </h4>

			</div>
			<!-- .head -->
			<div class="body">
			@foreach($data as $row)
				@php
					$checkFriend = Classes\UserCheck::checkFriend(Auth::id(),$row->id);
				@endphp
				<span class="product clearfix">		
					<div class="post clearfix">
						<div class="row">
							<div class="col-md-3 col-sm-12">
								@if(is_file( public_path() . '/assets/uploads/user/medium/' . $row->image))
								<img src="{!!asset('assets/uploads/user/medium/'.$row->image)!!}" alt="{{$row->name.' '.$row->family}}" class="img-rounded img-responsive" style="width: 130px;">
								@else
									<img src="{!! asset('assets/site/images/avatar.png') !!}"  alt="{{$row->name.' '.$row->family}}" class="img-rounded img-responsive" style="width: 130px;">
								@endif
							</div>
							<div class="col-md-9 col-sm-12" style="padding-top: 20px;">
								<div class="content">
								   <h4>{{$row->name.' '.$row->family}}</h4>
								   <p>{{@$row->category->title.' - '.@$row->branchInfo->title.' - '.@$row->info->branch}}</p>
								</div>
								@if($checkFriend == -1)
									<a href="{{URL::action('Crm\NetworkController@getSendFriendRequest',$row->id)}}"  class="link green link-hover"><i class="fa fa-plus" ></i>اتصال برقرار کن </a>
								@elseif($checkFriend == 0)
									<a href="{{URL::action('Crm\NetworkController@getRemoveFriendRequest',$row->id)}}" class="link red link-hover"> حذف اتصال </a>
									<a href="#" class="link blue link-hover">در انتظار تایید </a>
								@else
									<a href="{{URL::action('Crm\NetworkController@getRemoveFriendRequest',$row->id)}}" class="link red link-hover"> حذف اتصال </a>
									<a href="#" class="link green link-hover">اتصال برقرار شده است </a>
								@endif
							</div>
						</div>
						<hr>
					</div><!-- /.post -->
				</span>
			@endforeach
				
				
				
			
			</div>
			<!-- .body -->
		</div>
		<!-- .box -->



	</div>
	@include('layouts.crm.blocks.sidebar')

@endsection

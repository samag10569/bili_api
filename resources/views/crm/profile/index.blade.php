@extends('layouts.crm.master')

@section('map')
<section>
	<div class="container-fluid">
		<div class="row page-navigator">
			<div class="col-md-12">
				<ul>
					<li><img src="{!! asset('assets/site/images/location.png') !!}" alt=""></li>
					<li><a href="{{URL::action('Site\HomeController@getIndex')}}">صفحه اصلی</a></li><span>/</span>
					<li><a href="">پروفایل {{$user->name.' '.$user->family}}</a></li>
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
		<div class="box">
			<div class="head">
				<h4>رزومه {{$user->name.' '.$user->family}}</h4>

			</div><!-- .head -->
			<div class="body">
				

				
				<p>
				{!! $user->cv !!}
				</p>
			</div><!-- .body -->
		</div><!-- .box -->
		@include('layouts.crm.blocks.scientific')
		<div class="box hasForm" style="margin-top:30px">
			<div class="head">
				<h4>توانایی ها</h4>
			</div><!-- .head -->
			<div class="body">
				<div class="profile">
					<div class="row">
						<div class="col-md-5 col-sm-12 col-xs-12">
							@if(is_file('/assets/uploads/user/medium/' . $user->image))
								<img src="{!!asset('assets/uploads/user/medium/'.$user->image)!!}" alt="{{$user->name.' '.$user->family}}" class="avatar" style="width: 50%;">
							@else
								<img src="{!! asset('assets/site/images/avatar.png') !!}"  alt="{{$user->name.' '.$user->family}}" class="avatar" style="width: 50%;">
							@endif
							<span class="author">{{$user->name.' '.$user->family}}</span>
							<span class="field">{{@$user->category->title.' - '.@$user->branchInfo->title.' - '.@$user->info->branch}}</span>
						</div>
						<div class="col-md-7 col-sm-12 col-xs-12 ">
							<div class="labels">
								<span>مکالمه زبان انگلیسی</span>
								<span>برنامه نویسی سی شارپ</span>
								<span>برنامه نویسی سمت سرور</span>
							</div><!-- /.labels -->
						</div>
					</div>
					

				</div><!-- /.profile -->
	
			</div><!-- .body -->
		</div><!-- .box -->
		<div class="box hasForm" style="margin-top:30px">
			<div class="head">
				<h4>ارسال نظر در پروفایل کاربر</h4>
			</div><!-- .head -->
			<div class="body">
				<div class="profile">
					<div class="row">
						{!! Form::open(array('action' => array('Crm\ProfileController@postComment'),'role' => 'form','files' => 'true','id' => 'ejavan_form')) !!}
						<div class="col-md-10 col-sm-12 col-xs-12 ">
							<div class="form-group">
								<textarea class="form-control" rows="5" id="comment" name="comment"></textarea>
								<input type="hidden" name="pid" value="{{$user->id}}" >
							</div>
						</div>
						<div class="col-md-2 col-sm-12 col-xs-12">
							<button href=""  class="link green link-hover" style="margin-top:10px;">ارسال</button>

						</div>
						{!! Form::close() !!}
					</div>
					

				</div><!-- /.profile -->

			</div><!-- .body -->
		</div><!-- .box -->
		<div class="box hasForm" style="margin-top:30px">
			<div class="head">
				<h4> نظرات ارسال شده توسط سایر کاربران</h4>
			</div><!-- .head -->
			<div class="body">
				<div class="profile">
					@foreach($user->profileComment as $pc)
					<div class="row comment">
						<div class="col-md-5 col-sm-12 col-xs-12">
							<img src="images/profile.jpg" alt="" class="avatar">
							<span class="author">{{$pc->sender->name}} {{$pc->sender->family}}</span>
							<span class="field">{{@$pc->sender->info->branch}}</span>
						</div>
						<div class="col-md-7 col-sm-12 col-xs-12 ">
							<div class="labels">
								{{$pc->comment}}
							</div><!-- /.labels -->
						</div>
					</div><!-- /.comment -->
					@endforeach
				</div><!-- /.profile -->

			</div><!-- .body -->
		</div><!-- .box -->
		
	</div>
	@include('layouts.crm.blocks.sidebar')

@endsection
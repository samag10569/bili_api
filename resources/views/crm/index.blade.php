{{--
@extends('layouts.crm.master')

@section('map')
<section>
	<div class="container-fluid">
		<div class="row page-navigator">
			<div class="col-md-12">
				<ul>
					<li><img src="{!! asset('assets/site/images/location.png') !!}" alt=""></li>
					<li><a href="">صفحه اصلی</a></li><span>/</span>
					<li><a href="">پروفایل {{Auth::user()->name.' '.Auth::user()->family}}</a></li>
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
		<div class="box" style="margin-top:50px;">
			<div class="head">
				<h4>جدیدترین اخبار شبکه رشد و علم جوان</h4>

			</div><!-- .head -->
			<div class="body">
				@foreach($news as $row)
					<div class="list">
						<div class="row">
							<div class="col-md-3">
							@if(file_exists('assets/uploads/news/medium/' . $row->image) and $row->image != null)
								<img src="{!! asset('assets/uploads/news/medium/'.$row->image) !!}" class="img-responsive" alt="{!! $row->title !!}" style="width: 183px;height: 126px;">
							@else
								<img src="{!! asset('assets/uploads/notFound.jpg') !!}"  alt="{!! $row->title !!}" style="width: 183px;height: 126px;">
							@endif
								
							</div>
							<div class="col-md-9">
								<h3>{!! $row->title !!}</h3>
								<p>
									{!! str_limit(strip_tags($row->content),150) !!}
								<a href="{{URL::action('Site\NewsController@getDetails',[$row->id,Classes\Helper::seo($row->title)])}}"  class="link green link-hover pull-left">مطالعه بیشتر ...</a>
								</p>

							</div>
						</div>
					</div><!-- /.list -->
				@endforeach
				<a href="" class="link blue link-hover pull-left">مشاهده کردم</a>
			</div><!-- .body -->
		</div><!-- .box -->
		
		
		<div class="box hasForm" style="margin-top:50px">
			<div class="head">
				<h4>ارسال مطلب جدید در شبکه رشد علم جوان</h4>
			</div><!-- .head -->
			<div class="body">
				<div class="profile">
					<div class="row">
						<div class="col-md-5 col-sm-12 col-xs-12">
							<img src="{!! asset('asssets/site/images/profile.jpg') !!}" alt="" class="avatar">
							<span class="author">
							<?php $user = Auth::user() ?>
							{!! $user->name !!}&nbsp;{!! $user->family !!}
							</span>
							<span class="field">
								{!! $user->email !!}<br>{!! $user->mobile !!}
							</span>
						</div>
						<div class="col-md-7 col-sm-12 col-xs-12 ">
							<a href="" class="send-file pull-left link-hover">ارسال پست، عکس یا مطالب علمی <i class="fa fa-pencil-square-o" ></i></a>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-9 col-md-offsett-3 pull-left col-sm-12 col-xs-12 ">
							
							{!! Form::open(array('action' => array('Crm\HomeController@postScientificAdd'), 'role' => 'form','id' => 'ejavan_form', 'files'=> true)) !!}
								<div class="form-group">
									<input required name="title" type="text" class="form-control" id="usr">
									{!! Form::select('category_id',$scientific_category,null,array(
                                        'class'=>'form-control')) !!}
									<textarea required name="content" class="form-control" rows="5" id="comment"></textarea>
								</div>
							{!! Form::close() !!}
							
						</div>
					</div>
				</div><!-- /.profile -->
				<span class="pull-left">
					<a href="" class="link blue link-hover">افزودن پیوست</a>
					<button type="submit" href="" class="link green link-hover">ارسال</button>
				</span>
			</div><!-- .body -->
		</div><!-- .box -->
		@include('layouts.crm.blocks.scientific')
	</div>
	@include('layouts.crm.blocks.sidebar')

@endsection--}}

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
						<li class="default @if($type == 'to') active @endif"><a href="{{URL::action('Crm\PrivateMessagesController@getInbox')}}">دریافت شده</a></li>
						<li class="default @if($type == 'from') active @endif"><a href="{{URL::action('Crm\PrivateMessagesController@getOutbox')}}">ارسال شده</a></li>
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
				<h4>{{$msg->subject}}</h4>

			</div>
			<!-- .head -->
			<div class="body">
				<div class="row">
					<div class="col-md-4 col-sm-12 col-xs-12">
						<div class="profile">
							<div class="bg"></div>
							@if ($type == 'from') 
								<div class="wrap">
									<br>
									<a href="" class="avatar">
									@if(file_exists('assets/uploads/user/medium/' . @$msg->receiver->image))
										<img src="{!!asset('assets/uploads/user/medium/'.@$msg->receiver->image)!!}"
											 alt="{{@$msg->receiver->name.' '.@$msg->receiver->family}}">
									@else
										<img src="{!! asset('assets/site/images/avatar.png') !!}"
											 alt="{{@$msg->receiver->name.' '.@$msg->receiver->family}}">
									@endif
									</a>
									<br>
									<span>{{@$msg->receiver->name.' '.@$msg->receiver->family}}</span>
									<br>
									<span>{{@$msg->receiver->category->title.' - '.@$msg->receiver->branchInfo->title.' - '.@$msg->receiver->info->branch}}</span>
								</div>
							@else 
								<div class="wrap">
									<br>
									<a href="" class="avatar">
									
									@if(file_exists('assets/uploads/user/medium/' . @$msg->sender->image))
										<img src="{!!asset('assets/uploads/user/medium/'.@$msg->sender->image)!!}"
											 alt="{{@$msg->sender->name.' '.@$msg->sender->family}}">
									@else
										<img src="{!! asset('assets/site/images/avatar.png') !!}"
											 alt="{{@$msg->sender->name.' '.@$msg->sender->family}}">
									@endif
									
									</a>
									<br>
									
									<span>{{@$msg->sender->name.' '.@$msg->sender->family}}</span>
									<br>
									<span>{{@$msg->sender->category->title.' - '.@$msg->sender->branchInfo->title.' - '.@$msg->sender->info->branch}}</span>
								</div>
								
							@endif
							
							<!-- /.wrap -->
						</div>
						</div>
					<div class="col-md-8 col-sm-12 col-xs-12">
						<h3><img src="images/text.png" alt="">{{$msg->subject}}</h3>
						<p> 
							{{$msg->message}}
						</p>
						</br>
						</br>
						<h3><img src="images/text.png" alt="">ارسال پیام</h3>
						{!! Form::model(null,array('action' => array('Crm\PrivateMessagesController@postReplay',$msg->id),'role' => 'form','id' => 'ejavan_form')) !!}
						{!! Form::hidden('type',$type,array()) !!}
							<div class="box-body">

								<div class="form-group">
									<div class="row">
										<div class="col-md-12">
											<label>عنوان:</label>
											{!! Form::text('subject',$msg->title,array(
												'class'=>'form-control',
												'rows'=>3)) !!}
										</div>

									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-md-12">
											<label>پیام:</label>
											{!! Form::textarea('message',null,array(
												'class'=>'form-control ckeditor','rows'=>'2')) !!}
										</div>
									</div>
								</div>


								<div class="box-footer">
									<button type="submit" class="btn btn-primary">ارسال</button>
								</div>
							</div>
							{!! Form::close() !!}
							
					</div>
				</div>
			</div>
			<!-- .body -->
		</div>
		<!-- .box -->
				<!----------------------------------- RIGHT SIDE ------------------------------->

					</div>
@stop



@section('js')

	<script>
        (function($,W,D)
        {
            var JQUERY4U = {};

            JQUERY4U.UTIL =
                {
                    setupFormValidation: function()
                    {
                        //form validation rules
                        $("#ejavan_form").validate({
                            rules: {
                                subject: "required",
                                message: "required",

                            },
                            messages: {
                                subject: "این فیلد الزامی است.",
                                message: "این فیلد الزامی است.",

                            },
                            submitHandler: function(form) {
                                form.submit();
                            }
                        });
                    }
                }

            //when the dom has loaded setup form validation rules
            $(D).ready(function($) {
                JQUERY4U.UTIL.setupFormValidation();
            });

        })(jQuery, window, document);
	</script>
@endsection
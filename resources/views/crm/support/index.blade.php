@extends('layouts.crm.master')

@section('content')


    <div class="col-md-8">
		@include('layouts.site.blocks.help')
        <div class="box" style="margin-top:50px;">
            <div class="head">
                <h4>ارتباط با پشتیبانی</h4>
            </div><!-- .head -->
            <div class="body">
                <div class="row profile-network">
                    <div class="col-md-9">
                        <div class="accordion-content" id="accordion-content">

                            <div id="content1" class="content">
                                <div class="title-area">
                                    <hr>
                                    <p class="link blue title">درخواست های قبلی شما</p>
                                </div>
                                @foreach($data as $row)
									@php
										$color = 'gray';
										if($row->status == 2)
											$color = 'red';
										elseif($row->status == 0)
											$color = 'gray';
										elseif($row->status == 1)
											$color = 'green';
									@endphp
                                    <div class="connect clearfix">
                                        <h4><a href="{{URL::action('Crm\SupportController@getView',$row->id)}}">{{$row->title}}</a></h4>
                                        <p>{{$row->content}}</p>
                                        <p href=""  class="link {{$color}} link-hover">@if(isset($status[$row->status]))
                                                {{$status[$row->status]}}
                                            @endif</p>
                                        <p href=""  class="link blue link-hover">{{@$row->factualy->title}}</p>
										@if($row->status != 2)
											<a style="float: left;" href="{{URL::action('Crm\SupportController@getClose',$row->id)}}"  class="link red link-hover">
											<i class="fa fa-remove"></i>	بستن درخواست
											</a>
										@endif

                                    </div><!-- /.connect -->
                                @endforeach

                            </div><!-- /#content2 -->
                            <div id="content3" class="content" style="display:none">
                                {!! Form::open(array('method'=>'POST','action' => array('Crm\SupportController@postTicket'),'role' => 'form','files' => 'true','id' => 'support_form')) !!}
                                <div class="title-area">
                                    <hr>
                                    <p class="link blue title" style="width:350px;margin-top:0">ارسال درخواست جدید</p>
                                </div>
                                <div class="form-group form-inline">
                                    <label>دپارتمان:</label>
                                    {!! Form::select('factualy_id',$flist,null,array('class'=>'form-control')) !!}
                                </div>
                                <div class="form-group form-inline">
                                    <label>عنوان درخواست:</label>
                                    <input name="title" class="form-control" placeholder="عنوان درخواست" type="text">
                                </div>
                                <div class="form-group ">
                                    <label> متن درخواست :</label>
                                    <textarea name="content" class="form-control" rows="5" id="comment"></textarea>
                                    <input name="file" type="file" class="link green link-hover" />
                                </div>
                                <button href="" class="link green link-hover">ثبت نهایی درخواست</button>
                                {!! Form::close() !!}
                            </div><!-- /#content4 -->

                        </div><!-- /#accordion-content -->
                    </div>
                    <div class="col-md-3">
                        <ul id="myaccordion" class="accordion">

                            <li class="nochild active" id="1">لیست درخواست ها</li>
                            <li class="nochild deactive" id="3">درخواست جدید</li>
                        </ul><!-- /.myaccordion -->

                    </div>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    @include('layouts.crm.blocks.sidebar')

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
				$("#support_form").validate({
					rules: {
						factualy_id: "required",
						title: "required",
						content: "required",
						agree: "required"
					},
					messages: {
						factualy_id: "این فیلد الزامی است.",
						title: "این فیلد الزامی است.",
						content: "این فیلد الزامی است."
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
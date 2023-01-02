@extends('layouts.crm.master')

@section('content')


    <div class="col-md-8">
		@include('layouts.site.blocks.help')
        <div class="box" style="margin-top:30px;">
            <div class="head">
                <h4>تعریف پروژه ی موظفی  </h4>

            </div>
            <!-- .head -->
            <div class="body">
                <!---------------------- ACCORDION -------------------->
                <div class="row profile-network">
                    <div class="col-md-9">
                        <div class="accordion-content" id="accordion-content">

                            <div id="content1" class="content">
                                {!! Form::open(array('action' => array('Crm\ProjectController@postAdd'),'role' => 'form','files' => 'true','id' => 'project_form')) !!}
                                <div class="form-group form-inline">
                                    <label>عنوان:</label>
									{!! Form::text('title',null,array(
										'class'=>'form-control',
										'placeholder'=>'عنوان را وارد کنید . . .')) !!}
                                </div>
                                <div class="form-group">
									<label> چکیده</label>
									{!! Form::textarea('abstract',null,array(
									'class'=>'form-control',
									'rows'=>'3',
									'placeholder'=>'چکیده را وارد کنید . . .')) !!}
                                </div>
                                <div class="form-group">
                                   <label>متن پروژه</label>
									{!! Form::textarea('content',null,array(
									'class'=>'form-control ckeditor',
									'rows'=>'5',
									'placeholder'=>'متن پروژه را وارد کنید . . .')) !!}
                                </div>
                                <div class="form-group">
                                   	<label> منابع</label>
									{!! Form::textarea('source',null,array(
									'class'=>'form-control',
									'rows'=>'3',
									'placeholder'=>'منابع را وارد کنید . . .')) !!}
                                </div>
                                <div class="form-group">
                                   	<label> فایل</label>
									{!! Form::file('file',null,array(
									'class'=>'form-control')) !!}
                                </div>
                                <div class="form-group">
                                   	<label> استاد راهنما</label>
									
									<span id="comment" class="ejavan-alert">
										بخش مورد نظر را انتخاب کنید تا لیست اعضای هیت علمی نمایش داده شود
									</span>
									<select class="form-group" id="factualy_id" name="factualy_id">
											<option value="">انتخاب کنید . . .</option>
										@foreach($groups as $item)
											<option value="{{$item->id}}">{{$item->title}}</option>
										@endforeach
									</select>
									<select class="form-group" id="supervisor" name="supervisor">
									</select>
									
									<center class="loading" id="loading">
										<img src="{{ asset('assets/admin/img/loading.gif')}}"/>
										در حال بارگذاری لطفا شکیبا باشید
									</center>
                                </div>
                                <div class="title-area">
                                    <hr>
                                    <p class="link blue title">انتخاب نوع پروژه موظفی</p>
                                </div>
								<div class="form-group form-inline">
									@foreach($type as $item)
										<div class="checkbox">
											<label>  {!!Form::radio('type', $item->id)!!} {{$item->title}} </label>
										</div>
									@endforeach
									<button id="btn-save" class="link green link-hover">ثبت</button>
								</div>
                                {!! Form::close() !!}
                            </div><!-- /#content2 -->
                       
                            <div id="content4" class="content" style="display:none">
                                @foreach($data as $row)
                                <div class="connect clearfix">
                                    <h4>{{$row->title}}</h4>
                                    <p>{{$row->abstract}}</p>
                                    <a href=""  class="link green link-hover">
                                        {{@$row->projectRequiredStatus->title}}
                                    </a>
                                </div><!-- /.connect -->
                                @endforeach
                            </div><!-- /#content4 -->
                        </div><!-- /#accordion-content -->
                    </div>
                    <div class="col-md-3">
                        <ul id="myaccordion" class="accordion">
                            <li class="nochild active" id="1">تعریف پروژه موظفی</li>
                            <li class="haschild deactive " id="2">
								<span  id="2">
									استاد راهنما
								</span>
                                <ul>
									@foreach($groups as $item)
										<li><a href="{{URL::action('Crm\CoreScientificController@getList',$item->id)}}">{{$item->title}} ({{count($item->user)}})</a></li>
									@endforeach
                                </ul>
                            </li>
                            <li class="nochild deactive" id="4">لیست پروژه های شما</li>
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

@stop

@section('js')
	<script type="text/javascript">

		$(document).ready(function(){
			$('.loading').hide();
			$('#supervisor').hide();
			$('#comment').show();
			
			var supervisor = $("#supervisor");
			$("#factualy_id").on('change', function () {
				$('.loading').show();
				$('#comment').hide();
				$('#supervisor').hide();
				var factualy_id = $(this).val();
				$('#btn-save').attr('disabled', 'disabled');
				$.ajax({
					url: "{!! URL::action('Crm\ProjectController@postUserAjax') !!}",
					data: {
						_token: "{!! csrf_token() !!}",
						key: factualy_id
					},
					method: 'POST',
					success: function (result) {
						$('.loading').hide();
						$('#supervisor').show();
						var data = jQuery.parseJSON(result);
						if (data.count > 0) {
							if (data.status === true) {
								$('#comment').hide();
								supervisor.empty();
								supervisor.append(data.value);
								$('#btn-save').removeAttr('disabled');
							} else {
								alert(data.error);
							}
						}else{
							$('#comment').show();
							$('#supervisor').hide();
							$('#comment').empty();
							$('#comment').append('عضوی برای این بخش وجود ندارد');
						}
					}
				});
			});
				
		});
		
		(function($,W,D)
		{
			var JQUERY4U = {};

			JQUERY4U.UTIL =
			{
				setupFormValidation: function()
				{
					//form validation rules
					$("#project_form").validate({
						rules: {
							title: "required",
							abstract: "required",
							content: "required",
							source: "required",
							supervisor: "required",
							factualy_id: "required",
							type: "required",
							agree: "required"
						},
						messages: {
							title: "این فیلد الزامی است.",
							abstract: "این فیلد الزامی است.",
							content: "این فیلد الزامی است.",
							source: "این فیلد الزامی است.",
							type: "انتخاب الزامی است",
							supervisor: "این فیلد الزامی است.",
							factualy_id: "این فیلد الزامی است."
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
@stop

@extends('layouts.site.master')
@section('content')
	<section>
        <div class="container-fluid">
            <div class="row main-content">
                <div class="col-md-8">
		@include('layouts.site.blocks.help')
                    <div class="box main-page">
                        <div class="head">
                            <h4>{{$data->title}}
							<span style="float: left;">
								{{@$data->projectRequiredType->title}}
							</span>
							</h4>	
                        </div>
                        <!-- .head -->
                        <div class="body">
                            <div class="post">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
										@if(file_exists(public_path('assets/uploads/core-message/'.$data->file)) and $data->file != '' and $data->file != null)
											<a href="{!! asset('assets/uploads/core-message/'.$data->file) !!}" target="_blank">
												دانلود فایل 
												<i class="fa fa-download"></i>
											</a>
										@else
											 فایلی برای دانلود وجود ندارد
										@endif
										<hr>
									
										@if($data->status !=2)
											{!! Form::open(array('action' => array('Crm\CoreMessageController@postView',$data->id),'role' => 'form','id' => 'ejavan_form')) !!}
												<div class="form-group">
													<div class="row">
														<div class="col-md-10">
															<label>پاسخ:</label>
															{!! Form::textarea('content',null,array(
																'class'=>'form-control',
																'rows'=>'3')) !!}
														</div>
														<div class="col-md-2 ejavan_col">
															<button type="submit" class="btn btn-primary">ارسال</button>
														</div>
													</div>
												</div>
											 {!! Form::close() !!}
										@endif
									
										@foreach($msg_reply as $row)
											@if($row->user_id ==null)
												<div class="form-group">
													<div class="row">
														<div class="col-md-1">
														</div>
														<div class="col-md-11">
															<div class="ejavan-other">
																<div class="panel-body">
																	<h5>
																		<span>{!! @$row->admin->name.' '.@$row->admin->family  !!}  : </span>
																		<span class="ejavan-time"> {{jdate('Y/m/d H:i',$row->created_at->timestamp)}} </span>
																	</h5>
																	<p>
																		{!! $row->content !!}
																	</p>
																</div>
															</div>
														</div>
													</div>
												</div>
											@else
												<div class="form-group">
													<div class="row">
														<div class="col-md-11">
															<div class="ejavan-you">
																<div class="panel-body">
																	<h5>
																		<span>{!! @$row->user->name.' '.@$row->user->family  !!} :</span>
																		<span class="ejavan-time"> {{jdate('Y/m/d H:i',$row->created_at->timestamp)}} </span>
																	</h5>
																	<p>
																		{!! $row->content !!}
																	</p>
																</div>
															</div>
														</div>
														<div class="col-md-1">
														</div>
													</div>
												</div>
											@endif
										@endforeach
										<div class="form-group">
											<div class="row">
												<div class="col-md-11">
													<div class="ejavan-you">
														<div class="panel-body">
															<h5>
																<span>{!! @$data->user->name.' '.@$data->user->family  !!} :</span>
																<span class="ejavan-time"> {{jdate('Y/m/d H:i',$data->created_at->timestamp)}} </span>
															</h5>
															<p>
																{!! $data->content !!}
															</p>
														</div>
													</div>
												</div>
												<div class="col-md-1">
												</div>
											</div>
										</div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.post -->
                        </div>
                        <!-- .body -->
                    </div>
                    <!-- .box -->
                </div>
				
				@include('layouts.crm.blocks.sidebar')
            </div>
        </div>
    </section>
@endsection


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
                            content: "required"
                        },
                        messages: {
                            content: "این فیلد الزامی است.",
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
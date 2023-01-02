@extends ("layouts.admin.master")
@section('title','پشتیبانی درخواست ها')
@section('part','پشتیبانی درخواست ها')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> پشتیبانی درخواست ها</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                @include('layouts.admin.blocks.message')
					<div class="chat">   
					  <div class="chat-history">
						<ul class="chat-ul">
						  <li>
							  <h4 style="text-align: right;direction: rtl;">
								{{$data->title}}
							  </h4>
						  </li>
						  
							 <li>
								<div class="message-data  align-left">
								  <span class="message-data-name"><i class="fa fa-circle you"></i> {{$data->user->name.' '.$data->user->family}} - {{jdate('Y/m/d H:i',$data->created_at->timestamp)}}</span>
								</div>
								<div class="message you-message" style="text-align: right;direction: rtl;">
									{!! $data->content !!}
								</div>
							  </li>
						 

							@if(count($data->reply))
								@foreach($data->reply as $item) 
									@if($item->admin_id)
										
									 <li class="clearfix">
										<div class="message-data align-right">
										  <span class="message-data-name">{{@$item->admin->name.' '.@$item->admin->family}}  - {{jdate('Y/m/d H:i',$item->created_at->timestamp)}}</span> <i class="fa fa-circle me"></i>
										</div>
										<div class="message me-message float-right" style="text-align: right;direction: rtl;">
											{!! $item->content !!}
										</div>
									  </li>
									  
									  
									 @else
									 
										<li>
										<div class="message-data align-left">
										  <span class="message-data-name"><i class="fa fa-circle you"></i> {{@$data->user->name.' '.@$faitem->user->family}}  - {{jdate('Y/m/d H:i',$item->created_at->timestamp)}}</span>
										</div>
										<div class="message you-message" style="text-align: right;direction: rtl;">
											{!! $item->content !!}
										</div>
									  </li>
								 
									  @endif
								@endforeach
							@endif
						</ul>
						
					  </div> <!-- end chat-history -->
					  
					</div> <!-- end chat -->
                {!! Form::open(array('action' => array('Admin\MessageController@postView',$data->id),'role' => 'form','id' => 'ejavan_form')) !!}
                
					<div class="box-body">
							<div class="form-group">
								<div class="row">

									<div class="col-md-12">
										<label>پاسخ:</label>
										{!! Form::textarea('reply',null,array(
											'class'=>'form-control',)) !!}
									</div>
								</div>
							</div>

							<div class="col-md-4 ejavan_col">
								<button type="submit" class="btn btn-primary">پاسخ</button>
							</div>
					</div>

                {!! Form::close() !!}
            </div><!-- /.box -->
        </div>
    </div>
@stop


@section('css')
	<link href="{{ asset('assets/admin/css/chat.css')}}" rel="stylesheet">
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

                            reply: "required"


                        },
                        messages: {

                            reply: "این فیلد الزامی است.",


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
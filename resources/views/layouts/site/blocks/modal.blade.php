
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close pull-right" data-dismiss="modal">&times;</button>
                <br>
            </div>
            <div class="modal-body">
                <div class="arms">
                    <img src="{!! asset('assets/site/images/login-logo.png') !!}" alt="">
                    <p>شبکه رشد علم جوان</p>
                    <p>اولین هایپر فناوری ایرانی</p>
                </div>
				
				{!! Form::open(array('action' => 'Auth\LoginController@postCrmLogin', 'class' => 'form-horizontal','id' => 'loginform')) !!}

                    <div class="input-group" id="add-area1">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="login-username" class="form-control" name="email" value="" placeholder="آدرس ایمیل یا شماره خود را وارد کنید" type="email">
                    </div>

                    <div class="input-group" id="add-area2">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="login-password" class="form-control" name="password" placeholder="رمز عبور خود را وارد کنید" type="password">
                    </div>

					
					<div style="margin-top:10px;margin-right: 5px;" class="form-group">
                        <!-- Button -->

                        <div class="col-sm-7">
                            <input class="form-control" type="text" placeholder="کد امنیتی" id="captcha" name="captcha" autocomplete="off">
						</div>
                        <div class="col-sm-5">
							<span class="refereshrecapcha">
								{!! \Mews\Captcha\Facades\Captcha::img() !!}
							</span>
							<a href="javascript:void(0)" onclick="refreshCaptcha()"><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>

                    <div style="margin-top:10px" class="form-group">
                        <!-- Button -->

                        <div class="col-sm-12 controls">
                            <button id="btn-login" type="submit" class="btn btn-default link-hover">ورود به سامانه  </button>
                            <a id="btn-fblogin" href="{{URL::action('Auth\LoginController@redirectToProvider')}}" class="btn btn-danger">
								ورود / ثبت نام با اکانت گوگل در سامانه
							</a>

                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <form role="form">
                    <div class="form-group pull-right">
                        <a href="{{URL::action('Site\RegisterController@getStep1')}}" class="btn btn-default link-hover">
                            ثبت نام در سامانه
                        </a>
                        <a href="{{URL::action('Auth\ForgotPasswordController@getResetPassword')}}"> در صورت فراموشی رمز عبور کلیک کنید</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
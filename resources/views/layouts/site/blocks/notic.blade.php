
@if(Auth::check())
	@if(!Auth::user()->phone_confirm || !Auth::user()->email_confirm)
	</br>
	</br>
		<section>
			<div class="container-fluid">
				<div class="row notification-area">
					<div class="col-md-12">
						<p>
							<a href=""><i class="fa fa-times-circle close pull-right"></i></a> 
							@if(!Auth::user()->email_confirm and Auth::user()->phone_confirm)
								کاربر عزیز ، متاسفانه روند تایید آدرس ایمیل 
								({{Auth::user()->email}})
								خود را تکمیل نکرده اید.
							@endif
							@if(!Auth::user()->phone_confirm and Auth::user()->email_confirm)
								کاربر عزیز ، متاسفانه روند تایید شماره همراه 
								({{Auth::user()->mobile}})
								خود را تکمیل نکرده اید.
							@endif
							@if(!Auth::user()->phone_confirm and !Auth::user()->email_confirm)
								کاربر عزیز ، متاسفانه روند تایید آدرس ایمیل 
								({{Auth::user()->email}})
								و
								شماره همراه 
								({{Auth::user()->mobile}})
								خود را تکمیل نکرده اید.
							@endif
							لطفا از 
							<a href="{{URL::action('Crm\ProfileController@getEdit')}}">اینجا</a> 
							اقدام نمایید.
						</p>
					</div>
				</div>
			</div>
		</section>
	@endif
@endif

<header class="main-header">
	<!-- Logo -->
	<a href="index2.html" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>ترنج</b></span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b>شبکه رشد</b> علم جوان</span>
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top" role="navigation">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">

				<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="{!!asset('assets/uploads/user/medium/'.Auth::user()->image)!!}" class="user-image" alt="User Image">
						<span class="hidden-xs">{{Auth::user()->name.' '.Auth::user()->family}}</span>
					</a>
					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header">
							<img src="{!!asset('assets/uploads/user/medium/'.Auth::user()->image)!!}" class="img-circle" alt="User Image">
							<p>
								{{Auth::user()->name.' '.Auth::user()->family}}
								<small>{{jdate('F Y',Auth::user()->created_at->timestamp)}}  </small>
							</p>
						</li>
						<!-- Menu Body -->
						<li class="user-body">
							<div class="col-xs-12 text-center">
								<a href="#">{{Auth::user()->email}}</a>
							</div>
						</li>
						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-right">
								<a href="#" class="btn btn-default btn-flat">تغییر رمز</a>
							</div>
							<div class="pull-left">
								<a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">خروج</a>
								<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
									{{ csrf_field() }}
								</form>
							</div>
						</li>
					</ul>
				</li>
				<!-- Control Sidebar Toggle Button -->
				<li>
					<a href="#" data-toggle="control-sidebar">&nbsp;</a>
				</li>
			</ul>
		</div>
	</nav>
</header>
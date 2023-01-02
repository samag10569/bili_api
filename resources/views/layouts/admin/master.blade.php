<!DOCTYPE html>
<html>
  @include('layouts.admin.blocks.head')
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">
		@include('layouts.admin.blocks.menu')
      
      <!-- Left side column. contains the logo and sidebar -->
      @include('layouts.admin.blocks.sidebar')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            @yield('part')
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
			@yield('content')
		</section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	  {{--
		@include('layouts.admin.blocks.footer')
	  --}}

      <!-- Control Sidebar -->
	  
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    @include('layouts.admin.blocks.script')
  </body>
</html>

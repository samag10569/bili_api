<!DOCTYPE html>
<html>
  @include('layouts.out.blocks.head')
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">
		@include('layouts.out.blocks.menu')
      
      <!-- Left side column. contains the logo and sidebar -->
      @include('layouts.out.blocks.sidebar')

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
		@include('layouts.out.blocks.footer')
	  --}}

      <!-- Control Sidebar -->
	  
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    @include('layouts.out.blocks.script')
  </body>
</html>

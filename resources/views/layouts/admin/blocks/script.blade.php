
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.4 -->
    <script src="{{ asset('assets/admin/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- Morris.js charts -->
    <script src="{{ asset('assets/admin/js/raphael-min.js')}}"></script>
    <script src="{{ asset('assets/admin/plugins/morris/morris.min.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('assets/admin/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
    <!-- jvectormap -->
    <script src="{{ asset('assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
    <script src="{{ asset('assets/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('assets/admin/plugins/knob/jquery.knob.js')}}"></script>
    <!-- daterangepicker 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="{{ asset('assets/admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
    
	
    <script src="{{ asset('assets/admin/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
	-->
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
    <!-- Slimscroll -->
    <script src="{{ asset('assets/admin/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{ asset('assets/admin/plugins/fastclick/fastclick.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/admin/dist/js/app.min.js')}}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('assets/admin/dist/js/pages/dashboard.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('assets/admin/dist/js/demo.js')}}"></script>
    <script>
        $(document).ready(function(){
            /** add active class and stay opened when selected */
            var url = window.location;
            // for sidebar menu entirely but not cover treeview
            $('ul.sidebar-menu a').filter(function() {
                return this.href == url;
            }).parent().addClass('active');

            // for treeview
            $('ul.treeview-menu a').filter(function() {
                return this.href == url;
            }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');

            $( ".box-header .minimize" ).on( "click", function() {
                if($(this).hasClass( "fa-minus" )){
                    $(this).removeClass( "fa-minus" );
                    $(this).addClass( "fa-plus" );
                }else{
                    $(this).removeClass( "fa-plus" );
                    $(this).addClass( "fa-minus" );
                }
                if($(this).parent().parent().parent().find('.box-body').hasClass( "closed" )){
                    $(this).parent().parent().parent().find('.box-body').show();
                    $(this).parent().parent().parent().find('.box-body').removeClass('closed')
                }else{
                    $(this).parent().parent().parent().find('.box-body').hide();
                    $(this).parent().parent().parent().find('.box-body').addClass('closed')
                }
            });
        });
    </script>
@yield('js')
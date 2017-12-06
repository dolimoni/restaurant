        <!-- footer content -->
        
        <!-- /footer content -->
      </div>
    </div>


    <!-- jQuery -->
    <script src="<?php echo base_url('assets/vendors/jquery/dist/jquery.min.js'); ?>"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url("assets/vendors/bootstrap/dist/js/bootstrap.min.js"); ?> "></script>
    <!-- FastClick -->
    <script src="<?php echo base_url('assets/vendors/fastclick/lib/fastclick.js'); ?>"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url('assets/vendors/nprogress/nprogress.js'); ?>"></script>
    <!-- sweetalert --> 
    <script src="<?php echo base_url('assets/vendors/sweetalert/sweetalert.min.js'); ?>"></script>
    
    <!-- Chart.js -->
    <script src="<?php echo base_url('assets/vendors/Chart.js/dist/Chart.js'); ?>"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url('assets/build/js/custom.js'); ?>"> </script>


    <script src="<?php echo base_url('assets/js/v6car.js');?>"></script>

        <script>
            $(document).ready(function () {
                $('#fullScreen').on('click', go_full_screen);
                function go_full_screen() {
                    var elem = document.documentElement;
                    if (elem.requestFullscreen) {
                        elem.requestFullscreen();
                    } else if (elem.msRequestFullscreen) {
                        elem.msRequestFullscreen();
                    } else if (elem.mozRequestFullScreen) {
                        elem.mozRequestFullScreen();
                    } else if (elem.webkitRequestFullscreen) {
                        elem.webkitRequestFullscreen();
                    }
                }
            });
        </script>
  </body>
</html>

<?php echo $this->load->view('common/head');?>
    <!--header sec start-->

    <?php echo $this->load->view('common/header');?>
    <!--header sec end-->
   
    
    <?php echo $this->load->view('common/home_banner');?>
        
    <?php echo $template['body']; ?>
    <!-- /container -->
        
    
    <!--footer sec start-->
    <?php echo $this->load->view('common/footer');?>
    <!--footer sec end-->

    <!-- Bootstrap core JavaScript
    ================================================== -->
  
    <!-- Placed at the end of the document so the pages load faster -->   
    <script src="<?php echo MAIN_JS_DIR_FULL_PATH; ?>bootstrap.min.js"></script>
    <script src="<?php echo MAIN_JS_DIR_FULL_PATH; ?>jquery.eventCalendar.js" type="text/javascript"></script>  
    <!--
    <script src="<?php echo MAIN_JS_DIR_FULL_PATH; ?>jquery.headshrinker.js"></script>
    <script>
    jQuery(document).ready(function () {
        jQuery('.header').headshrinker({ fontSize: "17px", mobileMenu: true });
    });
    </script>
    -->
    <script src="<?php echo MAIN_JS_DIR_FULL_PATH; ?>f1-nav.js"></script>
    <script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH; ?>zebra_datepicker.js"></script>
    <script>
    $('#datepicker-example1').Zebra_DatePicker();
    </script>
    <script>
        $('#datepicker-example7-start').Zebra_DatePicker({
            direction: true,
            pair: $('#datepicker-example7-end')
        });

        $('#datepicker-example7-end').Zebra_DatePicker({
            direction: 1
        });        
    </script>
    
    <script>        
    $(function() {
        //Close alert
        $('.page-alerts .close').click(function(e) {
            e.preventDefault();
            $(this).closest('.page-alerts').slideUp();
        });
        
        //Clear all
        $('.clear-page-alerts').click(function(e) {
            e.preventDefault();
            $('.page-alerts').slideUp();
        });
    });
    </script>
    
   
    <script>
    $(document).ready(function(){
        $(".loadmore").click(function(){
            $(".loadmore").hide();
        });
        
    });
    </script>
    <!--
    <script>
        $('.collapse').collapse()
    </script>
    -->
</body>
</html>

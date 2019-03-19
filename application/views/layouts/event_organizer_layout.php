<?php echo $this->load->view('common/head');?>
<!--header sec end-->

<?php echo $this->load->view('common/header_event_organize');?>

<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>malsup.jquery.form.js"></script>
<?php $this->load->view('common/organizer_event_nav'); ?>

<!--item sec start-->
<div class="container organizer-details">
    <!--Vertical Tab-->
    <div id="parentVerticalTab">            
        <!--body section start -->
        <?php echo $template['body']; ?>
        <!--body section end -->
    </div>
</div> 
<!--item sec end-->

<!--footer sec start-->
<?php echo $this->load->view('common/footer');?>
<!--footer sec end-->

<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>general.js"></script>
<script src="<?php echo MAIN_JS_DIR_FULL_PATH;?>bootstrap.min.js"></script>
</body>
</html>
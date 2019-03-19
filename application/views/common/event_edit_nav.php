<!-- sub navigation bar start -->
<ul class="nav nav-tabs">
    <li <?php if($navigation=='index'){echo ' class="active"';} ?> ><a href="<?php echo site_url('organizer/index');?>" class="upload"><span><?php echo $this->lang->line('organizer_info'); ?></span></a></li>
    <li <?php if($navigation=='event'){echo ' class="active"';} ?> ><a href="<?php echo site_url('organizer/event');?>" class="upload"><span><?php echo $this->lang->line('event_management'); ?></span></a></li>
    <li <?php if($navigation=='payment'){echo ' class="active"';} ?>><a href="<?php echo site_url('organizer/payment');?>" class="ch_pass"><span><?php echo $this->lang->line('payments'); ?></span></a></li>    
</ul>
<!-- sub navigation bar end -->

<!--message block start -->
<?php if($this->session->flashdata('message')){ ?>
<div class="alert alert-success">  
  <a class="close" data-dismiss="alert">&times;</a>
  <?php echo $this->session->flashdata('message');?>
</div>
<?php  } ?>
<!--message block end -->
<!--error block start -->
<?php if($this->session->flashdata('error')){ ?>
<div class="alert alert-error">  
  <a class="close" data-dismiss="alert">&times;</a>
  <?php echo $this->session->flashdata('error');?>
</div>
<?php  } ?>
<!--error block end -->
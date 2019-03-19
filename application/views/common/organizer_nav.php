<!-- sub navigation bar start -->
<div class="col-md-2 left-sidebar">
    <ul>   
        <li <?php if($navigation=='event'){echo ' class="active"';} ?> ><a href="<?php echo site_url('organizer/event');?>" class="upload"><span><?php echo $this->lang->line('event_management'); ?></span></a></li>
        <li <?php if($navigation=='payment'){echo ' class="active"';} ?>><a href="<?php echo site_url('organizer/payment');?>" class="ch_pass"><span><?php echo $this->lang->line('payments'); ?></span></a></li>
        <li <?php if($navigation=='index'){echo ' class="active"';} ?> ><a href="<?php echo site_url('organizer/index');?>" class="upload"><span><?php echo $this->lang->line('organizer_info'); ?></span></a></li>    
    </ul>
</div>
<!-- sub navigation bar end -->

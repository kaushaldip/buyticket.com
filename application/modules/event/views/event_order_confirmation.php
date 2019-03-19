<div align="center" class="error">
    <?php 
        if($this->session->flashdata('message')){
            echo "<div class='message'>".$this->session->flashdata('message')."</div>";
        }  
    ?>
</div>
<!--error block start -->
<?php if($this->session->flashdata('cc_warning')){ ?>
<div class="alert alert-warning">  
  <a class="close" data-dismiss="alert">x</a>
  <?php echo $this->session->flashdata('cc_warning');?>
</div>
<?php  } ?>
<!--error block end -->
<div class="row-fluid">
	<div class="span8">
        <div class="box">
            <a href="<?=site_url('event/view/'.$data_event->id);?>"><?php echo $this->lang->line('back_to'); ?> <?=$data_event->title; ?></a>        	
            <div class="box_content">
                <legend><?php echo $this->lang->line('your_attending'); ?> <?=$data_event->title; ?></legend>
                <p><?php echo $this->lang->line('order_save_ticket'); ?></p>
                <p><?=$this->lang->line('order');?> <a href="<?=site_url('myticket/view/'.$order_detail->order_id); ?>" >#<?=$order_detail->order_id; ?></a> <?=$order_detail->total_tickets; ?> <?php echo $this->lang->line('tickets'); ?></p>
                <!--<p><?php echo $this->lang->line('tickets_have_sent'); ?> <?=$order_detail->email; ?></p>-->
                <br />
                <a href="<?=site_url('myticket'); ?>" class="btn"><?php echo $this->lang->line('go_my_tickets'); ?></a>                
            </div>
        </div>
    </div>
    
    <div class="span4">
        <div class="box">
            <div class="box_content">                                
                <?php echo $this->lang->line('hi'); ?> <?=ucwords($this->session->userdata(SESSION.'email')); ?>,<br />
                <?php 
                $logo_image = UPLOAD_FILE_PATH."event/thumb_".$data_event->logo;
                $logo = (file_exists($logo_image))? $logo_image: UPLOAD_FILE_PATH.'event_logo.jpg';
                ?>            	
                <img style="height: 50px !important;" class="event_logo" src="<?=base_url().$logo;  ?>" title="<?=$data_event->title; ?>" />
                
                <?php echo $this->lang->line('see_you_event'); ?>!
                <?php echo $this->lang->line('thanks'); ?>,
                
                <?php echo $this->lang->line('question_event'); ?><?=$this->lang->line('questions_about_this_event'); ?><?php echo $this->lang->line('contact_organizer'); ?> .
                
            </div>
        </div>
        <!-- organizers block start -->
        <?php if($organizers){ ?>
        <div class="box">
        	<h1><?php echo $this->lang->line('organizers'); ?></h1>
            <div class="box_content">
            <?php foreach($organizers as $organizer): ?>
                <?php               
                $organizer_image = UPLOAD_FILE_PATH."organizer/thumb_".$organizer->logo;
                $organizer_logo = (file_exists($organizer_image))? $organizer_image: UPLOAD_FILE_PATH.'sponsor_logo.jpg';
                ?>
                <ul class="description organizer_each">
                    <span class="organizer_logo"><img src="<?=base_url().$organizer_logo; ?>" title="<?php echo $organizer->name; ?>" /></span>
                	<li><strong><?php echo $this->lang->line('name'); ?>:</strong><?php echo ucwords($organizer->name); ?></li>                    
                    <li><strong><a href="<?=site_url('organizer/view/'.$organizer->organizer_id)?>" target="_blank"><?php echo $this->lang->line('organizer_profile'); ?></a></strong></li>
                </ul> 
                <br clear="all" />           	
            <?php endforeach; ?>                
            </div>
        </div>
        <?php } ?>
        <!-- organizers block end -->
    </div>
</div>
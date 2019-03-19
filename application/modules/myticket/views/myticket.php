<div class="row-fluid">
	<div class="<?=($events)? "span8": 'span';?>"> 
        <div class="box">
            <div class="box_content" style="position: relative;">
                <legend><?php echo $head; ?><span class="link_tag btn btn-small btn-info linker_tager pull-right"><i class="icon-info-sign icon-white"></i> <?=$link; ?></span></legend>
                <em><?php echo $this->lang->line('tickets_refunds_organizer'); ?>.</em>
                <a onclick="showURLInModal(this,'<?=site_url('page/refund-policy'); ?>')" href="javascript:void(0);" title="<?=$this->lang->line('refund_policy'); ?>" ><?=$this->lang->line('refund_policy'); ?></a>
                <div class="row-fluid  hullla">
                    <div class="create_event_ta col-md-3">
                        <a href="<?=site_url('event/create/') ?>" target="_blank"> 
                            <p class="date"><?php echo $this->lang->line('simple_step'); ?>.</p>
                            <p class="event_name"><?php echo $this->lang->line('create_an_event'); ?>.</p>
                            <span><?php echo $this->lang->line('get_started'); ?></span>
                        </a>
                    </div>
                <?php if($orders){ ?>
                    <?php foreach($orders as $order): ?>
                        <div class="order_ticket col-md-3">
                        <a href="<?=site_url('myticket/view/'.$order->order_id) ?>"> 
                            <p class="date"><?=date('M j, Y \a\t g:i A ',strtotime($order->order_for_date_start)); ?></p>
                            <p class="event_name"><?=ucwords($this->event_model->get_event_name_from_id($order->event_id)); ?></p>
                            <p class="date"><sub style="line-height: 14px;"><?=$this->lang->line('order_date')?>: <?=date('M j, Y \a\t g:i A ',strtotime($order->order_date)); ?></sub></p>
                            <span><?php echo $this->lang->line('view_order'); ?></span>
                        </a>
                        </div>
                    <?php endforeach; ?>                    
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    if($events)
    {
    ?>
    <div class="span4">
        <div class="box">
            <?php   
            foreach($events as $event) 
            {           
                $logo_image = UPLOAD_FILE_PATH."event/thumb_".$event->logo;
                $logo = (file_exists($logo_image))? $logo_image: UPLOAD_FILE_PATH.'event_logo.jpg';
               // print_r($event);
            ?>        
            <div class="event_each hereonly">
        		<a href="<?php echo site_url('event/view/'.$event->id); ?>" target="_blank">    		
                <span class="event_logo_image"><img align="left" src="<?=base_url().$logo;  ?>" /></span>
        		</a>
                <?php                 
                $gender = array('M'=>"Male Only", "F"=>"Female Only",'MF'=>"Male and Female");                       
                ?>                         
        		<dl>            
        			<dt><a href="<?php echo site_url('event/view/'.$event->id); ?>" target="_blank"><?=ucwords($event->title);?></a><i> (<?=(array_key_exists(strtoupper($event->target_gender),$gender))?$gender[strtoupper($event->target_gender)]: "Any gender";?>)</i></dt>       
        			
                    <?php if($event->date_id == 0 ):?>
                        <dd><?=$event->start_date;?> - <?=$event->end_date;?></dd>                
                    <?php else: ?>                
                        <dd><strong><?=$event->date_time_detail;?></strong></dd>
                    <?php endif; ?>
                                                    
        			<?php if(!empty($event->physical_name))?>
                        <dd><?=$event->physical_name;  ?></dd>                                       
        		</dl>
        		<div class="category_box color_<?=strtolower(substr($event->type_name,0,1)) ?>">
        			<p><?=ucwords($event->type_name);?></p>
        			<span class="category_divider"></span>
        			<p><?=ucwords($event->sub_type);?></p>
        		</div>
        	</div>
            <?php 
            }
            ?>
        </div>
    </div>
    <?
    }
    ?>
</div>
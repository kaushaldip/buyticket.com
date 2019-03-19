<link href="<?php echo MAIN_CSS_DIR_FULL_PATH;?>print.css" rel="stylesheet"/>
<?php if($tickets){ $i=1;?>

	<?php foreach($tickets as $ticket): ?>
    
    <div id="wrapper">
        <h2>#<?=$i; $i++;?></h2>    	
        <div class="ticket_box">
            
            <div class="ticket_detail_box">
            	<div class="event_box">
                	<span><?php echo $this->lang->line('event'); ?></span>
                    <?=$ticket->event_name ?>
                </div>
                <div class="date_box">
                	<span><?php echo $this->lang->line('date_time'); ?></span>
                    <?=$ticket->datetime_detail; ?>
                </div>
                <div class="type_box">
                <span><?php echo $this->lang->line('ticket_name'); ?></span>
                <?=$ticket->ticket_name; ?>
                </div>
                <div class="location_box">
                <span><?php echo $this->lang->line('location'); ?></span>
                <?=$ticket->location; ?>
                </div>
                <div class="order_box">
                <span><?php echo $this->lang->line('order_info'); ?></span>
                <?=$ticket->order_info; ?>
                </div>
            </div>
            <div class="ticket_logos_box">
            	<div class="logo_box">
                	<img src="<?=(file_exists(UPLOAD_FILE_PATH."event/thumb_".$ticket->event_logo))? site_url('', TRUE).UPLOAD_FILE_PATH."event/thumb_".$ticket->event_logo : site_url('', TRUE).UPLOAD_FILE_PATH."event_logo.jpg";?>" />
                </div>
                <div class="box_box">
                <img src="<?=site_url('', TRUE).UPLOAD_FILE_PATH."qrcode/".$ticket->barcode.".png"; ;?>" width="75" />
                </div>
                
                
            </div>
            <div class="fot_nm">
                <div class="logo_box1">
                	<h4><?=$ticket->barcode; ?></h4>
                </div>
                <div class="box_box2">
                    <span><?php echo $this->lang->line('order_by'); ?>:</span>
                    <h3><?=$ticket->attendee; ?> <nobr>(<?=$ticket->email; ?>)</nobr></h3>
                </div>
            </div>
            <div class="barcode_t_box">
                <div class="googlemap_box">   
                    <img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $ticket->latitude; ?>,+<?php echo $ticket->longitude; ?>&markers=<?php echo $ticket->latitude; ?>,+<?php echo $ticket->longitude; ?>&zoom=14&format=png&sensor=false&size=525x207&maptype=roadmap" />           
                    <?php /*  
                    <iframe height="207" width="525" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?q=<?php echo $ticket->latitude; ?>,+<?php echo $ticket->longitude; ?>&amp;hl=en&amp;ie=UTF8&amp;t=m&amp;source=embed&amp;z=17&amp;iwloc=A&amp;ll=<?php echo $ticket->latitude; ?>,<?php echo $ticket->longitude; ?>&amp;output=embed"></iframe>
                    */?>
                </div>
            </div>
            
        </div>
    </div>
    <br clear="all" />    
    <div style="height: 200px; display: block;"></div>
    <?php endforeach;?>
<?php } ?>

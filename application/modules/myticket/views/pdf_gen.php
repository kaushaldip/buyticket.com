<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <style type="text/css">
   HTML, BODY 
   {
   font-family:Serif, arabic;
   }
  </style>

<link href="<?php echo MAIN_CSS_DIR_FULL_PATH;?>pdf.css" rel="stylesheet"/>
<?php if($tickets){ ?>

	<?php foreach($tickets as $ticket): ?>    
<table border="0" class="ticket_table">
  <tr>
    <td width="50" rowspan="5" align="center">&nbsp;</td>
    <td width="286"><span><?php echo $this->lang->line('event'); ?></span>
        <h3><?=html_entity_decode(htmlentities($ticket->event_name)); ?></h3>
    </td>
    <td width="90" align="center" rowspan="2"><img src="<?=(file_exists(UPLOAD_FILE_PATH."event/thumb_".$ticket->event_logo))? site_url('',TRUE).UPLOAD_FILE_PATH."event/thumb_".$ticket->event_logo : site_url('',TRUE).UPLOAD_FILE_PATH."event_logo.jpg";?>" height="86px" /></td>
  </tr>
  <tr>
    <td><span><?php echo $this->lang->line('date_time'); ?></span>
        <p><?=$ticket->datetime_detail; ?></p>
    </td>
  </tr>
  <tr>
    <td ><span><?php echo $this->lang->line('type'); ?></span>
        <h4><?=html_entity_decode(htmlentities($ticket->ticket_name)); ?></h4>
    </td>
    <td align="center"><?=$ticket->payment_status ?></td>
  </tr>
  <tr>
    <td><span><?php echo $this->lang->line('location'); ?></span>
    <h6><?=html_entity_decode(htmlentities($ticket->location)); ?></h6>
    </td>
    <td rowspan="2" align="center"><img src="<?=site_url('', TRUE).UPLOAD_FILE_PATH."qrcode/".$ticket->barcode.".png"; ;?>" width="75" /></td>
  </tr>
  <tr>
    <td><span><?php echo $this->lang->line('order_info'); ?></span>
    <p><?=$ticket->order_info; ?></p>
    </td>
  </tr>
</table>
<div style="height: 80px; display: block; page-break-before:always;"></div>
    <?php endforeach;?>
<?php } ?>
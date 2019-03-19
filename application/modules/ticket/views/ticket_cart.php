<!-- list of tickets start-->
<div class="box">
    <h1><?php echo $this->lang->line('cart'); ?></h1>
    <div class="box_content">
        <table class="table table-striped for_table">
        	<tr>
            	<th><?php echo $this->lang->line('sn'); ?></th>
                <th><?php echo $this->lang->line('ticket_information'); ?></th>
                <th><?php echo $this->lang->line('rate'); ?></th>                
            </tr>
            <?php if($tickets) { ?>
            <?php $grand_total = 0; ?>
            <?php foreach($tickets as $ticket): ?>            
            <tr>
            	<td><?=$ticket->id;?></td>
                <td class="ticket_info">
                    <p><label><?php echo $this->lang->line('event'); ?>: </label> <?=ucwords($ticket->event_title); ?></p>
                    <p><label><?php echo $this->lang->line('location'); ?>: </label> <?=ucwords($ticket->event_location); ?></p>
                    <p><label><?php echo $this->lang->line('ticket'); ?>: </label> <?=ucwords($ticket->ticket_name); ?></p>
                    <p><label><?php echo $this->lang->line('ticket_number'); ?>: </label> <?=ucwords($ticket->ticket_number); ?></p>
                    <p><label><?php echo $this->lang->line('attendee'); ?>: </label> <input type="text" value="<?=ucwords($ticket->first_name." ".$ticket->last_name); ?>" name="attendee_name" /></p>
                </td>                
                <td><?=$ticket->currency;?> <?=$ticket->sub_total;?> </td>  
                <?php $grand_total += $ticket->sub_total; ?>               
            </tr>
            <?php endforeach; ?>
            <tr>
                <td>&nbsp;</td>
                <td align="right"><?php echo $this->lang->line('total'); ?>: </td>
                <td><?=$ticket->currency;?> <?=$grand_total; ?></td>
            </tr>
            <?php } else { ?>
            <tr>
                <td colspan="3"><?php echo $this->lang->line('empty_cart'); ?>.</td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
<!-- list of tickets end-->
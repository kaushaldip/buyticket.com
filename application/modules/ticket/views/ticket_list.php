<div align="center" class="error">
    <?php 
        if($this->session->flashdata('message')){
            echo "<div class='message'>".$this->session->flashdata('message')."</div>";
        }   
    ?>
</div>


<!-- event detail start-->
<div class="box">
    <h1><?=(!empty($event_detail->name)) ?$event_detail->name :$event_detail->title ;?></h1>
    <div class="box_content">
        <ul class="for_info">
            <li>
                <label><?=(!empty($event_detail->name)) ? "Name" :"Title" ;?></label>
                <?=(!empty($event_detail->name)) ?$event_detail->name :$event_detail->title ;?>
            </li>
            <?php if($event_detail->custom_date == '0000-00-00' ) {?>
            <li>
                <label><?php echo $this->lang->line('start_date');?></label>
                <?=$event_detail->start_date;?>
            </li>
            <li>
                <label><?php echo $this->lang->line('end_line');?></label>
                <?=$event_detail->end_date;?>
            </li>
            <?php }else{?>
            <li>
                <label><?php echo $this->lang->line('date');?></label>
                <?=$event_detail->custom_date;?>
            </li>
            <?php }?>
            <li>
                <label><?php echo $this->lang->line('current_status');?>:</label>
                <?=($check_event_active)? "Active":"Expired"; ?>
            </li>
        </ul>
    </div>
</div>
<!-- event detail end-->

<?php if($tickets){?>
<!-- list of tickets start-->
<div class="box">
    <h1><?php echo $this->lang->line('list_tickets');?></h1>
    <div class="box_content">
        <table class="table table-striped for_table">
        	<tr>
            	<th><?php echo $this->lang->line('ticket_name');?></th>
                <th><?php echo $this->lang->line('starts_on');?></th>
                <th><?php echo $this->lang->line('close_on');?></th>
                <th><?php echo $this->lang->line('quantity');?></th>                
                <th><?php echo $this->lang->line('ticket_price');?></th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach($tickets as $ticket): ?>
            <form method="post" action="<?php echo site_url('ticket/cart'); ?>">
            <tr>
            	<td><?=$ticket->name;?></td>
                <td><?=$ticket->start_date;?></td>
                <td><?=$ticket->end_date;?></td>
                <td>
                <?php 
                $total_ticket = $ticket->max_number;
                $sold_ticket = $this->ticket_model->sold_ticket($ticket->id);
                $remain_ticket = $total_ticket - $sold_ticket;                
                ?>
                <select name="quantity">
                    <?php for($i=1; $i<=$remain_ticket; $i++): ?>
                    <option value="<?=$i;?>"><?=$i;?></option>
                    <?php endfor; ?>                    
                </select>             
                </td>                
                <td><?=$ticket->currency;?> <?=$ticket->ticket_price;?> </td>
                <td>
                <?php if($this->ticket_model->ticket_available($ticket->id)){ ?>                    
                    <input type="hidden" value="<?=$ticket->id;?>" name="ticket_id" />                    
                    <input type="hidden" value="<?=$ticket->event_id;?>" name="event_id" />
                    <input type="hidden" value="<?=$ticket->ticket_price;?>" name="rate" />
                    <input type="hidden" value="<?=$ticket->ticket_prefix;?>" name="prefix" />
                    
                    <input type="submit" value="Buy Now" class="button" />                    
                <?php } else{ ?>
                    <a class="button">&nbsp;Closed&nbsp;&nbsp; </a>
                <?php } ?>                    
                </td>
            </tr>
            </form>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<!-- list of tickets end-->
<?php } ?> 
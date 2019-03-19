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
                <label>Start Date</label>
                <?=$event_detail->start_date;?>
            </li>
            <li>
                <label>End Date</label>
                <?=$event_detail->end_date;?>
            </li>
            <?php }else{?>
            <li>
                <label>Date</label>
                <?=$event_detail->custom_date;?>
            </li>
            <?php }?>
            <li>
                <label>Current Event Status:</label>
                <?=($check_event_active)? "Active":"Expired"; ?>
            </li>
        </ul>
    </div>
</div>
<!-- event detail end-->

<?php if($check_event_active){ ?>
<!-- add ticket form start-->
<form method="post" enctype="multipart/form-data" action="" id="event_form" class="for_form box">
    <h1>Add Ticket Form</h1>
    <fieldset class="for_inputs box_content">        
        <ul>
            <li>
                <label>Name*:</label>
                <input type="text" name="name" value="<?=set_value('name'); ?>" />      
                <?=form_error('name') ?>          
            </li>
            <li>
                <label>Maximum number of Tickets:</label>
                <input type="text" name="max_number" value="<?=set_value('max_number'); ?>" style="width: 100px;" />
                <?=form_error('max_number') ?>                  
            </li>
            <li>
                <label>Registration starts on*:</label>
                <input type="text" name="start_date" value="<?=set_value('start_date'); ?>" id="ticket_start_date" style="width: 100px;"/>                
                <?=form_error('start_date') ?>
            </li>
            <li>
                <label>Registration closed on*:</label>
                <input type="text" name="end_date" value="<?=set_value('end_date'); ?>" id="ticket_end_date" style="width: 100px;"/>                
                <?=form_error('end_date') ?>
            </li>
            <?php if($this->general->is_paid_event($event_id)) {?>
            <li>
                <label>Your Price:</label>
                <select name="currency" style="width: 100px;">
                    <option value="USD">USD</option>
                </select>
                <input type="text" name="price" value="<?=set_value('price'); ?>" style="width: 100px;" id="ticket_your_price"/>           
                <?=form_error('price') ?>     
            </li>
            <li>
                <label>Web Fee Included in ticket:</label>
                <input type="checkbox" name="web_fee_included_in_ticket" id="web_fee_included_in_ticket" checked="checked" />
                <em>Uncheck to exclude web cost in ticket.</em>
                <?=form_error('web_fee_included_in_ticket') ?>
                <br />                
                <label>&nbsp;</label>
                               
            </li>
            <li>
                <label>Web Fee:</label>
                <input type="text" style="width: 100px;" value="" disabled="disabled" name="website_fee" id="ticket_website_fee" />
                <em>Note: Web fee charge is <?=WEBSITE_FEE;?>%.</em>
                    
            </li>
            <li>
                <label>Ticket Price:</label>
                <input type="text" name="ticket_price" style="width: 100px;" value="" disabled="disabled" id="ticket_price" />    
            </li>
            <li>
                <label>Payment Method Fee:</label>
                <em>Payment method fees are charged separately to the attendee.</em>
                    
            </li>
            <!-- to check affilate start -->
                <?php if($this->general->has_affilate_parent()){ ?>
                <li>
                    <label>Affiliate Rate: </label>                
                    <?php                                        
                    $affilate_rates = explode(',',EVENT_AFFILIATE_RATE);
                    foreach($affilate_rates as $affilate):
                    ?>
                    <input checked="checked" type="radio" name="affiliate_rate" value="<?=$affilate;?>" /> <?=$affilate;?> %
                    <?php endforeach;?>        
                    <?=form_error('affiliate_rate') ?>        
                </li>
                <?php } ?>
            <!-- to check affilate start -->
            <?php } ?>
            <li>
                <label>&nbsp;</label>
                <input type="submit" name="add_ticket" value="Add Ticket" class="submit" style="width: 120px !important;"/>    
            </li>
        </ul>
    </fieldset>
</form>
<!-- add ticket form end-->
<?php } ?>

<?php if($tickets){?>
<!-- list of tickets start-->
<div class="box">
    <h1>List of tickets</h1>
    <div class="box_content">
        <table class="table table-striped for_table">
        	<tr>
            	<th>Ticket Name</th>
                <th>Starts On</th>
                <th>Close On</th>
                <th>Total Tickets</th>
                <th>Tickets available</th>
                <th>Ticket Price</th>
            </tr>
            <?php foreach($tickets as $ticket): ?>
            <tr>
            	<td><?=$ticket->name;?></td>
                <td><?=$ticket->start_date;?></td>
                <td><?=$ticket->end_date;?></td>
                <td><?=$ticket->max_number;?></td>
                <td><?=$ticket->max_number;?></td>
                <td>
                    <p>Your Price: <?=$ticket->currency;?> <?=$ticket->price;?></p>
                    <p>Web Fee: <?=$ticket->currency;?> <?=($ticket->web_fee_include_in_ticket == '1')? "": "+" ; ?> <?=$ticket->website_fee;?></p>
                    <hr />
                    <p>Ticket Price: <?=$ticket->currency;?> <?=$ticket->ticket_price;?></p>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<!-- list of tickets end-->
<?php } ?> 
<?php 
//$mindays = (strtotime($event_detail->start_date) - strtotime(date('y-m-d')))/(24*60*60);
$maxdays = (strtotime($event_detail->end_date) - strtotime(date('y-m-d')))/(24*60*60);
?>
<script>

var startDateTextBox = $('#ticket_start_date');
var endDateTextBox = $('#ticket_end_date');

$(function() {
    $( "#ticket_start_date" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        maxDate: "<?=$event_detail->start_date;?>",
        dateFormat: "yy-mm-dd",
        onClose: function( selectedDate ) {
            $( "#ticket_end_date" ).datepicker( "option", "minDate", selectedDate );
            }
    });
    $( "#ticket_end_date" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        maxDate: <?=$maxdays;?>,
        dateFormat: "yy-mm-dd",
        onClose: function( selectedDate ) {
            $( "#ticket_start_date" ).datepicker( "option", "maxDate", selectedDate );
        }
    });
});
</script>
<script>
web_fee_rate = parseFloat("<?=WEBSITE_FEE?>") ;
$('#ticket_your_price').keyup(function(){        
    price_display();         
});

$("#web_fee_included_in_ticket").click(function(){
    price_display();
});

function price_display()
{
    your_price = $('#ticket_your_price').val();
    your_price = parseFloat(your_price);
    
     
    
    web_fee = web_fee_rate /100 * your_price;
    web_fee = parseFloat(web_fee);    
         
    $('#ticket_website_fee').val(parseFloat(web_fee).toFixed(2));
    
    flag = document.getElementById("web_fee_included_in_ticket").checked;
    
    if(flag)
        ticket_price = your_price;
    else{
        ticket_price  = your_price + web_fee;  
        ticket_price = parseFloat(ticket_price).toFixed(2)
    }
                    
    $('#ticket_price').val(ticket_price); 
}
</script>
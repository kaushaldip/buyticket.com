<?php
//var_dump($order_detail);
?>
<style>
.here_only h2{margin: 5px 0 !important;}
.here_only label{font-weight: bold; padding:0 !important}
.here_only .mws-form-row{padding: 0 !important;}
.for_labeled label{width: 85px;text-align: right;display: inline-block;margin-right: 10px;}
.here_only h5{margin-bottom: 5px; border-bottom: 1px solid #cdcdcd; padding: 5px;}
#load_form{   
    display: none;
    overflow: scroll;
    height: 230px;
    margin: auto;
    overflow-x: hidden;
    position: absolute;
    width: 100%;
}
#load_form span.back{ background: none repeat scroll 0 0 #ff8b23; color: #efefef; cursor: pointer; padding: 5px; position: absolute; right: 0; z-index: 99999;}
#load_form span#back1{ top: 0;}
#load_form span#back2{bottom: 0;}
#load_form span.back:hover{background: #ff7e0b; color: #fff;}
</style>
<div class="here_only" id="organizer_details">
    <?php    
    	if ($this->session->flashdata('message'))
    	{
    		echo "<div class='mws-form-message success'>" . $this->session->flashdata('message') . "</div>";
    	}            
    ?>
    <div class="for_labeled" style="padding: 5px 15px; line-height: 20px;">
        <p>Event: <strong><?=$event_organizer->title;?></strong></p>
    	<div style="background: #f5f5f5; padding: 10px; margin-bottom: 10px;">
    		<h5>Organizer Details:</h5>
    		<label>Organizer:</label><strong><?=$event_organizer->first_name." ".$event_organizer->last_name; ?></strong><br />
    		<label>Email:</label><em><?=$event_organizer->email; ?></em>
    	</div>
    	<div style="background: #f5f5f5; padding: 10px; margin-bottom: 10px;">
    		<h5>Organizer Payment Details:</h5>
    		<div style="display:inline-block; width: 40%;">
    			<h6 style="margin-bottom: 0;">Bank Detail:</h6>
    			<label>Name:</label><strong><?=$event_organizer->bank_name; ?></strong><br />
    			<label>Acc Number:</label><strong><?=$event_organizer->account_number; ?></strong><br />
    			<label>Acc holder:</label><strong><?=$event_organizer->account_holder_name; ?></strong><br />                
    		</div>
    		<div style="display:inline-block; width: 40%; margin-left: 8%;">
    			<h6 style="margin-bottom: 0;">Western Union:</h6>
    			<label>Payee Name:</label><strong><?=$event_organizer->western_payee_name; ?></strong><br />
    			<label>City:</label><strong><?=$event_organizer->western_city; ?></strong><br />
    			<label>Country:</label><strong><?=$event_organizer->western_country; ?></strong><br />                
    		</div>
        </div>             
    </div>
    <div class="mws-panel grid_8" id="view_organizer_payment">
    	<div style="border-top:1px solid #cccccc;" class="mws-panel-body">
            <table id="myTable" class="mws-datatable mws-table">
                <thead>
                    <tr>
                        <th>ID</th>                         
                        <th>Ticket</th>  
                        <th>Total Payment</th>
                        <th>Total Paid</th>
                        <th>Total Due</th>                    
                        <th>Operation</th>                    
                    </tr>
                </thead>
                <tbody>
                <?php if($ticketwise_order){?>
                    <?php foreach($ticketwise_order as $t):?>
                    <tr>
                        <td><?=$t->id ?></td>                        
                        <td><?=$t->ticket_name; ?></td>                    
                        <td id="organizer_payment"><?="USD ".$t->total_organizer_payment; ?></td>
                        <td id="organizer_paid<?=$t->ticket_id ?>"><?="USD ".$t->total_organizer_paid; ?></td>
                        <td id="organizer_due<?=$t->ticket_id ?>"><?="USD ".($t->total_organizer_payment - $t->total_organizer_paid); ?></td>
                        <td id="pay_organizer<?=$t->ticket_id ?>">
                        <?php if($t->total_organizer_paid == $t->total_organizer_payment){?>
                            Paid
                        <?php }else{?>                        
                            <a href="#" onclick="confirm_organizer_payment('<?=$t->event_id ?>','<?=$t->ticket_id ?>');return false;" >Pay</a>                        
                        <?php }?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php }else{ ?>
                    <tr>
                        <td colspan="6">No payments left.</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <!--
        <h3>Order details:</h3>
        <div style="border-top:1px solid #cccccc;" class="mws-panel-body">            
            <table id="myTable" class="mws-datatable mws-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order ID</th> 
                        <th>Ticket</th>  
                        <th>Payment</th>
                        <th>Paid</th>
                        <th>Due</th>
                    </tr>
                </thead>
                <tbody>
                <?php if($order_detail){?>
                    <?php foreach($order_detail as $pd):?>
                    <tr>
                        <td><?=$pd->id ?></td>
                        <td><?=$pd->order_id; ?> #<?=$pd->id ?></td>
                        <td><?=$pd->ticket_id; ?></td>                    
                        <td id="organizer_payment"><?="USD ".$pd->organizer_payment; ?></td>
                        <td id="organizer_paid"><?="USD ".$pd->organizer_paid; ?></td>
                        <td id="organizer_due"><?="USD ".($pd->organizer_payment - $pd->organizer_paid); ?></td>                    </tr>
                    <?php endforeach; ?>
                <?php } ?>
                </tbody>
            </table>
        </div>
        -->
    </div>
    <div id="load_form"><span class="back" id="back1">Back</span><div></div><span style="position: relative; float:right;" class="back" id="back2">Back</span></div>
</div>
<script>
site_url = "<?=site_url(); ?>";
adminUrl = "<?=site_url(ADMIN_DASHBOARD_PATH)?>";
root_url = site_url.slice(0,-3); 
function confirm_organizer_payment(event_id, ticket_id)
{    
    $("#view_organizer_payment").hide();
    $("#load_form").show(500);
    $('#load_form div').append('<img src='+root_url+'/assets/images/ajax_loader_small.gif>');    
    $.ajax({
        type: "POST",
        url: adminUrl+"/payment/confirm_organizer_payment",  
        data: 'event_id='+event_id+"&ticket_id="+ticket_id,
        dataType: "html",       
        success: function(data){     
            $("#load_form div").html(data);                       
        }     
    });  
   
}

$("#load_form .back").on('click',function(){
    $("#load_form div").html("");
    $("#load_form").hide();
    $("#view_organizer_payment").show(500);
        
});
</script>
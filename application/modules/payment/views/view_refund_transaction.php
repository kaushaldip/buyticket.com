<style>
.for_labeled label{width: 105px;text-align: right;display: inline-block;margin-right: 10px;}
</style>
<div class="for_labeled" style="padding: 5px 15px; line-height: 20px;">    
	<div style="background: #f5f5f5; padding: 10px; margin-bottom: 10px;">
	   <p>Event: <strong><?=$this->general->get_value_from_id('es_event',$refund_detail->event_id,'title') ;?></strong></p>	
	</div>
	<div style="background: #f5f5f5; padding: 10px; margin-bottom: 10px;">
		<h5>Refund Transaction:</h5>
		<div style="display:inline-block; width: 40%; border-right: 1px solid #ccc;">
			<h6 style="margin-bottom: 0;">Order Details:</h6>
    		<label>Email:</label><strong><?=$refund_detail->email; ?></strong><br />
    		<label>Total Payment:</label><em><?=$refund_detail->total; ?></em><br />
            <label>Amount Paid:</label><em><?=$this->general->price($refund_detail->paid); ?></em><br />
            <label>Due:</label><em><?=$this->general->price($refund_detail->due); ?></em><br />
            <label>Organizer Paid:</label><em><?=($refund_detail->organizer_paid > 0)? "Yes" : "No"; ?></em><br />
            <label>Order Date:</label><em><?=($refund_detail->order_date); ?></em>             
		</div>
		<div style="display:inline-block; width: 40%; margin-left: 8%;">
			<h6  style="margin-bottom: 0;">Refund Details:</h6>
    		<label>Refund Amount:</label><strong><?=$this->general->price($refund_detail->refund_percent * $refund_detail->paid  / 100); ?></strong><br />
    		<label>Refund Percent:</label><em><?=$refund_detail->refund_percent; ?> %</em><br />
            <label>Refund Date:</label><em><?=$refund_detail->refund_date; ?></em><br />                       
		</div>
    </div>
    <div style="background: #f5f5f5; padding: 10px; margin-bottom: 10px;">
        <?php if($refund_detail->refund_complete=='no'){?>
            <div id="refund_here">
                <button class="mws-button blue" id="refund_transaction_approved">Refund</button>
            </div>
        <?php }else{?>
            Refunded    
        <?php  } ?>
    </div>             
</div>


<script>
var ticket_order_id = '<?=$ticket_order_id?>';
var adminURL = '<?=site_url(ADMIN_DASHBOARD_PATH); ?>';
site_url= '<?=site_url(); ?>';
root_url = site_url.slice(0,-3); 
$("#refund_transaction_approved").click(function(){
    $('#refund_here').append('<img src='+root_url+'/assets/images/ajax_loader_small.gif>');
    $.ajax({
        type: "POST",
        url: adminURL+"/payment/refund_transaction_approved",  
        data: 'ticket_order_id='+ticket_order_id,
        dataType: "json",       
        success: function(json){      
            if(json.result=='success'){
                $('#refund_here').html("Refunded");
                //$("#refund_payment_detail"+ticket_order_id).hide(200);
            }else{
                $('#refund_here').html("<font color=red>Something went wrong.</font>");
            }                          
        }     
    });         
});
</script>


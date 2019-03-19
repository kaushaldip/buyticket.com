<?php
//var_dump($order_detail);
?>
<style>
.here_only h2{margin: 5px 0 !important; border-bottom: 1px dotted #32325f;}
.here_only label{font-weight: bold; padding:0 !important}
.here_only .mws-form-row{padding: 0 !important;}
</style>
<div class="mws-panel here_only">
	<div class="mws-panel-header">
    	<span class="mws-i-24">Order Information</span>
    </div> 
    <?php if($order_detail->event_cancel == 'yes'){ ?>
        <div class="mws-form-message warning">
        This event has been cancelled. Please confirm if payment has been done or cancel it if payment is not done yet. If payment has been done, 
        <ol>
            <li>First, confirm payment from here for approval. </li>
            <li>Second, move to refund section where you will need to refund the price.</li>
        </ol>
        </div>
    <?php } ?>   
	<form id="mws-validate" class="mws-form mws-panel-content mws-panel-body" >
    	<div class="mws-form-inline">
        	<?php if(strtoupper($order_detail->payment_status) !="COMPLETE") { ?>
            <div class="mws-form-row" id="loderere">
            	USD <input type="text" name="amount_paid" class="mws-textinput required number" title=" " value="<?=$order_detail->due;?>" />
                <input type="hidden" name="due" value="<?=$order_detail->due;?>" />
                <input type="hidden" name="received_amount" value="<?=$order_detail->paid;?>" />
            	<input type="button" class="mws-button green" value="Confirm" onclick="confirm_approve_payment('<?=$order_detail->ticket_order_id;?>');return false;" />
                
            </div>
            <?php }else{?>
            <div class="status-active-bg">Transaction Complete</div>
            <?php }?>
            
            <h2>&nbsp;</h2>
                
                    
            <div class="mws-form-row">
            	<label>Total Amount:</label>
            	<div class="mws-form-item large"><?="USD ".$order_detail->total;?></div>
            </div>
            <div class="mws-form-row">
            	<label>Amount Received:</label>
            	<div class="mws-form-item large" id="received_amt" ><?="USD ".$order_detail->paid;?> </div>
            </div>
            <div class="mws-form-row">
            	<label>Due Amount:</label>
            	<div class="mws-form-item large" id="due_amt"> <?="USD ".$order_detail->due;?> </div>
            </div>
            <div class="mws-form-row">
            	<label>Discount:</label>
            	<div class="mws-form-item large"><?="USD ".$order_detail->discount;?></div>
            </div>
            <div class="mws-form-row">
            	<label>Ordered Quantity:</label>
            	<div class="mws-form-item large"><?=$order_detail->ticket_quantity;?></div>
            </div>
            <div class="mws-form-row">
            	<label>Event Name:</label>
            	<div class="mws-form-item large"><?=$order_detail->title;?></div>
            </div>
            <h2>Ticket Information:</h2>
            <div class="mws-form-row">
            	<label>Ticket Name:</label>
            	<div class="mws-form-item large"><?=$order_detail->ticket_name;?></div>
            </div>
            <div class="mws-form-row">
            	<label>Ticket Rate:</label>
            	<div class="mws-form-item large"><?="USD ".$order_detail->price;?></div>
            </div>
            <div class="mws-form-row">
            	<label>Web Price:</label>
            	<div class="mws-form-item large"><?="USD ".$order_detail->website_fee;?></div>
            </div>
            <div class="mws-form-row">
            	<label>Ticket Price:</label>
            	<div class="mws-form-item large"><?="USD ".$order_detail->ticket_price;?></div>
            </div>                
            <h2>Order Detail</h2>
            
            <div class="mws-form-row">
            	<label>Order Id:</label>
            	<div class="mws-form-item large"><?=$order_detail->order_id;?></div>                    
            </div>
            <div class="mws-form-row">
            	<label>Order Email (user):</label>
            	<div class="mws-form-item large"><?=$order_detail->main_email;?></div>                    
            </div>
            <div class="mws-form-row">
            	<label>Order Date:</label>
            	<div class="mws-form-item large"><?=date('Y m d H:i:s', strtotime($order_detail->order_date));?></div>
            </div>
            <div class="mws-form-row">
            	<label>Transaction Method:</label>
            	<div class="mws-form-item large"><?=$order_detail->transaction_method;?></div>
            </div>
            <h2>Transaction detail</h2>
            <?php if(strtoupper($order_detail->transaction_method) == 'PAYPAL'){ ?>
                <div class="mws-form-row">
                	<label>Paypal Token:</label>
                	<div class="mws-form-item large"><?=$order_detail->token;?></div>
                </div>
                <div class="mws-form-row">
                	<label>Paypal PayerID:</label>
                	<div class="mws-form-item large"><?=$order_detail->payid;?></div>
                </div>
                <div class="mws-form-row">
                	<label>Paypal Email:</label>
                	<div class="mws-form-item large"><?=$order_detail->email;?></div>
                </div>    
                <div class="mws-form-row">
                	<label>Currency Code:</label>
                	<div class="mws-form-item large"><?=$order_detail->currencycode;?></div>
                </div>            
                <div class="mws-form-row">
                	<label>Amount paid:</label>
                	<div class="mws-form-item large"><?="USD ".$order_detail->epi_amount;?> </div>
                </div>
            <?php }else{?>
                <div class="mws-form-message success">
                The payment is made for all the paid tickets of order <strong>#<?=$order_detail->order_id;?></strong>. So you need to confirm all the payments of this order.
                </div>
                <div class="mws-form-row">
                	<label>Bank Name (FROM):</label>
                	<div class="mws-form-item large"><?=$order_detail->bank_name_from;?></div>
                </div>
                <div class="mws-form-row">
                	<label>Account Holder:</label>
                	<div class="mws-form-item large"><?=$order_detail->account_holder_name;?></div>
                </div>
                <div class="mws-form-row">
                	<label>Amount Paid:</label>
                	<div class="mws-form-item large"><?="USD ".$order_detail->ebt_amount;?></div>
                </div>
                <div class="mws-form-row">
                	<label>Payment made to Bank:</label>
                	<div class="mws-form-item large"><?=$order_detail->bank_name_to;?></div>
                </div> 
            <?php }?>
            
            
        </div>
    </form>
        	
</div>
<script>
adminUrl = '<?=site_url(ADMIN_DASHBOARD_PATH);?>';
//alert('<?=$order_detail->ticket_order_id;?>');
site_url = '<?=site_url(); ?>';
root_url = site_url.slice(0,-3); 
//$("#mws-validate").validate();
function confirm_approve_payment(ticket_order_id)
{    
    amount_paid = $("input[name=amount_paid]").val();
    due =  $("input[name=due]").val();
    received_amount = $("input[name=received_amount]").val();
    if(amount_paid > due){
        alert("Can not enter more than due amount.");
    }else{
        $('#loderere').append('<img src='+root_url+'/assets/images/ajax_loader_small.gif>');    
        $.ajax({
            type: "POST",
            url: adminUrl+"/payment/confirm_approve_payment",  
            data: 'ticket_order_id='+ticket_order_id+"&amount_paid="+amount_paid+"&due="+due+'&received_amount='+received_amount,
            dataType: "json",       
            success: function(json){      
                if(json.response=='success'){
                    htmls = '<div class="status-active-bg">Transaction Complete.</div>';
                }else{
                    htmls = '<div class="status-active-bg">Failed to compelte transaction. Please try again.</div>';
                }
                $("#loderere").html(htmls);
                $("#received_amt").html('USD '+json.received_amount)
                $("#due_amt").html('USD '+json.due_amount)
                $("#payment_status_"+'<?=$order_detail->ticket_order_id;?>').html(json.payment_status);
                if(json.event_cancel == 'yes')
                {
                    $("#payment_status_"+'<?=$order_detail->ticket_order_id;?>').parent().hide('slow');
                }                 
            }     
        });  
    }
           
      
}

</script>
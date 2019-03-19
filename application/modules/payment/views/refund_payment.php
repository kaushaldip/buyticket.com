<style>
.for_labeled label{width: 105px;text-align: right;display: inline-block;margin-right: 10px;}
</style>
<?php 
$event_id =$this->general->get_value_from_id('es_event_ticket_order',$ticket_order_id,'event_id');
$refund_id =  $this->general->get_value_from_id('es_event',$event_id,'refund_id');
?>
<div class="for_labeled" style="padding: 5px 15px; line-height: 20px;">    
    <div style="background: #f5f5f5; padding: 10px; margin-bottom: 10px;">
        <div style="margin-bottom: 20px;">
            <h4>Refund Ticket Order #<?=$ticket_order_id; ?></h4>
            <h5>Event: <strong><?=$this->general->get_value_from_id('es_event',$event_id,'title');?></strong></h5>            
        </div>
        <?php if($refund_id==0){ ?>
            You may not refund this transaction. 
        <?php }else{ ?>            
            <?php
            $refund_detail = $this->myticket_model->get_refund_policy_by_event($event_id);
            if(strtotime($this->general->get_local_time('time')) < strtotime($refund_detail->date_1)){
                $per = $refund_detail->refund_1;
                echo $refund_detail->refund_1." % ".$this->lang->line('refund');    
            }else if(strtotime($this->general->get_local_time('time')) < strtotime($refund_detail->date_2)){
                $per = $refund_detail->refund_2;
                echo $refund_detail->refund_2." % ".$this->lang->line('refund');
            }else if(strtotime($this->general->get_local_time('time')) < strtotime($refund_detail->date_3)){
                $per = $refund_detail->refund_3;
                echo $refund_detail->refund_3." % ".$this->lang->line('refund');
            }else{
                echo "No refund";
                exit;
            }
            ?>  
            <h5>Refund Details:</h5>
            Order Amount: <?=$this->general->price($this->general->get_value_from_id('es_event_ticket_order', $ticket_order_id, 'paid')); ?> <br />
            Refund Amount: <?=$this->general->price($this->general->get_value_from_id('es_event_ticket_order', $ticket_order_id, 'paid') * $per / 100 ); ?>
            <br /><br />
            <div id="refund_payment_block">
                <button class="mws-button green" id="confirm_refund<?=$ticket_order_id?>">Make Refund</button>
                <button class="mws-button blue" onclick="jQuery.colorbox.close(); return false;" >Cancel</button>
            </div>
        <?php } ?>
               	
	</div>
</div>

<script>
var ticket_order_id = '<?=$ticket_order_id?>';
var siteUrl = '<?=site_url(); ?>';
$("#cancel_refund"+ticket_order_id).click(function(){
    $("#refund_block"+ticket_order_id).html('').hide(200);
});

$("#confirm_refund"+ticket_order_id).click(function(){
    $.ajax({
        type: "POST",
        url: siteUrl+"myticket/refund_confirmed",  
        data: 'ticket_order_id='+ticket_order_id+"&percent="+'<?=$per;?>'+"&event_id="+'<?=$event_id?>',
        dataType: "json",       
        success: function(json){      
            if(json.result=='success'){
                $("#refund_payment_block").show().html(json.msg);
                $("#order_row"+ticket_order_id).html("").hide();
            }else{
                $("#refund_payment_block").show().html(json.msg);
            }                          
        }     
    }); 
});
</script>
<?php
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
<h5><?=$this->lang->line('refund_details') ?>:</h5>
<?=$this->lang->line('order_amount') ?>: <?=$this->general->price($this->general->get_value_from_id('es_event_ticket_order', $ticket_order_id, 'paid')); ?> <br />
<?=$this->lang->line('refund_amount') ?>: <?=$this->general->price($this->general->get_value_from_id('es_event_ticket_order', $ticket_order_id, 'paid') * $per / 100 ); ?>
<br /><br />
<button class="btn" id="confirm_refund<?=$ticket_order_id?>"><?=$this->lang->line('refund'); ?></button>
<button class="btn" id="cancel_refund<?=$ticket_order_id?>"><?=$this->lang->line('cancle'); ?></button>

<script>
var ticket_order_id = '<?=$ticket_order_id?>';
var siteUrl = '<?=site_url(); ?>';
$("#cancel_refund"+ticket_order_id).click(function(){
    $("#refund_block"+ticket_order_id).html('').hide(200);
});

$("#confirm_refund"+ticket_order_id).click(function(){
    //alert('ticket_order_id='+ticket_order_id+"&percent="+'<?=$per;?>'+"&event_id="+'<?=$event_id?>');
    $.ajax({
        type: "POST",
        url: siteUrl+"/myticket/refund_confirmed",  
        data: 'ticket_order_id='+ticket_order_id+"&percent="+'<?=$per;?>'+"&event_id="+'<?=$event_id?>',
        dataType: "json",       
        success: function(json){   
            //alert(json.result);
            if(json.result=='success'){
                $("#refund_block"+ticket_order_id).show().html('<div class="alert alert-success"><a class="close" data-dismiss="alert">&times;</a>'+json.msg+'</div>');                
                $("#menu_print"+ticket_order_id).html('<button class="btn btn-mini btn-info " style="cursor: default;" >Waiting for Refund</button>');
            }else{
                $("#refund_block"+ticket_order_id).show().html('<div class="alert alert-error"><a class="close" data-dismiss="alert">&times;</a>'+json.msg+'</div>');
            }                          
        },
        error: function(e){            
            console_log(e);
        }     
    }); 
});
</script>
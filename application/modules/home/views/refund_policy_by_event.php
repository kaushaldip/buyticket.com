<style>
h5.for_h5{font-size: 14px !important; font-weight: bold;}
</style>
<legend class="for_legend">
    <h4><?=ucwords($this->general->get_value_from_id('es_event',$event_id,'title')); ?></h4>
    <h6><?=$this->lang->line('refund_policy')?></h6>
</legend>
<?php if($refund_detail){ ?>    
    <h5 class="for_h5">
    <span class="text-danger"><?=$refund_detail->refund_1; ?>% <?=$this->lang->line('refund'); ?></span> <?=$this->lang->line('until'); ?> <?=date("l Y-m-d h:i a",strtotime($refund_detail->date_1)); ?>
    </h5>
    
<?php }else{?>
    <h5 class="for_h5">
    <span class="text-danger"><?=$this->lang->line('no')." ".$this->lang->line('refund');?></span>
    </h5>
        
<?php } ?>
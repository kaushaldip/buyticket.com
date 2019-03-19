<div class="row">
    <div class="col-md-12">
        <h3><?php  echo $this->lang->line('refund_policy') ?></h3>
        <style>
        #ui-datepicker-div{z-index: 19999 !important;}
        input.error{border:  1px solid #e00;}
        </style>
        <!--message block start -->
        <?php if($this->session->flashdata('message')){ ?>
        <div class="alert alert-success">  
          <a class="close" data-dismiss="alert">&times;</a>
          <?php echo $this->session->flashdata('message');?>
        </div>
        <?php  } ?>
        <!--message block end -->
        <form class="form-horizontal" id="refund_policy_form" method="post">
            <div class="event-form-main"> 
                <div class="form-group">                    
                    <div class="col-md-5">
                        <input type="radio" <?php if($refund_id==0) echo "checked"; ?> value="no_refund" name="refund_policy" style="margin: 0;" />
                        <span><?=$this->lang->line('no')?> <?=$this->lang->line('refund')?></span>
                    </div>
                    <div class="clearfix"></div> 
                </div>    
                <div class="form-group">                    
                    <div class="col-md-5">
                        <input type="radio" <?php if($refund_id>0) echo "checked"; ?> value="refund" name="refund_policy" id="refund_only" style="margin: 0;" />
                        <span><?=$this->lang->line('refund')?></span>
                    </div>
                    <div class="clearfix"></div>         
                </div>
                
                <div id="refund_policy" style="display: <?=($refund_id>0)? "block" : "none"; ?>;">
                    <div class="form-group">
                        <div class="col-md-2"><?=$this->lang->line('full')?> <?=$this->lang->line('refund')?> <?=$this->lang->line('until')?> (100%):</div>
                        <div class="col-md-3"><input type="text" class="date_ranger form-control datepicker required" name="date_1" value="<?=($refund_detail)? $this->general->get_date($refund_detail->date_1) : ""; ?>"/></div>
                        <div class="clearfix"></div>
                    </div>
                    <?php /*
                    <div class="control-group">
                        <label  class="control-label"><?=$this->lang->line('optional')?> <?=$this->lang->line('refund')?> <?=$this->lang->line('until')?>:</label>
                        <div class="controls">
                            <input type="text" name="refund_2" placeholder="<?=$this->lang->line('percent') ?>" class="number" value="<?=($refund_detail)? $refund_detail->refund_2 : ""; ?>" />
                            <input type="text" class="date_ranger datepicker" name="date_2" value="<?=($refund_detail)? $this->general->get_date($refund_detail->date_2) : ""; ?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label  class="control-label"><?=$this->lang->line('last')?> <?=$this->lang->line('refund')?> <?=$this->lang->line('until')?>:</label>
                        <div class="controls">
                            <input type="text" name="refund_3" placeholder="<?=$this->lang->line('percent') ?>" class="number" value="<?=($refund_detail)? $refund_detail->refund_3 : ""; ?>" />
                            <input type="text" class="date_ranger datepicker" name="date_3" value="<?=($refund_detail)? $this->general->get_date($refund_detail->date_3) : ""; ?>" />
                        </div>
                    </div> 
                    */?>         
                </div>
                <div class="control-group">
                    <label  class="control-label">&nbsp;</label>
                    <div class="controls">
                        <input type="submit" name="save" class="btn btn-success" value='<?=$this->lang->line('save');?>' />                
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
$(document).ready(function(){
   $('#refund_policy_form').validate(); 
});
$('input:radio[name="refund_policy"]').click(
    function(){
    if ($(this).is(':checked') && $(this).val() == 'refund') {
        $('#refund_policy').show(200);
    }else{
        $('#refund_policy').hide(200);
    }
});
</script>
<script>
    $(function() {
        $( ".date_ranger" ).datetimepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,  
            yearRange: "-20:+0",       
            dateFormat: "yy-mm-dd",
            timeFormat: "hh:mm tt",
            stepHour: 1,
            stepMinute: 10,
        });
    });
</script>

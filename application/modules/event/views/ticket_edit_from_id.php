<style>
#edit_ticket_modal .span6 {
	margin: 0;
	margin-bottom: 12px;
	clear:both;
}
#edit_ticket_modal .span3 {
	margin: 0;
	margin-bottom: 12px;
}
</style>
<!--edit modal start-->
<div id="edit_ticket_modal" >
  <form id="edit_ticket<?= $td->id ?>" action="" method="post" name="add_remove_seats" class="clrfix" style="margin-bottom: 0 !important;">
    <div class="modal-header">
      <button type="button" class="close" onclick="$(window).colorbox.close(2000);">&times;</button>
      <h3 id="myModalLabel"><?php echo $this->lang->line('edit_ticket'); ?></h3>
    </div>
    <div class="modal-body" id="displaying_message">
      <div class="span6"> <?php echo $this->lang->line('ticket_name'); ?>: <span class="required_field">*</span>
        <input type="text" id="from_name" value="<?= $td->name ?>" name="from_name"  class="required"/>
        <select id="paid_free_select0" name="paid_free_select0" style="width: 100px;" onchange="change_paid_free(this);" index='0'>
          <option <?php if(strtolower($td->paid_free)=="paid"){echo "selected";}?> value="paid"><?php echo $this->lang->line('paid'); ?></option>
          <option <?php if(strtolower($td->paid_free)=="free"){echo "selected";}?> value="free"><?php echo $this->lang->line('free'); ?></option>
        </select>
      </div>
      <div class="span6"> <?php echo $this->lang->line('starts_on'); ?>:
        <input type="text" name="ticket_start_date0" id="ticket_start_date<?=$i ?>" class="ticket_start_date datepicker" value="<?= $td->start_date; ?>" style="width: 200px;" index="<?=$i ?>" onclick="set_ticket_start_date(this);"/>
        <br />
        <?php echo $this->lang->line('ends_on'); ?>:
        <input type="text" name="ticket_end_date0" id="ticket_end_date<?=$i ?>" class="ticket_end_date datepicker" value="<?= $td->end_date; ?>" style="width: 200px;" index="<?=$i ?>" onclick="set_ticket_end_date(this);"/>
      </div>
      <div class="span6">
        <?php /*
        <select name="ticket_currency0" style="width: 100px;" id="ticket_form_currency0" index="0">
            <?php if(CURRENCY_SYMBOL == $this->lang->line('USD')){ ?>
            <option value="USD"><?php echo $this->lang->line('usd'); ?></option>
            <?php }else{ ?>
            <option value="QAR"><?php echo $this->lang->line('SAR'); ?></option>
            <?php } ?>
        </select>
        */?>
        <?php echo $this->lang->line('usd'); ?>
        <input name="ticket_currency0" value="USD" type="hidden" />
        <input type="text" name="ticket_your_price0" value="<?=$this->general->price_clean($td->price); ?>" style="width: 100px;" class="ticket_your_price number" id="ticket_your_price<?=$i ?>" index='<?=$i ?>' onkeyup="price_display(this);" />
      </div>
      <div class="span6">
        <input type="checkbox" name="web_fee_included_in_ticket0" onclick="price_display(this);" <?php if($td->web_fee_include_in_ticket==1) echo "checked" ?>  id="web_fee_included_in_ticket<?=$i ?>" index="<?=$i ?>"/>
        <em for="web_fee_included_in_ticket<?=$i ?>"><?php echo $this->lang->line('uncheck_cost_ticket'); ?>.</em> </div>
      <br clear="both" />
      <div class="span3"> <?php echo $this->lang->line('web_free'); ?>:
        <input type="text" style="width: 100px;" value="<?=$this->general->price_clean($td->website_fee) ?>" disabled="disabled" name="ticket_website_fee0" id="ticket_website_fee<?=$i ?>" index="<?=$i ?>" />
        <em><?php echo $this->lang->line('note'); ?>:<?php echo $this->lang->line('web_charge'); ?>
        <?= WEBSITE_FEE; ?>
        % + <nobr class='currency' >(
        <?= $this->general->price(WEBSITE_FEE_PRICE); ?>
        )</nobr>. </em> </div>
      <div class="span3">
        <?php if($td->web_fee_include_in_ticket==1) $price=$td->website_fee+$td->price ?>
        <?php echo $this->lang->line('ticket_price'); ?>:
        <input type="text" name="ticket_main_price0" style="width: 100px;" value="<?=$this->general->price_clean($td->ticket_price) ?>" disabled="disabled" id="ticket_main_price<?=$i ?>" index="<?=$i ?>" />
      </div>
    </div>
    <div class="modal-footer" id="displaying_message_footer">
      <input type="hidden" id="ticket_id" name="ticket_id" value="<?= $td->id ?>" >
      <input type="hidden" id="ticket_name" name="ticket_name" value="<?= $td->name ?>" >
      <input type="hidden" id="form_contact_organizer_hidden" name="contact_organizer_submit" value="1">
      <input type="submit" class="submit" name="submit" id="searchsubmit11" value="<?php echo $this->lang->line('update'); ?>"/>
      <button class="btn" onclick="$(window).colorbox.close(2000);return false;"><?php echo $this->lang->line('cancel'); ?></button>
    </div>
  </form>
</div>
<script>       
var ticket_id = "<?= $td->id ?>";
$("#edit_ticket<?= $td->id ?>").validate({
    submitHandler: function(form) {
        $(form).ajaxSubmit({
            url:"<?php echo site_url('event/edit_ticket_name'); ?>",
            data: "ticket_id="+ticket_id,
            type:"GET",
            success: function(r){
                //alert(r);
                if(r==1){
                    alert('48 hour exceed');
                    $('#edit_ticket_<?= $td->id ?>').modal('hide');
                    return false;
                }
                //alert(r);
                //console.log(r);
                //return false;                            
                var n=r.split("@#@");
                // $('.modal-body').find("input[type=text], textarea").val("");
                if(n[2]){
                    $("#"+n[1]).html('<strong>'+n[0]+'</strong>');
                    $("#p_"+n[1]).html('<strong>'+n[2]+'</strong>');
                    $("#pr_"+n[1]).html('<strong>'+n[3]+'</strong>');
                    $("#p_f"+n[1]).html('<strong>'+n[4]+'</strong>');                    
                }
                else {
                    $("#"+n[1]).html('<strong>'+n[0]+'</strong>')                    
                }
                
                $("#displaying_message").html('<?=$this->lang->line('update_successfull_message')?>');
                $("#displaying_message_footer").html("");
                $("#cboxWrapper").css('height','auto');
                //$(window).colorbox.close(2000);
                // $('#myModal3').modal('show');
            },
            beforeSend:function(){
                //$('#searchsubmit').attr('value', 'Please wait..')
            }
        });
    
        return false;
    }
});
</script>
<!--edit modal end-->

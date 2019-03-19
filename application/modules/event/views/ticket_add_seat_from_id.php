<div id="seat_modal">
<form id="add_remove_seats_form" action="" method="post">
    <div class="modal-header">
        <button type="button" class="close" onclick="$(window).colorbox.close(2000);">&times;</button>
        <h3 id="myModalLabel"><?php echo $this->lang->line('add_remove_seats'); ?></h3>
    </div>
    
    <div class="modal-body" id="displaying_message21">
        <label for="contact_name"><?php echo $this->lang->line('ticket_quantity'); ?>: <span class="required_field">*</span></label>
        <input type="text" id="max_number_<?=$td->id;?>" value="<?=$td->max_number;?>" name="from_name"  class="required"/>
    </div>
    <div class="modal-footer" id="displaying_message21_footer">
        <input type="hidden" id="ticket_id" name="ticket_id" value="<?= $td->id ?>" />
        <input type="hidden" id="form_contact_organizer_hidden" name="contact_organizer_submit" value="1"/>
        <input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php echo $this->lang->line('update'); ?>"/>
        <button class="btn" onclick="$(window).colorbox.close(2000); return false;"><?php echo $this->lang->line('cancel'); ?></button>        
    </div>
</form>    
</div>

<script>                
$("#add_remove_seats_form").validate({
    submitHandler: function(form) {
        $(form).ajaxSubmit({
            url:"<?php echo site_url('event/update_seats'); ?>",
            type:"GET",
            success: function(r){
                max_val = $("#max_number_<?=$td->id;?>").val();
                if(r=='successfully'){
                    $("#max_number"+<?=$td->id ?>).html(max_val);
                    $("#displaying_message21").html('<?=$this->lang->line('update_successfull_message')?>');
                }else{
                    $("#displaying_message21").html('<?=$this->lang->line('value_exceed_error_msg')?>');
                }
                
                $("#displaying_message21_footer").html('');
            },
            beforeSend:function(){
                //$('#searchsubmit').attr('value', 'Please wait..')
            }
        });
    
        return false;
    }
});
</script>
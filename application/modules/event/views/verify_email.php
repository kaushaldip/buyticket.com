<div class="span10">
    
    <form action="" method="post" id="verify_email_form">
    <div class="alert alert-info" id="mg_box" style="display: none;">
        <p></p>
    </div>
    <?=$this->lang->line('verify_your_email_message_ask')?>
    <input type="submit" id="submit_verify_email" class="btn-success" value="<?=$this->lang->line('yes');?>" name="send" onclick="send_verify_email()" />
    <input type="button" class="btn-info" value="<?=$this->lang->line('no');?>" name="no_send" onclick="jQuery.colorbox.close();" />
    </form>
 
</div>

<script>                
$("#verify_email_form").validate({
    submitHandler: function(form) {
        $(form).ajaxSubmit({
            url:"<?php echo site_url('event/verify_email?s=yes'); ?>",
            type:"GET",            
            success: function(r){                  
                if(r=='ok')
                {
                    msg = '<?=$this->lang->line('') ?>';
                    $('#mg_box').show();
                    $('#mg_box p').html(msg);
                    $('#submit_verify_email').attr('value', '<?=$this->lang->line('yes')?>');
                    //jQuery.colorbox.close(5000);
                }              
            },
            beforeSend:function(){
                $('#submit_verify_email').attr('value', '<?=$this->lang->line('please_wait')?>');
            }
        });
    
        return false;
    }
});
</script>
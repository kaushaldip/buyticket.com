<div class="col-md-2 left-sidebar">
    <ul>
        <li><a href="<?php echo site_url('users/account/index');?>" class="upload"><span><?php echo $this->lang->line('view_profile');?></span></a></li>
        <li ><a href="<?php echo site_url('users/account/editprofile');?>" class="upload"><span><?php echo $this->lang->line('update_profile');?></span></a></li>
        <!--
        <li <?php if($this->uri->segment(2) == 'invitefriends'){echo ' class="active"';} ?>><a href="<?php echo site_url('users/account/invitefriends');?>"  class="frnds"><span>invite friends</span></a></li>
        -->
        <li><a href="<?php echo site_url('users/account/changepassword');?>" class="ch_pass"><span><?php echo $this->lang->line('change_password');?></span></a></li>
        <li class="active"><a href="<?php echo site_url('users/account/closeaccount');?>" class="ch_pass"><span><?php echo $this->lang->line('close_account');?></span></a></li>
    </ul>
</div>
<div class="col-md-10">
    <div class="change-password">      
        <h3 style="margin-top:0 ;"><?php echo $this->lang->line('close_account'); ?></h3>  
        <?php if($this->session->flashdata('message')){ ?>
        <div class="alert alert-success">  
            <a class="close" data-dismiss="alert">&times;</a>
            <?php echo $this->session->flashdata('message');?>
        </div>
        <?php  } ?>
        

        <form  method="post" class="frm_rg frm_acc" name="close_account">
            <div class="box">
                <div class="box_content">
                    <ul class="for_info">
                        <li><p><?php echo $this->lang->line('select_the_reason');?></p></li>
                        <li>
                            <label><input type="radio" name="closing_reason" value="many_emails" class="closing_account" /></label><?php echo $this->lang->line('too_many_email');?> 
                            <div id="many_emails" class="closing_account_reason" style="display: none;">
                                <p onclick="change_notification('update');">
                                <label><?php echo $this->lang->line('update_email_notification');?></label><span id="change_update_event_notify" style="cursor: pointer;"><?php echo ($notification->email_update_notify==1)? "on": "off"; ?></span>
                                </p>
                                <br />
                                <p onclick="change_notification('event')">
                                <label><?php echo $this->lang->line('event_email_notification');?></label> <span id="change_email_event_notify" style="cursor: pointer;"><?php echo ($notification->email_event_notify==1)? "on": "off"; ?></span>
                                </p>
                            </div>
                        </li>
                        <li>            
                            <label><input type="radio" name="closing_reason" value="dislike_system" class="closing_account" /></label><?php echo $this->lang->line('donot_like');?>
                            <div id="dislike_system" class="closing_account_reason" style="display: none; margin-left: 210px;">
                                <textarea name="dislike_system"></textarea>        
                            </div>
                        </li>
                        <li>
                            <label><input type="radio" name="closing_reason" value="other" class="closing_account" /></label><?php echo $this->lang->line('other');?>
                            <div id="other" class="closing_account_reason" style="display: none; margin-left: 210px;">
                                <textarea name="other"></textarea>        
                            </div>
                        </li>          
                    </ul>
                </div>
            </div>
            <p class="update-btn">
                <input type="submit" class="submit" name="close_acc_submit" value="<?php echo $this->lang->line('close_account');?>" />
                <a href="<?php echo site_url('home/contact') ?>"><button class="custom pull-right"><?php echo $this->lang->line('contact_us');?></button></a>
            </p>
        </form>
    </div>
</div>                


<script>
$(".closing_account").click(function(){
    var value = $(this).val();
    $(".closing_account_reason").hide();
    $('#'+value).show();
       
});

function change_notification(checkpoint)
{    
    img = "<img src='"+"<?php print(MAIN_IMAGES_DIR_FULL_PATH);?>"+"ajax_loader_small.gif'/>"; 
    
    if(checkpoint=='event'){
        value = $("#change_email_event_notify").html();
        $("#change_email_event_notify").html(img);
        
    }        
    else if(checkpoint=='update'){
        value = $("#change_update_event_notify").html();
        $("#change_update_event_notify").html(img);         
    }

    ajaxUrl = "<?php echo site_url('users/account/change_notification'); ?>";
    $.ajax({
        type: "POST",
        url: ajaxUrl,    
        data: "checkpoint="+checkpoint+"&value="+value,    
        success: function(data) {                    
            if(checkpoint=='event'){
                $("#change_email_event_notify").html(data);
                
            }                
            else if(checkpoint=='update'){
                $("#change_update_event_notify").html(data);
            }
                
        }
    });
}
</script>
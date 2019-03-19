<div class="col-md-2 left-sidebar">
    <ul>
        <li><a href="<?php echo site_url('users/account/index');?>" class="upload"><span><?php echo $this->lang->line('view_profile');?></span></a></li>
        <li ><a href="<?php echo site_url('users/account/editprofile');?>" class="upload"><span><?php echo $this->lang->line('update_profile');?></span></a></li>
        <!--
        <li <?php if($this->uri->segment(2) == 'invitefriends'){echo ' class="active"';} ?>><a href="<?php echo site_url('users/account/invitefriends');?>"  class="frnds"><span>invite friends</span></a></li>
        -->
        <li class="active"><a href="<?php echo site_url('users/account/changepassword');?>" class="ch_pass"><span><?php echo $this->lang->line('change_password');?></span></a></li>
        <li><a href="<?php echo site_url('users/account/closeaccount');?>" class="ch_pass"><span><?php echo $this->lang->line('close_account');?></span></a></li>
    </ul>
</div>
<div class="col-md-10">  
    <div class="change-password">
        <h3 style="margin-top:0 ;"><?php echo $this->lang->line('change_password'); ?></h3>
        <?php if($this->session->flashdata('message')){ ?>
        <div class="alert alert-success">  
            <a class="close" data-dismiss="alert">&times;</a>
            <?php echo $this->session->flashdata('message');?>
        </div>
        <?php  } ?>
        <form  method="post" class="frm_rg frm_acc" name="change_password">
            <div class="box">
                <div class="box_content">
                    <ul class="for_info">
                        <li>
                            <label><?php echo $this->lang->line('old_password'); ?></label>
                            <p>
                            <input name="old_password" type="password" class="" value="" > 
                            <?php echo form_error('old_password'); ?>
                            <span align="center" class="text-danger"><?php echo $this->session->flashdata('password_error');?></span>
                            </p>
                        </li>
                        <li>
                            <label><?php echo $this->lang->line('new_password'); ?></label>
                            <p>
                            <input name="new_password" type="password" class="" value="" /> 
                            <?php echo form_error('new_password'); ?>                        
                            </p>                        
                        </li>                        
                        <li>
                            <label><?php echo $this->lang->line('re_password'); ?></label>
                            <p>
                            <input name="re_password" type="password" class="" value="" /> 
                            <?php echo form_error('re_password'); ?>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>            
            <p class="update-btn">
                <button type="submit" class="submit"><?php echo $this->lang->line('change'); ?></button>
            </p>            
        </form>                                    
    </div>
</div>
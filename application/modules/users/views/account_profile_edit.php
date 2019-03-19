<div class="col-md-2 left-sidebar">
    <ul>
        <li><a href="<?php echo site_url('users/account/index');?>" class="upload"><span><?php echo $this->lang->line('view_profile');?></span></a></li>
        <li class="active" ><a href="<?php echo site_url('users/account/editprofile');?>" class="upload"><span><?php echo $this->lang->line('update_profile');?></span></a></li>
        <!--
        <li <?php if($this->uri->segment(2) == 'invitefriends'){echo ' class="active"';} ?>><a href="<?php echo site_url('users/account/invitefriends');?>"  class="frnds"><span>invite friends</span></a></li>
        -->
        <li><a href="<?php echo site_url('users/account/changepassword');?>" class="ch_pass"><span><?php echo $this->lang->line('change_password');?></span></a></li>
        <li><a href="<?php echo site_url('users/account/closeaccount');?>" class="ch_pass"><span><?php echo $this->lang->line('close_account');?></span></a></li>
    </ul>
</div>

<div class="col-md-10">  
    <div class="update-profile">
        <h1><?php echo $this->lang->line('profile_update'); ?></h1>	
        <?php if($this->session->flashdata('message')){ ?>
        <div class="alert alert-success">  
          <a class="close" data-dismiss="alert">&times;</a>
          <?php echo $this->session->flashdata('message');?>
        </div>
        <?php  } ?>
        <?php if($this->session->flashdata('error')){ ?>
        <div class="alert alert-danger">  
          <a class="close" data-dismiss="alert">&times;</a>
          <?php echo $this->session->flashdata('error');?>
        </div>
        <?php  } ?>         
        <form  method="post" class="frm_rg frm_acc" name="update_profile">
        <div class="box">
            <h3><?php echo $this->lang->line('account_information'); ?></h3>
            <div class="box_content">
                <ul class="for_info">        
                    <li>
                        <label><?php echo $this->lang->line('prefix'); ?></label>
                        <p>
                            <input name="prefix" type="text" class="" value="<?php echo $profile_data->prefix;?>" maxlength="4" />
                            <?php echo form_error('prefix'); ?>
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('first_name'); ?></label>
                        <p>
                            <input name="first_name" type="text" class="" value="<?php echo $profile_data->first_name;?>" /> 
                            <?php echo form_error('first_name'); ?>
                        </p>        
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('last_name'); ?></label>
                        <p>
                            <input name="last_name" type="text" class="" value="<?php echo $profile_data->last_name;?>" /> 
                            <?php echo form_error('last_name'); ?>            
                        </p>        
                    </li>     
                    <li>
                        <label><?php echo $this->lang->line('gender'); ?></label>
                        <p>
                            <input type="radio" name="gender" value="M" <?php echo ($profile_data->gender=='M')? "checked='checked'": ""; ?> /> Male
                            <input type="radio" name="gender" value="F" <?php echo ($profile_data->gender=='F')? "checked='checked'": ""; ?>/> Female                
                        </p>
                    </li>   
                    <li>
                        <label><?php echo $this->lang->line('email_address'); ?></label>
                        <p>
                            <input name="email" type="text" class="" value="<?php echo $profile_data->email;?>" /> 
                            <?php echo form_error('email'); ?>            
                        </p>        
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('contact_number'); ?></label>
                        <p>
                            <?php echo $this->lang->line('home');?>: <input name="home_number" type="text" value="<?php echo $profile_data->home_number ?>" />
                            <?php echo $this->lang->line('mobile');?>: <input name="mobile_number" type="text" value="<?php echo $profile_data->mobile_number ?>" />
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('address'); ?></label>
                        <p>
                            <input name="address" type="text" class="" value="<?php echo $profile_data->address;?>" /> 
                            <?php echo form_error('address'); ?>            
                        </p>        
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('address')." ".$this->lang->line('1'); ?></label>
                        <p>
                            <input name="address1" type="text" class="" value="<?php echo $profile_data->address1;?>" />
                        </p>        
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('city'); ?></label>
                        <p>
                            <input name="city" type="text" class="" value="<?php echo $profile_data->city;?>" /> 
                            <?php echo form_error('city'); ?>            
                        </p>        
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('province'); ?></label>
                        <p>
                            <input name="state" type="text" class="" value="<?php echo $profile_data->state; ?>" /> 
                        </p>
                    </li>
                    
                    <li>
                        <label><?php echo $this->lang->line('zip_code'); ?></label>
                        <p>
                            <input name="zip" type="text" class="" value="<?php echo $profile_data->zip;?>" />
                            <?php echo form_error('zip'); ?>            
                        </p>        
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('country'); ?></label>
                        <p>
                            <select name="country">
                                <option value="" ><?=$this->lang->line('select_option');?></option>
                                <?php $countries = $this->general->get_country();?>
                                <?php foreach($countries as $country): ?>
                                    
                                    <option value="<?=$country->country?>" <?= (strtolower($country->country)==strtolower($profile_data->country))? "selected='selected'" : '';?> ><?=$country->country?></option>
                                    
                                <?php endforeach;?>
                            </select>                    
                            <?php echo form_error('country'); ?>            
                        </p>        
                    </li>
                </ul>
            </div>
        </div>
        <div class="box">
            <h3><?php echo $this->lang->line('work_information'); ?></h3>
            <div class="box_content">
                <ul class="for_info">
                    <li>
                        <label><?php echo $this->lang->line('job_title'); ?></label>
                        <p>
                            <input type="text" name="work_job_title" class="" value="<?php echo $profile_data->work_job_title; ?>" />
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('company'); ?></label>
                        <p>
                            <input type="text" name="work_company" class="" value="<?php echo $profile_data->work_company; ?>" />
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('address'); ?></label>
                        <p>
                            <input type="text" name="work_address" class="" value="<?php echo $profile_data->work_address; ?>" />
                        </p>                
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('city'); ?></label>
                        <p>
                            <input type="text" name="work_city" class="" value="<?php echo $profile_data->work_city; ?>" />
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('province'); ?></label>
                        <p>
                            <input type="text" name="work_state" class="" value="<?php echo $profile_data->work_state; ?>" />
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('zip'); ?></label>
                        <p>
                            <input type="text" name="work_zip" class="" value="<?php echo $profile_data->work_zip; ?>" />
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('country'); ?></label>
                        <p>
                            <input type="text" name="work_country" class="" value="<?php echo $profile_data->work_country; ?>" />
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('website'); ?></label>
                        <p>
                            <input type="text" name="work_website" class="" value="<?php echo $profile_data->work_website; ?>" />
                        </p>
                    </li>
                </ul>
            </div>
        </div>
            <div class="box">
            <h3><?php echo $this->lang->line('bank_information'); ?></h3>
            <div class="box_content">
                <ul class="for_info">
                    <li>
                        <label><?=$this->lang->line('bank_name'); ?></label>
                        <p>
                            <input type="text" name="bank_name" class="" value="<?php echo $profile_data->bank_name; ?>" />
                        </p>
                    </li>
                    <li>
                        <label><?=$this->lang->line('account_holder_name'); ?></label>
                        <p>
                            <input type="text" name="account_holder_name" class="" value="<?php echo $profile_data->account_holder_name; ?>" />
                        </p>
                    </li>
                    <li>
                        <label><?=$this->lang->line('account_number'); ?></label>
                        <p>
                            <input type="text" name="account_number" class="" value="<?php echo $profile_data->account_number; ?>" />
                        </p>                
                    </li>
                    <li>
                        <label>Western Union <?=$this->lang->line('payee_name') ?></label>
                        <p>
                            <input type="text" name="western_payee_name" class="" value="<?php echo $profile_data->western_payee_name; ?>" />
                        </p>
                    </li>
                    <li>
                        <label>Western Union <?=$this->lang->line('city') ?></label>
                        <p>
                            <input type="text" name="western_city" class="" value="<?php echo $profile_data->western_city; ?>" />
                        </p>
                    </li>
                    <li>
                        <label>Western Union <?=$this->lang->line('country') ?></label>
                        <p>
                            <input type="text" name="western_country" class="" value="<?php echo $profile_data->western_country; ?>" />
                        </p>
                    </li>
                  
                </ul>
            </div>
        </div>
        <div class="box">
            <h3><?php echo $this->lang->line('email_preference'); ?></h3>
            <div class="box_content">
                <ul class="for_info">
                    <li>
                        <label><?php echo $this->lang->line('send_updates'); ?></label>
                        <p>
                            <input type="radio" name="email_update_notify" value="1" <?php echo ($profile_data->email_update_notify=='1')? "checked='checked'": ""; ?> /><?=$this->lang->line('yes')?>
                            <input type="radio" name="email_update_notify" value="0" <?php echo ($profile_data->email_update_notify=='0')? "checked='checked'": ""; ?>/><?=$this->lang->line('no')?>
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('send_reminder_event'); ?></label>
                        <p>
                            <input type="radio" name="email_event_notify" value="1" <?php echo ($profile_data->email_event_notify=='1')? "checked='checked'": "";  ?> /><?=$this->lang->line('yes')?> 
                            <input type="radio" name="email_event_notify" value="0" <?php echo ($profile_data->email_event_notify=='0')? "checked='checked'": ""; ?> /><?=$this->lang->line('no')?>
                        </p>
                    </li>
                </ul>
            </div>
        </div>
        <p class="update-btn">
           <button type="submit" class="submit"><?php echo $this->lang->line('update'); ?></button>
        </p>
        </form>
    </div>
</div>
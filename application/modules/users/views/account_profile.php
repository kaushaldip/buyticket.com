<div class="col-md-2 left-sidebar">
    <ul>
        <li class="active" ><a href="<?php echo site_url('users/account/index');?>" class="upload"><span><?php echo $this->lang->line('view_profile');?></span></a></li>
        <li><a href="<?php echo site_url('users/account/editprofile');?>" class="upload"><span><?php echo $this->lang->line('update_profile');?></span></a></li>
        <!--
        <li><a href="<?php echo site_url('users/account/invitefriends');?>"  class="frnds"><span>invite friends</span></a></li>
        -->
        <li><a href="<?php echo site_url('users/account/changepassword');?>" class="ch_pass"><span><?php echo $this->lang->line('change_password');?></span></a></li>
        <li><a href="<?php echo site_url('users/account/closeaccount');?>" class="ch_pass"><span><?php echo $this->lang->line('close_account');?></span></a></li>
    </ul>
</div>
<div class="col-md-10">    
    <div class="view-profile">
    	<h1><?php echo $this->lang->line('my_account'); ?></h1>
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
        <div class="box">
            <h3><?php echo $this->lang->line('account_information'); ?></h3>
            <div class="box_content">
                <ul class="for_info">
                    <li>
                        <label><?php echo $this->lang->line('prefix'); ?> </label>
                        <p>
                            <?php echo $profile_data->prefix;?>
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('first_name'); ?></label>
                        <p>
                            <?php echo $profile_data->first_name;?>
                        </p>        
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('last_name'); ?></label>
                        <p>
                            <?php echo $profile_data->last_name;?>                            
                        </p>        
                    </li>     
                    <li>
                        <label><?php echo $this->lang->line('gender'); ?></label>
                        <p>
                            <?php echo ($profile_data->gender=='M')? "Male":(($profile_data->gender=='F')? "Female" : ""); ?>                                
                        </p>
                    </li>   
                    <li>
                        <label><?php echo $this->lang->line('email_address'); ?></label>
                        <p>
                            <?php echo $profile_data->email;?>                            
                        </p>        
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('contact_number'); ?></label>
                        <p>
                            Home: <?php echo $profile_data->home_number ?>
                            Mobile: <?php echo $profile_data->mobile_number ?>
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('address'); ?> </label>
                        <p>
                            <?php echo $profile_data->address;?>
                        </p>        
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('address'); ?><?php echo $this->lang->line('1'); ?></label>
                        <p>
                            <?php echo $profile_data->address1;?>
                        </p>        
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('city'); ?></label>
                        <p>
                            <?php echo $profile_data->city;?>            
                        </p>        
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('province'); ?></label>
                        <p>
                            <?php echo $profile_data->state; ?> 
                        </p>
                    </li>
                    
                    <li>
                        <label><?php echo $this->lang->line('zip_code'); ?></label>
                        <p>
                            <?php echo $profile_data->zip;?>            
                        </p>        
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('country'); ?></label>
                        <p>
                            <?php echo $profile_data->country;?>    
                                
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
                            <?php echo $profile_data->work_job_title; ?>
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('company'); ?></label>
                        <p>
                            <?php echo $profile_data->work_company; ?>
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('address'); ?></label>
                        <p>
                            <?php echo $profile_data->work_address; ?>
                        </p>                
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('city'); ?></label>
                        <p>
                            <?php echo $profile_data->work_city; ?>
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('province'); ?></label>
                        <p>
                            <?php echo $profile_data->work_state; ?>
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('zip'); ?></label>
                        <p>
                            <?php echo $profile_data->work_zip; ?>
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('country'); ?></label>
                        <p>
                            <?php echo $profile_data->work_country; ?>
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('website'); ?></label>
                        <p>
                            <?php echo $profile_data->work_website; ?>
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
                            <?php echo $profile_data->bank_name; ?>
                        </p>
                    </li>
                    <li>
                        <label><?=$this->lang->line('account_holder_name'); ?></label>
                        <p>
                            <?php echo $profile_data->account_holder_name; ?>
                        </p>
                    </li>
                    <li>
                        <label><?=$this->lang->line('account_number'); ?></label>
                        <p>
                            <?php echo $profile_data->account_number; ?>
                        </p>                
                    </li>
                    <li>
                        <label>Western Union <?=$this->lang->line('payee_name') ?></label>
                        <p>
                            <?php echo $profile_data->western_payee_name; ?>
                        </p>
                    </li>
                    <li>
                        <label>Western Union <?=$this->lang->line('city') ?></label>
                        <p>
                            <?php echo $profile_data->western_city; ?>
                        </p>
                    </li>
                    <li>
                        <label>Western Union <?=$this->lang->line('country') ?></label>
                        <p>
                            <?php echo $profile_data->western_country; ?>
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
                           <?php echo ($profile_data->email_update_notify=='1')? $this->lang->line('yes'): $this->lang->line('no'); ?> 
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('send_reminder_event'); ?></label>
                        <p>
                            <?php echo ($profile_data->email_event_notify=='1')? $this->lang->line('yes'): $this->lang->line('no'); ?>
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
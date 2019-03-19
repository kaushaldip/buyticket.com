<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=	site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/users/index'); ?>"><?php echo $this->lang->line('user_management');?></a> &raquo; <?=$full_user_name; ?>
        <a class="back_button" href="javascript:history.go(-1)" style="text-decoration:none;">
        <img src="<?php	print(ADMIN_CSS_DIR_FULL_PATH);?>css/icons/24/bended-arrow-left.png" width="24" height="24" alt="back" align="right" title="Go Back" />
        </a> 
    </div>   
</div>
<?php if($profile_data->closed_account == 'no'){ ?>
<!--for status start-->
<!--
<?php
$key = "status-inactive-bg"; 
$status = "Blocked / Inactive";
if($profile_data->status == '1'){
    $key = "status-active-bg";
    $status = "Active";
}   
else if($profile_data->status =='2'){
    $key = 'status-pending-bg';
    $status = "Pending";
}
//var_dump($profile_data); 
?>

<div class="mws-panel grid_8 status_show">
    <div class="<?=$key;?>">
        <?php echo $this->lang->line('user_status');?><span class="status_value"><?=$status;?></span>
        <span style="float: right;">
            <select>
                <option selected="selected"><?php echo $this->lang->line('change_status');?></option>
                <option value="1" onclick="change_user_status('<?php echo site_url(ADMIN_DASHBOARD_PATH);?>','<?php echo site_url();?>','<?=$profile_data->uid; ?>','1');">Active</option>
                <option value="0" onclick="change_user_status('<?php echo site_url(ADMIN_DASHBOARD_PATH);?>','<?php echo site_url();?>','<?=$profile_data->uid; ?>','0');">Block / Inactive</option>
                <option value="2" onclick="change_user_status('<?php echo site_url(ADMIN_DASHBOARD_PATH);?>','<?php echo site_url();?>','<?=$profile_data->uid; ?>','2');">Pending</option>
            </select>            
        </span>
    </div>
</div>
-->
<!--for status end-->
<?php }else{ ?>
<!--closed account info start-->
<div class="mws-panel grid_8 status_show">
    <div class="status-pending-bg">
        <?php echo $this->lang->line('account_closed');?>        
    </div>
    <div class="inactive_reason">
        <p><strong><?php echo $this->lang->line('account_closed-reason');?></strong></p>
        <em><?=ucfirst($profile_data->inactive_reason);?></em>        
    </div>
</div>
<!--close account info end-->

<?php }?>

<!--for referral section start-->
<?php if($profile_data->referral_id!=0){ ?>
<div class="mws-panel grid_8 mws-collapsible">
	<div class="mws-panel-header">
    	<span><?php echo $this->lang->line('referral_information');?></span>
        <div class="mws-collapse-button mws-inset"><span></span></div>
    </div>
    <div class="mws-panel-body">
    	<div class="mws-panel-content">
            <div class="clearfix">
                <label class="title_label"><?php echo $this->lang->line('id');?>:</label>
                <div class="mws-form-item small value_div"><?=$referral->id; ?></div>
            </div>
        	<div class="clearfix">
                <label class="title_label"><?php echo $this->lang->line('username');?> (EMAIL):</label>
                <div class="mws-form-item small value_div"><?=$referral->email; ?></div>
            </div>
            
            <div class="clearfix">
                <label class="title_label"><?php echo $this->lang->line('full_name');?></label>
                <div class="mws-form-item small value_div "><?=$this->general->get_user_full_name($referral->id); ?></div>
            </div>
            <?php if($referral_url){ ?>
            <div class="clearfix">
                <label class="title_label">Referral Url:</label>
                <div class="mws-form-item small value_div no_capitalize"><?=site_url("reff/".$referral_url->referral_url); ?></div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>
<!--for referral section end-->   


<!--for personal information section start--> 
<div class="mws-panel grid_4">
	<div class="mws-panel-header">
    	<span class="mws-i-24 i-list"><?php echo $this->lang->line('account_information'); ?></span>        
    </div>
    <div class="mws-panel-body">
        <form method="post" name="sitesetting" class="mws-form">            
		<div class="mws-form-inline">            
            <div style="position: relative;" class="mws-form-row">
				<label><?php echo $this->lang->line('prefix'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo $profile_data->prefix;?>        
				</div>
                <?php
                if(file_exists($profile_data->image)){                    
                ?>
                <span class="profile_image"><img src="<?php echo site_url().$profile_data->image; ?>" /></span>
                <?php } ?>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('username'); ?></label>
				<div class="mws-form-item small value_div no_capitalize"> 
                    <?php echo $profile_data->username;?>                                
				</div>
			</div>
            
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('password'); ?></label>
				<div class="mws-form-item small value_div no_capitalize" id="reset_password_id"> 
                    <a href="javascript:void(0);" onclick="reset_password('<?=site_url(ADMIN_DASHBOARD_PATH);?>','<?=site_url();?>','<?=$profile_data->uid;?>','reset_password_id')" >Reset</a>                                
				</div>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('first_name'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo $profile_data->first_name;?>                                
				</div>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('last_name'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo $profile_data->last_name;?>        
				</div>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('gender'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo ($profile_data->gender=='M')? "Male": "Female"; ?>        
				</div>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('email_address'); ?></label>
				<div class="mws-form-item small value_div no_capitalize"> 
                    <?php echo $profile_data->email;?>       
                    <?=($profile_data->verified_email=='yes')? "<strong style='color:green;'>Verified</strong>" : "<strong style='color:red;'>Not verified</strong>" ;?>
				</div>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('contact_number'); ?></label>
				<div class="mws-form-item small value_div">
                    <?php echo ($profile_data->home_number)? "Home: ".$profile_data->home_number: ""; ?>
                    <?php echo ($profile_data->mobile_number)? "Mobile: ".$profile_data->mobile_number: ""; ?>
				</div>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('address'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo $profile_data->address;?>            
				</div>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('address'); ?><?php echo $this->lang->line('1'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo $profile_data->address1;?>            
				</div>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('city'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo $profile_data->city;?>            
				</div>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('province'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo $profile_data->state; ?>            
				</div>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('zip_code'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo $profile_data->zip;?>            
				</div>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('country'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo $profile_data->country;?>            
				</div>
			</div>
        </div>
        </form>
    </div>    	
</div>
<!--for personal information section end-->

<!--for work information section start-->
<div class="mws-panel grid_4 mws-collapsible">
	<div class="mws-panel-header">
    	<span class="mws-i-24 i-list"><?php echo $this->lang->line('work_information'); ?></span>
        <div class="mws-collapse-button mws-inset"><span class=""></span></div>
    </div>
    <div class="mws-panel-body">
        <form method="post" name="sitesetting" class="mws-form">    
		<div class="mws-form-inline">                

            <div class="mws-form-row">
				<label><?php echo $this->lang->line('job_title'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo $profile_data->work_job_title;?>            
				</div>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('company'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo $profile_data->work_company;?>            
				</div>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('address'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo $profile_data->work_address;?>            
				</div>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('city'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo $profile_data->work_city;?>            
				</div>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('province'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo $profile_data->work_state;?>            
				</div>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('zip'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo $profile_data->work_zip;?>            
				</div>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('country'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo $profile_data->work_country;?>            
				</div>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('website'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo $profile_data->work_website;?>            
				</div>
			</div>
            
		</div>
        </form>
    </div>    	
</div>
<!--for work information section end-->

<!--for email perfermance information section start-->
<div class="mws-panel grid_4 mws-collapsible">
	<div class="mws-panel-header">
    	<span class="mws-i-24 i-list"><?php echo $this->lang->line('email_preference'); ?></span>
        <div class="mws-collapse-button mws-inset"><span class=""></span></div>
    </div>
    <div class="mws-panel-body">            
        <form method="post" name="sitesetting" class="mws-form">
		<div class="mws-form-inline">                

            <div class="mws-form-row">
				<label><?php echo $this->lang->line('send_updates'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo ($profile_data->email_update_notify=='1')? "Yes": "No"; ?>            
				</div>
			</div>
            <div class="mws-form-row">
				<label><?php echo $this->lang->line('send_reminder_event'); ?></label>
				<div class="mws-form-item small value_div"> 
                    <?php echo ($profile_data->email_event_notify=='1')? "Yes": "No";  ?>            
				</div>
			</div>
            
		</div>
        </form>
    </div>    	
</div>
<!--for email perfermance information section end-->

<!--for event list start -->

<div class="mws-panel grid_8 mws-collapsible">
	<div class="mws-panel-header">         
    	<span class="mws-i-24 i-table-1"><?php echo $this->lang->line('event_list');?></span>  
        <div class="mws-collapse-button mws-inset"><span></span></div>      
    </div>
    <div class="mws-panel-body">
        <table class="mws-datatable mws-table">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line('id');?></th>
                    <th><?php echo $this->lang->line('name_title');?></th>
                    <th>Total Visits</th>                    
                    <th><?php echo $this->lang->line('created_date');?></th>
                    <th><?php echo $this->lang->line('updated_date');?></th>
                    <th><?php echo $this->lang->line('targeted_gender');?></th>    
                    <th>Status</th>  
                    <th>Publish</th>              
                </tr>
            </thead>
            <tbody>
            <?php 
            if($events)
            {
                foreach($events as $event)
                {
                ?>
                <tr class="gradeU">
                    <td align="left"><?php print($event->id);?></td>
                    <td align="left">
                        <a href="<?=site_url(ADMIN_DASHBOARD_PATH.'/event/view/'.$event->id);?>" target="_blank">
                        <?php print($event->name);?>
                        <br/>
                        <em><?=ucwords($event->title);?></em>
                        </a>
                    </td>
                    <td><?php print($event->visit_count); ?></td>                                   
                    <td align="left"><div align="center"><?php print($this->general->date_time_formate($event->created_date));?></div></td>
                    <td align="left"><div align="center"><?php print($this->general->date_time_formate($event->updated_date));?></div></td>
                    <td><?php print($event->target_gender=='B')? "Male & Female" :(($event->target_gender=='M')? "Male only": "Female only") ; ?></td>
                    <td align="center">                        
                        <span id="event_status<?=$event->id; ?>">
                        <?php 
                            $status = "<font color='green'>PUBLIC</div>";
                            if($event->status=='0')
                                $status = "<font color='red'>CLOSED</div>";
                            else if ($event->status=='2')
                                $status = "<font color='#A98B15'>PRIVATE</div>";
                            print($status); 
                        ?>           
                        </span>
                        <select onchange="change_event_status('<?php echo site_url(ADMIN_DASHBOARD_PATH);?>','<?php echo site_url();?>','<?=$event->id; ?>',this.value);">
                            <option>Change...</option>
                            <option value="1">PUBLIC</option>
                            <option value="2">PRIVATE</option>
                            <option value="0">CLOSE</option>                            
                        </select>
                    </td>
                    <td align="center">
                        <span id="event_publish<?=$event->id; ?>">
                        <?=($event->publish == '1')? "<font color='green'>PUBLISHED</font>" :(($event->publish == '0')? "<font color='#A98B15'>NOT PUBLISHED</font>" : "<font color='red'>CLOSED</font>") ; ?>
                        <br />
                        </span>
                        <select onchange="change_event_publish('<?php echo site_url(ADMIN_DASHBOARD_PATH);?>','<?php echo site_url();?>','<?=$event->id; ?>',this.value);">
                            <option>Change...</option>
                            <option value="1">PUBLISH</option>
                            <option value="0">UNPUBLISH</option>
                            <option value="2">CLOSE</option>
                        </select>
                    </td>
    
                </tr>
            <?php
            	}            	
            }            
            ?>
            </tbody>
        </table>
    </div>
</div>

<!--for event list end -->

<!-- organizer information start-->
<!--
<div class="mws-panel grid_2 mws-collapsible">
    <div class="mws-panel-header">
    	<span class="mws-i-24 i-books-2"><?php echo $this->lang->line('organizer');?></span>
        <div class="mws-collapse-button mws-inset"><span></span></div>
    </div>
    <div class="mws-panel-body">
        <ul class="mws-summary">
            <li id="user_organizer_<?=$profile_data->uid;?>" style="text-align: center; padding: 60px 0px;">
            <?php 
            if($this->general->is_organizer($profile_data->uid))
                echo "<div class='status-active' title='Organizer: Yes'>Active</div>";
            else if($profile_data->organizer == '2')
                echo "<input class='mws-button orange small' value='Approve Organizer' style='width: 110px;' onclick='change_user_to_organizer(\"".site_url(ADMIN_DASHBOARD_PATH)."\",\"".site_url()."\",\"".$profile_data->uid."\" )' >";
            else
                echo "<div class='status-active' title='Organizer: Yes'>Inactive</div>";
            ?>      
            </li>              
        </ul>    
    </div>                 
</div>
-->
<!-- organizer information end-->
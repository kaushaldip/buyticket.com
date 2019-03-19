<script type="text/javascript">
function doconfirm()
{
	job=confirm("Are you sure to delete permanently?");
	if(job!=true)
	{
		return false;
	}
}
</script>

<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=	site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; <?php echo $this->lang->line('users_management');?>
        <a class="back_button" href="javascript:history.go(-1)" style="text-decoration:none;">
        <img src="<?php	print(ADMIN_CSS_DIR_FULL_PATH);?>css/icons/24/bended-arrow-left.png" width="24" height="24" alt="back" align="right" title="Go Back" />
        </a> 
    </div>   
</div>
 
<div class="mws-panel grid_8">
	<div class="mws-panel-header">         
    	<span class="mws-i-24 i-table-1"><?php echo $head_title; ?></span>
        
    </div>
    <div class="mws-panel-body">
        <div class="mws-panel-toolbar top clearfix">
        	<ul>
            	<li><a class="mws-ic-16 ic-direction" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/users/<?=$key; ?>"><?php echo $menu ?></a></li>
            	
            </ul>
        </div>
        <?php    
        	if ($this->session->flashdata('message'))
        	{
        		echo "<div class='mws-form-message success'>" . $this->session->flashdata('message') . "</div>";
        	}            
        ?>
        <table class="mws-datatable mws-table">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line('id');?></th>
                    <th><?php echo $this->lang->line('username');?></th>                    
                    <th><?php echo $this->lang->line('referral');?></th>                                        
                    <th><?php echo $this->lang->line('last_login');?></th>
                    <th><?php echo $this->lang->line('last_login_ip');?></th>
                    <th><?php echo $this->lang->line('register_ip');?></th>
                    <th><?php echo $this->lang->line('refrees');?></th>
                    <th align="center"><?php echo $this->lang->line('organizer');?></th>                                        
                </tr>
            </thead>
            <tbody>
            <?php 
            if($result_data)
            {
                foreach($result_data as $data)
                {
                ?>
                <tr class="gradeU">
                    <td align="left"><?php print($data->id);?></td>
                    <td align="left">
                        <a href="<?=site_url(ADMIN_DASHBOARD_PATH.'/users/view/'.$data->id);?>">
                        <?=($data->verified_email=='yes')? "<strong style='color:green;' title='verified email'>".$data->email."</strong>" : "<strong style='color:red;' title='Not verified'>".$data->email."</strong>" ;?>
                        </a>
                    </td>                    
                    <td align="center">
                    <?php 
                        $referral = "";
                        if($data->referral_id >0)
                            $referral = $this->admin_user->get_username($data->referral_id)." <br/>ID = ".$data->referral_id;
                        print($referral);
                    ?>
                    </td>                                                            
                    <td align="left"><div align="center"><?php print($this->general->date_time_formate($data->last_login_date));?></div></td>
                    <td align="left"><?php print($data->last_ip_address); ?></td>
                    <td align="left"><?php print($data->reg_ip_address); ?></td>
                    <td align="left"><span title="<?php print($this->admin_user->list_user_refrees($data->id)); ?>"><?php print($this->admin_user->count_user_refrees($data->id)); ?></span></td>
                    <td align="center">
                        <span id="user_organizer_<?=$data->id; ?>">
                        <?php 
                            if($data->organizer == '1')
                                $organizer = "<div class='status-active' title='Organizer: Yes'>&nbsp;</div>";
                            else if($data->organizer == '0')
                                $organizer = "<div class='status-inactive' title='Organizer: No'>&nbsp;</div>";
                            else
                                //$organizer = "<div class='status-pending' title='Organizer: Pending'>&nbsp;</div>";
                                $organizer = "<input class='mws-button orange small' value='Approve Organizer' style='width: 110px;' onclick='change_user_to_organizer(\"".site_url(ADMIN_DASHBOARD_PATH)."\",\"".site_url()."\",\"".$data->id."\" )' >";
                            print($organizer);                                                       
                        ?>
                        </span>
                        <br /><br />
                        <a class="mws-button blue small ajax" style="text-decoration:none;" href="<?=site_url(ADMIN_DASHBOARD_PATH.'/users/organizer/'.$data->id)?>"><nobr>Organizer Detail</nobr></a>
                        <br /><br />
                        <span id="user_td<?=$data->id?>">
                            <?php if($data->status=='0'){?>
                                <button class="mws-button green small" onclick="enable_user_login('<?=site_url(ADMIN_DASHBOARD_PATH)?>','<?=site_url()?>', '<?=$data->id?>');">Enable Login</button>
                            <?php }else{?>
                                <button class="mws-button red small" onclick="disable_user_login('<?=site_url(ADMIN_DASHBOARD_PATH)?>','<?=site_url()?>', '<?=$data->id?>');">Disable Login</button>
                            <?php } ?>                       
                        </span> 
                    </td>
                    <?php /*
                    <!--
                    <td align="center"><?php print($data->paid_event);?></td>
                    <td align="center"><?php print($data->is_display);?></td>
                    <td align="center" style="border-right:none;">
                        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/category/edit_category/<?php print($data->id);?>" style="margin-right:5px;">
                            <img src='<?php print(ADMIN_IMG_DIR_FULL_PATH);?>edit.gif' title="Edit"/>
                        </a>
                    </td>
                    <td align="center" style="border-right:none;">
                        <a  style="margin-left:5px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/category/delete_category/<?php print($data->id);?>">
                            <img  src='<?php print(ADMIN_IMG_DIR_FULL_PATH);?>delete.gif' title="Delete" onClick="return doconfirm();" />
                        </a>    
                    </td>
                    -->    
                    */?>                
                </tr>
            <?php
            	}            	
            }            
            ?>
            </tbody>
        </table>
    </div>
</div>

<div class="breadcum">
    <div class="breadcum_inside">    
        <a href="<?=	site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; Change Password
        <a class="back_button" href="javascript:history.go(-1)" style="text-decoration:none;">
        <img src="<?php	print(ADMIN_CSS_DIR_FULL_PATH);?>css/icons/24/bended-arrow-left.png" width="24" height="24" alt="back" align="right" title="Go Back" />
        </a> 
    </div>   
</div>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span class="mws-i-24 i-list">Change Admin Password</span>
    </div>
    <div class="mws-panel-body">
    	<form class="mws-form" name="sitesetting" method="post">
            <?php    
            	if ($this->session->flashdata('message'))
            	{
            		echo "<div class='mws-form-message success'>" . $this->session->flashdata('message') . "</div>";
            	}            
            ?>
    		<div class="mws-form-inline">
    			<div class="mws-form-row">
    				<label>Old Password</label>
    				<div class="mws-form-item small">
                        <input name="old_password" type='text' id="old_password" class="mws-textinput" value="<?php echo set_value('old_password');?>" />
                        <?=form_error('old_password')?>
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>New Password</label>
    				<div class="mws-form-item small">
                        <input name="new_password" type='text' id="new_password" class="mws-textinput" value="<?php echo set_value('new_password');?>" />
                        <?=form_error('new_password')?>
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Confirm Password</label>
    				<div class="mws-form-item small">  
                        <input name="re_password" type="text" id="re_password" class="mws-textinput" value="<?php echo set_value('re_password');?>" />
                        <?=form_error('re_password')?>                        
    				</div>
    			</div>                
    		</div>
    		<div class="mws-button-row">
                <input class="mws-button blue" type="submit" name="Submit" value="Update" />                
    		</div>
    	</form>
    </div>    	
</div>
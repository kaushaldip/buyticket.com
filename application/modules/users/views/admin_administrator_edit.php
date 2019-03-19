<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=	site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; <a href="<?=site_url(ADMIN_DASHBOARD_PATH)."/users/administrator"?>">Administrators</a> &raquo; Add
        <a class="back_button" href="javascript:history.go(-1)" style="text-decoration:none;">
        <img src="<?php	print(ADMIN_CSS_DIR_FULL_PATH);?>css/icons/24/bended-arrow-left.png" width="24" height="24" alt="back" align="right" title="Go Back" />
        </a> 
    </div>   
</div>
 	 	
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span class="mws-i-24 i-list"><?=$head_title; ?></span>
    </div>
    <div class="mws-panel-body">
    	<form class="mws-form" name="cms-setting" method="post" action="" id="admin_admin_edit">            
            <?php    
            	if ($this->session->flashdata('message'))
            	{
            		echo "<div class='mws-form-message success'>" . $this->session->flashdata('message') . "</div>";
            	}            
            ?>
    		<div class="mws-form-inline">
                <div class="mws-form-row">
    				<label>Username</label>
    				<div class="mws-form-item medium">
                        <input class="mws-textinput required" type="text" id="user_name" name="user_name" value="<?php echo set_value('user_name',$data_detail->user_name);?>" title="Username"/>
                        <?=form_error('user_name')?>                       
    				</div>
    			</div>
    			<div class="mws-form-row">
    				<label>Password</label>
    				<div class="mws-form-item medium">
                        <input class="mws-textinput" type="password" id="password" name="password" value="<?php echo set_value('password');?>" title="Password"/>
                        <br /> 
                        <font color="#008040">* leave blank if you don't want to change password.</font>
                        <?=form_error('password')?>                       
    				</div>
    			</div>                
                <div class="mws-form-row">
    				<label>Email</label>
    				<div class="mws-form-item medium">
                        <input class="mws-textinput required email" type="text" id="email" name="email" value="<?php echo set_value('email',$data_detail->email);?>" title="Email"/>
                        <?=form_error('email')?>                       
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Admin Role</label>
    				<div class="mws-form-item medium">
                        <select name="type" class="required" title="Admin Role">  
                            <option value="">Select Admin Role</option>                      
                            <option <?=$data_detail->type == 'ACCOUNTANT'? 'selected=selected': '';?> value="ACCOUNTANT">ACCOUNTANT</option>
                            <option <?=$data_detail->type == 'MODERATOR'? 'selected=selected': '';?> value="MODERATOR">MODERATOR</option>
                            <option <?=$data_detail->type == 'ADMIN'? 'selected=selected': '';?> value="ADMIN">ADMIN</option>
                        </select>
                        <?=form_error('type')?>                       
    				</div>
    			</div>                          
    		</div>
    		<div class="mws-button-row">
                <input class="mws-button blue" type="submit" value="Submit" class="bttn"/>
    		</div>
    	</form>
    </div>    	
</div>
<script>
$("#admin_admin_edit").validate();
</script>
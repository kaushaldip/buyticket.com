<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/block-ip/index">Blocked IP Management</a> &raquo; Add
        <a class="back_button" href="javascript:history.go(-1)" style="text-decoration:none;">
        <img src="<?php	print(ADMIN_CSS_DIR_FULL_PATH);?>css/icons/24/bended-arrow-left.png" width="24" height="24" alt="back" align="right" title="Go Back" />
        </a> 
    </div>   
</div>

<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span class="mws-i-24 i-list">Add Blocked IP</span>
    </div>
    <div class="mws-panel-body">
    	<form class="mws-form" name="blocked-ip-add" method="post" action=""  enctype="multipart/form-data" autocomplete="off">
            <?php    
            	if ($this->session->flashdata('message'))
            	{
            		echo "<div class='mws-form-message success'>" . $this->session->flashdata('message') . "</div>";
            	}            
            ?>
    		<div class="mws-form-inline">                
                <div class="mws-form-row">
    				<label>IP Address</label>
    				<div class="mws-form-item small">  
                        <input name="ip_address" type="text" class="mws-textinput" id="ip_address" value="<?php echo set_value('ip_address',$data_ip->ip_address);?>" size="20" />   
                        <?=form_error('ip_address')?>                     
    				</div>
    			</div>                               
    		</div>
            <!-- end performer div-->
    		<div class="mws-button-row">
                <input class="mws-button blue" type="submit" name="Submit" value="Submit" />
    		</div>
    	</form>
    </div>    	
</div>
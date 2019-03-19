<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=	site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/help/index">Help Management</a> &raquo; Edit
        <a class="back_button" href="javascript:history.go(-1)" style="text-decoration:none;">
        <img src="<?php	print(ADMIN_CSS_DIR_FULL_PATH);?>css/icons/24/bended-arrow-left.png" width="24" height="24" alt="back" align="right" title="Go Back" />
        </a> 
    </div>   
</div>

<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span class="mws-i-24 i-list">Edit Help</span>
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
    				<label>Help Title </label>
    				<div class="mws-form-item small">                        
                        <input name="name" type="text" class="mws-textinput" id="name" value="<?php echo set_value('name',$data_help->title);?>" size="25" />
                        <?=form_error('name')?>
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Is Display?</label>
    				<div class="mws-form-item small">
                        <ul class="mws-form-list inline">
    						<li><input name="is_display" type="radio" value="Yes" checked="checked" /> <label>Yes</label></li>
    						<li><input name="is_display" type="radio" value="No" <?php if($data_help->is_display == 'No'){ echo 'checked="checked"';}?> /> <label>No</label></li>    						
    					</ul>
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Description</label>
    				<div class="mws-form-item small">  
                        <textarea name="description" cols="75" rows="7"><?php echo set_value('description',$data_help->description);?></textarea>
                        <?=form_error('description')?>                     
    				</div>
                    
    			</div>                
    		</div>
    		<div class="mws-button-row">                
                <input class="mws-button blue" type="submit" name="Submit" value="Submit" />                
    		</div>
    	</form>
    </div>    	
</div>
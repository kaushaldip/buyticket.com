<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=	site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/bank/index">Bank Detail Management</a> &raquo; Add
        <a class="back_button" href="javascript:history.go(-1)" style="text-decoration:none;">
        <img src="<?php	print(ADMIN_CSS_DIR_FULL_PATH);?>css/icons/24/bended-arrow-left.png" width="24" height="24" alt="back" align="right" title="Go Back" />
        </a> 
    </div>   
</div>

<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span class="mws-i-24 i-list">Add New Bank Detail</span>
    </div>
    <div class="mws-panel-body">    
    	<form class="mws-form" name="sitesetting" method="post" enctype="multipart/form-data">
            <?php    
            	if ($this->session->flashdata('message'))
            	{
            		echo "<div class='mws-form-message success'>" . $this->session->flashdata('message') . "</div>";
            	}            
            ?>
    		<div class="mws-form-inline">
    			<div class="mws-form-row">
    				<label>Bank Name</label>
    				<div class="mws-form-item small">
                        <input name="bank_name" type="text" class="mws-textinput" id="bank_name" value="<?php echo set_value('bank_name');?>" size="55" />
                        <?=form_error('bank_name')?>
                        
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Bank Logo</label>
    				<div class="mws-form-item small">
                        <input name="image" type="file"  />                        
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Account Name</label>
    				<div class="mws-form-item small">
                        <input name="bank_account_name" type="text"  class="mws-textinput" id="bank_account_name" value="<?php echo set_value('bank_account_name');?>" size="55" />
                        <?=form_error('bank_account_name')?>
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Account Number</label>
    				<div class="mws-form-item small">
                        <input name="bank_account_number" type="text"  class="mws-textinput" id="bank_account_number" value="<?php echo set_value('bank_account_number');?>" size="55" />
                        <?=form_error('bank_account_number')?>
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>IBAN Number</label>
    				<div class="mws-form-item small">
                        <input name="bank_iban_number" type="text" class="mws-textinput" id="bank_iban_number" value="<?php echo set_value('bank_iban_number');?>" size="55" />
                        <?=form_error('bank_iban_number')?>
    				</div>
    			</div>                                
    		</div>
    		<div class="mws-button-row">                
                <input class="mws-button blue" type="submit" name="Submit" value="Submit" />                
    		</div>
    	</form>
    </div>    	
</div>
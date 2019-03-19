<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=	site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; <a href="<?=site_url(ADMIN_DASHBOARD_PATH)."/email-settings/index"?>">Email Settings Management</a> &raquo; Add
        <a class="back_button" href="javascript:history.go(-1)" style="text-decoration:none;">
        <img src="<?php	print(ADMIN_CSS_DIR_FULL_PATH);?>css/icons/24/bended-arrow-left.png" width="24" height="24" alt="back" align="right" title="Go Back" />
        </a> 
    </div>   
</div>


<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span class="mws-i-24 i-list">Add Email Setting</span>
    </div>
    <div class="mws-panel-body">
    	<form class="mws-form" name="cms-setting" method="post" action="">            
            <?php    
            	if ($this->session->flashdata('message'))
            	{
            		echo "<div class='mws-form-message success'>" . $this->session->flashdata('message') . "</div>";
            	}            
            ?>
    		<div class="mws-form-inline">
                <div class="mws-form-row">
    				<label>Title</label>
    				<div class="mws-form-item medium">
                        <input class="mws-textinput" type="text" id="name" name="name" value="<?php echo set_value('name');?>"/>
                        <?=form_error('name')?>                       
    				</div>
    			</div>
    			<div class="mws-form-row">
    				<label>Subject</label>
    				<div class="mws-form-item medium">
                        <input class="mws-textinput" type="text" id="subject" name="subject" value="<?php echo set_value('subject');?>"/>
                        <?=form_error('subject')?>                       
    				</div>
    			</div>
                
                <div class="mws-form-row">
                    <label>Email Body</label>
                    <div class="mws-form-item small">
                        <?php
                        echo form_fckeditor('content', set_value('email_body') );
                        ?>
                        <?=form_error('content')?>
                    </div>
                </div>
                      
    		</div>
    		<div class="mws-button-row">
                <input class="mws-button blue" type="submit" value="Submit" class="bttn"/>
    		</div>
    	</form>
    </div>    	
</div>
<div class="keywords_status">
	<div class="keywords_status_inside">
		<table width="100%" border="0" cellspacing="4" cellpadding="0">
    <tr>
        <td colspan="4" style="color:#FF0000"><p><strong>Legends (For the Dyanamic Content) </strong></p></td>
    </tr>
    <tr>
        <td width="25%">[SITENAME]</td>
        <td width="25%">Display Website Name </td>
        <td width="25%">[EVENTNAME]</td>
        <td width="16%">Event Name </td>
    </tr>
    <tr>
        <td>[CONFIRM]</td>
        <td width="25%">Registration confirm link </td>
        <td>[AMOUNT]</td>
        <td>Amount/Credit</td>
    </tr>
    <tr>
        <td>[USERNAME]</td>
        <td>User name </td>
        <td>[DATE]</td>
        <td>Date and Time </td>
    </tr>
    <tr>
        <td>[PASSWORD] </td>
        <td>User Password </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>
	</div>
</div>
<script>
function redirect_lang_cms(val)
{
	if($('#lang').val())
		document.location.href="<?php echo base_url().ADMIN_DASHBOARD_PATH.'/email-settings/index/'.$this->uri->segment(3).'/';?>"+$('#lang').val();
}
</script>
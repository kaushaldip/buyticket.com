<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=	site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; Site Settings
        <a class="back_button" href="javascript:history.go(-1)" style="text-decoration:none;">
        <img src="<?php	print(ADMIN_CSS_DIR_FULL_PATH);?>css/icons/24/bended-arrow-left.png" width="24" height="24" alt="back" align="right" title="Go Back" />
        </a> 
    </div>   
</div>
    
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span class="mws-i-24 i-list">Web Site Configuration</span>
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
    				<label>Website Name</label>
    				<div class="mws-form-item small">    					
                        <input type='text' name="site_name" class="mws-textinput" value="<?php echo set_value('site_name', $site_set['site_name']);?>"/>
                        <?=form_error('site_name');?>
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Contact Email</label>
    				<div class="mws-form-item small">   
                        <input name="contact_email" type='text' class="mws-textinput"  id="contact_email" value="<?php	echo set_value('contact_email', $site_set['contact_email']);?>" />
                        <?=form_error('contact_email');?>
    				</div>
    			</div>
                               
                <div class="mws-form-row">
    				<label>Contact Phone</label>
    				<div class="mws-form-item small">   
                        <input name="contact_phone" type="text"  class="mws-textinput" id="contact_phone" value="<?php echo set_value('contact_phone', $site_set['contact_phone']); ?>" />
                        <?=form_error('contact_phone');?>
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Contact Address</label>
    				<div class="mws-form-item small">   
                        <input name="contact_address" type="text"  class="mws-textinput" id="contact_address" value="<?php echo set_value('contact_address', $site_set['contact_address']); ?>" />
                        <?=form_error('contact_address');?>
    				</div>
    			</div>
               
                <div class="mws-form-row">
    				<label>Website Fee Rate</label>
    				<div class="mws-form-item small">   
                        <input name="website_fee_rate" type="text" style="width: 32%;"  class="mws-textinput small" maxlength="5" id="website_fee_rate" value="<?php echo set_value('website_fee_rate', $site_set['website_fee_rate']); ?>" /> %
                        + USD <input name="website_fee_price" type="text" style="width: 32%;"  class="mws-textinput small" maxlength="5" id="website_fee_price" value="<?php echo set_value('website_fee_price', $site_set['website_fee_price']); ?>" />
                        <?=form_error('website_fee_rate');?>
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Affiliate Referral Program Percentage</label>
    				<div class="mws-form-item small">   
                        <input name="affiliate_referral_rate" type="text"  class="mws-textinput small" maxlength="5" id="affiliate_referral_rate" value="<?php echo set_value('affiliate_referral_rate', $site_set['affiliate_referral_rate']); ?>" /> %
                        <?=form_error('affiliate_referral_rate');?>
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Event Affiliate Program Percentages</label>
    				<div class="mws-form-item small">   
                        <input name="event_affiliate_referral_rate" type="text"  class="mws-textinput" id="event_affiliate_referral_rate" value="<?php echo set_value('event_affiliate_referral_rate', $site_set['event_affiliate_referral_rate']); ?>" /> <em>* Must be comma seperated.</em>
                        <?=form_error('event_affiliate_referral_rate');?>
    				</div>
    			</div>         
                <div class="mws-form-row">
    				<label>Facebook Page URL</label>
    				<div class="mws-form-item small">   
                        <input name="facebook_page_url" type="text"  class="mws-textinput" id="facebook_page_url" value="<?php echo set_value('facebook_page_url', $site_set['facebook_page_url']); ?>" />
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Twitter Page URL</label>
    				<div class="mws-form-item small"> 
                        <input name="twitter_page_url" type="text"  class="mws-textinput" id="twitter_page_url" value="<?php echo set_value('twitter_page_url', $site_set['twitter_page_url']);?>"/>                        
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Youtube Page URL </label>
    				<div class="mws-form-item small">
                        <input name="youtube_page_url" type="text"  class="mws-textinput" id="youtube_page_url" value="<?php echo set_value('youtube_page_url', $site_set['youtube_page_url']);?>" />                       
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Google + Page URL</label>
    				<div class="mws-form-item small">   
                        <input name="googleolus_page_url" type="text"  class="mws-textinput" id="googleolus_page_url" value="<?php echo set_value('googleolus_page_url', $site_set['googleolus_page_url']); ?>" />
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Default Page Title</label>                    
    				<div class="mws-form-item large">  
                        <textarea name="default_page_title" rows="100%" cols="100%" id="default_page_title"><?php echo set_value('default_page_title', $site_set['default_page_title']);?></textarea>
                        <?=form_error('default_page_title');?>
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Default Meta Key</label>
    				<div class="mws-form-item large">
                        <textarea name="default_meta_keys" rows="100%" cols="100%" id="default_meta_keys"><?php echo set_value('default_meta_keys', $site_set['default_meta_keys']);?></textarea>
                        <?=form_error('default_meta_keys');?>                       
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Default Meta Description</label>
    				<div class="mws-form-item large">
                        <textarea name="default_meta_desc" rows="100%" cols="100%" id="default_meta_desc"><?php echo set_value('default_meta_desc', $site_set['default_meta_desc']);?></textarea>
                        <?=form_error('default_meta_desc');?>
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Paypal API username</label>
    				<div class="mws-form-item small">   
                        <input name="paypal_api_username" type="text"  class="mws-textinput" id="paypal_api_username" value="<?php echo set_value('paypal_api_username', $site_set['paypal_api_username']); ?>" />
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Paypal API Signature</label>
    				<div class="mws-form-item small">   
                        <input name="paypal_api_signature" type="text"  class="mws-textinput" id="paypal_api_signature" value="<?php echo set_value('paypal_api_signature', $site_set['paypal_api_signature']); ?>" />
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Paypal API Password</label>
    				<div class="mws-form-item small">   
                        <input name="paypal_api_password" type="text"  class="mws-textinput" id="paypal_api_password" value="<?php echo set_value('paypal_api_password', $site_set['paypal_api_password']); ?>" />
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Site Offline Message</label>
    				<div class="mws-form-item large">
                        <textarea name="site_offline_msg" cols="34" rows="3" id="site_offline_msg"><?php echo set_value('site_offline_msg', $site_set['site_offline_msg']);?></textarea>
                        <?=form_error('site_offline_msg');?>
    				</div>
    			</div>
                <div class="mws-form-row">
    				<label>Website Status</label>
    				<div class="mws-form-item small"> 
                        <ul class="mws-form-list inline">
    						<li><input name="site_status" type="radio" value="online" checked="checked" /> <label>Online</label></li>
    						<li><input name="site_status" type="radio" value="offline" <?php if ($site_set['site_status'] == 'offline'){echo 'checked="checked"';}?> /> <label>Offline</label></li>    						
    					</ul>
    				</div>
    			</div>
    		</div>
    		<div class="mws-button-row">
                <input class="mws-button blue" type="submit" name="Submit" value="Update" />
    		</div>
    	</form>
    </div>    	
</div>


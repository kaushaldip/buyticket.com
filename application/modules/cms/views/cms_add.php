<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=	site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; CMS  Management
        <a class="back_button" href="javascript:history.go(-1)" style="text-decoration:none;">
        <img src="<?php	print(ADMIN_CSS_DIR_FULL_PATH);?>css/icons/24/bended-arrow-left.png" width="24" height="24" alt="back" align="right" title="Go Back" />
        </a> 
    </div>   
</div>



<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span class="mws-i-24 i-list">Add Content Management System</span>
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
    				<label>Heading</label>
    				<div class="mws-form-item small">
                        <input size="50" type="text" id="headtext" name="headtext" class="mws-textinput" value="<?php echo set_value('headtext');?>"/>
                        <?=form_error('headtext')?>
                    </div>
                    
    			</div>
                <div class="mws-form-row">
                    <label>CMS Slug</label>
                    <div class="mws-form-item small">
                        <input size="50"  type="text" id="cms_slug" name="cms_slug" class="mws-textinput" value="<?php echo set_value('cms_slug');?>"/>(Ex.:about-us <strong>or</strong> how-it-works)
                        <?=form_error('cms_slug')?>
                    </div>
                </div>
                <div class="mws-form-row">
                    <label>Content</label>
                    <div class="mws-form-item small">
                        <?php echo form_fckeditor('content', set_value('content') );?>
                        <?=form_error('content')?>
                    </div>                    
                    
                </div>
                <div class="mws-form-row">
                    <label>Page Title</label>
                    <div class="mws-form-item small">
                        <textarea cols="60" rows="1" id="page_title" name="page_title"><?php echo set_value('page_title');?></textarea>
                        <?=form_error('page_title')?>
                    </div>
                </div>
                <div class="mws-form-row">
                    <label>Meta Key</label>
                    <div class="mws-form-item small">
                        <textarea cols="60" rows="2" id="meta_key" name="meta_key"><?php echo set_value('meta_key');?></textarea>
                        <?=form_error('meta_key')?>
                    </div>
                </div>
                <div class="mws-form-row">
                    <label>Meta Description</label>
                    <div class="mws-form-item small">
                        <textarea cols="60" rows="2" id="meta_description" name="meta_description"><?php echo set_value('meta_description');?></textarea>
                        <?=form_error('meta_description')?>
                    </div>
                </div>
                <div class="mws-form-row">
                    <label>Display</label>
                    <div class="mws-form-item small">
                        <ul class="mws-form-list inline">
                        <li><input name="status" type="radio" value="Yes" checked="checked" /> <label>Yes</label></li>
                        <li><input name="status" type="radio" value="No"  /><label>No</label></li>
                        </ul>
                        <?=form_error('status')?> 
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
function redirect_lang_cms(val)
{
	if($('#lang').val())
		document.location.href="<?php echo base_url().ADMIN_DASHBOARD_PATH.'/cms/index/'.$this->uri->segment(3).'/';?>"+$('#lang').val();
}
</script>
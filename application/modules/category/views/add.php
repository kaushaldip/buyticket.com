<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/category/index">Event Category Management</a> &raquo; Add
        <a class="back_button" href="javascript:history.go(-1)" style="text-decoration:none;">
        <img src="<?php	print(ADMIN_CSS_DIR_FULL_PATH);?>css/icons/24/bended-arrow-left.png" width="24" height="24" alt="back" align="right" title="Go Back" />
        </a> 
    </div>   
</div>


<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span class="mws-i-24 i-list">Add Event Category</span>
    </div>
    <div class="mws-panel-body">
    	<form class="mws-form" name="event-category-edit" method="post" action=""  enctype="multipart/form-data" autocomplete="off">
            <?php    
            	if ($this->session->flashdata('message'))
            	{
            		echo "<div class='mws-form-message success'>" . $this->session->flashdata('message') . "</div>";
            	}            
            ?>
    		<div class="mws-form-inline">
    			<div class="mws-form-row">
    				<label>Category Name*</label>
    				<div class="mws-form-item small">
                        <input name="category_name" type="text" id="category_name" value="<?php echo set_value('category_name');?>" class="mws-textinput" onkeyup="lookup(this.value,'category');" onblur="close_this('category');"/>
                        <div class="suggestionsBox" id="category_suggestions" style="display: none;">				
                            <div class="suggestionList" id="category_autoSuggestionsList">
                            &nbsp;
                            </div>
                		</div>
                        <?=form_error('category_name')?>
    				</div>
    			</div>
                
                <div class="mws-form-row">
    				<label>Sub category</label>
    				<div class="mws-form-item small">
                        <input name="sub_type" type="text" class="mws-textinput" value="<?php echo set_value('sub_type');?>" />
                        <em>Hint: Leave this field if you do not want sub category.</em>
                        <?=form_error('sub_type')?>
    				</div>
    			</div>
                
                
                <div class="mws-form-row">
    				<label>Sub event option</label>
    				<div class="mws-form-item small">  
                        <input name="sub_sub_type" type="text" class="mws-textinput" value="<?php echo set_value('sub_sub_type');?>" />
                        <em>Hint: Leave this field if you do not want sub type option.</em>
                        <?=form_error('sub_sub_type')?>                      
    				</div>
    			</div>
                
                <div class="mws-form-row">
    				<label>Image</label>
    				<div class="mws-form-item small">
                        <input name="category_image" type="file" id="category_image" value="" class="mws-textinput" />
                        
    				</div>
    			</div>
                
                
                <div class="mws-form-row">
    				<label>Is Display?</label>
    				<div class="mws-form-item small">  
                        <ul class="mws-form-list inline">
                        <li><input name="is_display" type="radio" value="Yes" checked="checked" /> <label>Yes</label></li>
                        <li><input name="is_display" type="radio" value="No" /><label>No</label></li>
                        </ul>
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


<script type="text/javascript">
	function lookup(inputString,prefix) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#'+prefix+'_suggestions').hide();
		} else {
			$.post("autofill_"+prefix, {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					$('#'+prefix+'_suggestions').show();
					$('#'+prefix+'_autoSuggestionsList').html(data);
				}
			});
		}
        
	} // lookup
	
	function fill(thisValue,prefix) {
		$('#'+prefix+'_name').val(thisValue);
		setTimeout("$('#"+prefix+"_suggestions').hide();", 200);        
	}
    function fill_performer(name,type,description,prefix,id) {        
		$('#'+prefix+'_type').val(type);
        $('#'+prefix+'_description').val(description);
        $('#'+prefix+'_name').val(name);
        $('#'+prefix+'_id').val(id);
		setTimeout("$('#"+prefix+"_suggestions').hide();", 200);        
	}
    function close_this(prefix){
		setTimeout("$('#"+prefix+"_suggestions').hide();", 200);
    }
</script>
<style type="text/css">
	body {
		font-family: Helvetica;
		font-size: 11px;
		color: #000;
	}
	
	h3 {
		margin: 0px;
		padding: 0px;	
	}

	.suggestionsBox {
		position: relative;
		left: 0px;
		margin: 0px 0px 0px 0px;
		width: 200px;		
		color: #000;

	}
	
	.suggestionList {
		margin: 0px;
		padding: 0px;
        position:absolute;
    	background-color:#ccc;
    	width:204px;
        border: 1px solid #666666;	
    	height:60px;
    	z-index:1;
    	border: 1px solid #333;
    	padding: 10px;
	}
	
	.suggestionList li {
		
		margin: 0px 0px 3px 0px;
		padding: 3px;
		cursor: pointer;
	}
	
	.suggestionList li:hover {
		background-color: #659CD8;
	}

</style>
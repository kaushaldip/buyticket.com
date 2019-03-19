<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/performer/view">Performer Type Management</a> &raquo; Add
        <a class="back_button" href="javascript:history.go(-1)" style="text-decoration:none;">
        <img src="<?php	print(ADMIN_CSS_DIR_FULL_PATH);?>css/icons/24/bended-arrow-left.png" width="24" height="24" alt="back" align="right" title="Go Back" />
        </a> 
    </div>   
</div>


<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span class="mws-i-24 i-list">Add Performer Type</span>
    </div>
    <div class="mws-panel-body">
    	<form class="mws-form" name="event-category-edit" method="post" action="" autocomplete="off">
            <?php    
            	if ($this->session->flashdata('message'))
            	{
            		echo "<div class='mws-form-message success'>" . $this->session->flashdata('message') . "</div>";
            	}            
            ?>
    		<div class="mws-form-inline">
    			<div class="mws-form-row">
    				<label>Performer Type*</label>
    				<div class="mws-form-item small">
                        <input name="performer_type" type="text" id="category_name" value="<?php echo $performer_d->performer_type ?>" class="mws-textinput" onkeyup="lookup(this.value,'category');" onblur="close_this('category');"/>
                        
                        <?=form_error('performer_type')?>
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
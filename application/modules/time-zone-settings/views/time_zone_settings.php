<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=	site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; Time Zone Management
        <a class="back_button" href="javascript:history.go(-1)" style="text-decoration:none;">
        <img src="<?php	print(ADMIN_CSS_DIR_FULL_PATH);?>css/icons/24/bended-arrow-left.png" width="24" height="24" alt="back" align="right" title="Go Back" />
        </a> 
    </div>   
</div>

<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span class="mws-i-24 i-list">View Time Zone Settings</span>
    </div>
    <div class="mws-panel-body">
    	<form class="mws-form" name="timezonesettings" method="post">
            <?php    
            	if ($this->session->flashdata('message'))
            	{
            		echo "<div class='mws-form-message success'>" . $this->session->flashdata('message') . "</div>";
            	}            
            ?>   
            <div class="mws-form-message info">* Select time zone and click on button to save it. </div>
    		<div class="mws-form-inline">
    			<div class="mws-form-row">
    				<label>Select Time Zone :</label>
    				<div class="mws-form-item small">
                        <select name="gmt_time">
                    	  <? foreach($gmt_lists as $gmt){?>
                    	  <option value="<?=$gmt['id'];?>" <? if($gmt['status']=="on"){echo "selected";}?>>GMT<? if(strstr($gmt['gmt_time'], '-')){echo $gmt['gmt_time'];}else if($gmt['gmt_time'] == "00:00"){echo "";}else {echo "+".$gmt['gmt_time'];}?></option>
                    	  <? }?>	  
                        </select>
                        <input type="submit" name="Submit" class="mws-button blue" value="Save Time Zone" />
    				</div>
    			</div>          
    		</div>    		
    	</form>
    </div>    	
</div>    
<script type="text/javascript">
function doconfirm()
{
	job=confirm("Are you sure to delete permanently?");
	if(job!=true)
	{
		return false;
	}
}
</script>

<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=	site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; Blocked IP Management 
        <a class="back_button" href="javascript:history.go(-1)" style="text-decoration:none;">
        <img src="<?php	print(ADMIN_CSS_DIR_FULL_PATH);?>css/icons/24/bended-arrow-left.png" width="24" height="24" alt="back" align="right" title="Go Back" />
        </a> 
    </div>   
</div>

<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span class="mws-i-24 i-table-1">View Block IP Details </span>
        
    </div>
    <div class="mws-panel-body">
        <div class="mws-panel-toolbar top clearfix">
        	<ul>
            	<li><a class="mws-ic-16 ic-add" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/block-ip/add_ip">Add Block IP</a></li>
            	
            </ul>
        </div>
        <?php    
        	if ($this->session->flashdata('message'))
        	{
        		echo "<div class='mws-form-message success'>" . $this->session->flashdata('message') . "</div>";
        	}            
        ?>
        <table class="mws-datatable mws-table">
            <thead>
                <tr>
                    <th >S. No. </th>
                    <th>IP Address </th>
                    <th>Date</th>
                    <th width="10" align="center"><div align="center">Edit</div></th>
                    <th width="10" align="center" style="border-right:none;"><div align="center">Delete</div></th>
                </tr>
            </thead>
            <tbody>
            <?php 
            if($ip_data)
            {
                foreach($ip_data as $ip_val)
                {
                ?>
                <tr> 
                    <td align="left"><div align="center"><?php print($ip_val->id);?></div></td>
                    <td align="left"><div align="left"><?php print($ip_val->ip_address);?></div></td>
                    <td align="left"><div align="left"><?php print($ip_val->last_update);?></div></td>
                    <td align="center"><a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/block-ip/edit_ip/<?php print($ip_val->id);?>">
                    <img src='<?php print(ADMIN_IMG_DIR_FULL_PATH);?>edit.png' title="Edit"/></a> </td>
                    <td align="center" style="border-right:none;">
                        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/block-ip/delete_ip/<?php print($ip_val->id);?>"> 
                            <img src='<?php print(ADMIN_IMG_DIR_FULL_PATH);?>delete.png' title="Delete" onClick="return doconfirm();" />
                        </a>    
                    </td>
                </tr>
            <?php
            	}            	
            }            
            ?>
            </tbody>
        </table>
    </div>
</div>
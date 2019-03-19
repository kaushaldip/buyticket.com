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
        <a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; Help Management
        <a class="back_button" href="javascript:history.go(-1)" style="text-decoration:none;">
        <img src="<?php	print(ADMIN_CSS_DIR_FULL_PATH);?>css/icons/24/bended-arrow-left.png" width="24" height="24" alt="back" align="right" title="Go Back" />
        </a> 
    </div>   
</div>

<div class="mws-panel grid_8">
	<div class="mws-panel-header">
    	<span class="mws-i-24 i-table-1">View Help  Details</span>
    </div>
    <div class="mws-panel-body">
        <div class="mws-panel-toolbar top clearfix">
        	<ul>
            	<li><a class="mws-ic-16 ic-add" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/help/add_help">Add Help</a></li>
            	
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
                    <th>Help Title </th>
                    <th>Last Update</th>
                    <th>Is Display?</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            if($result_data)
            {
                foreach($result_data as $data)
                {
                ?>
                <tr class="gradeA"> 
                    <td align="left"><?php print($data->title);?></td>
                    <td align="left"><div align="center"><?php print($this->general->date_time_formate($data->last_update));?></div></td>
                    <td align="center"><?php print($data->is_display);?></td>
                    <td align="center" style="border-right:none;">
                        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/help/edit_help/<?php print($data->id);?>" style="margin-right:5px;">
                            <img src='<?php print(ADMIN_IMG_DIR_FULL_PATH);?>/edit.gif' title="Edit"/>
                        </a>
                        <a  style="margin-left:5px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/help/delete_help/<?php print($data->id);?>">
                            <img  src='<?php print(ADMIN_IMG_DIR_FULL_PATH);?>/delete.gif' title="Delete" onClick="return doconfirm();" />
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
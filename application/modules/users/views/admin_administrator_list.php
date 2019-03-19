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
        <a href="<?=	site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; Administrators
        <a class="back_button" href="javascript:history.go(-1)" style="text-decoration:none;">
        <img src="<?php	print(ADMIN_CSS_DIR_FULL_PATH);?>css/icons/24/bended-arrow-left.png" width="24" height="24" alt="back" align="right" title="Go Back" />
        </a> 
    </div>   
</div>
 
<div class="mws-panel grid_8">
	<div class="mws-panel-header">         
    	<span class="mws-i-24 i-table-1"><?php echo $head_title; ?></span>
        
    </div>
    <div class="mws-panel-body">
        <div class="mws-panel-toolbar top clearfix">
        	<ul>
            	<li><a class="mws-ic-16 ic-direction" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/users/administrator_add">Add</a></li>
            	
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
                    <th><?php echo $this->lang->line('id');?></th>
                    <th><?php echo $this->lang->line('username');?></th>
                    <th>Email</th>
                    <th>Last Login</th>
                    <th>Last Login IP</th>
                    <th>Admin Role</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            if($result_data)
            {
                foreach($result_data as $data)
                {
                ?>
                <tr class="gradeU">
                    <td><?=$data->id;?></td>
                    <td><?=$data->user_name;?></td>
                    <td><?=$data->email;?></td>
                    <td><?=$data->last_login;?></td>
                    <td><?=$data->ip_addr;?></td>
                    <td><?=$data->type;?></td>
                    <td>
                    <?php if($data->id!=101):?>
                        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH."/users/administrator_edit/".$data->id);?>">Edit</a>
                        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH."/users/administrator_delete/".$data->id);?>">Delete</a>
                    <?php else:?>
                    <?php endif; ?>
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
<style>
#cboxPrevious, #cboxNext{display: none;}
</style>

<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=	site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; <a href="#">Performer management</a> 
        
    </div>   
</div>
<div class="mws-panel grid_8">
	
    <div class="mws-panel-body">
        <div class="mws-panel-toolbar top clearfix">
        	<ul>
            	<li><a class="mws-ic-16 ic-add" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/performer/add_performer">Add New Performer Type</a></li>
            	
            </ul>
        </div>
        <?php 
        
        	if ($this->session->flashdata('message'))
        	{
        		echo "<div class='mws-form-message success'>" . $this->session->flashdata('message') . "</div>";
        	}            
        ?>
        <table id="myTable" class="mws-datatable-fn mws-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Performer Type</th>
                    <th>Edit</th>
                    <th>Delete</th>                
                </tr>
            </thead>
            <tbody>
            <?php if($performer_type){?>
                <?php foreach($performer_type as $pd):?>
                
                <tr>
                    <td><?=$pd->id ?></td>
                    <td><?=$pd->performer_type; ?></td>
                    <td align="center" style="border-right:none;">
                        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/performer/edit/<?php print($pd->id);?>" style="margin-right:5px;">
                            <img src='<?php print(ADMIN_IMG_DIR_FULL_PATH);?>edit.png' title="Edit"/>
                        </a>
                    </td>
                    <td align="center" style="border-right:none;">
                        <a  style="margin-left:5px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/performer/delete/<?php print($pd->id);?>">
                            <img  src='<?php print(ADMIN_IMG_DIR_FULL_PATH);?>delete.png' title="Delete" onClick="return doconfirm();" />
                        </a>    
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php }?>
            </tbody>
        </table>
    </div>
</div>

<script>


$(document).ready(function()
{
    var oTable = $('#myTable').dataTable();    
  
    oTable.fnSort( [ [0,'asc'] ] );
} );
</script>
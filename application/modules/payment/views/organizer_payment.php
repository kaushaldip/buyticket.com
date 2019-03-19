<style>
#cboxPrevious, #cboxNext{display: none;}
</style>

<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=	site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; <a href="#">Payment management</a> &raquo; Organizer Payment
        
    </div>   
</div>
<div class="mws-panel grid_8">
	
    <div class="mws-panel-body">
        
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
                    <th>Organizer Email</th>   
                    <th>Organizer Name</th>
                    <th>Event</th>
                    <th>Event ID</th>
                    <th>Operation</th>                    
                </tr>
            </thead>
            <tbody>
            <?php if($payment_details){?>
                <?php foreach($payment_details as $pd):?>
                <?php 
                $payments = $this->payment_admin_model->get_view_organizer_payment($pd->event_id);
                if(!$payments)
                    continue;
                ?>
                <tr>
                    <td><?=$pd->id ?></td>
                    <td><?=$pd->email; ?></td>
                    <td><?=ucwords($pd->first_name." ".$pd->last_name); ?></td>
                    <td><?=$pd->title ?></td>
                    <td><?=$pd->event_id ?></td>
                    <td><a href="<?=site_url(ADMIN_DASHBOARD_PATH.'/payment/view_organizer_payment/'.$pd->event_id) ?>" class="ajax1">View Payment</a></td>
                </tr>
                <?php endforeach; ?>
            <?php }?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(window).load(function(){
//Examples of how to assign the Colorbox event to elements
    jQuery(".ajax1").colorbox({width:"800px",height:"600px"});

});

$(document).ready(function()
{
    var oTable = $('#myTable').dataTable();    
  
    oTable.fnSort( [ [0,'asc'] ] );
} );
</script>
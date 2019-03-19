<link rel="stylesheet" href="<?php echo ASSETS_PATH ?>colorbox/colorbox.css" />
<script src="<?php echo ASSETS_PATH ?>colorbox/jquery.colorbox.js"></script>
<script>
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				
				jQuery(".ajax").colorbox({width:"600px",height:"400px"});
				
			});
		</script>
                <style>
                    #cboxPrevious, #cboxNext{
    display: none;
}
                </style>
<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=	site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH.'/payment/index'); ?>">Payment management</a>
        
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
        <table class="mws-datatable mws-table">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line('id');?></th>
                    <th>Event Name</th>                    
                    <th>Ticket Sold</th>
                    <th>Total of Revenue</th>                    
                    <th>Affilate Fee</th>
                     <th>Service Fee</th>
                    <th>P.code Discount</th>                    
                    <th>Total of Earning</th>
                    <th>Pay Action</th>
                                 
                </tr>
            </thead>
            <tbody>
                <?php foreach($payment_details as $pd):?>
                <tr>
                    <td><?=$pd->event_id ?></td>
                    <td><?=$pd->title ?></td>
                    <td><?=$pd->total_tickets_sold ?></td>
                    <td><?=$pd->affilate_total+$pd->total_discount+$pd->total_fee+$pd->total_price ?></td>
                    <td><?=$pd->affilate_total ?></td>
                    <td><?=$pd->total_fee ?></td>
                    <td><?=$pd->total_discount ?></td>
                    <td><?=$pd->total_price ?></td>
                    <td><a href="<?=site_url(ADMIN_DASHBOARD_PATH.'/payment/pay/'.$pd->event_id) ?>"class='ajax'>pay</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
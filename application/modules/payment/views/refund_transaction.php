<link rel="stylesheet" href="<?php echo ASSETS_PATH ?>colorbox/colorbox.css" />
<script src="<?php echo ASSETS_PATH ?>colorbox/jquery.colorbox.js"></script>
<script>
	jQuery(document).ready(function(){
		//Examples of how to assign the Colorbox event to elements
		
		jQuery(".ajax").colorbox({width:"80%",height:"500px"});
		
	});
</script>
<style>
#cboxPrevious, #cboxNext{
display: none;
}
</style>
<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=	site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; <a href="#">Payment management</a> &raquo; Refund Transaction
        
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
                    <th>ID</th> 
                    <th>Event Name</th>                                       
                    <th>Order ID</th>
                    <th>Email</th>                    
                    <th>Payment</th>              
                    <th>Paid</th>                    
                    <th>Refund %</th>
                    <th>Refund Amount</th>
                    <th>Refund on</th>
                    <th>Payment Detail</th>                                 
                </tr>
            </thead>
            <tbody>
            <?php if($payment_details){?>
                <?php foreach($payment_details as $pd):?>
                <tr id="refund_payment_detail<?=$pd->ticket_order_id; ?>">
                    <td><?=$pd->ticket_order_id; ?></td>
                    <td><?=$this->event_model->get_event_name_from_id($pd->eeeid) ?></td>                    
                    <td><?=$pd->order_id; ?></td>
                    <td><?=$pd->email;?></td>                    
                    <td><nobr><?=$this->general->price($pd->total);?></nobr></td>              
                    <td><nobr><?=$this->general->price($pd->paid);?></nobr></td>                    
                    <td><?=$pd->refund_percent;?></td>
                    <td><nobr><?=$this->general->price($pd->paid * ($pd->refund_percent)/100);?></nobr></td>
                    <td><?=$pd->refund_date;?></td>
                    <td><a href="<?=site_url(ADMIN_DASHBOARD_PATH."/payment/view_refund_transaction/$pd->ticket_order_id")?>" class="ajax">View Detail</a></td>
                </tr>
                <?php endforeach; ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
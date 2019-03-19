<script>
$(document).ready(function(){
//Examples of how to assign the Colorbox event to elements
    jQuery(".ajax").colorbox({width:"800px",height:"auto"});

});

$(document).ready(function()
{
    var oTable = $('#myTable').dataTable();    
    // Sort immediately with column 2 (at position 1 in the array. More could be sorted with additional array elements
    oTable.fnSort( [ [0,'desc'] ] );
} );
</script>
<style>
#cboxPrevious, #cboxNext{display: none;}
</style>

<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=	site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; <a href="#">Payment management</a> &raquo; Approve Transaction
        
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
        <table id="myTable" class="mws-datatable mws-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Event Name</th>
                    <th>Ticket Name</th>   
                    <th>Order ID</th>                 
                    <th>Ordered By</th>
                    <th>Ticket Price</th>
                    <th>Qty</th>                    
                    <th>Total Payment</th>                    
                    <th>Order Method</th>
                    <th>Status</th>
                    <th>Operation</th>                    
                </tr>
            </thead>
            <tbody>
            <?php if($payment_details){?>
                <?php foreach($payment_details as $pd):?>
                <tr id="order_row<?=$pd->ticket_order_id ?>">
                    <td><?=$pd->ticket_order_id ?></td>
                    <td><?=$this->event_model->get_event_name_from_id($pd->eeeid) ?><?php if($pd->event_cancel == 'yes'){ echo "<br/><span title='Event has been cancelled, please approve payment and then refund.' style='color:red;'>(EVENT CANCELLED)</span>"; } ?></td>
                    <td><?=ucwords($pd->name); ?></td>
                    <td><?=$pd->order_id; ?></td>
                    <td><a href="<?=site_url(ADMIN_DASHBOARD_PATH.'/payment/view_approve_transaction/'.$pd->ticket_order_id) ?>"class='ajax'>View</a></td>
                    <td><nobr><?='USD '.$pd->ticket_price; ?> </nobr><br /></td>
                    <td><?=$pd->ticket_quantity ?></td>                    
                    <td><nobr><?='USD '.$pd->total;?></nobr><br /></td>
                    <td><?=$pd->transaction_method;?></td>
                    <td id="payment_status_<?=$pd->ticket_order_id;?>"><?=$pd->payment_status; ?></td> 
                    <td>
                        <?php if(strtoupper($pd->payment_status)=='COMPLETE'){ ?>
                        <a href="<?=site_url(ADMIN_DASHBOARD_PATH.'/payment/refund_payment/'.$pd->ticket_order_id)?>" class="ajax">Cancel</a>
                        <?php }else if(strtoupper($pd->payment_status)=='PENDING'){?>
                        <a href="<?=site_url(ADMIN_DASHBOARD_PATH.'/payment/cancel_payment/'.$pd->ticket_order_id)?>" class="ajax">Cancel</a>
                        <?php } ?>
                    </td>                   
                </tr>
                <?php endforeach; ?>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
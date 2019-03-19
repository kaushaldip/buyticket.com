<style>
.for_labeled label{width: 105px;text-align: right;display: inline-block;margin-right: 10px;}
</style>
<div class="for_labeled" style="padding: 5px 15px; line-height: 20px;">    
    <div style="background: #f5f5f5; padding: 10px; margin-bottom: 10px;">
        <div style="margin-bottom: 20px;">
            <h4>Cancel Order</h4>
            <em>Since payment is pending, order will be cancelled and removed.</em>
        </div>
        <div id="delete_heeeee">
            <input type="submit" name="delete_order" value="Confirm" onclick="delete_ticket_order();" class="mws-button red" />
            <input type="button" name="cancel" value="Cancel" onclick="jQuery.colorbox.close(); return false;" class="mws-button blue" />
        </div>
               	
	</div>
</div>

<script>
var ticket_order_id = "<?=$ticket_order_id; ?>";
var adminURL = '<?=site_url(ADMIN_DASHBOARD_PATH); ?>';
site_url= '<?=site_url(); ?>';
root_url = site_url.slice(0,-3); 

function delete_ticket_order()
{
    if(confirm("Are you sure to delete order?")){
        $('#delete_heeeee').append('<img src='+root_url+'/assets/images/ajax_loader_small.gif>');
        $.ajax({
            type: "POST",
            url: adminURL+"/payment/delete_ticket_order",  
            data: 'ticket_order_id='+ticket_order_id,
            dataType: "json",       
            success: function(json){      
                if(json.result=='success'){
                    $('#delete_heeeee').html("Order has been deleted."); 
                    $("#order_row"+ticket_order_id).html("").hide();               
                }else{
                    $('#delete_heeeee').html("<font color=red>Something went wrong.</font>");
                }                          
            }     
        });    
    }
    return false;
      
}
</script>
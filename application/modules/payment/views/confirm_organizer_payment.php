<style>
.payment_form label{width: 185px;text-align: right;display: inline-block;margin-right: 10px;}
</style>
<div class="mws-panel grid_8" id="view_organizer_holder">
    <h3>Order details:</h3>
    <strong><?=$event_and_ticket->ticket_name;?></strong>
    
	<div style="border-top:1px solid #cccccc;" class="mws-panel-body">
        <table id="myTable" class="mws-datatable mws-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Order ID</th>                     
                    <th>Payment</th>
                    <th>Paid</th>
                    <th>Due</th>
                    <th title="Payment made by ticket buyers.">Buyer Pay Status</th>
                </tr>
            </thead>
            <tbody>
            <?php if($order_detail){?>
                <?php $total = 0; ?>
                <?php foreach($order_detail as $key=>$pd):?>
                <?php $total += $pd->organizer_payment; $id[] = $pd->id; ?>
                <tr>
                    <td><?=$pd->id ?></td>
                    <td><?=$pd->order_id; ?> #<?=$pd->id ?></td>                                       
                    <td><?="USD ".$pd->organizer_payment; ?></td>
                    <td><?="USD ".$pd->organizer_paid; ?></td>
                    <td><?="USD ".($pd->organizer_payment - $pd->organizer_paid); ?></td> 
                    <td title="Payment made by ticket buyers."><?=$pd->payment_status; ?></td>    
                </tr>
                <?php endforeach; ?>
                <?php $ids = implode(',',$id);?>
                <tr style="border-top: 1px solid #ccc;">
                    <td colspan="2">Total Amount:</td>
                    <td><?="USD ".$total; ?></td>
                    <td colspan="3"></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="payment_form" id="payment_form_id">
    <form method="post" class="mws-form-row" id="release_organizer_payment_form">
        <label>Release Payment via:</label> 
        <select name="pay_through">
            <option value="WU">Western Union</option>
            <option value="BT">Bank Transaction</option>
        </select>
        <br />
        <label>Release Payment Detail:</label>
        <textarea name="pay_detail"></textarea>
        <br />
        <?php //var_dump($id); ?>
        <input type="hidden" value="<?=$ids; ?>" name="ticket_order_ids" />
        <input type="hidden" value="<?=$event_id;?>" name="event_id" />
        <input type="hidden" value="<?=$organizer_id; ?>" name="organizer_id" />
        <input type="hidden" value="<?=$total; ?>" name="payment" />
        <br />
        <label>&nbsp;</label>
        <input type="button" id="release_organizer_payment_btn" class="mws-button blue" value="Release Payment" />   
    </form> 
</div>
<script>
site_url = "<?=site_url(); ?>";
adminUrl = "<?=site_url(ADMIN_DASHBOARD_PATH)?>";
root_url = site_url.slice(0,-3); 
$("#release_organizer_payment_btn").on('click',function(){    
    ticket_order_ids = $("#payment_form_id input[name=ticket_order_ids]").val();
    event_id = $("#payment_form_id input[name=event_id]").val(); 
    organizer_id = $("#payment_form_id input[name=organizer_id]").val();
    pay_through = $("#payment_form_id select[name=pay_through]").val();
    pay_detail = $("#payment_form_id textarea[name=pay_detail]").val();
    payment = $("#payment_form_id input[name=payment]").val();        
    $('#payment_form_id').html('<img src='+root_url+'/assets/images/ajax_loader_small.gif> Please wait...');   
    
    $.ajax({
        type: "POST",
        url: adminUrl+"/payment/release_organizer_payment",  
        data: 'ticket_order_ids='+ticket_order_ids+'&event_id='+event_id+"&organizer_id="+organizer_id+'&pay_through='+pay_through+'&pay_detail='+pay_detail+"&payment="+payment,
        dataType: "json",       
        success: function(data){   
            if(data.result == 'error'){
                $("#payment_form_id").html(data.msg);
            }else{
                $("#organizer_paid<?=$pd->ticket_id ?>").html("USD "+payment);
                $("#organizer_due<?=$pd->ticket_id ?>").html("USD 0.00");
                $("#pay_organizer<?=$pd->ticket_id ?>").html("paid");
                $("#payment_form_id").html(data.msg);    
            }                                 
        }     
    });      
});
</script>
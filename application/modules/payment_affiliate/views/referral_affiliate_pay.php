<style>
.eap_eap {padding: 10px;}
.eap_eap label{  float: left; margin-right: 10px; text-align: right; width: 200px;}
.eap_eap .row{ clear: both; padding: 10px;}
</style>
<?php
$date_arr = array(
        '1'=> "Janaury",'2' => "Febaury", '3' => "March",'4' => "April", '5' => "May", '6' => "June", '7' => "July", '8' => "August", '9' => "September",'10' => "October", '11' => "November", '12' => "December",
    );
?>
<h2>Referral Affiliate Payment:</h2>
<div class="for_labeled" style="padding: 5px 15px; line-height: 20px;">    
	<div style="background: #f5f5f5; padding: 10px; margin-bottom: 10px;">
		<h5>Affiliate User Details :</h5>
		<label>Organizer:</label><strong><?=$user_detail->first_name." ".$user_detail->last_name; ?></strong><br />
		<label>Email:</label><em><?=$user_detail->email; ?></em>
	</div>
	<div style="background: #f5f5f5; padding: 10px; margin-bottom: 10px;">
		<h5>Affiliate Payment Details:</h5>
		<div style="display:inline-block; width: 40%;">
			<h6 style="margin-bottom: 0;">Bank Detail:</h6>
			<label>Name:</label><strong><?=$user_detail->bank_name; ?></strong><br />
			<label>Acc Number:</label><strong><?=$user_detail->account_number; ?></strong><br />
			<label>Acc holder:</label><strong><?=$user_detail->account_holder_name; ?></strong><br />                
		</div>
		<div style="display:inline-block; width: 40%; margin-left: 8%;">
			<h6 style="margin-bottom: 0;">Western Union:</h6>
			<label>Payee Name:</label><strong><?=$user_detail->western_payee_name; ?></strong><br />
			<label>City:</label><strong><?=$user_detail->western_city; ?></strong><br />
			<label>Country:</label><strong><?=$user_detail->western_country; ?></strong><br />                
		</div>
    </div>             
</div>
<div class="mws-panel grid_8" id="view_organizer_payment"> 
    <h2><?=$date_arr[$month];?>:</h2>   
	<div style="border-top:1px solid #cccccc;" class="mws-panel-body">
        <table id="myTable" class="mws-datatable mws-table">
            <thead>
                <tr>
                    <th>Order ID</th>   
                    <th>Month</th>                      
                    <th>Website Fee</th>
                    <th>Affiliate Payment</th>           
                </tr>
            </thead>             	 	
            <tbody>
            <?php if($payment_details){?>
                <?php $total = 0 ; $order_arr = array();?>
                <?php foreach($payment_details as $t):?>
                <?php $total += $t->referral_pay ;?>
                <tr>
                    <td><?=$t->ticket_order_id ?></td>                        
                    <td><?=$t->month; ?></td>                    
                    <td><?="USD ".$t->web_fee; ?></td>
                    <td><?="USD ".$t->referral_pay; ?></td>
                    <?php 
                    if($t->referral_pay_status == 'no')
                        $order_arr[] = $t->ticket_order_id; 
                    ?>
                </tr>
                <?php endforeach; ?>
                <tr style="border-top: 1px solid #ccc;">
                    <td colspan="3" align="right">Total Payment</td>
                    <td><?="USD ".$total; ?></td>
                </tr>
            <?php }else{ ?>
                <tr>
                    <td colspan="3">No payments left.</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div id="eap_eap" class="eap_eap">
    <?php if(empty($order_arr)):?>
        <div class="mws-form-message success" style="clear: both;">Complete payment</div>
    <?php else:?>
        <form method="post" id="event_affiliate_pay_form">
            <div class="row">
                <label>Release Payment via:</label> 
                <select name="pay_through">
                    <option value="WU">Western Union</option>
                    <option value="BT">Bank Transaction</option>
                </select>
            </div>
            <div class="row">
                <label>Release Payment Detail:</label>
                <textarea name="pay_detail"></textarea>
                <?php $order_ids = implode(',',$order_arr);?>
            </div>
            <div class="row">    
                <input type="hidden" value="<?=$order_ids ?>" name="order_ids" />
                <label>&nbsp;</label>
                <button class="mws-button blue" id="referral_affiliate_pay_release">Release Payment</button>
            </div>
        </form>
    <?php endif;?>
</div>
<script>
adminUrl = '<?=site_url(ADMIN_DASHBOARD_PATH);?>';
site_url = '<?=site_url(); ?>';
month = '<?=$date_arr[$month]; ?>';
img_site_url = root_url = site_url.slice(0,-3); 
$("#referral_affiliate_pay_release").on('click',function(){       
    order_ids = $("#event_affiliate_pay_form input[name=order_ids]").val();
    user_id = "<?=$affilate_user_id; ?>";
    pay_through = $("#event_affiliate_pay_form select[name=pay_through]").val();
    pay_detail = $("#event_affiliate_pay_form textarea[name=pay_detail]").val();
        
    $('#eap_eap').html('<img src='+img_site_url+'/assets/images/ajax_loader_small.gif>');
    $.ajax({
        type: "POST",
        url: adminUrl+"/payment_affiliate/referral_affiliate_pay_release",  
        data: 'order_ids='+order_ids+"&user_id="+user_id+'&pay_through='+pay_through+'&pay_detail='+pay_detail,
        dataType: "json",       
        success: function(json){      
            if(json.result=='success'){
                $('#eap_eap').html("<div class=\"mws-form-message success\" style=\"clear: both;\">"+json.msg+"</div>");
                $("#referral_affiliate_"+user_id+"_"+month).hide(500);
            }else{
                $('#eap_eap').html("<div class=\"mws-form-message error\" style=\"clear: both;\">"+json.msg+"</div>");
            }                          
        }     
    });        
});
</script>    
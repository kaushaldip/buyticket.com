<?php
$date_arr = array(
        '1'=> "Janaury",'2' => "Febaury", '3' => "March",'4' => "April", '5' => "May", '6' => "June", '7' => "July", '8' => "August", '9' => "September",'10' => "October", '11' => "November", '12' => "December",
    );
?>

<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; <a>Payment Affiliate</a> &raquo; Referral Affiliate Program
        
    </div>   
</div>
<div class="mws-panel grid_8">
	
    <div class="mws-panel-body">
        <?php if($end_of_month != $today): ?>        
        <?php    
        	if ($this->session->flashdata('message'))
        	{
        		echo "<div class='mws-form-message success'>" . $this->session->flashdata('message') . "</div>";
        	}    
                            
        ?>
        <table class="mws-datatable mws-table" id="referral_table">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line('id');?></th>
                    <th><?php echo $this->lang->line('referral_affiliate_user');?></th>
                    <th><?php echo $this->lang->line('month');?></th>
                    <th><?php echo $this->lang->line('total_web_fee');?></th>
                    <th><?php echo $this->lang->line('referral_payment');?> <?="(".AFFILIATE_REFERRAL_RATE." % of web fee)";  ?></th>
                    <th><?php echo $this->lang->line('actions');?></th>                                 
                </tr>
            </thead>
            <tbody>
            <?php if($payment_details){ ?>
                <?php foreach($payment_details as $pd):?>
                <tr id="referral_affiliate_<?=$pd->referral_user_id ?>_<?=$date_arr[$pd->month];?>">
                    <td><?=$pd->referral_user_id ?></td>
                    <td><?=$this->general->get_value_from_id('es_user',$pd->referral_user_id, "email") ?></td>
                    <td><?=$date_arr[$pd->month];?></td>
                    <td><?="USD ".$pd->total_web_fee ?></td>                    
                    <td><?="USD ".$pd->total_referral_pay ?></td>                    
                    <td><a href="<?=site_url(ADMIN_DASHBOARD_PATH.'/payment_affiliate/referral_affiliate_pay/'.$pd->referral_user_id.'/'.$pd->month) ?>"class='ajax'>pay</a></td>
                </tr>
                <?php endforeach; ?>
            <?php } ?>
            </tbody>
        </table>
        <?php else: ?>
            <div class='mws-form-message success'>
            You will be notify at end of the month. <?=date('d',strtotime($end_of_month)) - date('d',strtotime($today))  ?> days left. Thank you. 
            </div>
        <?php endif; ?>
    </div>
</div>
<script>
$(document).ready(function(){
	jQuery(".ajax").colorbox({width:"800px",height:"600px"});	
});

$(document).ready(function()
{
    var oTable = $('#referral_table').dataTable();  
    
    oTable.fnSort( [ [2,'asc'] ] );
} );
</script>
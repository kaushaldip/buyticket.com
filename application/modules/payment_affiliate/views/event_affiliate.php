<script>
$(document).ready(function(){
	jQuery(".ajax").colorbox({width:"800px",height:"600px"});	
});
</script>

<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; <a>Payment Affiliate</a> &raquo; Event Affiliate Program
        
    </div>   
</div>
<div class="mws-panel grid_8">
	
    <div class="mws-panel-body">
    <?php if($end_of_month == $today): ?>         
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
                    <th>Event Affiliate User</th>                    
                    <th>Total Transaction -</th>
                    <th>Total Web fee -</th>                    
                    <th>Total Organizer Paid =</th>
                    <th>Affiliate Payment</th>
                    <th>Action</th>                                 
                </tr>
            </thead>
            <tbody>
            <?php if($payment_details):?>
                <?php foreach($payment_details as $pd):?>
                <tr id="event_affiliate_<?=$pd->affiliate_user_id ?>">
                    <td><?=$pd->affiliate_user_id ?></td>
                    <td><?=$this->general->get_value_from_id('es_user',$pd->affiliate_user_id, "email") ?></td>
                    <td><?="USD ".$pd->total_paid ?></td>
                    <td><?="USD ".$pd->total_web_fee ?></td>
                    <td><?="USD ".$pd->total_organizer_paid ?></td>
                    <td><?="USD ".$pd->total_er_pay ?></td>                    
                    <td><a href="<?=site_url(ADMIN_DASHBOARD_PATH.'/payment_affiliate/event_affiliate_pay/'.$pd->affiliate_user_id) ?>"class='ajax'>pay</a></td>
                </tr>
                <?php endforeach; ?>
            <?php endif;?>
            </tbody>
        </table>
    <?php else: ?>
        <div class='mws-form-message success'>
        You will be notify at end of the month. <?=date('d',strtotime($end_of_month)) - date('d',strtotime($today))  ?> days left. Thank you. 
        </div>
    <?php endif; ?>
    </div>
</div>
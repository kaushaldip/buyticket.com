<style>
h4 {border-bottom: 1px solid #ddd; padding-bottom: 5px;}
</style>
<div class="tab-pane" id='tab2'>
<h4><?=$this->general->get_value_from_id('es_event',$event_id,'title') ; ?></h4>
<h4>Last Payments: </h4>
<table class="table table-bordered">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('id'); ?></th>
            <th><?php echo $this->lang->line('total_tickets_sold'); ?></th>
            <th><?php echo $this->lang->line('total_revenue'); ?></th>
            <th><?php echo $this->lang->line('service_fees'); ?></th>
            <th><?php echo $this->lang->line('promotion_discount'); ?></th>
            <th><?php echo $this->lang->line('affiliates_fees'); ?></th>
            <th><?php echo $this->lang->line('total_earning'); ?></th>
            <th><?php echo $this->lang->line('payment_date'); ?></th>
            <th><?php echo $this->lang->line('payment_method_information'); ?></th>
        </tr>
        <?php if($last_payment_detail):?>
            <?php $lps = $last_payment_detail; ?>
            <tr>
                <td><?=$this->general->get_value_from_id('es_event_ticket',$lps->ticket_id,'name') ; ?></td>
                <td><?=$lps->total_ticket_sold; ?></td>
                <td><?=$this->general->price($lps->total_revenue); ?></td>
                <td><?=$this->general->price($lps->total_service_fee); ?></td>
                <td><?=$this->general->price($lps->total_discount); ?></td>
                <td><?=$this->general->price($lps->total_affiliate_fee) ?></td>
                <!--<td><?='net income='.$this->general->price($lps->total_net_income).'<br/>earning='.$lps->total_earning.'<br>net income paid='.$lps->total_net_income_paid; ?></td>-->
                <td><?=$this->general->price($lps->total_earning); ?></td>
                <td><?php if($lps->payment_date) echo $lps->payment_date; else echo 'N/A'?></td>
                <td>
                    <strong><?=(strtoupper($lps->pay_through)=='BT')? "Bank Transaction": "Western Union";?></strong>:<br />
                    <?=$lps->pay_detail;?>
                </td>
            </tr>
        <?php else: ?>
            <tr>
                <td colspan="9">No payment records found.</td>
            </tr>
        <?php  endif;?>        
    </tbody>
</table>                            
</div>
<div class="tab-pane" id='tab2'>
<h4>Past Payments: </h4>
<table class="table table-bordered">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('id'); ?></th>
            <th><?php echo $this->lang->line('total_tickets_sold'); ?></th>
            <th><?php echo $this->lang->line('total_revenue'); ?></th>
            <th><?php echo $this->lang->line('service_fees'); ?></th>
            <th><?php echo $this->lang->line('promotion_discount'); ?></th>
            <th><?php echo $this->lang->line('affiliates_fees'); ?></th>
            <th><?php echo $this->lang->line('total_earning'); ?></th>
            <th><?php echo $this->lang->line('payment_date'); ?></th>
            <th><?php echo $this->lang->line('payment_method_information'); ?></th>
        </tr>
        <?php if($payment_summary_past):?>
            <?php foreach($payment_summary_past as $pps): ?>
            <tr>
                <td><?=$this->general->get_value_from_id('es_event_ticket',$pps->ticket_id,'name') ; ?></td>
                <td><?=$pps->total_ticket_sold; ?></td>
                <td><?=$this->general->price($pps->total_revenue); ?></td>
                <td><?=$this->general->price($pps->total_service_fee); ?></td>
                <td><?=$this->general->price($pps->total_discount); ?></td>
                <td><?=$this->general->price($pps->total_affiliate_fee) ?></td>
                <!--<td><?='net income='.$this->general->price($pps->total_net_income).'<br/>earning='.$pps->total_earning.'<br>net income paid='.$pps->total_net_income_paid; ?></td>-->
                <td><?=$this->general->price($pps->total_earning); ?></td>
                <td><?php if($pps->payment_date) echo $pps->payment_date; else echo 'N/A'?></td>
                <td>
                    <strong><?=(strtoupper($pps->pay_through)=='BT')? "Bank Transaction": "Western Union";?></strong>:<br />
                    <?=$pps->pay_detail;?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="9">No past payment records found.</td>
            </tr>
        <?php  endif;?>        
    </tbody>
</table>                            
</div>
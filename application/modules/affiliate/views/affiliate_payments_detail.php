<?php
$date_arr = array(
        '1'=> "Janaury",'2' => "Febaury", '3' => "March",'4' => "April", '5' => "May", '6' => "June", '7' => "July", '8' => "August", '9' => "September",'10' => "October", '11' => "November", '12' => "December",
    );
?>
<!-- lastest payment start-->
<div id="lastest_payment_detail_page" style="clear: both;">
    <h4><?=$this->lang->line('last_payment_detail') ?>:</h4>
    <table class="table table-striped">
        <tr>
            <th><?=$this->lang->line('month');?></th>
            <th><?=$this->lang->line('earning_credit');?></th>
            <th><?=$this->lang->line('payment_date');?></th>
            <th><?=$this->lang->line('payment_method');?></th>
            <th><?=$this->lang->line('payment_information');?></th>
        </tr>
        <?php if($last_payments_detail){ ?>
        <?php $lpd = $last_payments_detail;?>                
        <tr>
            <td><?=$date_arr[$lpd->month]; ?></td>
            <td><?=$this->general->price($lpd->total_earning); ?></td>
            <td><?=$lpd->create_date; ?></td>
            <td><?=(strtoupper($lpd->pay_through)=='WU')? "Western Union": "Bank Transaction"; ?></td>
            <td><?=$lpd->pay_detail; ?></td>
        </tr>        
        <?php }else{?>
        <tr>
            <td colspan="5">No payments</td>
        </tr>
        <?php } ?>
    </table>
</div>
<!-- lastest payment end-->
<div id="payment_detail_page" style="clear: both;">
    <h4><?=$this->lang->line('payments') ?>:</h4>
    <table class="table table-striped">
        <tr>
            <th><?=$this->lang->line('month');?></th>
            <th><?=$this->lang->line('earning_credit');?></th>
            <th><?=$this->lang->line('payment_date');?></th>
            <th><?=$this->lang->line('payment_method');?></th>
            <th><?=$this->lang->line('payment_information');?></th>
        </tr>
        <?php if($payments_detail){ ?>
        <?php foreach($payments_detail as $key=>$pd): ?>        
        <tr>
            <td><?=$date_arr[$pd->month]; ?></td>
            <td><?=$this->general->price($pd->total_earning); ?></td>
            <td><?=$pd->create_date; ?></td>
            <td><?=(strtoupper($pd->pay_through)=='WU')? "Western Union": "Bank Transaction"; ?></td>
            <td><?=$pd->pay_detail; ?></td>
        </tr>
        <?php endforeach;?>
        <?php }else{?>
        <tr>
            <td colspan="5">No payments</td>
        </tr>
        <?php } ?>
    </table>
</div>
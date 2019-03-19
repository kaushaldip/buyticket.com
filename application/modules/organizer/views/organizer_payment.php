<?php $this->load->view('common/organizer_nav'); ?>
<div class="col-md-10">    
    <div class="payments  table-responsive">
    	<h3><?php echo $this->lang->line('payments'); ?></h3>
        <?php if($this->session->flashdata('message')){ ?>
        <div class="alert alert-success">  
          <a class="close" data-dismiss="alert">&times;</a>
          <?php echo $this->session->flashdata('message');?>
        </div>
        <?php  } ?>
        <?php if($this->session->flashdata('error')){ ?>
        <div class="alert alert-danger">  
          <a class="close" data-dismiss="alert">&times;</a>
          <?php echo $this->session->flashdata('error');?>
        </div>
        <?php  } ?>
        <table class="table table-bordered">
            <tbody>
                <tr style="background: #f5f5f5;">
                    <th><?php echo $this->lang->line('event_name'); ?></th>
                    <th width="80px"><?php echo $this->lang->line('total_tickets_sold'); ?></th>
                    <th><?php echo $this->lang->line('total_revenue'); ?></th>
                    <th><?php echo $this->lang->line('service_fees'); ?></th>
                    <th width="50px"><?php echo $this->lang->line('promotion_discount'); ?></th>
                    <th><?php echo $this->lang->line('affiliates_fees'); ?></th>
                    <th><?php echo $this->lang->line('net_income'); ?></th>
                    <th><?php echo $this->lang->line('due_payment'); ?></th>
                </tr>
                <?php foreach($payment_summary_current as $ps): ?>
                <tr>
                    <td><a href="<?=site_url('organizer/payment_details/'.$ps->event_id) ?>"class='ajax'><?=$ps->title ?></a></td>
                    <td><?=$ps->total_tickets_sold ?></td>
                    <td><?=$this->general->price($ps->total_revenue); ?></td>
                    <td><?=$this->general->price($ps->total_service_fee); ?></td>
                    <td><?=$this->general->price($ps->total_discount); ?></td>
                    <td><?=$this->general->price($ps->total_affiliate_fee); ?></td>
                    <td><strong><?=$this->general->price($ps->total_net_income); ?></strong></td>
                    <td><?=$this->general->price(($ps->total_net_income - $ps->total_net_income_paid)); ?></td>
                </tr>
                <?php endforeach; ?>
                
            </tbody>
        </table>
    </div>                  
</div>
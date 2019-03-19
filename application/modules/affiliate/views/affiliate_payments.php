<div class="col-md-2 left-sidebar">
    <ul>
        <li><a href="<?php echo site_url('affiliate/index');?>" class="upload"><span><?php echo $this->lang->line('referral_program'); ?></span></a></li>
        <li><a href="<?php echo site_url('affiliate/ea_program');?>" class="upload"><span><?php echo $this->lang->line('affiliate_program'); ?></span></a></li>
        <li class="active"><a href="<?php echo site_url('affiliate/payments');?>" class="upload"><span><?php echo $this->lang->line('payments'); ?></span></a></li>        
    </ul>
</div>

<div class="col-md-10">    
    <div class="affiliate_program">
    	<h3><?=$this->lang->line('earning_payment_summery_table');?><div class="pull-right right_menu_box"><a href="javascript:void(0);" onclick="showPaymentDetail();" class="btn btn-success btn-xs"><?=$this->lang->line('payment_details_page');?></a></div></h3>
        <?php if($this->session->flashdata('message')){ ?>
        <div class="alert alert-success no-margin-bottom">  
          <a class="close" data-dismiss="alert">&times;</a>
          <?php echo $this->session->flashdata('message');?>
        </div>
        <?php  } ?>
        <?php if($this->session->flashdata('error')){ ?>
        <div class="alert alert-danger no-margin-bottom">  
          <a class="close" data-dismiss="alert">&times;</a>
          <?php echo $this->session->flashdata('error');?>
        </div>
        <?php  } ?>
        <?php if($affilates){ ?>
            <table class="table table-striped">
                <tr>
                    <th><?=$this->lang->line('today_earning_so_far');?></th>
                    <th><?=$this->lang->line('yesterday_earning');?></th>
                    <th><?=$this->lang->line('this_month_earning_so_far');?></th>
                    <th><?=$this->lang->line('last_month_earning')?></th>
                    <th><?=$this->lang->line('unpaid_earning')?></th>
                    <th><?=$this->lang->line('most_recent_payment'); ?></th>
                </tr>
                <tr>
                    <td><?=$this->general->price($this->affiliate_model->get_payment_event_affiliate_earning('today') + $this->affiliate_model->get_payment_referral_affiliate_earning('today'));?></td>
                    <td><?=$this->general->price($this->affiliate_model->get_payment_event_affiliate_earning('yesterday') + $this->affiliate_model->get_payment_referral_affiliate_earning('yesterday'));?></td>
                    <td><?=$this->general->price($this->affiliate_model->get_payment_event_affiliate_earning('month') + $this->affiliate_model->get_payment_referral_affiliate_earning('month'));?></td>
                    <td><?=$this->general->price($this->affiliate_model->get_payment_event_affiliate_earning('last_month') + $this->affiliate_model->get_payment_referral_affiliate_earning('last_month'));?></td>
                    <td><?=$this->general->price($this->affiliate_model->get_unpaid_earning_affiliate_referral());?></td>
                    <td><?=$this->general->price($this->affiliate_model->get_payment_recent_earning());?></td>            
                </tr>
            </table> 
            
                                                                                            
        <?php }else{?>
            <div class="alert alert-error"><?php echo $this->lang->line('not_referral_member'); ?>.</div>
        <?php } ?>
    </div>
</div>
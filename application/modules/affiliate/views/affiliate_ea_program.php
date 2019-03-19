<!-- sub navigation bar start -->
<div class="col-md-2 left-sidebar">
    <ul>
        <li><a href="<?php echo site_url('affiliate/index');?>" class="upload"><span><?php echo $this->lang->line('referral_program'); ?></span></a></li>
        <li class="active"><a href="<?php echo site_url('affiliate/ea_program');?>" class="upload"><span><?php echo $this->lang->line('affiliate_program'); ?></span></a></li>
        <li><a href="<?php echo site_url('affiliate/payments');?>" class="upload"><span><?php echo $this->lang->line('payments'); ?></span></a></li>        
    </ul>
</div>
<!-- sub navigation bar end -->

<div class="col-md-10">    
    <div class="affiliate_program">
    	<h3><?php echo $this->lang->line('affiliate_program'); ?><div class="pull-right right_menu_box"><a class="btn btn-xs  btn-success" href="<?=site_url('affiliate/event_list')?>" target="_blank" ><?php echo $this->lang->line('event_affiliate_program'); ?></a></div></h3>
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

        <?php if($profile_data->is_referral_user == 'yes' || $affiliate_events){ //check if user is affiilate memeber ?>
        <!--referral urls start-->
        <div class="box">
            <div class="box_content">
                <span id="add_referral_url_response"></span>
                
                <?php if($affiliate_events){ ?>
                <script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#username=<?=$this->session->userdata(SESSION.'email'); ?>"></script>
                <ul class="for_info" id="referral_url_lists">            
                    <?php foreach($affiliate_events as $url): ?>
                        
                        <li id="url_block_<?=$url->id;?>">
                            <div class="url_list_block">
                                <strong><?=$title = ucwords($this->general->get_value_from_id('es_event',$url->event_id,'title')); ?></strong>
                                <nobr>(<?=site_url('e/'.$url->url); ?>)</nobr>
                                <label>
                                    <!-- AddThis Button BEGIN -->
                                    <script type="text/javascript">
                                    var addthis_config = {
                                         pubid: "ra-51e850956b0d3a6e"
                                    }
                                    </script>
        
                                    <a class="addthis_button"
                                    	addthis:url="<?=site_url('e/'.$url->url); ?>"
                                    	addthis:title="<?=$title; ?>"
                                        shortener=bitly
                                        bitly.login= "buyticketco" <?php /*"o_ufdlp4osj" */?>
                                        bitly.apiKey= "R_718e95523dc9602f6d353bff45b29858" <?php /*"R_48e78007e706b711c04300e46551449d" */?>
                                    	href="#">
                                    	<img src="https://s7.addthis.com/static/btn/sm-share-en.gif"
                                    		width="83"
                                    		height="16"
                                    		alt="Bookmark and Share"
                                    		style="border:0"/>
                                    </a>                            
                                    <!-- AddThis Button END -->
                                </label>
                            </div>                    
                            <!--table for referral url details start-->
                            <table class="table table-striped">                        
                                <thead>  
                                    <tr>  
                                        <th><?php echo $this->lang->line('page_views'); ?></th>  
                                        <th><?php echo $this->lang->line('ticket_sold'); ?></th>  
                                        <th><?php echo $this->lang->line('total_revenue'); ?></th>
                                        <th><?php echo $this->lang->line('unpaid_earning'); ?></th>
                                        <th><?php echo $this->lang->line('total_paid_earnings'); ?></th>                                
                                    </tr>  
                                </thead>  
                                <?php 
                                $total_event_referral_payment = $this->affiliate_model->get_total_event_referral_payment($url->id);
                                $unpaid_event_referral_payment = $this->affiliate_model->get_total_unpaid_event_referral_payment($url->id);
                                $revenue = ($total_event_referral_payment && !empty($total_event_referral_payment->total_paid_earning))? $total_event_referral_payment->total_paid_earning : '0.00';
                                $unpaid = ($unpaid_event_referral_payment && !empty($unpaid_event_referral_payment->total_paid_earning))? $unpaid_event_referral_payment->total_paid_earning : '0.00';
                                //echo ($url->id);
                                //var_dump($total_event_referral_payment);
                                ?>
                                <tbody>
                                    <tr>
                                        <td><?=$url->visits; ?></td>                                
                                        <td><?=($total_event_referral_payment && !empty($total_event_referral_payment->total_ticket_sold))? $total_event_referral_payment->total_ticket_sold : '0'; ?></td>
                                        <td><?=$this->general->price($revenue); ?></td>
                                        <td><?=$this->general->price($unpaid); ?></td>
                                        <td><?=$this->general->price(($revenue - $unpaid)); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--table for referral url details end-->
                        </li>
                    <?php endforeach;?>
                </ul>
                <?php } ?>
                        
            </div>
        </div>
        <!--referral urls end-->
        <?php }else{ ?>
        <div class="alert alert-error"><?php echo $this->lang->line('not_referral_member'); ?>.</div>
        <?php } ?>
    </div>
</div>
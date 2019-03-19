<!-- sub navigation bar start -->
<div class="col-md-2 left-sidebar">
    <ul>
        <li class="active"><a href="<?php echo site_url('affiliate/index');?>" class="upload"><span><?php echo $this->lang->line('referral_program'); ?></span></a></li>
        <li><a href="<?php echo site_url('affiliate/ea_program');?>" class="upload"><span><?php echo $this->lang->line('affiliate_program'); ?></span></a></li>
        <li><a href="<?php echo site_url('affiliate/payments');?>" class="upload"><span><?php echo $this->lang->line('payments'); ?></span></a></li>        
    </ul>
</div>
<!-- sub navigation bar end -->


<div class="col-md-10">    
    <div class="affiliate_program">
    	<h3><?php echo $this->lang->line('my_referral_urls'); ?><div class="right_menu_box pull-right"><button class="btn btn-xs btn-success" onclick="add_referral_url('<?=site_url(); ?>')"><?php echo $this->lang->line('create_referral_url'); ?></button></div></h3>
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
        <?php if($referral_member){ //check if user is affiilate memeber ?>
        <!--referral urls start-->
        <div class="box">
            <div class="box_content">
                <span id="add_referral_url_response"></span>
                       
                <ul class="for_info" id="referral_url_lists">
                <?php if($referral_urls){ ?>                 
                <script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#username=<?=$this->session->userdata(SESSION.'email'); ?>"></script>       
                    <?php foreach($referral_urls as $url): ?>
                        <?php 
                        $check_url_used = $this->affiliate_model->check_url_used($url->id); 
                        $affiliate_earning = $this->affiliate_model->get_affiliate_earning_by_urlid($url->id);
                        //$affiliate_earning_unpaid = $this->affiliate_model->get_affiliate_earning_unpaid_by_urlid($url->id);
                        $affiliate_earning_unpaid = $this->affiliate_model->get_affiliate_earning_unpaid_by_urlid_new($url->id);
                        ?>
                        <li id="url_block_<?=$url->id;?>">
                            <div class="url_list_block">
                                <strong><?=site_url('reff/'.$url->referral_url); ?></strong>
                                <label style="width: auto;">
                                    <!-- AddThis Button BEGIN -->
                                    <script type="text/javascript">
                                    var addthis_config = {
                                         pubid: "ra-51e850956b0d3a6e"
                                    }
                                    </script>
                                    
                                    <a class="addthis_button"
                                    	addthis:url="<?=site_url('reff/'.$url->referral_url); ?>"
                                    	addthis:title="<?=DEFAULT_PAGE_TITLE;?>"
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
                                    <?php /*
                                    <!--span onclick="edit_referral_url('<?=site_url(); ?>','<?=$url->id; ?>');">Edit</span--> &nbsp; 
                                    */ ?>
                                    <?php if(!$check_url_used){?> 
                                        <span onclick="remove_referral_url('<?=site_url(); ?>','<?=$url->id; ?>');"><?php echo $this->lang->line('remove'); ?></span>
                                    <?php } ?>
                                </label>
                            </div>
                            <!--table for referral url details start-->
                            <table class="table table-striped">
                                <thead>  
                                    <tr>  
                                        <th><?php echo $this->lang->line('page_views'); ?></th>  
                                        <th><?php echo $this->lang->line('total_register'); ?></th>  
                                        <th><?php echo $this->lang->line('total_paid_revenue'); ?></th>  
                                        <th><?php echo $this->lang->line('total_paid_earnings'); ?></th>  
                                        <th><?php echo $this->lang->line('unpaid_revenue'); ?></th>
                                        <th><?php echo $this->lang->line('unpaid_earning'); ?></th>
                                    </tr>  
                                </thead>  
                                <tbody>
                                    <tr>
                                        <td><?=$url->visits; ?></td>
                                        <td><?=$check_url_used;?></td>
                                        <td><?=($affiliate_earning->total_revenue)? $affiliate_earning->total_revenue : '0.00'; ?></td>
                                        <td><?=($affiliate_earning->total_earning)? $affiliate_earning->total_earning : '0.00'; ?></td>
                                        <td><?=($affiliate_earning_unpaid->total_unpaid_revenue)? $affiliate_earning_unpaid->total_unpaid_revenue : '0.00'; ?></td>
                                        <td><?=($affiliate_earning_unpaid->total_unpaid_earning)? $affiliate_earning_unpaid->total_unpaid_earning : '0.00'; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <!--table for referral url details end-->
                        </li>
                    <?php endforeach;?>
                <?php } ?>
                </ul>                  
            </div>
        </div>
        <!--referral urls end-->
        <?php }else{ ?>
        <div class="alert alert-error"><?php echo $this->lang->line('not_referral_member'); ?>.</div>
        <?php } ?>
    </div>
</div>
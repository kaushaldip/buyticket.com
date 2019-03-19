<div class="col-md-12">
    <div class="post-event2">
        <h1><?php echo $this->lang->line('affiliate_program'); ?></h1>
        <div class="box_content">
            <p>Event Organizer can promote their event through this system by assigning a specific percentage of the ticket price to be paid to affiliates upon ticket sales.</p>
        </div>
    </div>            
    <div class="box">
        <h3 class="navy_blue_head"><?php echo $this->lang->line('affiliated_even_list'); ?> </h3>
        <div class="box_content">
            <table class="table table-striped for_table">
                <tbody>
                    <tr>
                        <th><?php echo $this->lang->line('event_name'); ?></th>
                        <th><?php echo $this->lang->line('referral_fees'); ?></th>
                        <th></th>
                    </tr>
                    <?php if($affiliate_events){ ?>
                    <?php foreach($affiliate_events as $aff_event): ?>
                    <tr>
                        <td><?=$aff_event->title; ?></td>
                        <td><?=$aff_event->affiliate_referral_rate ; ?> %</td>
                        <td>
                        <?php if($this->session->userdata(SESSION.'user_id')){?>
                            <?php $joined = $this->affiliate_model->check_joined_event_affiliate($aff_event->id); ?>
                            <?php if(!$joined){ ?>
                                <span id="join_a_event_<?=$aff_event->id; ?>"><a href="javascript:void(0);" onclick="join_affiliate_event('<?=site_url();?>','<?=$aff_event->id; ?>','<?=$aff_event->organizer_id; ?>','<?=$aff_event->affiliate_referral_rate ; ?>')" class="button btn btn-xs btn-warning"><?php echo $this->lang->line('join'); ?></a></span>
                            <?php }else{ ?>
                                <?=site_url("e/$joined");?>
                                <a href="<?=site_url('affiliate/ea_program'); ?>"><?=$this->lang->line('view_detail')?></a>
                            <?php } ?>
                        <?php }else{ ?>
                            <span><a href="<?=site_url('affiliate/register');?>" class="button"><?php echo $this->lang->line('join'); ?></a></span>
                        <?php } ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php }else{?>
                    <tr>
                        <td colspan="3"><?php echo $this->lang->line('no_affiliate_event'); ?>.</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
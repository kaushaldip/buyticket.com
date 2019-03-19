<style>
.refund_block{ background: #f4eca3; }
h5.for_h5 nobr a{color: #fff; text-decoration: none;}
</style>
<div class="row-fluid view_order_ticket">
	<div class="span"> 
        <div class="box">
            <div class="box_content" style="position: relative;">
                <legend class="for_legend ticket-title">
                    <?=$this->lang->line('order_for'); ?> <br /><a href="<?=site_url('event/view/'.$event->event_id) ?>" target="_blank"><?=ucwords($event->title); ?></a>
                    <span class="linker_tager pull-right">
                    <a class="btn btn-info " onclick="showURLInModal(this,'<?=site_url("myticket/refund_policy/".$event_id)?>')" title="<?=$this->lang->line('refund_policy'); ?>" href="javascript:void(0);" ><?=$this->lang->line('refund_policy'); ?></a>
                    <button href='#contact123456' role="button" class="btn" data-toggle="modal"><i class="icon-inbox"></i> <?php echo $this->lang->line('contact_host'); ?></button>                    
                    </span>
                    <div class="clearfix"></div>
                </legend>                
                <div class="row-fluid">
                    <p class="for_date_order"><?=$event->date_time_detail; ?></p>
					<p class="for_date_order"><?=$this->lang->line('order'); ?> #<span><?=$event->order_id ?></span></p>                    
                    <?php foreach($orders as $order): ?>
                        <?php 
                        if($order->ticket_quantity < 1) {
                            $this->db->where('id', $order->id);
                            $this->db->delete('event_ticket_order');
                            continue;                            
                        }
                        ?>
                        <h5 class="for_h5">
                        <?=$this->event_model->get_ticket_name_from_id($order->ticket_id); ?> 
                        <nobr>
                        <?php if($order->create_ticket=='yes'){?>
                            <a class="ajax" href="<?=site_url('event/show_attendees/'.$order->id)?>">(Quantity: <?=$order->ticket_quantity; ?>)</a>
                        <?php }else{?>
                            (Quantity: <?=$order->ticket_quantity; ?>)
                        <?php } ?>
                        </nobr>
                        <span class="float_righter pull-right confirm-pay" id="menu_print<?=$order->id;?>">
                        <?php if($order->refund_complete=='no' and $order->refund_id > 0){?>
                            <button class="btn btn-mini btn-info " style="cursor: default;" ><?=$this->lang->line('wait_for_refund')?></button>
                        <?php }else{ ?>
                            <?php if($order->create_ticket=='yes' and strtolower($order->payment_status) == "complete"){ ?>                        
                                <button class="btn btn-mini btn-success" onclick="printTicket('<?=site_url();?>','<?=$order->id ?>')"><i class="icon-print icon-white"></i> <?php echo $this->lang->line('print_ticket'); ?></button>                            
                                <button class="btn btn-mini btn-danger" onclick="cancelOrder('<?=site_url();?>','<?=$order->id ?>','<?=$order->ticket_quantity; ?>','<?=$order->ticket_id; ?>');"><i class="icon-trash icon-white"></i> <?php echo $this->lang->line('cancel_order'); ?></button>
                                <button class="btn btn-mini btn-danger" onclick="pdfgen('<?=site_url();?>','<?=$order->id ?>');">&nbsp;<i class="icon-download-alt icon-white"></i>&nbsp;</button>                 
                            <?php }else if(strtolower($order->payment_status)=='complete'){ ?>
                                <button class="btn btn-mini btn-success" onclick="getmyticket('<?=site_url();?>','<?=$order->id ?>');" ><?php echo $this->lang->line('get_ticket'); ?></button>
                            <?php } else if($order->ticket_type == 'paid'){ ?>
                                <?php if(strtoupper($order->transaction_method) == 'BANK'){?>
                                    <?php if(strtolower($order->bank_transaction_status) == 'yes'){?>
                                        <button class="btn btn-mini btn-warning " style="cursor: default;" ><?=$this->lang->line('payment_pending'); ?></button>
                                    <?php }else{ ?>
                                        <a task="showURLInModal(this,'<?=site_url('event/bank/'.$order->bank_transaction_id.'/'.$order->order_id)?>');" title="Cljl" href="<?=site_url('event/bank/'.$order->bank_transaction_id.'/'.$order->order_id)?>" class="btn btn-mini btn-warning" ><?=$this->lang->line('confirm_payment'); ?></a>    
                                    <?php } ?>
                                <?php }else{?>
                                    <button class="btn btn-mini btn-warning " style="cursor: default;" >Payment <?=$order->payment_status; ?></button>
                                <?php }?>
                            <?php } else if($order->ticket_type == 'free' and $order->create_ticket=='yes'){ ?>
                                <button class="btn btn-mini btn-success" onclick="printTicket('<?=site_url();?>','<?=$order->id ?>')"><i class="icon-print icon-white"></i> <?php echo $this->lang->line('print_ticket'); ?></button>                            
                                <button class="btn btn-mini btn-danger" onclick="cancelOrder('<?=site_url();?>','<?=$order->id ?>','<?=$order->ticket_quantity; ?>','<?=$order->ticket_id; ?>');"><i class="icon-trash icon-white"></i> <?php echo $this->lang->line('cancel_order'); ?></button>
                                <button class="btn btn-mini btn-danger" onclick="pdfgen('<?=site_url();?>','<?=$order->id ?>');">&nbsp;<i class="icon-download-alt icon-white"></i>&nbsp;</button> 
                            <?php } ?>    
                        <?php } ?>
                        </span>
                        </h5> 
                        <div id="refund_block<?=$order->id ?>" class="refund_block"></div>                       
                    <?php endforeach; ?>
                    
                    <div class="form-horizontal form-description">
                        <legend><?php echo $this->lang->line('contact_information'); ?>:</legend>
                        <div class="control-group">
                            <label class="control-label"><?php echo $this->lang->line('first_name'); ?>:</label>
                            <div class="controls"><?=$this->session->userdata(SESSION.'first_name') ;?></div>                                
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo $this->lang->line('last_name'); ?>:</label>
                            <div class="controls"><?=$this->session->userdata(SESSION.'last_name') ;?></div>                                
                        </div>
                        <div class="control-group">
                            <label class="control-label"><?php echo $this->lang->line('email_address'); ?>:</label>
                            <div class="controls"><?=$this->session->userdata(SESSION.'email') ;?></div>                                
                        </div>
                        <?php /* 
                        <!--for including paid ticket start-->
                        <?php if(!empty($contact->order_form_detail)){ ?>
                            <?php $ofd = json_decode($contact->order_form_detail); ?>
                            
                            <legend><?php echo $this->lang->line('account_information'); ?></legend>
                            <?php $arr_useless = array('email_login','password_login','complete_order_pb'); ?>
                            <?php foreach($ofd as $key=>$val):?>
                            <?php if(in_array($key, $arr_useless)){
                                    continue;
                                  }
                            ?>
                            <div class="control-group">
                                <label class="control-label"><?php echo $this->lang->line($key); ?>: <?//=$key; ?></label>
                                <div class="controls"><?=$val; ?></div>     
                            </div>
                            <?php endforeach; ?>                        
                        <?php } ?>                            
                        <!--for including paid ticket end-->
                        */?>
                        <!--bank details start-->
                        <?php if($contact->bank_transaction_id != 0){ ?>
                            <?php 
                            $bank_info = $this->event_payment_model->get_bank_details($contact->bank_transaction_id);
                            if($bank_info){ 
                            ?>
                            <div class="form-horizontal form-description">
                                <legend><?php echo $this->lang->line('payment_made_from'); ?></legend>
                                <div class="control-group">
                                    <label class="control-label"><?php echo $this->lang->line('bank_name'); ?>:</label>
                                    <div class="controls"><?=$bank_info->bank_name_from; ?></div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"><?php echo $this->lang->line('account_holder_name'); ?>:</label>
                                    <div class="controls"><?=$bank_info->account_holder_name; ?></div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"><?php echo $this->lang->line('amount'); ?>:</label>
                                    <div class="controls"><?=$this->general->price($bank_info->amount); ?></div>
                                </div>                                
                                <div class="control-group">
                                    <label class="control-label"><?php echo $this->lang->line('payment_made_to'); ?>:</label>
                                    <div class="controls"><?=$bank_info->bank_name_to; ?></div>
                                </div>
                            </div>
                            <?php }?>
                        <?php }?>
                        <!--bank details end-->
                        
                        <!--paypal details start-->  
                        <?php if($contact->paypal_info_id != 0){?>
                            <?php 
                            $paypal_info = $this->event_payment_model->get_paypal_details($contact->paypal_info_id);
                            if($paypal_info){ 
                            ?>
                            <div class="form-horizontal form-description">
                                <legend><?php echo $this->lang->line('paypal_information'); ?>:</legend>
                                
                                <div class="control-group">
                                    <label class="control-label"><?php echo $this->lang->line('token'); ?>:</label>
                                    <div class="controls"><?=$paypal_info->token; ?></div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"><?php echo $this->lang->line('payid'); ?>:</label>
                                    <div class="controls"><?=$paypal_info->payid; ?></div>
                                </div>                                
                                <div class="control-group">
                                    <label class="control-label"><?php echo $this->lang->line('paypal_email'); ?>:</label>
                                    <div class="controls"><?=$paypal_info->email; ?></div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"><?php echo $this->lang->line('checkoutstatus'); ?>:</label>
                                    <div class="controls"><?=$paypal_info->checkoutstatus; ?></div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"><?php echo $this->lang->line('paypal_timestamp'); ?>:</label>
                                    <div class="controls"><?=$paypal_info->timestamp; ?></div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"><?php echo $this->lang->line('ack'); ?>:</label>
                                    <div class="controls"><?=$paypal_info->ack; ?></div>
                                </div>
                                <div class="control-group">                             
                                    <label class="control-label"><?php echo $this->lang->line('amount'); ?>:</label>
                                    <div class="controls"><?=$paypal_info->currencycode." ".$paypal_info->amount; ?></div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"><?php echo $this->lang->line('feeamt'); ?>:</label>
                                    <div class="controls"><?=$paypal_info->currencycode." ".$paypal_info->feeamt; ?></div>
                                </div>
                            </div>
                            <?php } ?>    
                        <?php } ?>
                        <!--paypal details end-->             
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- contact host Modal start-->
<div id="contact123456" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Contact organizer</h3>
            </div>
            <form id="form_contact_organizer" action="" method="post" name="contactForm" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">  
                        <div class="col-md-12">    
                            <p id="error_messages" class="error_inline"></p>
                            <span class="required_field required_field_hint"><?php echo $this->lang->line('required'); ?>*</span>
                            <span class="error_inline hide_me"><?php echo $this->lang->line('missing_information'); ?>.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4"><?php echo $this->lang->line('your_name'); ?>: <span class="required_field">*</span></label>
                        <div class="col-md-8">
                            <input type="text" id="contact_name" name="from_name" value="<?=$contact->first_name." ".$contact->last_name ?>" class="required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4"><?php echo $this->lang->line('your')." ".$this->lang->line('email_address'); ?>: <span class="required_field">*</span></label>
                        <div class="col-md-8">
                            <input type="text" id="contact_email" name="from_email" value="<?=$contact->email;?>" class="required email"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4"><?php echo $this->lang->line('send_message'); ?>: <span class="required_field">*</span></label>
                        <div class="col-md-8">
                            <textarea id="contact_message" name="message" class="required"></textarea>
                        </div>
                    </div>           
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="user_organiser" name="user_organiser" value="<?=$this->myticket_model->get_organizer_id_from_event_id($contact->event_id); ?>" />
                    <input type="hidden" id="form_contact_organizer_hidden" name="contact_organizer_submit" value="1"/>
                    <input type="submit" class="btn btn-success" name="submit" id="searchsubmit" value="<?=$this->lang->line('send_msg')?>"/>
                    <button class="btn" data-dismiss="modal" aria-hidden="true"><?=$this->lang->line('cancel')?></button>
                    
                    <?php /*<script src="http://malsup.github.com/jquery.form.js"></script> */?>
                    <script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>malsup.jquery.form.js"></script>  
                    <script>       
                    $("#form_contact_organizer").validate({
                        submitHandler: function(form) {
                            loaderOn(); 
                            $(form).ajaxSubmit({
                                beforeSend: function(){
                                     
                                },
                                url:"<?php echo site_url('organizer/send_contact_email'); ?>",
                                type:"GET",
                                success: function(r){                                    
                                    $('.modal-body').find("input[type=text], textarea").val("");
                                    $('#contact123456').modal('hide');                                    
                                    $('#searchsubmit').attr('value', '<?=$this->lang->line('send_msg')?>');
                                    if(r == ""){
                                        $("#mainModal #mainModalLabel").html("Success");
                                        $("#mainModal #mainModalBody").html("Message sent successfully.");    
                                    }else{
                                        $("#mainModal #mainModalLabel").html("Error");
                                        $("#mainModal #mainModalBody").html("Somethign went wrong. Please try later.");
                                    }                                    
                                    $("#mainModal").modal("show");
                                    loaderOff();
                                },
                                beforeSend:function(){
                                    $('#searchsubmit').attr('value', 'Please wait..');
                                }
                            });            
                            return false;
                        }
                    });
                    </script>        
                </div>
            </form>
        </div>
    </div>
</div>
<!-- contact host Modal end-->
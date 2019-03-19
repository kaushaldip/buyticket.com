<div class="row">
    <div class="col-md-3 col-sm-12">
        <!-- location block start -->
        <?php if(!empty($data_event->address)){ ?>
    	<div class="location-map">
        	<h3 class="no-margin-top"><?=$this->lang->line('where')?></h3>
            <div class="map-name">  
                <p><strong><?=ucwords($data_event->physical_name);?></strong></p>                    
                <p><?=$data_event->address;?></p>
            </div>
        </div>
        <?php }else if(!empty($data_event->physical_name)){ ?>
        <div class="location-map">
        	<h3 class="no-margin-top"><?=$this->lang->line('physical_address')?></h3>
            <div class="map-name">  
                <p><strong><?=ucwords($data_event->physical_name);?></strong></p>
            </div>
        </div>
        <?php } ?>
        <!-- location block end -->
        <!-- performer block start -->
        <?php if($performers){ $i=1; ?>
        <div class="search-event-small">
        	<h3 class="h3-lower"><?php echo $this->lang->line('performers_detail');?></h3>
            <div class="box_content">
            <?php foreach($performers as $performer): ?>                            
            	<div class="performers-detail">
                	<span><?=$this->event_model->get_performer_name_from_id($performer->performer_type);?>:</span><?php echo ucwords($performer->performer_name); ?>                    
                    <?php if($performer->performer_description!=''){ ?>
                    <a onclick="$('#performer_description<?=$i;?>').toggle();" style="text-decoration: none; cursor: pointer;"><?php echo $this->lang->line('view_detail'); ?></a>
                    <p id="performer_description<?=$i;?>" style="display: none;"><?php echo ucfirst($performer->performer_description); ?></p>
                    <?php } ?>
                </div>                          
            <?php $i++; endforeach; ?>
            </div>
        </div>        
        <?php } ?>
        <!-- performer block end -->
        
        <!-- organizers block start -->
        <?php if($organizers){ ?>
        <div class="search-event-small">
        	<h3 class="h3-lower"><?php echo $this->lang->line('organizers_information'); ?></h3>
            <div class="box_content">
            <?php foreach($organizers as $organizer): ?>
                <?php               
                $organizer_image = UPLOAD_FILE_PATH."organizer/thumb_".$organizer->logo;
                $organizer_logo = (file_exists($organizer_image))? $organizer_image: UPLOAD_FILE_PATH.'event_logo_169_136.png';
                ?>
                <div class="performers-detail">
                    <span class="organizer_logo"><img src="<?=base_url().$organizer_logo; ?>" title="<?php echo $organizer->name; ?>" /></span>
                    <span class="organizer-detail">
                        <p><?php echo ucwords($organizer->name); ?></p>                    
                        <strong><a href="<?=site_url('organizer/view/'.$organizer->organizer_id)?>" target="_blank"><?php echo $this->lang->line('organizer_profile'); ?></a></strong>
                    </span>
                </div>           	
            <?php endforeach; ?>                
            </div>
        </div>
        <?php } ?>
        <!-- organizers block end -->
    </div>
    <div class="col-md-9 col-sm-12">
        <div>
            <!--error block start -->
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
            <div class="clearfix"></div>
            <!--error block end -->
            <div class="col-md-8">
                <h2 class="detail-title2"><?=ucwords($data_event->title);?></h1>
                <h4>
                <?php if($data_event->date_id =='0'){ ?>            
                    <strong><?=(strtolower($data_event->frequency)=='never')? "":$data_event->frequency." Event -"; ?></strong>
                    <strong><?php echo $this->lang->line('from'); ?></strong> <?=$this->general->date_language(date('l, F j, Y  g:i A',strtotime($data_event->start_date))); ?> <strong><?php echo $this->lang->line('to'); ?></strong> <?php echo str_replace('(AST)',$this->lang->line('KSA'),$this->general->date_language(date('l, F j, Y  g:i A (T)',strtotime($data_event->end_date)))); ?>
                <?php }else{ ?>        
                    <?php echo str_replace('(AST)',$this->lang->line('KSA'),$this->general->date_language($data_event->date_time_detail)); ?>             
                <?php } ?>
                </h4>
                <h4><?php echo $data_event->physical_name; ?></h4>
            </div>
            <div class="col-md-4">
                <?php 
                $logo_image = UPLOAD_FILE_PATH."event/".$data_event->logo;
                $logo = (file_exists($logo_image))? $logo_image: UPLOAD_FILE_PATH.'event_logo_269_123.png';
                ?>
            	<img style="width: 100%;" class="event_logo" src="<?=base_url().$logo;  ?>" title="<?=$data_event->title; ?>" /> 
            </div>
            <div class="clearfix"></div>
            <div class="detail-sections">
                <form id="event_order_paid" class="form-horizontal" method="post" action=""> 	
                    <!-- order summary start -->
                    <div class="box">
                    	<h3 class="ticket_header"><?=$this->lang->line('order_summary') ?></h3>
                        <div class="box_content">
                            <?php                
                            if($data_event->date_id !='0')
                                $date_attendings = explode(',',$order->date_time);
                            ?>
                            <div class="description date_attending">                                
                                <strong><?=$this->lang->line('date_attending') ?>:</strong>                    
                                <?php if($data_event->date_id =='0'){ echo date('M j, Y \a\t g:i A ',strtotime($data_event->start_date)) ; }else { echo date('M j, Y \a\t g:i A ',strtotime($date_attendings[0])) ;}?>
                                <?php echo $this->lang->line('to');?> 
                                <?php if($data_event->date_id =='0'){ echo date('M j, Y \a\t g:i A ',strtotime($data_event->end_date)) ; }else { echo date('M j, Y \a\t g:i A ',strtotime($date_attendings[1])) ;}?>
                            </div>
                        	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table_rows_add table table-striped">
                                <tr>                            
                                    <th><?=$this->lang->line('type') ?></th> 
                                    <th><?=$this->lang->line('price') ?></th>
                                    <th><?=$this->lang->line('fee') ?></th>                       
                                    <th><?=$this->lang->line('quantity') ?></th>
                                    <th><?=$this->lang->line('total') ?></th>
                                </tr>
                                <?php
                                $tickets_no = explode(',',$order->ticket_quantity);                     
                                $tickets_id = explode(',',$order->ticket_id);
                                
                                $grand_total = 0;
                                $total_discount = 0;
                                $discount = 0;
                                $discount_per = 0;
                                if($order->promotion_code_id != 0)
                                {
                                    $discount_per = $order->discount;
                                }
                                foreach($tickets_no as $key=>$ticket):
                                    if($ticket=='')
                                        continue;
                                    $ticket_detail = $this->event_model->get_ticket_detail_from_id($tickets_id[$key]);
                                    //$discount =  number_format(($ticket_detail->ticket_price - $ticket_detail->website_fee)* $ticket * $discount_per / 100, 2, '.', '');
                                    $discount =  number_format(($ticket_detail->ticket_price - $ticket_detail->website_fee)* $ticket * $discount_per / 100, 2, '.', '');
                                    ?>
                                    <tr>                        
                                        <td><?=ucwords($ticket_detail->name); ?></td>
                                        <td><?=$this->general->price($ticket_detail->price); ?></td>
                                        <td><?=($ticket_detail->web_fee_include_in_ticket == '1')? $this->general->price('0'): $this->general->price($ticket_detail->website_fee); ?></td>
                                        <td><?=$ticket; ?></td>
                                        <td><?=$this->general->price($ticket_detail->ticket_price * $ticket); ?></td>
                                    </tr>
                                    
                                    <?php 
                                    $grand_total += (($ticket_detail->ticket_price) * $ticket); 
                                    $symbol = $ticket_detail->symbol;
                                    $total_discount += $discount;
                                    ?>
                                <?php endforeach;?> 
                                <?php if($order->promotion_code_id != 0){ ?>
                                <tr>                       
                                    <th colspan="4" align="right"><?=$this->lang->line('amount_total') ?></th>
                                    <th><?=$this->general->price($grand_total); ?></th>
                                </tr>
                                <tr>                       
                                    <th colspan="2" align="right"><?=$this->lang->line('discount_allowed') ?></th>
                                    <th colspan="2"><?=$order->discount." %"; ?></th>
                                    <th><?='- '.$this->general->price($total_discount); ?></th>
                                </tr>
                                <tr>                       
                                    <th colspan="4" align="right"><?=$this->lang->line('total_amount_due') ?></th>
                                    <th><?=$this->general->price($grand_total - $total_discount); ?></th>
                                </tr>
                                <?php }else{?>
                                <tr>                       
                                    <th colspan="4" align="right"><?=$this->lang->line('total_amount_due') ?></th>
                                    <th><?=$this->general->price($grand_total) ?></th>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <th colspan="4">&nbsp;</th>
                                    <th><a href="javascript:void(0);" onclick="showRefundPolicyOfEvent('<?=$order->event_id?>')" ><?=$this->lang->line('refund_policy')?></a></th>
                                </tr>
                            </table>                
                        </div>
                    </div>
                    <!-- order summary end -->
                    
                    <!--timer holder start-->
                    <div class="timer_holder">
                        <?//=var_dump($order->timestamp); ?>
                        <br clear="all" /><br />
                        <div class="alert alert-warning">           
                            <div style="font-size: 54px; line-height: 54px;" id="time_left"></div>
                            <p>
                            <?=$this->lang->line('time_left_message')?>
                            </p>
                        </div>
            
                        <script type="text/javascript">
                        
                        	var timeLimit = 1200;
                        	var timeLeft  = 1200;
                        
                            var cnt = 1000;
                            
                        	var now1 = new Date(); 
                            var phpnow = "<?=strtotime($this->general->get_local_time('time'));?>"*1000;
                            var nows = new Date(phpnow);
                                
                        	//var endTime1 = new Date(now.getTime() + timeLeft*1000);
                            var timeer = "<?=strtotime($order->current_date)?>"*1000;
                            var endTime = new Date(timeer + timeLeft*1000);
                            
                            //alert(nows + '=' +endTime);
                            
                        	function displayTime(field, numSeconds) {
                        	    //console.log(numSeconds);
                        		timeMinutes = parseInt(numSeconds / 60);
                        		timeSeconds = parseInt(numSeconds - timeMinutes*60);
                        		if (timeSeconds < 10)
                        			timeLabel   = timeMinutes + ":0" + timeSeconds + " ";
                        		else
                        			timeLabel   = timeMinutes + ":" + timeSeconds + " ";
                        
                        		document.getElementById(field).innerHTML = timeLabel;
                        	}
                        
                        	displayTime("time_limit", timeLimit);
                        	displayTime("time_limit2", timeLimit);
                        	displayTime("time_left", timeLeft);
                        
                            var gUpdateCountdownTimeoutId = null; //This global variable is a hack for #7215. Sorry
                        
                        	function updateCountdown() {                       
                                cnt +=1000;
                        		var now1 = new Date(); 
                                var phpnow = "<?=strtotime($this->general->get_local_time('time'));?>" *1000 + cnt ;
                                var nows = new Date(phpnow);
                                //console.log(endTime);
                                //console.log(nows);	
                                
                                
                        		if (nows < endTime) {
                        			displayTime("time_left", (endTime - nows)/1000);
                        			gUpdateCountdownTimeoutId = window.setTimeout("updateCountdown();", 1000);
                        		} else {
                                    alert("You have exceed the time limit of 20mins. You may not proceed further using current information. Please try again for new registration. You will be redirected to the event page right now.");
                        			//display_error_msg("alert", "exceeded", "register");
                                    redirect_to_event_page("<?=site_url();?>","<?=$order->event_id;?>",'<?=$this->uri->segment(count($this->uri->segment_array())) ?>');
                        		}
                        	}
                            function redirect_to_event_page(site_url,event_id, temp_id)
                            {
                                //alert(site_url);
                                $.post(site_url+'/event/order_cancel',
                                {event_id:event_id,temp_id:temp_id},
                                function(data)
                                {
                                    window.location.replace(site_url+"/event/view/"+event_id); 
                                });
                            }
                        	gUpdateCountdownTimeoutId = window.setTimeout("updateCountdown();", 1000);
                        </script>            
                    </div>
                    <!--timer holder end-->
                    
                    <div class="box">
                        <h3><?=$this->lang->line('registration_information'); ?></h3>
                        
                        <div class="box-content-new">  
                            <div class="form-group">
                                
                                <?php 
                                $user_ses_id = $this->session->userdata(SESSION."user_id");
                                if($user_ses_id){                        
                                    $user = $this->account_module->get_user_profile_data(); 
                                    //var_dump($user);exit;
                                    if(!$user)
                                    {
                                        $this->session->set_flashdata('message', 'Confirm email first to access your account. Please check your email.');
                                        redirect(site_url('event'));    
                                    }
                                        
                                    //echo "<div class=\"controls\" style=\"float: right;\">Hi, <strong>".$user->email."</strong>. Not you? <a href=\"javascript:void(0);\" onclick=\"logoutajax('".site_url()."');\">Sign out</a></div>"; 
                                    echo "<div class=\"controls\" style=\"float: right;\">".$this->lang->line('hi').", <strong>".$this->session->userdata(SESSION."email")."</strong>. ".$this->lang->line('not_you')." <a href=\"javascript:void(0);\" onclick=\"logoutajax('".site_url()."');\">".$this->lang->line('logout')."</a></div>";   
                                }else{?>
                                    <div class="controls" style="float: right;" id="login_result">
                                        <?=$this->lang->line('do_have_account')?> <a href="javascript:void(0);" onclick="$('#login_box_hidden').show();$(this).parent().hide();"><?=$this->lang->line('signin_account') ?></a>
                                    </div>
                                    <br clear="all" />
                                    <div class="" id="login_box_hidden" style="display: none;">
                                        <div id="load_error"></div>
                                        <div id="email_empty_err_msg" style="display: none;"><?=$this->lang->line('email_empty_err_msg');?></div>
                                        <div class="form-group">
                                            <label class="form-label"><?=$this->lang->line('email_address') ?>:</label>
                                            <div class="controls"><input type="text" name="email_login" id="email_login" class="required input-large"   /></div>                                
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label"><?=$this->lang->line('password') ?>:</label>
                                            <div class="controls"><input type="password" name="password_login" id="password_login" class="required input-large"  /></div>                                
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">&nbsp;</label>
                                            <input type="button" class="btn" onclick="loginajax('<?=site_url();?>');" value="<?=$this->lang->line('login');?>" />
                                            <em><?=$this->lang->line('loggin_optional');?></em>
                                        </div>
                                    </div>
                                <?php
                                }   
                                if (!empty($selected_question->order_form_details)) {
                                    $s=1;
                                    $arr=json_decode($selected_question->order_form_details);
                                }
                                else {
                                    $s=2;
                                }
                                ?>
                           
                            </div>
                            <legend><?=$this->lang->line('ticket_buyer'); ?></legend>
                            <div class="form-group">
                                <label class="form-label"><?=$this->lang->line('email_address');?>: *</label>
                                <div class="controls">
                                    <input class="input-large required" type="text" name="email" value="<?=($user_ses_id)? $user->email: set_value('email');?>" title="<?=$this->lang->line('required')?>"/>
                                    <?=form_error('email') ?>
                                </div>
                            </div>
                            <?php if(!$user_ses_id){ ?>                
                            <div class="form-group">
                                <label class="form-label"><?=$this->lang->line('password');?>: *</label>
                                <div class="controls">
                                    <input class="input-large  <?php if(isset ($arr->home_number_required)) echo "required" ?> " id="passowrd_reg" type="password" name="password" value="" title="<?=$this->lang->line('required')?>"/>
                                    <?=form_error('password') ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><?=$this->lang->line('re_password');?>: *</label>
                                <div class="controls">
                                    <input class="input-large  <?php if(isset ($arr->home_number_required)) echo "required" ?> " equalTo='#passowrd_reg' type="password" name="re_password" value="" title="<?=$this->lang->line('required')?>"/>
                                    <?=form_error('re_password') ?>
                                </div>
                            </div>
                            <?php } ?>
                            
                            <?php foreach($tickets_no as $key=>$ticket): ?>
                                <?php if($ticket=='') continue;?>
                                <?php for($i=1 ; $i <=$ticket; $i++){ ?>
                                <!--ticket buyer information start-->
                                <?php $ticket_id = trim($tickets_id[$key]); $tic_id = "a".$ticket_id; ?>
                                <legend><?="#".$i;?> <?=ucwords($this->general->get_value_from_id('es_event_ticket',$ticket_id,'name')); //echo $this->lang->line('add_ticket_name_here')?></legend>
                                <!------------------------>
                                <h5><?=$this->lang->line('contact_information'); ?></h5>
                                <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('first_name');?>: *</label>
                                    <div class="controls">
                                        <input class="input-large required" type="text" name="<?=$tic_id;?>[first_name<?=$i?>]" value="<?=($user_ses_id)? $user->first_name: $this->input->post($tic_id."[first_name$i]");?>" title="<?=$this->lang->line('required')?>" />
                                        <?=form_error($tic_id['first_name'.$i]) ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('last_name');?>: *</label>
                                    <div class="controls">
                                        <input class="input-large required" type="text" name="<?=$tic_id;?>[last_name<?=$i?>]" value="<?=($user_ses_id)? $user->last_name: $this->input->post($tic_id."[last_name$i]");?>" title="<?=$this->lang->line('required')?>"/>
                                        <?=form_error($tic_id['last_name'.$i]) ?>
                                    </div>
                                </div>                
                                <?php if($s==1): 
                                     if(isset ($arr->home_number) || isset ($arr->home_number_required)){
                                    ?>
                                 <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('home_number');?>: <?php if(isset ($arr->home_number_required)) echo "*" ?></label>
                                    <div class="controls">
                                        <input class="input-large <?php if(isset ($arr->home_number_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[home_number<?=$i?>]" value="<?=($user_ses_id)? $user->home_number: $this->input->post($tic_id."[home_number$i]");?>" title="<?=$this->lang->line('required')?>"/>
                                        
                                    </div>
                                </div>
                                <?php }  if(isset ($arr->mobile_number)||isset ($arr->mobile_number_required)){?>
                                 <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('mobile_number');?>: <?php if(isset ($arr->mobile_number_required)) echo "*" ?></label>
                                    <div class="controls">
                                        <input class="input-large <?php if(isset ($arr->mobile_number_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[mobile_number<?=$i?>]" value="<?=($user_ses_id)? $user->mobile_number: $this->input->post($tic_id."[mobile_number$i]");?>" title="<?=$this->lang->line('required')?>"/>
                                        
                                    </div>
                                </div>
                                <?php } endif; ?>
                                
                                <!--ticket buyer information end-->
                                 <?php if($s==1): ?>
                                <!--billing information start-->   
                                <?php if((isset ($arr->country)||isset ($arr->country_required)) || (isset ($arr->address)||isset($arr->address_required)) || (isset ($arr->address1)||isset ($arr->address1_required)) || (isset ($arr->street)||isset ($arr->street_required)) || (isset ($arr->city)||isset ($arr->city_required)) || (isset ($arr->state)||isset ($arr->state_required)) || (isset ($arr->zip)||isset ($arr->zip_required)) ){?>     
                                <h5><?=$this->lang->line('biling_information');?></h5>
                                <?php } ?>
                                <?php  if(isset ($arr->country)||isset ($arr->country_required)){?>
                                <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('country');?>: <?php if(isset ($arr->country_required)) echo "*" ?></label>
                                    <div class="controls">
                                        <select class="input-large  <?php if(isset ($arr->country_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[billing_country<?=$i?>]" title="<?=$this->lang->line('required')?>">
                                            <option value="" ><?=$this->lang->line('select_option');?></option>
                                            <?php $countries = $this->general->get_country();?>
                                            <?php foreach($countries as $country): ?>
                                                <option value="<?=$country->country?>" <?= (strtolower($country->country)==strtolower($profile_data->country))? "selected='selected'" : '';?> ><?=$country->country?></option>
                                                
                                            <?php endforeach;?>
                                        </select>
                                        <?php /*
                                        <input class="input-large  <?php if(isset ($arr->country_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[billing_country<?=$i?>]" value="<?=($user_ses_id)? $user->country: $this->input->post($tic_id."[billing_country$i]");?>" title="<?=$this->lang->line('required')?>"/>
                                        */?>
                                        <?=form_error($tic_id['billing_country'.$i]) ?>
                                    </div>
                                </div>
                                <?php } ?>
                                 <?php  if(isset ($arr->address)||isset($arr->address_required)){?>
                                <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('address');?>: <?php if(isset ($arr->address_required)) echo "*" ?></label>
                                    <div class="controls">
                                        <input class="input-large  <?php if(isset ($arr->address_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[billing_address<?=$i?>]" value="<?=($user_ses_id)? $user->address: $this->input->post($tic_id."[billing_address$i]");?>" title="<?=$this->lang->line('required')?>"/>
                                        <?=form_error($tic_id['billing_address'.$i]); ?>
                                    </div>
                                </div>  
                                 <?php } ?>
                                 <?php  if(isset ($arr->address1)||isset ($arr->address1_required)){?>
                                <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('address');?>2: <?php if(isset($arr->address1_required)) echo "*" ?></label>
                                    <div class="controls">
                                        <input class="input-large  <?php if(isset($arr->address1_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[billing_address2<?=$i?>]" value="<?=($user_ses_id)? $user->address1: $this->input->post($tic_id."[billing_address2$i]");?>"  title="<?=$this->lang->line('required') ?>"/>
                                        <?=form_error($tic_id['billing_address2'.$i]) ?>
                                    </div>
                                </div><?php } ?>
                                 <?php  if(isset ($arr->street)||isset ($arr->street_required)){?>
                                <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('street');?>: <?php if(isset($arr->street_required)) echo "*" ?></label>
                                    <div class="controls">
                                        <input class="input-large  <?php if(isset($arr->street_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[street_address<?=$i?>]" value="<?=($user_ses_id)? $user->street: $this->input->post($tic_id."[street_address$i]");?>" title="<?=$this->lang->line('required')?>"/>
                                        <?=form_error($tic_id['street_address'.$i]) ?>
                                    </div>
                                </div> <?php } ?>
                                 <?php  if(isset ($arr->city)||isset ($arr->city_required)){?>
                                <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('city');?>: <?php if(isset ($arr->city_required)) echo "*" ?></label>
                                    <div class="controls">
                                        <input class="input-large  <?php if(isset ($arr->city_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[billing_city<?=$i?>]" value="<?=($user_ses_id)? $user->city: $this->input->post($tic_id."[billing_city$i]");?>" title="<?=$this->lang->line('required')?>"/>
                                        <?=form_error($tic_id['billing_city'.$i]) ?>
                                    </div>
                                </div><?php } ?>
                                 <?php  if(isset ($arr->state)||isset ($arr->state_required)){?>
                                <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('state');?>: <?php if(isset ($arr->state_required)) echo "*" ?></label>
                                    <div class="controls">
                                        <input class="input-large  <?php if(isset ($arr->state_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[billing_state<?=$i?>]" value="<?=($user_ses_id)? $user->state: $this->input->post($tic_id."[billing_state$i]");?>" />
                                        <?=form_error($tic_id['billing_state'.$i]) ?>
                                    </div>
                                </div>
                                <?php } ?>
                                 <?php  if(isset ($arr->zip)||isset ($arr->zip_required)){?>
                                <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('postal_code');?>: <?php if(isset ($arr->zip_required)) echo "*" ?></label>
                                    <div class="controls">
                                        <input class="input-large  <?php if(isset ($arr->zip_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[billing_postal_code<?=$i?>]" value="<?=($user_ses_id)? $user->zip: $this->input->post($tic_id."[billing_postal_code$i]");?>" title="<?=$this->lang->line('required')?>"/>
                                        <?=form_error($tic_id['billing_postal_code'.$i]); ?>
                                    </div>
                                </div>
                                <?php } ?>
                                <!--billing information end-->
                                <!--working infromation start-->
                                <?php if(isset ($arr->work_job_title)||isset ($arr->work_job_title_required) || (isset ($arr->work_company)||isset ($arr->work_company_required)) || (isset ($arr->work_address)||isset ($arr->work_address_required)) || (isset ($arr->work_number)||isset ($arr->work_number_required)) || (isset ($arr->work_city)||isset ($arr->work_city_required)) || (isset ($arr->work_city)||isset ($arr->work_city_required)) || (isset ($arr->work_state)||isset ($arr->work_state_required)) ||  (isset ($arr->work_country)||isset ($arr->work_country_required)) || (isset ($arr->work_zip)||isset ($arr->work_zip_required)) || (isset ($arr->gender)||isset ($arr->gender_required))){?>
                                <h5><?=$this->lang->line('work_information');?></h5>
                                <?php } ?>
                                <?php  if(isset ($arr->work_job_title)||isset ($arr->work_job_title_required)){?>
                                <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('work_job_title');?>: <?php if(isset ($arr->work_job_title_required)) echo "*" ?></label>
                                    <div class="controls">
                                        <input class="input-large  <?php if(isset ($arr->work_job_title_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[work_job_title<?=$i?>]" value="<?=($user_ses_id)? $user->work_job_title: $this->input->post($tic_id."[work_job_title$i]");?>" title="<?=$this->lang->line('required')?>"/>
                                       
                                    </div>
                                </div> 
                                <?php } ?>
                                 <?php  if(isset ($arr->work_company)||isset ($arr->work_company_required)){?>
                                <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('company');?>: <?php if(isset ($arr->work_company_required)) echo "*" ?></label>
                                    <div class="controls">
                                        <input class="input-large  <?php if(isset ($arr->work_company_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[work_company<?=$i?>]" value="<?=($user_ses_id)? $user->work_company: $this->input->post($tic_id."[work_company$i]");?>" title="<?=$this->lang->line('required')?>"/>
                                       
                                    </div>
                                </div> 
                                <?php } ?>
                                 <?php  if(isset ($arr->work_address)||isset ($arr->work_address_required)){?>
                                <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('work_address');?>: <?php if(isset ($arr->work_address_required)) echo "*" ?></label>
                                    <div class="controls">
                                        <input class="input-large  <?php if(isset ($arr->work_address_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[work_address<?=$i?>]" value="<?=($user_ses_id)? $user->work_address: $this->input->post($tic_id."[work_address$i]");?>" title="<?=$this->lang->line('required')?>"/>
                                       
                                    </div>
                                </div> 
                                <?php } ?>
                                <?php  if(isset ($arr->work_number)||isset ($arr->work_number_required)){?>
                                <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('work_phone');?>: <?php if(isset ($arr->work_number_required)) echo "*" ?></label>
                                    <div class="controls">
                                        <input class="input-large  <?php if(isset ($arr->work_number_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[work_number<?=$i?>]" value="<?=($user_ses_id)? $user->work_number: $this->input->post($tic_id."[work_number$i]");?>" title="<?=$this->lang->line('required')?>"/>
                                       
                                    </div>
                                </div> 
                                <?php } ?>
                                <?php  if(isset ($arr->work_city)||isset ($arr->work_city_required)){?>
                                <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('work_city');?>: <?php if(isset ($arr->work_city_required)) echo "*" ?></label>
                                    <div class="controls">
                                        <input class="input-large  <?php if(isset ($arr->work_city_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[work_city<?=$i?>]" value="<?=($user_ses_id)? $user->work_city: $this->input->post($tic_id."[work_city$i]");?>" title="<?=$this->lang->line('required')?>"/>
                                       
                                    </div>
                                </div> 
                                <?php } ?>
                                <?php  if(isset ($arr->work_state)||isset ($arr->work_state_required)){?>
                                <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('work_state');?>: <?php if(isset ($arr->work_state_required)) echo "*" ?></label>
                                    <div class="controls">
                                        <input class="input-large  <?php if(isset ($arr->work_state_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[work_state<?=$i?>]" value="<?=($user_ses_id)? $user->work_state: $this->input->post($tic_id."[work_state$i]");?>" title="<?=$this->lang->line('required')?>"/>
                                       
                                    </div>
                                </div> 
                                <?php } ?>
                                <?php  if(isset ($arr->work_country)||isset ($arr->work_country_required)){?>
                                <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('work_country');?>: <?php if(isset ($arr->work_country_required)) echo "*" ?></label>
                                    <div class="controls">
                                        <select class="input-large  <?php if(isset ($arr->work_country_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[work_country<?=$i?>]" title="<?=$this->lang->line('required')?>">
                                            <option value="" ><?=$this->lang->line('select_option');?></option>
                                            <?php $countries = $this->general->get_country();?>
                                            <?php foreach($countries as $country): ?>
                                                
                                                <option value="<?=$country->country?>" <?= (strtolower($country->country)==strtolower($profile_data->country))? "selected='selected'" : '';?> ><?=$country->country?></option>
                                                
                                            <?php endforeach;?>
                                        </select>
                                        <?php /*
                                        <input class="input-large  <?php if(isset ($arr->work_country_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[work_country<?=$i?>]" value="<?=($user_ses_id)? $user->work_country: $this->input->post($tic_id."[work_country$i]");?>" title="<?=$this->lang->line('required')?>"/>
                                        */?>                           
                                    </div>
                                </div>
                                <?php } ?>
                                <?php  if(isset ($arr->work_zip)||isset ($arr->work_zip_required)){?>
                                <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('work_zip');?>: <?php if(isset ($arr->work_zip_required)) echo "*" ?></label>
                                    <div class="controls">
                                        <input class="input-large  <?php if(isset ($arr->work_zip_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[work_zip<?=$i?>]" value="<?=($user_ses_id)? $user->work_zip: $this->input->post($tic_id."[work_zip$i]");?>" title="<?=$this->lang->line('required')?>"/>
                                       
                                    </div>
                                </div> 
                                <?php } ?>
                                <?php  if(isset ($arr->gender)||isset ($arr->gender_required)){?>
                                <div class="form-group">
                                    <label class="form-label"><?=$this->lang->line('gender');?>: <?php if(isset ($arr->gender_required)) echo "*" ?></label>
                                    <div class="controls">
                                        <select class="input-large  <?php if(isset ($arr->gender_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[gender<?=$i?>]" title="<?=$this->lang->line('required')?>">
                                            <option value=""><?=$this->lang->line('select_option');?></option>
                                            <option value="<?=$this->lang->line('male');?>"><?=$this->lang->line('male');?></option>
                                            <option value="<?=$this->lang->line('female');?>"><?=$this->lang->line('female');?></option>
                                        </select>
                                        <?php /*
                                        <input class="input-large  <?php if(isset ($arr->gender_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[gender<?=$i?>]" value="<?=($user_ses_id)? $user->gender: $this->input->post($tic_id."[gender$i]");?>" title="<?=$this->lang->line('required')?>"/>*/?>
                                       
                                    </div>                        
                                </div> 
                                <?php } ?>
                                <?php endif; ?>
                                <!--billing information end-->
                                <?php } ?>
                            <?php endforeach; ?>
                            <?/*
                            <!--billing information end-->
                            
                            <!--credit card information start-->
                            <!--<legend>Credit Card Information</legend>-->
                            <!--error block start -->
                            <!--
                            <?php //if($this->session->flashdata('cc_error')){ ?>
                            <div class="alert alert-error">  
                              <a class="close" data-dismiss="alert">x</a>
                              <?php //echo $this->session->flashdata('cc_error');?>
                            </div>
                            <?php // } ?>
                            -->
                            <!--error block end -->
                            <!--
                            <div class="control-group">
                                <label class="control-label">Credit Card Type: *</label>
                                <div class="controls">
                                    <select name="credit_card_type" class="required" >
                                        <option value="">Select Your Card</option>
                                        <option value="MasterCard">Master Card</option>
                                        <option value="visa">VISA Card</option>                            
                                    </select>    
                                    <?//=form_error('credit_card_type') ?>                    
                                </div>
                            </div>
                            <div class="control-group" class="required">
                                <label class="control-label">Credit Card Number: *</label>
                                <div class="controls">
                                    <input class="input-large required creditcard number" type="text" name="credit_card_number" value=""/>
                                    <?//=form_error('credit_card_number') ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Expiration Date: *</label>
                                <div class="controls">
                                    <select name="month" style="width: 150px;" class="required" title="<?=$this->lang->line('required')?>" >
                                        <option value="">Month</option>
                                        <?php //for($i=1; $i<=12;$i++):?>
                                        <option value="<?//=($i<10)? "0".$i : $i; ?>"><?//=($i<10)? "0".$i : $i; ?></option>
                                        <?php //endfor;?>
                                    </select>
                                    <select name="year" style="width: 150px;" class="required" title="<?=$this->lang->line('required')?>" >
                                        <option value="">Year</option>
                                        <?php //for($i=0; $i<20;$i++):?>
                                        <option value="<?//=date('Y')+$i; ?>"><?//=date('Y')+$i; ?></option>
                                        <?php //endfor;?>
                                    </select> 
                                    <?//=form_error('year') ?>                                 
                                </div>
                            </div>
                            <div class="control-group" class="required">
                                <label class="control-label">CSC: *</label>
                                <div class="controls">
                                    <input class="input-large required number" type="text" name="csc" value="" maxlength="4" style="width: 100px;" />   
                                    <?//=form_error('csc') ?>                     
                                </div>
                            </div>-->
                            <!--credit card information end-->
                            */?>
                            
                            <div class="form-actions nopad">
                                <label class="label_assect">
                                    <input type="radio" name="order_type_pb" value="paypal" checked="checked" />
                                    <img src="<?=MAIN_IMAGES_DIR_FULL_PATH.'i_paypal_1.jpg' ?>" />
                                    <img src="<?=MAIN_IMAGES_DIR_FULL_PATH.'i_paypal_2.jpg' ?>" />
                                    <a href="#" class="tooltip-test tooltip-test3" data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->lang->line('paypal_payment_tooltip'); ?>" ><span></span></a>
                                    
                                </label>
                                <?php //if(COUNTRY_CODE == 'SA'){ ?>
                                <label class="label_assect">
                                    <input type="radio" name="order_type_pb" value="bank" />
                                    <?php /*<img src="<?=MAIN_IMAGES_DIR_FULL_PATH.'i_bank_1.jpg' ?>" />*/?>
                                    <span class="bank_transfer"><?=$this->lang->line('bank_transfer');?></span>
                                    <img src="<?=MAIN_IMAGES_DIR_FULL_PATH.'i_bank_2.jpg' ?>" />
                                    <a href="#" class="tooltip-test tooltip-test3" data-toggle="tooltip" data-placement="bottom" title="<?php echo $this->lang->line('bank_payment_tooltip'); ?>" ><span></span></a>
                                </label>  
                                <?php // } ?>
                                <?php /*
                                <input type="submit" name="order_paid" value="Paypal" class="btn" style="background: url('<?=MAIN_IMG_DIR_FULL_PATH.'paypal.gif' ?>') no-repeat;color: transparent; height: 30px; width: 52px;" />                     
                                <input type="submit" name="bank_pay" value="bankname" class="btn" style="background: url('<?=MAIN_IMG_DIR_FULL_PATH.'SAMA.jpg' ?>') no-repeat;color: transparent; height: 30px; width: 52px;" />
                                
                                <!--<img onclick="paypal_order('<?=site_url("event/pay/paypal/$order->event_id/$order->order_id/$order->token_id/$order->id") ?>');" src="<?=MAIN_IMG_DIR_FULL_PATH.'paypal.gif' ?>" style="cursor: pointer;" />-->
                                */?>
                                <input type="submit" name="complete_order_pb" value="<?=$this->lang->line('complete_reg')?>" class="btn btn-success" />
                                 
                            </div>
                        </div>
                        
                    </div>        
                    
                    <!--hidden fields start-->
                    <input type="hidden" name="order_id" value="<?=$order->order_id; ?>" />        
                    <!--hidden fields end-->
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(function (){ 
    $(".tooltip-test").tooltip();
    $("#event_order_paid").validate();  
});  
</script>
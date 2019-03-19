<div class="row-fluid event_head">
	<?php /*
    <div class="span8 left">
    <dl>
    	<dt><?=$data_event->title;?></dt>
        <!--dd><em><?=ucwords($data_event->first_name." ".$data_event->last_name);?></em></dd-->
        <dd><?php //echo $data_event->name; ?></dd>
        <dd>
        <?php if($data_event->date_id =='0'){ ?>            
            <strong><?=$data_event->frequency." Event -"; ?></strong>
            <strong>From</strong> <?php echo date('l, F j, Y  g:i A',strtotime($data_event->start_date)); ?> <strong><?php echo $this->lang->line('to'); ?></strong> <?php echo date('l, F j, Y  g:i A (T)',strtotime($data_event->end_date)); ?>                    
        <?php }else{ ?>
            <?php echo $data_event->date_time_detail; ?>                                
        <?php } ?>
        </dd>
        <dd><?php echo $data_event->physical_name; ?></dd>
	</dl>
    </div>
    */?>
    <div class="span8 left">
    <dl>
    	<h1 class="event_title"><?=ucwords($data_event->title);?></h1>
        <dd>
        <?php if($data_event->date_id =='0'){ ?>            
            <strong><?=(strtolower($data_event->frequency)=='never')? "":$data_event->frequency." Event -"; ?></strong>
            <strong><?php echo $this->lang->line('from'); ?></strong> <?=$this->general->date_language(date('l, F j, Y  g:i A',strtotime($data_event->start_date))); ?> <strong><?php echo $this->lang->line('to'); ?></strong> <?php echo str_replace('(AST)',$this->lang->line('KSA'),$this->general->date_language(date('l, F j, Y  g:i A (T)',strtotime($data_event->end_date)))); ?>                         
        <?php }else{ ?>        
            <?php echo str_replace('(AST)',$this->lang->line('KSA'),$this->general->date_language($data_event->date_time_detail)); ?>                                
        <?php } ?>
        </dd>
        <dd><?php echo $data_event->physical_name; ?></dd>
	</dl>
    </div>
    
    <div class="span4 right">
        <?php 
        $logo_image = UPLOAD_FILE_PATH."event/thumb_".$data_event->logo;
        $logo = (file_exists($logo_image))? $logo_image: UPLOAD_FILE_PATH.'event_logo.jpg';
        ?>
    	<img class="event_logo" src="<?=base_url().$logo;  ?>" title="<?=$data_event->title; ?>" />           
    </div>
</div>
<div align="center" class="error">
    <?php 
        if($this->session->flashdata('message')){
            echo "<div class='message'>".$this->session->flashdata('message')."</div>";
        }  
    ?>
</div>
<div class="row-fluid">
	<div class="span8">   
    <form id="event_order_register" class="form-horizontal" method="post" action=""> 	
        <!-- order summary start -->
        <div class="box">
        	<h1><?php echo $this->lang->line('order_summary'); ?></h1>
            <div class="box_content">
                <?php 
                if($data_event->date_id !='0')
                    $date_attendings = explode(',',$order->date_time);
                ?>
                <ul class="description date_attending">
                    <li><strong><?php echo $this->lang->line('date_attending'); ?>:</strong> </li>
                </ul>
            	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table_rows_add table table-striped">
                    <tr>                            
                        <th><?php echo $this->lang->line('type'); ?></th>                        
                        <th><?php echo $this->lang->line('quantity'); ?></th>
                    </tr>
                    <?php
                    $tickets_no = explode(',',$order->ticket_quantity);                     
                    $tickets_id = explode(',',$order->ticket_id);
                    
                    foreach($tickets_no as $key=>$ticket):
                        if($ticket=='')
                            continue;
                        ?>
                        <tr>                        
                            <td><?=ucwords($this->event_model->get_ticket_name_from_id($tickets_id[$key])); ?></td>
                            <td><?=$ticket; ?></td>
                        </tr>                                        
                    <?php endforeach;?>
                    <tr>
                        <th>&nbsp;</th>
                        <th><a class="ajax1111" href="<?=site_url('home/refund_policy/'.$order->event_id)?>"><?=$this->lang->line('refund_policy')?></a></th>
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
            	   console.log(numSeconds);
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
                    console.log(endTime);
                    console.log(nows);	
                    
                    
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
            <h1><?php echo $this->lang->line('registration_information'); ?></h1>
            <div class="box_content">
            
                <legend><?php echo $this->lang->line('your_information'); ?></legend>
                <div class="control-group">
                    
                    <?php 
                    $user_ses_id = $this->session->userdata(SESSION."user_id");
                    if($user_ses_id){
                        $user = $this->account_module->get_user_profile_data(); 
                        echo "<div class=\"controls\" style=\"float: right;\">".$this->lang->line('hi').", <strong>".$this->session->userdata(SESSION."email")."</strong>. ".$this->lang->line('not_you')." <a href=\"javascript:void(0);\" onclick=\"logoutajax('".site_url()."');\">".$this->lang->line('logout')."</a></div>";   
                    }else{ ?>
                        <div class="controls" style="float: right;" id="login_result">
                            <?php echo $this->lang->line('do_have_account'); ?>? <a href="javascript:void(0);" onclick="$('#login_box_hidden').show();$(this).parent().hide();"><?php echo $this->lang->line('signin_account'); ?></a>
                        </div>
                        <br clear="all" />
                        <div class="" id="login_box_hidden" style="display: none;">
                            <div id="load_error"></div>
                            <div id="email_empty_err_msg" style="display: none;"><?=$this->lang->line('email_empty_err_msg');?></div>
                            <div class="control-group">
                                <label class="control-label"><?php echo $this->lang->line('email_address');?>:</label>
                                <div class="controls"><input type="text" name="email_login" id="email_login" class="required input-large"  title="*" /></div>                                
                            </div>
                            <div class="control-group">
                                <label class="control-label"><?php echo $this->lang->line('password'); ?>:</label>
                                <div class="controls"><input type="password" name="password_login" id="password_login" class="required input-large" title="*"  /></div>                                
                            </div>
                            <div class="control-group">
                                <label class="control-label">&nbsp;</label>
                                <input type="button" class="btn" onclick="loginajax('<?=site_url();?>');" value="<?=$this->lang->line('login');?>" />
                                <em><?php echo $this->lang->line('loggin_optional'); ?>.</em>
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
                <?php /*
                <div class="control-group">
                    <label class="control-label"><?php echo $this->lang->line('first_name'); ?>: *</label>
                    <div class="controls">
                        <input class="input-large required" title="*" type="text" name="first_name" value="<?=($user_ses_id)? $user->first_name: "";?>" />
                        <?=form_error('first_name') ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><?php echo $this->lang->line('last_name'); ?>: *</label>
                    <div class="controls">
                        <input class="input-large required" title="*" type="text" name="last_name" value="<?=($user_ses_id)? $user->last_name: "";?>" />
                        <?=form_error('last_name') ?>
                    </div>
                </div>
                */?>
                <div class="control-group">
                    <label class="control-label"><?php echo $this->lang->line('email_address'); ?>: *</label>
                    <div class="controls">
                        <input class="input-large required" title="*" type="text" name="email" value="<?=($user_ses_id)? (empty($user->email)? $this->session->userdata(SESSION.'email'): $user->email): "";?>" />
                        <?=form_error('email') ?>
                    </div>
                </div>                  
                <?php if(!$user_ses_id){?>
                <div class="control-group">
                    <label class="control-label"><?php echo $this->lang->line('email_address'); ?>: *</label>
                    <div class="controls">
                        <input class="input-large required" title="*" type="text" name="email" value="<?=($user_ses_id)? $user->email: "";?>" />
                        <?=form_error('email') ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><?=$this->lang->line('password')?>: *</label>
                    <div class="controls">
                        <input class="input-large required" id="passowrd_reg" type="password" name="password" value="" title="*"/>
                        <?=form_error('password') ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><?=$this->lang->line('re_password')?>: *</label>
                    <div class="controls">
                        <input class="input-large required" equalTo='#passowrd_reg' type="password" name="re_password" value="" title="*"/>
                        <?=form_error('re_password') ?>
                    </div>
                </div>
                <?php } ?>  
                
                
                <?php foreach($tickets_no as $key=>$ticket): ?>
                    <?php if($ticket=='') continue;?>
                    <?php for($i=1 ; $i <=$ticket; $i++){ ?>
                    <!--ticket buyer information start-->                    
                    <?php $ticket_id = trim($tickets_id[$key]); $tic_id = "a".$ticket_id; ?>
                    <legend><?="#".$i?> <?=ucwords($this->general->get_value_from_id('es_event_ticket',$ticket_id,'name')); //echo $this->lang->line('add_ticket_name_here')?></legend>
                    <!------------------------>
                    <h5><?=$this->lang->line('contact_information'); ?></h5>
                    <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('first_name');?>: *</label>
                        <div class="controls">
                            <input class="input-large required" type="text" name="<?=$tic_id;?>[first_name<?=$i?>]" value="<?=($user_ses_id)? $user->first_name: $this->input->post($tic_id."[first_name$i]");?>" title="<?=$this->lang->line('required')?>" />
                            <?=form_error($tic_id['first_name'.$i]) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('last_name');?>: *</label>
                        <div class="controls">
                            <input class="input-large required" type="text" name="<?=$tic_id;?>[last_name<?=$i?>]" value="<?=($user_ses_id)? $user->last_name: $this->input->post($tic_id."[last_name$i]");?>" title="<?=$this->lang->line('required')?>"/>
                            <?=form_error($tic_id['last_name'.$i]) ?>
                        </div>
                    </div>                
                    <?php if($s==1): 
                         if(isset ($arr->home_number) || isset ($arr->home_number_required)){
                        ?>
                     <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('home_number');?>: <?php if(isset ($arr->home_number_required)) echo "*" ?></label>
                        <div class="controls">
                            <input class="input-large <?php if(isset ($arr->home_number_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[home_number<?=$i?>]" value="<?=($user_ses_id)? $user->home_number: $this->input->post($tic_id."[home_number$i]");?>" title="<?=$this->lang->line('required')?>"/>
                            
                        </div>
                    </div>
                    <?php }  if(isset ($arr->mobile_number)||isset ($arr->mobile_number_required)){?>
                     <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('mobile_number');?>: <?php if(isset ($arr->mobile_number_required)) echo "*" ?></label>
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
                    <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('country');?>: <?php if(isset ($arr->country_required)) echo "*" ?></label>
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
                    <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('address');?>: <?php if(isset ($arr->address_required)) echo "*" ?></label>
                        <div class="controls">
                            <input class="input-large  <?php if(isset ($arr->address_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[billing_address<?=$i?>]" value="<?=($user_ses_id)? $user->address: $this->input->post($tic_id."[billing_address$i]");?>" title="<?=$this->lang->line('required')?>"/>
                            <?=form_error($tic_id['billing_address'.$i]); ?>
                        </div>
                    </div>  
                     <?php } ?>
                     <?php  if(isset ($arr->address1)||isset ($arr->address1_required)){?>
                    <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('address');?>2: <?php if(isset($arr->address1_required)) echo "*" ?></label>
                        <div class="controls">
                            <input class="input-large  <?php if(isset($arr->address1_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[billing_address2<?=$i?>]" value="<?=($user_ses_id)? $user->address1: $this->input->post($tic_id."[billing_address2$i]");?>"  title="<?=$this->lang->line('required') ?>"/>
                            <?=form_error($tic_id['billing_address2'.$i]) ?>
                        </div>
                    </div><?php } ?>
                     <?php  if(isset ($arr->street)||isset ($arr->street_required)){?>
                    <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('street');?>: <?php if(isset($arr->street_required)) echo "*" ?></label>
                        <div class="controls">
                            <input class="input-large  <?php if(isset($arr->street_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[street_address<?=$i?>]" value="<?=($user_ses_id)? $user->street: $this->input->post($tic_id."[street_address$i]");?>" title="<?=$this->lang->line('required')?>"/>
                            <?=form_error($tic_id['street_address'.$i]) ?>
                        </div>
                    </div> <?php } ?>
                     <?php  if(isset ($arr->city)||isset ($arr->city_required)){?>
                    <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('city');?>: <?php if(isset ($arr->city_required)) echo "*" ?></label>
                        <div class="controls">
                            <input class="input-large  <?php if(isset ($arr->city_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[billing_city<?=$i?>]" value="<?=($user_ses_id)? $user->city: $this->input->post($tic_id."[billing_city$i]");?>" title="<?=$this->lang->line('required')?>"/>
                            <?=form_error($tic_id['billing_city'.$i]) ?>
                        </div>
                    </div><?php } ?>
                     <?php  if(isset ($arr->state)||isset ($arr->state_required)){?>
                    <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('state');?>: <?php if(isset ($arr->state_required)) echo "*" ?></label>
                        <div class="controls">
                            <input class="input-large  <?php if(isset ($arr->state_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[billing_state<?=$i?>]" value="<?=($user_ses_id)? $user->state: $this->input->post($tic_id."[billing_state$i]");?>" />
                            <?=form_error($tic_id['billing_state'.$i]) ?>
                        </div>
                    </div><?php } ?>
                     <?php  if(isset ($arr->zip)||isset ($arr->zip_required)){?>
                    <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('postal_code');?>: <?php if(isset ($arr->zip_required)) echo "*" ?></label>
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
                    <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('work_job_title');?>: <?php if(isset ($arr->work_job_title_required)) echo "*" ?></label>
                        <div class="controls">
                            <input class="input-large  <?php if(isset ($arr->work_job_title_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[work_job_title<?=$i?>]" value="<?=($user_ses_id)? $user->work_job_title: $this->input->post($tic_id."[work_job_title$i]");?>" title="<?=$this->lang->line('required')?>"/>
                           
                        </div>
                    </div> 
                    <?php } ?>
                     <?php  if(isset ($arr->work_company)||isset ($arr->work_company_required)){?>
                    <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('company');?>: <?php if(isset ($arr->work_company_required)) echo "*" ?></label>
                        <div class="controls">
                            <input class="input-large  <?php if(isset ($arr->work_company_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[work_company<?=$i?>]" value="<?=($user_ses_id)? $user->work_company: $this->input->post($tic_id."[work_company$i]");?>" title="<?=$this->lang->line('required')?>"/>
                           
                        </div>
                    </div> 
                    <?php } ?>
                     <?php  if(isset ($arr->work_address)||isset ($arr->work_address_required)){?>
                    <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('work_address');?>: <?php if(isset ($arr->work_address_required)) echo "*" ?></label>
                        <div class="controls">
                            <input class="input-large  <?php if(isset ($arr->work_address_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[work_address<?=$i?>]" value="<?=($user_ses_id)? $user->work_address: $this->input->post($tic_id."[work_address$i]");?>" title="<?=$this->lang->line('required')?>"/>
                           
                        </div>
                    </div> 
                    <?php } ?>
                    <?php  if(isset ($arr->work_number)||isset ($arr->work_number_required)){?>
                    <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('work_phone');?>: <?php if(isset ($arr->work_number_required)) echo "*" ?></label>
                        <div class="controls">
                            <input class="input-large  <?php if(isset ($arr->work_number_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[work_number<?=$i?>]" value="<?=($user_ses_id)? $user->work_number: $this->input->post($tic_id."[work_number$i]");?>" title="<?=$this->lang->line('required')?>"/>
                           
                        </div>
                    </div> 
                    <?php } ?>
                    <?php  if(isset ($arr->work_city)||isset ($arr->work_city_required)){?>
                    <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('work_city');?>: <?php if(isset ($arr->work_city_required)) echo "*" ?></label>
                        <div class="controls">
                            <input class="input-large  <?php if(isset ($arr->work_city_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[work_city<?=$i?>]" value="<?=($user_ses_id)? $user->work_city: $this->input->post($tic_id."[work_city$i]");?>" title="<?=$this->lang->line('required')?>"/>
                           
                        </div>
                    </div> 
                    <?php } ?>
                    <?php  if(isset ($arr->work_state)||isset ($arr->work_state_required)){?>
                    <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('work_state');?>: <?php if(isset ($arr->work_state_required)) echo "*" ?></label>
                        <div class="controls">
                            <input class="input-large  <?php if(isset ($arr->work_state_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[work_state<?=$i?>]" value="<?=($user_ses_id)? $user->work_state: $this->input->post($tic_id."[work_state$i]");?>" title="<?=$this->lang->line('required')?>"/>
                           
                        </div>
                    </div> 
                    <?php } ?>
                    <?php  if(isset ($arr->work_country)||isset ($arr->work_country_required)){?>
                    <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('work_country');?>: <?php if(isset ($arr->work_country_required)) echo "*" ?></label>
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
                    <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('work_zip');?>: <?php if(isset ($arr->work_zip_required)) echo "*" ?></label>
                        <div class="controls">
                            <input class="input-large  <?php if(isset ($arr->work_zip_required)) echo "required" ?> " type="text" name="<?=$tic_id?>[work_zip<?=$i?>]" value="<?=($user_ses_id)? $user->work_zip: $this->input->post($tic_id."[work_zip$i]");?>" title="<?=$this->lang->line('required')?>"/>
                           
                        </div>
                    </div> 
                    <?php } ?>
                    <?php  if(isset ($arr->gender)||isset ($arr->gender_required)){?>
                    <div class="control-group">
                        <label class="control-label"><?=$this->lang->line('gender');?>: <?php if(isset ($arr->gender_required)) echo "*" ?></label>
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
                
                
                <!--buttons-->
                <div class="form-actions">  
                    <input type="submit" name="register" value="<?=$this->lang->line('complete_reg')?>" class="btn" />
                </div>             
                
            </div>
        </div>
    </form>
    </div>
    
    <div class="span4">
        <!-- location block start -->
        <?php if(!empty($data_event->address)){ ?>
    	<div class="box">
        	<h1><?php echo $this->lang->line('where'); ?></h1>
            <div class="box_content">            	
                <ul class="description organizer_each">                    
                    <li><strong><?=ucwords($data_event->physical_name);?></strong></li>                    
                    <li><?=$data_event->address;?></li>
                </ul>
            </div>
        </div>
        <?php }else if(!empty($data_event->physical_name)){ ?>
        <div class="box">
        	<h1><?php echo $this->lang->line('physical_address'); ?></h1>
            <div class="box_content">            	 
                <ul class="description organizer_each">                    
                    <li><strong><?=ucwords($data_event->physical_name);?></strong></li>
                </ul>
            </div>
        </div>
        <?php } ?>
        <!-- location block end -->
        
        <!-- performer block start -->
        <?php if($performer){ ?>
        <div class="box">
        	<h1><?php echo $this->lang->line('performer'); ?></h1>
            <div class="box_content">
            	<ul class="description">
                	<li><strong><?php echo $this->lang->line('name'); ?>:</strong><?php echo ucwords($performer->performer_name); ?></li>
                    <li><strong><?php echo $this->lang->line('type'); ?>:</strong><?php echo ucwords($performer->performer_type); ?></li>
                    <?php if($performer->performer_description!=''){ ?>
                    <li><a onclick="$('#performer_description').toggle();" style="text-decoration: none; cursor: pointer;"><?php echo $this->lang->line('view_detail'); ?></a></li>
                    <li id="performer_description" style="display: none;"><strong><?php echo $this->lang->line('description'); ?>:</strong><?php echo $performer->performer_description; ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>        
        <?php } ?>
        <!-- performer block end -->
        
        <!-- organizers block start -->
        <?php if($organizers){ ?>
        <div class="box">
        	<h1><?php echo $this->lang->line('organizers'); ?></h1>
            <div class="box_content">
            <?php foreach($organizers as $organizer): ?>
                <?php               
                $organizer_image = UPLOAD_FILE_PATH."organizer/thumb_".$organizer->logo;
                $organizer_logo = (file_exists($organizer_image))? $organizer_image: UPLOAD_FILE_PATH.'sponsor_logo.jpg';
                ?>
                <ul class="description organizer_each">
                    <span class="organizer_logo"><img src="<?=base_url().$organizer_logo; ?>" title="<?php echo $organizer->name; ?>" /></span>
                	<li><strong><?php echo $this->lang->line('name'); ?>:</strong><?php echo ucwords($organizer->name); ?></li>                    
                    <li><strong><a href="<?=site_url('organizer/view/'.$organizer->organizer_id)?>" target="_blank"><?php echo $this->lang->line('organizer_profile'); ?></a></strong></li>
                </ul> 
                <br clear="all" />           	
            <?php endforeach; ?>                
            </div>
        </div>
        <?php } ?>
        <!-- organizers block end -->
    </div>
</div>

<script>
$("#event_order_register").validate();
</script>
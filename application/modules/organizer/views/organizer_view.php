<div class="row">
    <div class="col-md-3 col-sm-12">
        <?php 
        //var_dump($organizer);
        if($organizer->description){ ?>
        <div class="search-event-small">
        	<h3><?php echo $this->lang->line('about_us'); ?></h3>
            <div class="box-content">
            	<p><?=$organizer->description ?></p>
            </div>
        </div>
        <?php } ?>
        <div class="search-event-small">
        	<h3><?php echo $this->lang->line('contact_us'); ?></h3>
            <div class="box-content center">
            	<a href="#contact090" role="button" class="btn btn-danger" data-toggle="modal"><?php echo $this->lang->line('contact_the_organizer'); ?></a>
            </div>
        </div>
    </div>
            
    <div class="col-md-9 col-sm-12 list-main">
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
                <h2 class="detail-title2"><?=$organizer->name ?></h2>
            </div>
            <div class="col-md-4">
                <div class="">               
                    <?php               
                    $organizer_image = UPLOAD_FILE_PATH."organizer/thumb_".$organizer->logo;
                    $organizer_logo = (file_exists($organizer_image))? $organizer_image: UPLOAD_FILE_PATH.'sponsor_logo.jpg';
                    ?>
                    <img class="event_logo" src="<?=base_url().$organizer_logo; ?>" title="<?php echo $organizer->name; ?>" class="img-responsive" />            
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="event-management margin-top-10">
                <div class="box">
                	<ul class='tabs nav nav-tabs'>
                        <li class="active"><a href='#tab1' data-toggle="tab"><?php echo $this->lang->line('current_event'); ?></a></li>
                        <li><a href='#tab2' data-toggle="tab"><?php echo $this->lang->line('past_event'); ?></a></li>
					</ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id='tab1'>
                            <?php
                            if($current_events):
                            foreach($current_events as $event):
                                $logo_image = UPLOAD_FILE_PATH."event/thumb_".$event->logo;
                                $logo = (file_exists($logo_image))? $logo_image: UPLOAD_FILE_PATH.'event_logo.jpg';
                            ?>
                        	<div class="box">
                                <div class="events-img">
                                	<img class="img-responsive" src="<?=base_url().$logo;  ?>" />
                                </div>
                                <div class="events-detail">
                                	<h4><a class="organizing_event" href="<?php echo site_url('event/view/' . $event->id); ?>" target="_blank"><span class="titllee"><?=ucwords($event->title);?></span></a></h4>
                                    <p>
                                        <?php if($event->date_id == "0" ):?>
                                        <strong><?php echo $this->lang->line('start_date'); ?></strong>: <?=$event->start_date;?><br /> 
                                        <strong><?php echo $this->lang->line('end_date'); ?></strong>: <?=$event->end_date;?> <br />
                                        <?php else: ?>
                                        <?=$event->date_time_detail;?><br />
                                        <?php endif; ?>
                                        
                                        <strong> <?=$event->physical_name;  ?></strong><br />
                                        <?php  
                                        $target_gender=$event->target_gender;
                                        if($target_gender="M"){
                                            $targetgender="Male";
                                        }
                                        elseif($target_gender="F"){
                                            $targetgender="Female";
                                        }
                                        elseif($target_gender="MF"){
                                            $targetgender="Male and Female";
                                        }
                                        ?>  
                                        <strong><?php echo $this->lang->line("target_gender") ?>:</strong> <?=$targetgender;?><br />           
                                    </p>
                                </div>
                                <div class="clearfix"></div>                                
                            </div>
                            <?php endforeach;?>
                            <?php else: ?>
                            <div class="alert alert-info">                            
                                <strong><?php echo $this->lang->line('no_records'); ?>!</strong>
                            </div>
                            <?php endif;?>
                                                       
                        </div>
                        <div class="tab-pane" id='tab2'>
                            <?php 
                            if($past_events):                    
                            foreach($past_events as $event):                                  
                                $logo_image = UPLOAD_FILE_PATH."event/thumb_".$event->logo;
                                $logo = (file_exists($logo_image))? $logo_image: UPLOAD_FILE_PATH.'event_logo.jpg';
                            ?>   
                                <div class="box">
                                    <div class="events-img">
                                    	<img class="img-responsive" src="<?=base_url().$logo;  ?>" />
                                    </div>
                                    <div class="events-detail">
                                    	<h4><span class="titllee"><?=ucwords($event->title);?></span></h4>
                                        <p>
                                            <?php if($event->date_id == "0" ):?>
                                            <strong><?php echo $this->lang->line('start_date'); ?></strong>: <?=$event->start_date;?><br /> 
                                            <strong><?php echo $this->lang->line('end_date'); ?></strong>: <?=$event->end_date;?> <br />
                                            <?php else: ?>
                                            <?=$event->date_time_detail;?><br />
                                            <?php endif; ?>
                                            
                                            <strong> <?=$event->physical_name;  ?></strong><br />
                                            <?php  
                                            $target_gender=$event->target_gender;
                                            if($target_gender="M"){
                                                $targetgender="Male";
                                            }
                                            elseif($target_gender="F"){
                                                $targetgender="Female";
                                            }
                                            elseif($target_gender="MF"){
                                                $targetgender="Male and Female";
                                            }
                                            ?>  
                                            <strong><?php echo $this->lang->line("target_gender") ?>:</strong> <?=$targetgender;?><br />                      
                                        </p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>                        
                            	
                            <?php endforeach; ?>
                            <?php else: ?>
                                <div class="alert alert-info">                            
                                    <strong><?php echo $this->lang->line('no_records'); ?>!</strong>
                                </div>
                            <?php endif;?>       
                        </div>
                    </div>
                </div>
            </div>
            <!-- event description start -->
            <?php if(!empty($data_event->description)){ ?>
            <div class="detail-sections">
            	<h3><?php echo $this->lang->line('event_details'); ?></h3>
                <div class="box_content">
                    <iframe scrolling="no" onload='javascript:resizeIframe(this);' id="event_description_iframe" src="<?=site_url('event/description_only/'.$data_event->id)?>" style="width: 100%; border:none;"></iframe>
                    <?php //echo $data_event->description; ?>
                    <script language="javascript" type="text/javascript">
                      function resizeIframe(obj) {
                        obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
                      }
                    </script>         	
                </div>
            </div>
            <?php } ?>
            <!-- event description end -->
            
            <!-- event keywords start -->
            <?php if(!empty($keywords)){ ?>
            <div class="detail-sections">
            	<h3><?php echo $this->lang->line('keywords'); ?></h3>
                <?php
                foreach($keywords as $keyword): 
                    if(empty($keyword->keyword))
                        continue;                   
                ?>
                    <span class="keywords"><?php echo $keyword->keyword; ?></span>
                <?php endforeach; ?>                
            </div>
            <?php } ?>
            <!-- event keywords end -->
            
            <?php if($sponsors){ ?>
            <div class="sponsers">
                <h2 class="title"><span><?php echo $this->lang->line('sponsors'); ?></span></h2>    
                <?php foreach($sponsors as $sponsor): ?>
                    <?php 
                    $sponsor_image = UPLOAD_FILE_PATH."sponsor/thumb_".$sponsor->logo;
                    $sponsor_image = (file_exists($sponsor_image))? $sponsor_image: UPLOAD_FILE_PATH.'sponsor_logo.jpg';
                    ?>
                    <div style="width: auto; margin: 0 3px; display: inline-block;">
                        <span style="width: 100%; float:left; text-align:center;"><?=ucwords($sponsor->type)?></span>
                        <img src="<?=base_url().$sponsor_image; ?>" title="<?php echo $sponsor->title; ?>" />
                    </div>
                <?php endforeach;?>
            </div>
            <?php } ?>            
        </div>
    </div>
</div>


<!--models-->
<div class="modal fade" id="contact090" tabindex="-1" role="dialog" aria-labelledby="contact090Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="contact090Label"><?php echo $this->lang->line('contact_organizer'); ?></h4>
        </div>
        <form id="form_contact_organizer" action="" method="post" name="contactForm" class="clrfix">
            <div class="modal-body center">        
                <p id="error_messages" class="error_inline"></p>
                <span class="required_field required_field_hint">* <?php echo $this->lang->line('required'); ?></span>
                <span class="error_inline hide_me"><?php echo $this->lang->line('missing_information'); ?>.</span>
                <div class="form-group">
                    <label for="contact_name"><?php echo $this->lang->line('your_name'); ?>: <span class="required_field">*</span></label> <br />               
                    <input type="text" id="contact_name" name="from_name" value="" class="required"/>
                </div>
                <div class="form-group">
                    <label for="contact_email"><?php echo $this->lang->line('email_address'); ?>: <span class="required_field">*</span></label><br />
                    <input type="text" id="contact_email" name="from_email" value="" class="required email"/>
                </div>
                <div class="form-group">
                    <label for="contact_message"><?php echo $this->lang->line('send_message'); ?>: <span class="required_field">*</span></label><br />
                    <textarea id="contact_message" name="message" class="required"></textarea>
                </div>
                <div id="container_captcha_privacy" class="no_recaptcha">
                <div id="contact_disclaimer">
                    <p>
                    <?php echo $this->lang->line('seen_by_organizer'); ?>.
                    </p>
                    <p>
                    <a href="<?php echo site_url("page/privacy-policy"); ?>" target="_blank"><?php echo $this->lang->line('privacy_protected'); ?>.</a>
                    </p>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="user_organiser" name="user_organiser" value="<?=$user_organiser->user_id ?>" />
                <input type="hidden" id="form_contact_organizer_hidden" name="contact_organizer_submit" value="1">
                <input type="submit" class="submit btn btn-success" name="submit" id="searchsubmit" value="Send message"/>
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                <script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>malsup.jquery.form.js"></script>  
                <script>       
                $("#form_contact_organizer").validate({
                    submitHandler: function(form) {
                        $(form).ajaxSubmit({
                            url:"<?php echo site_url('organizer/send_contact_email'); ?>",
                            type:"GET",
                            success: function(r){
                                $('.modal-body').find("input[type=text], textarea").val("");
                                $('#contact090').modal('hide');
                                message = "<?php echo $this->lang->line('message_send'); ?>";
                                $("#mainModal #mainModalBody").html(message);
                                $("#mainModal").modal("show");
                            },
                            beforeSend:function(){
                                $('#searchsubmit').attr('value', 'Please wait..')
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
<!--models-->
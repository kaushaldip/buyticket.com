<ul class="nav nav-tabs">
    <?php $all_cms =  $this->general->get_cms_lists();if($all_cms){for($i=0;$i<4;$i++){?>
    <li>
        <a href="<?php echo site_url("/page/".$all_cms[$i]->cms_slug);?> ">
        <?php echo $all_cms[$i]->heading;?>
       
        </a>
    </li>
    <?php }}?>
    <li><a href="<?php echo site_url('help/index');?>"><?php echo $this->lang->line('help'); ?></a></li>
    <li class="active"><a href="<?php echo site_url('home/contact');?>"><?php echo $this->lang->line('contact_us'); ?></a></li>
</ul>
<?php /*
<!--
<form id="form_contact_organizer" action="" method="post" name="contactForm" class="clrfix">
  <div class="modal-body">
      
        <p id="error_messages" class="error_inline"></p>
        <span class="required_field required_field_hint">* <?php echo $this->lang->line('required'); ?></span>
       
            

            <span class="error_inline hide_me"><?php echo $this->lang->line('missing_information'); ?>.</span>

            <label for="contact_name"><?php echo $this->lang->line('your_name'); ?>: <span class="required_field">*</span></label>
            <input type="text" id="contact_name" name="from_name" value="" class="required"/>

            <label for="contact_email"><?php echo $this->lang->line('email_address'); ?>: <span class="required_field">*</span></label>
            <input type="text" id="contact_email" name="from_email" value="" class="required email"/>
            
            <label for="contact_email"><?php echo $this->lang->line('phone_number'); ?>: <span class="required_field">*</span></label>
            <input type="text" id="phone_no" name="phone_no" value="" class="required"/>
             

            <label for="contact_message"><?php echo $this->lang->line('send_message'); ?>: <span class="required_field">*</span></label>
            <textarea id="contact_message" name="message" class="required"></textarea>

            <div id="container_captcha_privacy" class="no_recaptcha">
                
                
                <div id="contact_disclaimer">
                    <p>
                        <?php echo $this->lang->line('seen_by_organizer'); ?>.
                    </p>
                    <p>
                        <a href="#" target="_blank"><?php echo $this->lang->line('privacy_protected'); ?>.</a>
                    </p>
                </div>
            </div>
  </div>
  <div class="modal-footer">
      
      <input type="hidden" id="form_contact_organizer_hidden" name="contact_organizer_submit" value="1"/>
      <input type="submit" class="submit" name="submit" id="searchsubmit" value="Send message"/>
-->      
      <!--<script src="http://malsup.github.com/jquery.form.js"></script>--> 

 <!--   
  </div>
</form>
-->
*/?>
<div class="row-fluid contact_us">
	<div class="span9">
		<h3><span><?=$this->lang->line('contact')?></span></h3>
		<form action="" method="post" id="contact_us_form">
			<div class="control-group">
			  <label><?=$this->lang->line('i_am')?>: <span class="required">*</span></label>
			  <select style="width: 502px;" class="input-xxlarge required" name="i_am" title="<?=$this->lang->line('select_who_you_are') ?>">
				<option value="">-- <?=$this->lang->line('select_option') ?> --</option>
				<option value="<?=$this->lang->line('event_organizer');?>"><?=$this->lang->line('an_event_organizer') ?></option>
				<option value="<?=$this->lang->line('event_attendee');?>"><?=$this->lang->line('an_event_attendee') ?></option>
				<option value="<?=$this->lang->line('other') ?>"><?=$this->lang->line('other') ?></option>
			  </select>
			</div>
			<div class="control-group">
			  <label><?=$this->lang->line('name')?>: <span class="required">*</span></label>
			  <input type="text" name="contact_name" class="input-xxlarge required" title="<?=$this->lang->line('enter_your_name')?>"/>
			</div>
			<div class="control-group">
			  <label><?=$this->lang->line('email')?>: <span class="required">*</span></label>
			  <input type="text" name="from_email" class="input-xxlarge required email" title="<?=$this->lang->line('enter_valid_email')?>"/>
			</div>
			<div class="control-group">
			  <label><?=$this->lang->line('message')?>:</label>
			  <textarea style="width: 540px; min-height: 120px;" name="message" class="input-xxlarge"></textarea>
			</div>
		  
		  <button type="submit" id="submitcontact" class="contact_btn"><?=$this->lang->line('send_msg')?></button>  
		</form>
	</div>
	<div class="span3">
		<h3><span><?=$this->lang->line('contact_information')?></span></h3>
		<ul class="contact_us_list con_list">
			<li class="contact_us_list1"><?=CONTACT_ADDRESS?></li>
			<li class="contact_us_list2"><a href="mailto:<?=CONTACT_EMAIL?>"><?=CONTACT_EMAIL?></a></li>
			<li class="contact_us_list3"><?=CONTACT_PHONE ?></li>
			<li class="contact_us_list4"><a href="<?=site_url(); ?>"><?=site_url(); ?></a></li>
		</ul>
		<h3><span><?=$this->lang->line('business_hours')?></span></h3>
		<ul class="con_list">
			<li><strong><?=$this->lang->line('Monday-Friday')?>:</strong> <?=$this->lang->line('ten_to_eight')?></li>
			<li><strong><?=$this->lang->line('Saturday')?>:</strong> <?=$this->lang->line('eleven_to_three')?></li>
			<li><strong><?=$this->lang->line('Sunday')?>:</strong> <?=$this->lang->line('close')?></li>
		</ul>
	</div>
</div>
<?php /*<script src="http://malsup.github.com/jquery.form.js"></script> */?> 
<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>malsup.jquery.form.js"></script>
<script>       
$("#contact_us_form").validate({
    submitHandler: function(form) {
         $(form).ajaxSubmit({
                            url:"<?php echo site_url('home/send_contact'); ?>",
                           type:"GET",
                        success: function(r){
                            $('#contact_us_form').find("select,input[type=text], textarea").val("");
                           // alert(r);
                            //$('#contact').modal('hide');
                            $('#myModal3').modal('show');
                            $('#submitcontact').html('<?=$this->lang->line('send_msg')?>')
                      },
                      beforeSend:function(){
                          $('#submitcontact').html('<?=$this->lang->line('please_wait')?>');
                      }
                  });
        
    return false;
    }
});
</script>
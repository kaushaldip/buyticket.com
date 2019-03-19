<?php /*
<script>

window.fbAsyncInit = function() {
    FB.init({
        appId: '<?php $facebook_param = $this->config->item('facebook');echo $facebook_param['appId'];?>',
        status: true,
        cookie: true,
        xfbml: true,
        oauth: true
    });    

};
(function(d){
    var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
    js = d.createElement('script'); js.id = id; js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    d.getElementsByTagName('head')[0].appendChild(js);
}(document));



function login(){
    FB.login(function(response) {
        
        if (response.authResponse) {        
            //  var access_token = response.authResponse.accessToken; //get access token
            //    user_id = response.authResponse.userID; //get FB UID
            
            FB.api('/me', function(response) {
                window.location = '<?php echo site_url('/users/fb_connect');?>'; 
            });
            
        } else {
        //user hit cancel button        
        }
    }, {
        scope: 'email,user_birthday,user_location'
    });
}
</script> 
<!-- End Facebook Like -->
*/?>
<?php if(!isset($navigation)) $navigation="";?>
<div class="navbar header">
  <div class="navbar-inner">
    <div class="main">
    	<div class="row-fluid">        
        <div class="span3 login_signup">
            <ul>
                <? if (!$this->session->userdata(SESSION.'user_id')) { ?>
                    <li><a href="<?php echo site_url('login');?>"><?php echo $this->lang->line('login'); ?></a></li>
                    <li><a href="<?php echo site_url('register');?>"><?php echo $this->lang->line('register'); ?></a></li>
                <?php } else{ ?>
                    <li><a href="<?php echo site_url('users/account');?>"><?php echo (strlen($this->session->userdata(SESSION.'email'))>13)? substr($this->session->userdata(SESSION.'email'),0,13)."." :$this->session->userdata(SESSION.'email'); ?></a></li>
                    <li><a href="<?php echo site_url('users/logout');?>"><?php echo $this->lang->line('logout'); ?></a></li>
                <?php } ?>
            </ul>
        </div>        
        <div class="span2 <?= "pull-right"?> language">
        </div>       
      </div>
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a class="logo" href="<?php echo site_url(); ?>">
        <img src="<?php echo MAIN_IMG_DIR_FULL_PATH;?>logo.jpg" />
      </a>      
      <div class="nav-collapse collapse menu">
        <ul class="nav">
            <?php /*<!--<li <?php if($navigation=='') echo  'class="active"';?>><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a></li>--> */?>
            <li <?php if($navigation=='event') echo  'class="active"';?>><a href="<?php echo site_url('event'); ?>"><?php echo $this->lang->line('find_event'); ?></a></li>
            <li <?php if($navigation=='myticket') echo  'class="active"';?>><a href="<?=site_url('myticket'); ?>"><?php echo $this->lang->line('my_tickets'); ?></a></li>
            <li <?php if($navigation=='create_event') echo  'class="active"';?>><a href="<?php echo site_url('event/create'); ?>"><?php echo $this->lang->line('create_event'); ?></a></li>
            <li <?php if($navigation=='myevents') echo  'class="active"';?>><a href="<?php echo site_url('organizer/event'); ?>"><?php echo $this->lang->line('my_events'); ?></a></li>            
            <li <?php if($navigation=='help') echo  'class="active"';?>><a href="<?=site_url('help/index'); ?>"><?php echo $this->lang->line('help'); ?></a></li>
            <?php /*<!--<li class="contact_menu"><a href="#contact12" data-toggle="modal"><?php echo $this->lang->line('contact_us'); ?></a></li>--> */?>            
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>

<!-- Modal -->

<div id="contact12" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel"><?php echo $this->lang->line('contact_organizer'); ?></h3>
  </div>
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
      <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $this->lang->line('cancle'); ?></button>
      <?php /*<script src="http://malsup.github.com/jquery.form.js"></script> */?> 
      <script>       
$("#form_contact_organizer").validate({
    submitHandler: function(form) {
         $(form).ajaxSubmit({
                            url:"<?php echo site_url('home/send_contact'); ?>",
                           type:"GET",
                        success: function(r){
                            $('.modal-body').find("input[type=text], textarea").val("");
                           // alert(r);
                            $('#contact').modal('hide');
                            $('#myModal3').modal('show');
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

<div id="myModal3" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    
    <h3 id="myModalLabel"><?php echo $this->lang->line('message_send'); ?>!</h3>
  </div>
  
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $this->lang->line('close'); ?></button>
     </div>
</div>


<?php if(isset($header_small)=='yes'):?>
<script>
$(document).ready(function() {
	var yOffset = $(".navbar.header_inside").offset().top;
	$(window).scroll(function() {
		if ($(window).scrollTop() > yOffset) {
			$(".navbar.header_inside").css({
				'top': 0,
				'position': 'fixed'
			});
			$(".header_inside .logo").css({
				'display': 'block'
			});
		} else {
			$(".navbar.header_inside").css({
				'top': yOffset + 'px',
				'position': 'absolute'
			});
			$(".header_inside .logo").css({
				'display': 'none'
			});
		}
	});
});
</script>
<div class="navbar header_inside">
  <div class="navbar-inner">
    <div class="main">
    
    	<!-- AddThis Button BEGIN -->
        <div class="addthis_toolbox addthis_default_style ">
        <a class="addthis_button_preferred_1"></a>
        <a class="addthis_button_preferred_2"></a>
        <a class="addthis_button_preferred_3"></a>
        </div>
        <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51e850956b0d3a6e"></script>
        <!-- AddThis Button END --> 
        	
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a class="logo" href="<?php echo site_url(); ?>">
        <img src="<?php echo MAIN_IMG_DIR_FULL_PATH;?>logo_small.png" /> 
      
      </a>
      <div class="nav-collapse collapse menu">
        <ul class="nav">
        	<li><a href="<?php echo site_url('event/create'); ?>"><?php echo $this->lang->line('create_event'); ?></a></li>
            <li class="last_right"><a href="<?php echo site_url('event'); ?>"><?php echo $this->lang->line('find_event'); ?></a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>
<?php endif; ?>
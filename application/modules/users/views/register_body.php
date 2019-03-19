<?php
//$this->session->set_userdata('fb_data', $fb_data);
$fb_user_register = $this->session->userdata('me');

$fb_data = array("first_name"=>$fb_user_register['first_name'],"last_name"=>$fb_user_register['last_name'],"email"=>$fb_user_register['email'],
                  "username"=>$fb_user_register['username']);

if(!$this->session->userdata('is_fb_user'))
{
	$this->session->set_userdata('is_fb_user', 'No');
}

?>	


<!--	<h1 class="heading title"><span><?php echo $this->lang->line('login_title');?></span></h1>  
<h2 class="smcap pnk_clr">Login or Signup via Social API </h2>
	
<section class="scl-logn">	
	<a id="fb_login_button" onclick="javascript:login();" class="fb">sign in with facebook</a>
    <a href="#" class="twt">sign in with twitter</a>	
</section>

<h2 class="smcap smpad">One click easy sign up Via Facebook or Twitter or Google+</h2>
-->
<!--counter for 20 mins
<div>
    <script>
    function secondsLeft() {
      now = new Date()
      mins = now.getMinutes();
      secs = now.getSeconds();
      document.f1.t1.value = 60 * 60 - (mins * 40 + secs);
    }
    
    $(document).ready(function(){
        timer = setInterval("secondsLeft()", 1000);  
    })
      
    </script>
    <form name="f1" onsubmit="return false">
    There are <input type="text" name="t1" size=4> seconds left until the next hour.
    </form>

</div>
-->
<div class="row create-event">
    <form id="register" name="register" method="post" action="<?php echo site_url('users/register');?>" class="frm_rg login registration" autocomplete="off">
        <h1><?php echo $this->lang->line("sign_up");?></h1>
        <div class="inputs event-div">
            <div class="event-form-main">
                <div class="event-step">
                    <h2 class="login_desc"><?php echo ucfirst($this->lang->line('login_title')); ?></h2>
                </div>
            </div>        	
            <?php if($this->session->userdata('fb_signup')){?>
                <div style="height:20px; padding:5px 20px; background-color:#FFCCCC; margin-bottom:10px; font-size:12px;">
                    <?php echo $this->session->userdata('fb_signup'); $this->session->unset_userdata('fb_signup');?>
                </div>
            <?php }?>
        
            <div class="event-form-main">
                <?php if($this->session->flashdata('error')){ ?>
                    <div class="alert alert-danger" role="alert">  
                    <a class="close" data-dismiss="alert">x</a>
                    <?php echo $this->session->flashdata('error');?>
                    </div>
                <?php  } ?>
                <?php if($this->session->flashdata('message')){ ?>
                    <div class="alert alert-success"  role="alert">  
                    <a class="close" data-dismiss="alert">&times;</a>
                    <?php echo $this->session->flashdata('message');?>
                    </div>
                <?php  } ?>
                <div class="clearfix"></div>                
                <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('email_address');?><span>*</span></label>
                    <div class="col-md-6 col-sm-12">
                        <input name="email" type="text" id="email" value="<?php echo set_value('email',$fb_data['email']);?>" class="form-control"/>
                        <?=form_error('email')?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('password');?><span>*</span></label>
                    <div class="col-md-6 col-sm-12">
                        <input name="password" type="password" id="password"  class="form-control"/>
                        <?=form_error('password')?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('retype_password');?><span>*</span></label>
                    <div class="col-md-6 col-sm-12">
                        <input name="re_password" type="password" id="re_password"  class="form-control"/>
                        <?=form_error('re_password')?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="form-label"><span>&nbsp;</span></label>
                    <div class="terms col-md-6 col-sm-10 col-xs-10">
                        <input name="t_c" type="checkbox" id="t_c" value="yes" <?php echo set_checkbox('t_c', 'yes'); ?> />
                        <?=$this->lang->line('i_have_read_accepted') ?> <a href="<?php echo site_url("/page/terms-and-conditions");?>"><?=$this->lang->line('terms_of_services') ?></a>
                        <?=form_error('t_c')?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-btn-grp">
                    <button type="button" class="submit btn btn-blue form-btn-fix" onclick="document.register.submit()"><?php echo strtoupper($this->lang->line('create_my_account'));?></button>
                </div>
            </div>
        </div>
    </form>
    <div class="sign_up no_account">
        <?php echo ucfirst($this->lang->line('have_acount')); ?> <a href="<?php echo site_url('login'); ?>"><strong><?php echo $this->lang->line('login'); ?></strong></a>
    </div>
</div>
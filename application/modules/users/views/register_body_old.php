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
<form id="register" name="register" method="post" action="<?php echo site_url('users/register');?>" class="frm_rg login registration" autocomplete="off">
	<h2><?php echo $this->lang->line("sign_up");?><br/><span class="login_desc"><?php echo $this->lang->line('login_title'); ?></span></h2>
    <?php if($this->session->userdata('fb_signup')){?>
        <div style="height:20px; padding:5px 20px; background-color:#FFCCCC; margin-bottom:10px; font-size:12px;">
            <?php echo $this->session->userdata('fb_signup'); $this->session->unset_userdata('fb_signup');?>
        </div>
    <?php }?>

    <fieldset class="inputs">
        <ol>
            <li>
                <label><?php echo $this->lang->line('email_address');?><span>*</span></label>
                <input name="email" type="text" id="email" value="<?php echo set_value('email',$fb_data['email']);?>"/>
                <?=form_error('email')?>
            </li>
            <li>
                <label><?php echo $this->lang->line('username');?><span>*</span></label>
                <input name="user_name" type="text" id="user_name" value="<?php echo set_value('user_name',$fb_data['username']);?>"/>
                <?=form_error('user_name')?>
                <!--keyword error for username start-->
                <?php if($this->session->userdata('user_name')){?>
                    <div style="height:20px; padding:5px 20px; background-color:#FFCCCC; margin-bottom:10px; font-size:12px;">
                        <?php echo $this->session->userdata('user_name'); $this->session->unset_userdata('user_name'); ?>
                    </div>
                <?php }?>
                <!--keyword error for username end-->
            </li>
            <li>
                <label><?php echo $this->lang->line('password');?><span>*</span></label>
                <input name="password" type="password" id="password"/>
                <?=form_error('password')?>
            </li>
            <li>
                <label><?php echo $this->lang->line('retype_password');?><span>*</span></label>
                <input name="re_password" type="password" id="re_password"/>
                <?=form_error('re_password')?>
            </li>
            <li>
                <label><?php echo $this->lang->line('prefix');?><span>*</span></label>
                <input name="prefix" type="text" id="prefix" maxlength="4" value="<?php echo set_value('prefix');?>"/>
                <?=form_error('prefix')?>
            </li>
            <li>
                <label><?php echo $this->lang->line('first_name');?><span>*</span></label>
                <input name="first_name" type="text" id="first_name" value="<?php echo set_value('first_name',$fb_data['first_name']);?>" />
                <?=form_error('first_name')?>
            </li>
            <li>
                <label><?php echo $this->lang->line('last_name');?><span>*</span></label>
                <input name="last_name" type="text" id="last_name" value="<?php echo set_value('last_name',$fb_data['last_name']);?>" />
                <?=form_error('last_name')?>
            </li>
            <li>
                <label class="terms">
                <input name="t_c" type="checkbox" id="t_c" value="yes" <?php echo set_checkbox('t_c', 'yes'); ?> />
                I've read and accepted the <a href="<?php echo site_url("/page/terms-and-conditions");?>">terms of services</a>
                <?=form_error('t_c')?>
                </label>
            </li>						
            
            <li>
                <button type="button" class="submit" onclick="document.register.submit()"><?php echo $this->lang->line('create_my_account');?></button>
            </li>
        </ol>
    </fieldset>
</form>
<div class="sign_up no_account">
    <?php echo $this->lang->line('have_acount'); ?> <a href="<?php echo site_url('users/login'); ?>"><strong><?php echo $this->lang->line('login'); ?></strong></a>
</div>
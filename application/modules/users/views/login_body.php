<?php
//$this->session->set_userdata('fb_data', $fb_data);
$fb_user_register = $this->session->userdata('me');

$fb_data = array("first_name"=>$fb_user_register['first_name'],
            "last_name"=>$fb_user_register['last_name'],
            "email"=>$fb_user_register['email'],
            "username"=>$fb_user_register['username'],
            "country"=>$this->session->userdata('country') 
            );

if(!$this->session->userdata('is_fb_user'))
{
	$this->session->set_userdata('is_fb_user', 'No');
}
?>
		
<?php if($this->session->userdata('fb_signup')){ ?>
    <div style="height:20px; padding:5px 20px; background-color:#FFCCCC; margin-bottom:10px; font-size:12px;">
        <?php echo $this->session->userdata('fb_signup');?>
    </div>
<?php }?>
<div class="row create-event">	
    <form id="register" name="register" method="post" action="" class="frm_rg login registration" autocomplete="off">
    	<h1><?php echo $this->lang->line('login'); ?></h1>
        <div class="inputs event-div">
            <div class="event-form-main">
                <div class="event-step">
                    <h2 class="login_desc"><?php echo $this->lang->line('login_title_enjoy'); ?></h2>
                </div>
            </div>
            
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
                    <label class="form-label"><?php echo $this->lang->line('username'); ?> <span></span></label> 
                    <div class="col-md-6 col-sm-12">
                        <input name="email" type="text" id="user_name" placeholder="<?php echo $this->lang->line('email'); ?>" class="form-control" value="<?php echo set_value('email',$this->input->cookie(SESSION.'email'));?>"/>
                    <?=form_error('email')?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('password'); ?> <span></span></label>
                    <div class="col-md-6 col-sm-12">
                        <input name="password" type="password" id="password" placeholder="<?php echo $this->lang->line('password'); ?>" value="<?php echo $this->input->cookie(SESSION.'password');?>" class="form-control"/>
                    </div>
                    <div class="clearfix"></div>
                </div>        
                <div class="form-group">
                    <label class="terms">
                        <input name="remember" type="checkbox" value="yes" <?php if($this->input->cookie(SESSION.'email')) echo "checked" ?>/>
                    <?php echo $this->lang->line('remember_me'); ?> <a class="forgot" href="<?php echo site_url("users/login/forgot");?>"><?php echo $this->lang->line('forgot_password'); ?></a>
                    </label>
                </div>
            
                <div class="form-btn-grp">                    
                    <input type="submit" class="submit btn btn-blue form-btn-fix" value="<?php echo $this->lang->line('login'); ?>" />
                </div>
                
            </div>
        </div>
    </form>
    <div class="sign_up no_account">
        <?php echo $this->lang->line('don_have_acount'); ?> <a href="<?php echo site_url('register'); ?>"><strong><?php echo $this->lang->line('sign_up_now'); ?></strong></a>
    </div> 
</div>   
<!-- 
<a id="fb_login_button" onclick="javascript:login();" class="fb">sign in with facebook</a>
-->
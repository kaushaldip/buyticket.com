<form id="activate_account" name="activate_account" method="post" action="" class="frm_rg login registration" autocomplete="off">
	<h2><?php echo ucwords(SITE_NAME); ?> <?php echo $this->lang->line("account"); ?><br/><span class="login_desc"><?php echo $this->lang->line('activate_account'); ?></span></h2>    
    <?php if($this->session->flashdata('error')){ ?>
    <div class="alert alert-error">  
      <a class="close" data-dismiss="alert">&times;</a>
      <?php echo $this->session->flashdata('error');?>
    </div>
    <?php  } ?>
    <?php if($this->session->flashdata('message')){ ?>
    <div class="alert alert-success">  
      <a class="close" data-dismiss="alert">&times;</a>
      <?php echo $this->session->flashdata('message');?>
    </div>
    <?php  } ?>
    <fieldset class="inputs">
        <ol>                        
            <li>
                <input name="email" type="text" class="logintxtbox" id="email" value="" placeholder="Email" />
                <?=form_error('email')?>
            </li>            
            <li>
                <label class="terms">                    
                <a class="forgot" href="<?php echo site_url("users/login");?>"><?php echo $this->lang->line('login'); ?></a>
                </label>
            </li>
            <li>            
                <input name="activate_account_btn" class="submit" type="submit" value="<?php echo $this->lang->line('activate_account'); ?>" class="lbtn"/>                
            </li>
        </ol>
    </fieldset>
</form>
<div class="sign_up no_account">
    <?php echo $this->lang->line('don_have_acount');?><a href="<?php echo site_url("/users/register");?>"> <?php echo $this->lang->line('sign_up_now');?></a>
</div>

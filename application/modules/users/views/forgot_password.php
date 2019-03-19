<div class="row create-event">	
    <form id="forgot_password" name="forgot_password" method="post" action="" class="frm_rg login registration" autocomplete="off">
    	<h1><?php echo $this->lang->line("buyticket_account"); ?></h1>
        <div class="inputs event-div">
            <div class="event-form-main">
                <div class="event-step">
                    <h2 class="login_desc"><?php echo $this->lang->line('forgot_password'); ?></h2>
                </div>
            </div>
            
            <div class="event-form-main inputs">
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
                    <div class="col-md-6 col-sm-12">
                        <input name="email" type="text" class="logintxtbox form-control" id="email" value="" placeholder="<?php echo $this->lang->line('email'); ?>" />
                        <?=form_error('email')?>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <a class="forgot" href="<?php echo site_url("users/login");?>"><?php echo $this->lang->line('login'); ?></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                <div class="form-btn-grp">            
                    <input name="Forgot_password" class="submit  btn btn-blue form-btn-fix" type="submit" value="<?php echo $this->lang->line('forgot_bttn_txt');?>" class="lbtn"/> 
                    <div class="clearfix"></div>               
                </div>                
            </div>
        </div>
    </form>
    <div class="sign_up no_account">
        <?php echo $this->lang->line('don_have_acount');?><a href="<?php echo site_url("/users/register");?>"> <?php echo $this->lang->line('sign_up_now');?></a>
    </div>
</div>
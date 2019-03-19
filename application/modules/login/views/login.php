<div id="mws-login">
    <h1>Administration Login</h1>
    <div class="mws-login-lock"><img src="<?php print(ADMIN_CSS_DIR_FULL_PATH);?>css/icons/24/locked-2.png" alt="" /></div>
    <div id="mws-login-form">
        <form name="admin_login" action="" class="mws-form" method="post">
            
            <div id="mws-login-error" class="mws-form-message error" <?php if($this->session->flashdata('message')) echo 'style="display:block;"';?>>
                <?php if($this->session->flashdata('message')) echo $this->session->flashdata('message');?>            
            </div>
            <div class="mws-form-row">
                <div class="mws-form-item large">
                    <input type="text" class="mws-login-username mws-textinput" placeholder="username" name="username" value="<?php echo set_value('username'); ?>" />
                    <?php echo form_error('username'); ?>
                </div>
            </div>
            <div class="mws-form-row">
                <div class="mws-form-item large">
                    <input type="password" class="mws-login-password mws-textinput" placeholder="password" name="password" />
                    <?php echo form_error('password'); ?>
                </div>
            </div>
            <!--
            <div class="mws-form-row mws-inset">
                <ul class="mws-form-list inline">
                    <li><input type="checkbox" /> <label>Remember me</label></li>
                </ul>
            </div>
            -->
            <div class="mws-form-row">
                <input type="submit" value="Login" class="mws-button green mws-login-button" />
            </div>
        </form>
    </div>
</div>
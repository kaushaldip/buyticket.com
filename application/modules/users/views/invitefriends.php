<aside class="acc_pro">
<div align="center" class="error"><?php echo $this->session->flashdata('message');?></div>
                            		<h1><?php echo $this->lang->line('invite_friends');?></h1>	
				<p><?php echo $this->lang->line('invite_your_friends_and_got');?><?php echo REFER_BONUS;?> <?php echo $this->lang->line('credits_bonus');?></p>
                                   	<div class="infos">
                  <form  method="post" class="frm_rg frm_acc" name="change_password">
                    <fieldset>
                    	<ol>
                        <li>
                          <label><?php echo $this->lang->line('email_1'); ?></label>
                          <p>
                        <input name="email1" type="text" class="" value="" > 
                         <?php echo form_error('email1'); ?>
                        </p>
                        
                        </li>
                         <li>
                          <label><?php echo $this->lang->line('email_2'); ?></label>
                          <p>
                        <input name="email2" type="text" class="" value="" > 
                         <?php echo form_error('email2'); ?>
                        </p>
                        
                        </li>
						
						<li>
                          <label><?php echo $this->lang->line('email_3'); ?></label>
                          <p>
                        <input name="email3" type="text" class="" value="" > 
                         <?php echo form_error('email3'); ?>
                        </p>
                        
                        </li>
						<li>
                          <label><?php echo $this->lang->line('email_4'); ?></label>
                          <p>
                        <input name="email4" type="text" class="" value="" > 
                         <?php echo form_error('email4'); ?>
                        </p>
                        
                        </li>
						<li>
                          <label><?php echo $this->lang->line('email_5'); ?></label>
                          <p>
                        <input name="email5" type="text" class="" value="" > 
                         <?php echo form_error('email5'); ?>
                        </p>
                        
                        </li>
						 
						
						 <li><label>&nbsp;</label>
                        <p>
                       <button type="submit"><?php echo $this->lang->line('invite_now'); ?></button>
                        </p>
                        
                        </li>
                       
                      
                        </ol>
                    </fieldset>
                    </form>
                                    </div>
                            </aside>
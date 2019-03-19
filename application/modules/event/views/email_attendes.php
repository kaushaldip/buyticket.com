<style>
td{padding: 0 10px;}
</style>
<div class="row">
    <div class="col-md-12">
        <?php $organizer_email=$this->event_model->email_organizer_of_event($data_event->organizer_id); 
        echo $this->session->flashdata('msgg');
        
        ?>
        <h3 class="margin-bottom-10 no-margin-top"><?=$this->lang->line('create_new_attendee_email');?></h3>
        
        <form method="post" class="form-horizontal">
            <table cellpadding="4">
            
            <tbody><tr height="40" valign="middle">
            	<td align="right" width="180"><b><?=$this->lang->line('name');?>:</b></td>
            	<td>
            		<input title="By default your organizer's name" name="from_name" id="from_name" value="<?=$data_event->title ?>" class="textbox" type="text" style="width: 450px;"><br>
            	</td>
            </tr>
            <?php /*
            <tr>
            	<td align="right" width="180" valign="top" style="line-height: 20px;"><b><?=$this->lang->line('reply_to_email');?>:</b></td>
            	<td>
            		<input name="from_email" id="from_email" value="<?php echo $organizer_email; ?>" class="textbox" type="text" style="width: 450px;"><br>
            		<small style="line-height: 15px;"><?=$this->lang->line('email_example')?></small><br>
            	</td>
            </tr>
            */?>
            <tr height="40" style="margin-bottom: -15px;">
            	<td align="right"><b><?=$this->lang->line('to');?> :</b></td>
            	<td>
            		<select id="reminder_to" name="reminder_to" style="font-size:12px;" onchange="loadTabTicket(this.name);">
            			<option value="ALL_ATTENDEES"><?=$this->lang->line('all_attendees')?></option>
            			
            		</select>
            		&nbsp;
            		<span class="tab" id="summary_selection"></span>
            	</td>
            </tr>
            
            
            
            <tr height="40" valign="middle">
            	<td align="right"><b><?=$this->lang->line('subject')?>:</b></td>
            	<td>
            		<input title="By default, the name of your event will appear as the email subject." name="subject" id="subject" maxlength="100" value="Message to attendees of <?=$data_event->title ?>" class="textbox" type="text" style="width: 450px;">
            	 <?=form_error('subject')?>
                    </td>
            </tr>
            
            <tr>
            	<td valign="top" align="right"><b><?=$this->lang->line('message')?>:</b></td>
            	<td>
            		<?php echo form_fckeditor('attende_email_description', set_value('attende_email_description') );?>
                    <?=form_error('attende_email_description')?>
                    <script>
                    CKEDITOR.config.language = '<?=$this->config->item('language_abbr');?>';
                    </script>
                </td>
            </tr>
            
            
            
            
            
            <tr>
            	<td valign="top" align="right">&nbsp;</td>
            	<td align="left" height="50">
                		<div id="emailbutton" style="align:left;">
                                <input type="submit" value="<?=$this->lang->line('send_msg')?>" class="btn btn-success"/>
            			</div>
            	</td>
            </tr>
            
            </tbody>
            </table>
        </form>
    </div>
</div>
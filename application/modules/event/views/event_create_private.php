<div class="form-group">  
    <label class="form-label" for="input01"><?php echo $this->lang->line('options'); ?></label>  
    <div class="controls col-md-10 col-sm-12">
        <input type="radio" name="op" onclick="$('#specific_emails').hide();" value="1" /> <?php echo $this->lang->line('show_url'); ?>                              
    </div>
    <div class="controls col-md-10 col-sm-12">
        <input type="radio" name="op" onclick="$('#specific_emails').show();" value="0"/> <?php echo $this->lang->line('show_specific_user'); ?>
    </div>
    <div class="clearfix"></div>
    <!-- specific_emails detail start -->  
    <div style="display: none;" id="specific_emails">
        <br clear="all" />
        <div class="controls col-md-10 col-sm-12">
            <input type="button" value="<?=$this->lang->line('add_email')?>" class="btn" onclick="addRow('specific_emailTable')"  />
            <input type="button" value="<?=$this->lang->line('remove_email')?>" class="btn" onclick="deleteRow('specific_emailTable')" />
            <br clear="all" /> <br />
            <table id="specific_emailTable" border="0" cellpadding="0" cellspacing="0" width="100%" class="table_rows_add table table-striped">  
                <tr>    
                    <td width="1"></td>
                    <td><?php echo $this->lang->line('email'); ?>:</td>                                            
                </tr>                  
                <tr>
                    <td align="right"><input type="checkbox" name="chk"/></td>
                    <td><input type="text" name="specific_email[]" id="event_form_specific_email[]" value="<?=set_value('specific_email[]'); ?>" /></td>                    
                </tr>
            </table>
        </div>
    </div>
    <!-- specific_emails detail end -->
</div>
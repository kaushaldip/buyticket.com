<div class="form-group">  
    <label class="form-label" for="input01"><?php echo $this->lang->line('options'); ?></label>  
    <div class="col-md-4 col-sm-4 col-xs-10 ">
        <input type="radio" <?php if($data_event->show_url == '1' ){echo "checked = 'checked'";} ?> name="op" onclick="$('#specific_emails').hide();" value="1" /> <?php echo $this->lang->line('show_url'); ?>                              
    </div>
    <div class="col-md-4 col-sm-4 col-xs-10 ">
        <input type="radio" <?php if($data_event->show_url == '0' ){echo "checked = 'checked'";} ?> name="op"  onclick="$('#specific_emails').show();" value="0"/> <?php echo $this->lang->line('show_specific_user'); ?>
    </div>
    <!-- specific_emails detail start -->  
    <div style="display: <?=($data_event->show_url == '0' ) ? "block" : "none"; ?>;" id="specific_emails">
        <br clear="all" />
               
        <div class="col-md-4 col-sm-4 col-xs-10 ">
            <input type="button"  value="<?=$this->lang->line('add_email')?>" class="btn" onclick="addRow('specific_emailTable')"  />
            <input type="button" value="<?=$this->lang->line('remove_email')?>" class="btn" onclick="deleteRow('specific_emailTable')" />
            <br clear="all" /> <br />
            <table id="specific_emailTable" border="0" cellpadding="0" cellspacing="0" width="100%" class="table_rows_add table table-striped">  
                <tr>    
                    <td width="1"></td>
                    <td><?php echo $this->lang->line('email'); ?>:</td>                                            
                </tr>
                <?php 
                if(!empty($data_event->specific_url)){            
                    $specific_url_arr = explode(',',trim($data_event->specific_url));
                    ?>
                    <?php foreach($specific_url_arr as $sp): if(empty($sp)) continue;?>
                    <tr>
                        <td align="right"><input type="checkbox" name="chk"/></td>
                        <td><input type="text" name="specific_email[]" id="event_form_specific_email[]" value="<?=set_value('specific_email[]',$sp); ?>" /></td>                    
                    </tr>
                    <?php endforeach;?>
                <?php
                }
                ?> 
                <tr>
                    <td align="right"><input type="checkbox" name="chk"/></td>
                    <td><input type="text" name="specific_email[]" id="event_form_specific_email[]" value="<?=set_value('specific_email[]'); ?>" /></td>                    
                </tr>
            </table>
        </div>
    </div>
    <!-- specific_emails detail end -->
</div>
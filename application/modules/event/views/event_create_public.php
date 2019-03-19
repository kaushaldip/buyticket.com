<style>
table.table_rows_add input[type='text']{width: 180px !important;}
</style>
    <div class="form-group">
        <label class="form-label" for="input01"><?php echo $this->lang->line('event_category'); ?>*</label>
        <div class=" col-md-5 col-sm-12">
            <select name="event_type" class="required form-control" id="event_form_event_type_id" style="width: auto; float: left;" title="&nbsp;" onchange="show_sub_category();">
                <option value=""><?php echo $this->lang->line('select_category'); ?></option>
                <?php foreach($categories as $category): ?>
                <option value="<?=$category->name; ?>">
                <?php
                echo ucwords($category->name);
                ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class=" col-md-5 col-sm-12">
            <span style="display:none;" id="wait_1">
                <img src="<?=MAIN_IMAGES_DIR_FULL_PATH?>ajax-loader.gif" alt="Please Wait"/>
            </span>
            <div id="sub_category_div" style="display: none;">
                <label class="pull-left"><?php echo $this->lang->line('event_sub_category'); ?></label>
                <select id="remain_sub_category" name="event_type_id" style="float: left; width: auto; margin-left: 10px;" class="required form-control" title="&nbsp;">
                    <option value=""><?php echo $this->lang->line('sub_category'); ?></option>                                        
                </select>                  
            </div>                  
        </div>            
        <div class="clearfix"></div>
    </div>
    
    <!-- affiliate block start -->
    <div class="form-group">
        <label class="form-label" for="input01"><?php echo $this->lang->line('event_marketing'); ?></label>  
        <div class=" col-md-10 col-sm-12">
            <div class="col-md-3 col-sm-5 col-xs-10">
                <input type="radio" value="yes" name="affilate_event" /> <?php echo $this->lang->line('yes'); ?> 
                <input type="radio" value="no" name="affilate_event"/> <?php echo $this->lang->line('no'); ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2"><i class="fa fa-exclamation-circle tooltip-i" data-toggle="tooltip" data-placement="top" title="<?=$this->lang->line('referral_system_for_marketing')?>"></i></div>
            <div class="col-md-7 col-sm-5 col-xs-12">
                <label class="error" id="error_event_mgmt"></label>
            </div>
            <div class="clearfix"></div>                
            <div id="event_affilate_block" style="display: none;">
                <?php $event_affiliates = explode(',',EVENT_AFFILIATE_RATE);?>
                <select class="form-control" name="affiliate_referral_rate">
                    <?php foreach($event_affiliates as $affiliate): ?>
                    <option value="<?=$affiliate;?>"><?=$affiliate;?> <?=$this->lang->line('of_ticket_price')?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
    </div>
    <!-- affiliate block end -->
    
    <!-- organizers detail start -->
    <div class="form-group">        
        <label class="form-label" for="input01"><?php echo $this->lang->line('organizer_information'); ?></label>  
        <div class=" col-md-10 col-sm-12">   
            <!--load old organizers start-->
            <?php if($organizers){ $i=0;?>  
                <h5><?php echo $this->lang->line('existing_organizer'); ?>:</h5>
                <?php foreach($organizers as $organizer): ?>
                    <div class="form-group span2 col-md-2 col-sm-2">                        
                        <input name="old_organizer<?=$i; ?>" value="<?=$organizer->id;?>" type="checkbox" /> <?=$organizer->name;?>
                    </div>
                <?php $i++; endforeach; ?>
                <br clear="all" />
            <?php } ?>
            <!--load old organizers start-->
            <input type="button" value="<?=$this->lang->line('add_organizer')?>" class="btn" onclick="addRow('organizerTable')"  />
            <input type="button" value="<?=$this->lang->line('remove_organizer')?>" class="btn" onclick="deleteRow('organizerTable')" />
            <br clear="all" /><br />  
            <table id="organizerTable" border="0" cellpadding="0" cellspacing="0" width="90%" class="table_rows_add table table-striped">
                <tr>    
                    <td width="1"></td>
                    <td><?php echo $this->lang->line('organizer_name'); ?></td>
                    <td><?php echo $this->lang->line('organizer_logo'); ?></td>
                    <?/*<td><?php echo $this->lang->line('organizer_description'); ?></td>*/?>
                </tr>                  
                <tr>
                    <td align="right" valign="top"><input type="checkbox" name="chk"/></td>
                    <td><input class="form-control" type="text" name="organizer_name[]" id="event_form_organizer_name[]" value="<?php echo set_value('organizer_name[0]'); ?>" /><?=form_error('organizer_name[]') ?></td>
                    <td><input type="file" name="organizer_logo[]" id="event_form_organizer_logo[]" class="fileType" onchange="pressed(this)" /><label class="fileLabel"><?=$this->lang->line('choose_file');?></label></td>                    
                    <?/*<td><textarea name="organizer_description[]" id="event_form_organizer_description[]"><?php echo set_value('organizer_description[]'); ?></textarea></td>*/?>
                </tr>
            </table>
        </div>
    </div>        
    <!-- organizers detail end -->
    
    <!-- Sponsor detail start -->
    <div class="form-group">
        <label class="form-label" for="input01"><?php echo $this->lang->line('sponsor_information'); ?></label>
        <div class="controls col-md-10 col-sm-12">
            <input type="button" value="<?=$this->lang->line('add_sponsor')?>" class="btn" onclick="addRow('sponsorTable')"  />
            <input type="button" value="<?=$this->lang->line('remove_sponsor')?>" class="btn" onclick="deleteRow('sponsorTable')" />
            <br clear="all" /> <br />
        
            <table id="sponsorTable" border="0" cellpadding="0" cellspacing="0" width="90%" class="table_rows_add table table-striped">  
                <tr>    
                    <td width="1"></td>
                    <td><?php echo $this->lang->line('sponsor_name'); ?>:</td>
                    <td><?php echo $this->lang->line('sponsor_type'); ?>:</td>
                    <td><?php echo $this->lang->line('sponsor_logo'); ?>:</td>    
                    <?/*<td><?php echo $this->lang->line('sponsor_description'); ?>:</td>*/?>                    
                </tr>                  
                <tr>
                    <td align="right"><input type="checkbox" name="chk"/></td>
                    <td><input type="text" name="sponsor_name[]" class="form-control" id="event_form_sponsor_name[]" value="<?=set_value('sponsor_name[]'); ?>" /></td>
                    <td><input type="text" name="sponsor_type[]" class="form-control" id="event_form_sponsor_type[]" value="<?=set_value('sponsor_type[]'); ?>" /></td>
                    <td><input type="file" name="sponsor_logo[]" id="event_form_sponsor_logo[]" class="fileType" onchange="pressed(this)" /><label class="fileLabel"><?=$this->lang->line('choose_file');?></label></td>
                    <?/*<td><textarea name="sponsor_description[]" id="event_form_sponsor_description[]"><?php echo set_value('sponsor_description[]'); ?></textarea></td>*/?>
                </tr>
            </table>
        </div>
        
    </div>
    <!-- Sponsor detail end -->
    
    <!-- performer blcok start-->
    <div class="form-group">        
    <label class="form-label" for="input01"><?php echo $this->lang->line('performer_information'); ?></label>  
    <div class=" col-md-10 col-sm-12">   
        <!--load old organizers start-->
        <?php if ($performers) {
            $i = 0; ?>  
            <h5><?=$this->lang->line('select_existing_performer');?>:</h5>
            <?php foreach ($performers as $performer): ?>
               
                <div class="form-group span2 col-md-2 col-sm-2">                        
                    <input name="old_performer<?= $i; ?>" value="<?= $performer->id; ?>" type="checkbox" /> <?= $performer->performer_name; ?>
                </div>
                <?php $i++;
            endforeach; ?>
            <br clear="all" />
        <?php } ?>
        <!--load old organizers start-->
        <input type="button" value="<?php echo $this->lang->line('add_Performer'); ?>" class="btn" onclick="addRow('performerTable')"  />
        <input type="button" value="<?php echo $this->lang->line('remove_Performer'); ?>" class="btn" onclick="deleteRow('performerTable')" />
        <br clear="all" /><br />  
        <table id="performerTable" border="0" cellpadding="0" cellspacing="0" width="90%" class="table_rows_add table table-striped">
            <tr>    
                <td width="1"></td>
                <td><?php echo $this->lang->line('performer_name'); ?></td>
                <td><?php echo $this->lang->line('performer_type'); ?></td>
                <td><?php echo $this->lang->line('performer_description'); ?></td>
            </tr> 
                          
            <tr>
                <td align="right" valign="top"><input type="checkbox" name="chk"/></td>
                <td><input class="form-control" type="text" name="performer_name[]" id="event_form_performer_name[]" value="<?php echo set_value('performer_name[0]'); ?>" /><?= form_error('performer_name[]') ?></td>
                <td><select class="form-control" name="performer_type[]" id="event_form_performer_type[]">
                        <option value=""><?=$this->lang->line('select_option');?></option>
                        <?php 
                        $perf_typ=$this->general->get_performet_type();
                        foreach($perf_typ as $p):
                            
                            ?>
                                <option value="<?=$p->id ?>"><?=$p->performer_type ?></option>
                            
                        <?php endforeach; ?>
                    </select>
                    <?php /*
                    <!--<input type="text" name="performer_type[]" id="event_form_performer_type[]" value="<?php echo set_value('performer_type[0]'); ?>"/>--> */?>
                </td>
                <td><textarea class="form-control" name="performer_description[]" id="event_form_performer_description[]"><?php echo set_value('performer_description[]'); ?></textarea></td>
            </tr>
        </table>
    </div>
</div>  
    <?php /* 
    <!--<div id="performer_menu">
        <div class="form-group">  
            <label class="form-label" for="input01"><?php echo $this->lang->line('performer_information'); ?></label>  
            <div class="controls col-md-10 col-sm-12">                
                <?php if($performers){?>
                <select name="performer_id" id="performer_id">
                    <option value="0"><?php echo $this->lang->line('no_performer'); ?></option>
                    <?php foreach($performers as $performer): ?>
                    <option value="<?=$performer->id;?>"><?=$performer->performer_name;?></option>
                    <?php endforeach;?>
                </select>
                <?php } ?>
                <a style="cursor: pointer;" id="add_perfomer">+ Add New</a><?php if($performers){?> | <a style="cursor: pointer;" id="edit_performer"><?php echo $this->lang->line('edit'); ?></a> <?php } ?>
            </div>
        </div>
    </div>-->
    <!--<div id="performer_form" style="display: none;">
        <div class="form-group">
            <label class="form-label" for="input01"><?php echo $this->lang->line('performer_name'); ?></label>
            <div class="controls col-md-10 col-sm-12">
                <input type="text" name="performer_name" class="required" id="performer_name" value="<?=set_value('performer_name') ?>" /> 
                <a style="cursor: pointer;" id="cancel_performer"><?php echo $this->lang->line('cancle'); ?></a>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label" for="input01"><?php echo $this->lang->line('performer_type'); ?></label>
            <div class="controls col-md-10 col-sm-12">
                <input type="text" name="performer_type" class="required" id="performer_type" value="<?=set_value('performer_type') ?>" />
            </div>
        </div>
        <div class="form-group">
            <label class="form-label" for="input01"><?php echo $this->lang->line('performer_description'); ?></label>
            <div class="controls col-md-10 col-sm-12">
                <textarea name="performer_description" id="performer_description"><?=set_value('performer_description'); ?></textarea>
            </div>
        </div>          
    </div>-->
    */?>
    <input name="performer_check" id="performer_check" value="<?=($performers)? $performers[0]->id: "no";?>" type="hidden" />  
    <input name="performer_check_edit" id="performer_check_edit" value="" type="hidden" />
    <!-- performer blcok end-->
    
    
    
    <div class="form-group">  
        <label class="form-label" for="input01"><?php echo $this->lang->line('keywords'); ?></label>  
        <div class=" col-md-10 col-sm-12">
            <input type="text" class="input-xxlarge form-control" name="event_keywords" id="event_form_keywords" value="<?php echo set_value('event_keywords'); ?>" /><br/><?=$this->lang->line("keywords should be separated by by a comma")?>
            <?=form_error('event_keywords') ?> 
        </div>  
    </div>
    <?/*
    <div class="form-group">  
        <label class="form-label" for="input01"><?php echo $this->lang->line('website'); ?></label>  
        <div class=" col-md-10 col-sm-12 website_buyticket">
            <input type="text"  name="event_website" class="input-medium nicename" id="event_form_website" value="<?php echo set_value('event_website'); ?>"  /> .buyticket.com
            <?=form_error('event_website') ?>              
        </div>  
    </div>
    */?>


<script>
$(document).ready(function(){
    $('#wait_1').hide();    
});

function show_sub_category(){    
    $('#sub_category_div').hide();
    $('#wait_1').show();
    var category = $("#event_form_event_type_id").val();
    $.ajax({
        type: "POST",
        url: site_url+"event/show_sub_category",  
        data: "category="+category,          
        success: function(msg){
                if(msg=='empty'){
                    $('#sub_category_div').hide();
                }else{
                    $('#sub_category_div').show();
                    $("#remain_sub_category").empty();
                    $("#remain_sub_category").append(msg);    
                }
                $('#wait_1').hide();
                return false;
        }     
    });
}
</script>
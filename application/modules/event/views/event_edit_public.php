<script>
$(document).ready(function(){
    $(".ajax0").on("click",function(){
        url = $(this).attr("url");
        loaderOn();
        $.ajax({
            url: url,
            type:'POST',
            data:'',
            success:function(msg){
                $("#mainModal #mainModalLabel").html("Edit Organizer");
                $("#mainModal #mainModalBody").html(msg);
                $("#mainModal").modal("show");
                loaderOff();                
                $("#edit_organiser").ajaxForm({
                    beforeSend: function(){
                        loaderOn();
                    },
                    beforeSubmit: function(){
                        return $("#edit_organiser").valid();
                    },
                    success:function(r){                        
                        var substr = r.split('--');
                        $("#mainModal #mainModalBody").html("<?=$this->lang->line('update_successfull_message')?>");                           
                        $('#logo_'+substr[2]).html(substr[0]);
                        $('#name_'+substr[2]).html(substr[1]);
                        loaderOff();  
                    }
                });
            }
        });          
    });
    
    $(".ajax1").on("click",function(){
        url = $(this).attr("url");
        loaderOn();
        $.ajax({
            url: url,
            type:'POST',
            data:'',
            success:function(msg){
                $("#mainModal #mainModalLabel").html("Edit Sponsor");
                $("#mainModal #mainModalBody").html(msg);
                $("#mainModal").modal("show");
                loaderOff();               
                
                $("#edit_sponser").ajaxForm({
                    beforeSend: function(){
                        loaderOn();
                    },
                    beforeSubmit: function(){
                        return $("#edit_sponser").valid();
                    },
                    success:function(r){                        
                        var substr = r.split('--');                        
                        $("#mainModal #mainModalBody").html("<?=$this->lang->line('update_successfull_message')?>");                                            
                        $('#logo1_'+substr[2]).html(substr[0]);
                        $('#name1_'+substr[2]).html(substr[1]);
                        $('#type1_'+substr[2]).html(substr[3]);   
                        loaderOff();                                    
                    }
                });
                
            }
        });          
    });
    
    $(".ajax2").on("click",function(){
        url = $(this).attr("url");
        loaderOn();
        $.ajax({
            url: url,
            type:'POST',
            data:'',
            success:function(msg){
                $("#mainModal #mainModalLabel").html("Edit Performer");
                $("#mainModal #mainModalBody").html(msg);
                $("#mainModal").modal("show");
                loaderOff(); 
                $("#edit_performer_1").ajaxForm({
                    beforeSend: function(){
                        loaderOn();
                    },
                    beforeSubmit: function(){
                        return $("#edit_performer_1").valid();
                    },
                    success:function(r){                
                        var substr = r.split('--');
                        $("#mainModal #mainModalBody").html("<?=$this->lang->line('update_successfull_message')?>");                        
                        $('#name3_'+substr[1]).html(substr[0]);
                        $('#type3_'+substr[1]).html(substr[2]);
                        loaderOff(); 
                    }
                });
            }
        });          
    });
})

</script>
<?php
$event_type = $this->category->get_category_byid($data_event->event_type_id);
$event_type_name = (is_object($event_type))? $event_type->name : "";
?>
<div class="form-group">
    <label class="form-label" for="input01"><?php echo $this->lang->line('event_category'); ?>*</label>
    <div class=" col-md-5 col-sm-12">
        <select name="event_type" class="required" id="event_form_event_type_id" style="width: auto; float: left;" title="&nbsp;" onchange="show_sub_category();">
            <option value=""><?php echo $this->lang->line('select_category'); ?></option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->name; ?>" <?= ( $event_type_name== $category->name ) ? "selected='selected'" : ""; ?>>
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
        <div id="sub_category_div" <?= ($data_event->event_type_id == 0) ? 'style="display: none;"' : 'style="display: block;"'; ?>>
            <label class="form-label"><?php echo $this->lang->line('event_sub_category'); ?></label>
            <select id="remain_sub_category" name="event_type_id" style="float: left; margin-left: 10px;" class="required" title="&nbsp;">
                <option value=""><?php echo $this->lang->line('sub_category'); ?></option>                                                  <?php
            $subcategories = $this->data['subcategories'] = $this->category->get_only_sub_category_lists_by_category($event_type->name);
            foreach ($subcategories as $subcategory):
                $selected = ($subcategory->id == $data_event->event_type_id) ? "selected='selected'" : "";
                echo '<option value="' . $subcategory->id . '"' . $selected . '>';                
                    echo ucwords($subcategory->sub_type);
                    echo (!empty($subcategory->sub_sub_type)) ? ' / ' . $subcategory->sub_sub_type : '';
                
                echo "</option>";
            endforeach;
            ?>
            </select>                  
        </div>                  
    </div>  
    <div class="clearfix"></div>          
</div>


<!-- affiliate block start -->
<div class="form-group">  
    <label class="form-label" for="input01"><?php echo $this->lang->line('event_marketing'); ?></label>  
    <div class="col-md-10 col-sm-10 col-xs-10  ">
        <?php if($data_event->affiliate_referral_rate!='0.00'){
            $affilate=1;
        }else {
             $affilate=0;
        } ?>
        <div class="col-md-3 col-sm-5 col-xs-10">
            <input type="radio" value="yes" name="affilate_event" <?php if($affilate==1) echo "checked='checked'"; ?> /> <?php echo $this->lang->line('yes'); ?> 
            <input type="radio" value="no" name="affilate_event" <?php if($affilate==0) echo "checked='checked'"; ?>/> <?php echo $this->lang->line('no'); ?>
        </div>
        <div class="col-md-2 col-sm-2 col-xs-2"><i class="fa fa-exclamation-circle tooltip-i" data-toggle="tooltip" data-placement="top" title="<?=$this->lang->line('referral_system_for_marketing')?>"></i></div>
        <div class="col-md-7 col-sm-5 col-xs-12">   
            <label class="error" id="error_event_mgmt"></label>
        </div>
        <div class="clearfix"></div>           
        <div id="event_affilate_block" <?php if($affilate==0) echo 'style="display: none;"'; ?>>
            <?php $event_affiliates = explode(',', EVENT_AFFILIATE_RATE); ?>
            <select name="affiliate_referral_rate">                                            
                <?php foreach ($event_affiliates as $affiliate): ?>
                    <option value="<?= $affiliate; ?>" <?php if($data_event->affiliate_referral_rate==$affiliate.'.00') echo 'selected="selected"';?>><?=$affiliate; ?> <?=$this->lang->line('of_ticket_price')?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>
<!-- affiliate block end -->

<!-- organizers detail start -->
<div class="form-group">        
    <label class="form-label" for="input01"><?php echo $this->lang->line('organizer_information'); ?></label>  
    <div class="col-md-10 col-sm-10 col-xs-10 ">   
        <!--already organizer list start-->
        <?php if ($organizers_alerady): ?>        
        <div class="table-responsive">            
            <table width="90%" border="0" cellpadding="0" cellspacing="0" class="ticket_table table_rows_add table table-striped" style="border-collapse: collapse;">                       
                <tbody>
                    <tr class="ticket_table_head">        
                        <th>&nbsp;</th>
                        <th><?php echo $this->lang->line('organizer_name'); ?></th>
                        <th><?php echo $this->lang->line('actions'); ?></th>
                    </tr>
                    <?php foreach ($organizers_alerady as $oal): ?>
                    <?php
                    $organizer_image = UPLOAD_FILE_PATH."organizer/thumb_".$oal->logo;
                    $organizer_logo = (file_exists($organizer_image))? $organizer_image: UPLOAD_FILE_PATH.'sponsor_logo.jpg';
                    ?>
                    <tr id="delete_r_<?=$oal->relation_id ?>">
                        <td id="logo_<?=$oal->organizer_id ?>"><img  src="<?=base_url().$organizer_logo; ?>"/></td>
                        <td id="name_<?=$oal->organizer_id ?>"><?= $oal->name ?></td>
                        <td><a href="javascript:void(0);" url="<?=site_url('event/edit_event_organizer/'.$oal->organizer_id) ?>" class="ajax0"><?php echo $this->lang->line('edit'); ?></a>&nbsp;|&nbsp;<a href="javascript:void(0);" kds="<?=$oal->relation_id ?>" class="delete_organiser"><?php echo $this->lang->line('delete'); ?></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        <!--already organizer list end-->
        
        <!--existing organizer list start-->
        <?php if ($organizers) {
            $i = 0; ?>  
            <h5><?php echo $this->lang->line('existing_organizer'); ?>:</h5>
            <?php foreach ($organizers as $organizer): ?>
                <?php if ($this->event_model->already_organizer_of_event($organizer->id, $data_event->id))
                    continue; 
                    if(($i%5)==0 && $i>0) echo "<br clear='all'/>";        
                    ?>
                <div class="form-group col-md-3">                        
                    <input name="old_organizer<?= $i; ?>" value="<?= $organizer->id; ?>" type="checkbox" /> <?= $organizer->name; ?>
                </div>
                <?php $i++;
            endforeach; ?>
            <br clear="all" />
        <?php } ?>
        <!--existing organizer list end-->
                
        <input type="button" value="<?=$this->lang->line('add_organizer')?>" class="btn" onclick="addRow('organizerTable')"  />
        <input type="button" value="<?=$this->lang->line('remove_organizer')?>" class="btn" onclick="deleteRow('organizerTable')" />
        
        <div class="table-responsive margin-top-10"> 
            <table id="organizerTable" border="0" cellpadding="0" cellspacing="0" width="90%" class="table_rows_add table table-striped">
                <tr>    
                    <td width="1"></td>
                    <td><?php echo $this->lang->line('organizer_name'); ?></td>
                    <td><?php echo $this->lang->line('organizer_logo'); ?></td>
                    <?/*<td><?php echo $this->lang->line('organizer_description'); ?></td>*/?>
                </tr> 
                              
                <tr>
                    <td align="right" valign="top"><input type="checkbox" name="chk"/></td>
                    <td><input type="text" name="organizer_name[]" id="event_form_organizer_name[]" value="<?php echo set_value('organizer_name[0]'); ?>" /><?= form_error('organizer_name[]') ?></td>
                    <td><input type="file" name="organizer_logo[]" id="event_form_organizer_logo[]" class="fileType" onchange="pressed(this);" /><label class="fileLabel"><?=$this->lang->line('choose_file') ?></label></td>
                    <?/*<td><textarea name="organizer_description[]" id="event_form_organizer_description[]"><?php echo set_value('organizer_description[]'); ?></textarea></td>*/?>
                </tr>
            </table>
        </div>
    </div>
</div>        
<!-- organizers detail end -->


<!-- Sponsor detail start -->
<div class="form-group">
    <label class="form-label" for="input01"><?php echo $this->lang->line('sponsor_information'); ?></label>
    <div class="col-md-10 col-sm-10 col-xs-10  ">
        <!-- Existing sponsor start -->
        <?php if($current_sponser): ?>
        <div class="table-responsive">    
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="ticket_table table_rows_add table table-striped" style="border-collapse: collapse;">            
                <tbody>
                    <tr class="ticket_table_head">    
                        <th>&nbsp;</th>    
                        <th><?php echo $this->lang->line('sponsor_name'); ?></th>
                        <th><?php echo $this->lang->line('sponsor_type'); ?></th>
                        <th><?php echo $this->lang->line('actions'); ?></th>
                    </tr>
                    <?php foreach ($current_sponser as $oal): ?>
                    <?php
                    $organizer_image = UPLOAD_FILE_PATH."sponsor/thumb_".$oal->logo;
                    $organizer_logo = (file_exists($organizer_image))? $organizer_image: UPLOAD_FILE_PATH.'sponsor_logo.jpg';
                    ?>
                    <tr id="delete_rl_<?=$oal->int ?>">
                        <td id="logo1_<?=$oal->int ?>"><img src="<?=base_url().$organizer_logo; ?>" height="20px" /></td>
                        <td id="name1_<?=$oal->int ?>"><?= $oal->name ?></td>
                        <td id="type1_<?=$oal->int ?>"><?= $oal->type ?></td>
                        <td><a href="javascript:void(0);" url="<?=site_url('event/edit_event_sponser/'.$oal->int) ?>" class="ajax1"><?php echo $this->lang->line('edit'); ?></a>&nbsp;|&nbsp;<a href="javascript:void(0);" kds="<?=$oal->int ?>" class="delete_sponser"><?php echo $this->lang->line('delete'); ?></a></td>
                    </tr>
                    
                        
                   
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        <!-- Existing sponsor end -->
        
        <input type="button" value="<?=$this->lang->line('add_sponsor')?>" class="btn" onclick="addRow('sponsorTable')"  />
        <input type="button" value="<?=$this->lang->line('remove_sponsor')?>" class="btn" onclick="deleteRow('sponsorTable')" />
        <div class="table-responsive margin-top-10">
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
                    <td><input type="text" name="sponsor_name[]" id="event_form_sponsor_name[]" value="<?= set_value('sponsor_name[]'); ?>" /></td>
                    <td><input type="text" name="sponsor_type[]" id="event_form_sponsor_type[]" value="<?=set_value('sponsor_type[]'); ?>" /></td>
                    <td><input type="file" name="sponsor_logo[]" id="event_form_sponsor_logo[]" class="fileType" onchange="pressed(this);" /><label class="fileLabel"><?=$this->lang->line('choose_file') ?></label></td>
                    <?/*<td><textarea name="sponsor_description[]" id="event_form_sponsor_description[]"><?php echo set_value('sponsor_description[]'); ?></textarea></td>*/?>
                </tr>
            </table>
        </div>
    </div>
</div>
<!-- Sponsor detail end -->

<!-- performer blcok start-->
<div class="form-group">        
    <label class="form-label" for="input01"><?php echo $this->lang->line('performer_information'); ?></label>  
    <div class="col-md-10 col-sm-10 col-xs-10 ">   
        <?php if ($performer_alerady): ?>
        <div class="table-responsive">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="ticket_table table_rows_add table table-striped" style="border-collapse: collapse;">            
                <tbody>
                    <tr class="ticket_table_head">        
                        <td><?php echo $this->lang->line('performer_name'); ?></td>
                        <td><?php echo $this->lang->line('performer_type'); ?></td>
                        <td><?php echo $this->lang->line('actions'); ?></td>
                    </tr>
                    <?php foreach ($performer_alerady as $oal): ?>
                    <tr id="delete_pr_<?=$oal->relation_id ?>">
                            <td id="name3_<?=$oal->performer_id ?>"><?=$oal->performer_name ?></td>
                            <td id="type3_<?=$oal->performer_id ?>">
                                <?php 
                                $per_type = $this->db->select('performer_type')->where(array('id'=>$oal->performer_type))->from('es_performer_type')->get()->row();
                                    echo $per_type->performer_type;
                                ?>
                            </td>
                            <td><a href="javascript:void(0);" url="<?=site_url('event/edit_event_performer/'.$oal->performer_id) ?>" class="ajax2"><?php echo $this->lang->line('edit'); ?></a>&nbsp;|&nbsp;<a href="javascript:void(0);" kds="<?=$oal->relation_id ?>" class="delete_performer"><?php echo $this->lang->line('delete'); ?></a></td>
                        </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        <!--load old organizers start-->
        <?php if ($performers) {
            $i = 0; ?>  
            <h5><?=$this->lang->line('select_existing_performer');?>:</h5>
            <?php foreach ($performers as $performer): ?>
               <?php if ($this->event_model->already_performer_of_event($performer->id, $data_event->id))
                    continue;
                    if(($i%5)==0 && $i>0) echo "<br clear='all'/>";                     
                    ?>                    
                    <div class="form-group col-md-3">                        
                        <input name="old_performer<?= $i; ?>" value="<?= $performer->id; ?>" type="checkbox" /> <?= $performer->performer_name; ?>
                    </div>
                <?php 
                
                $i++;
            endforeach; ?>
            <br clear="all" />
        <?php } ?>
        
        <!--load old organizers start-->
        <input type="button" value="<?php echo $this->lang->line('add_Performer'); ?>" class="btn" onclick="addRow('performerTable')"  />
        <input type="button" value="<?php echo $this->lang->line('remove_Performer'); ?>" class="btn" onclick="deleteRow('performerTable')" />
        <div class="table-responsive margin-top-10">  
            <table id="performerTable" border="0" cellpadding="0" cellspacing="0" width="90%" class="table_rows_add table table-striped">
                <tr>    
                    <td width="1"></td>
                    <td><?php echo $this->lang->line('performer_name'); ?></td>
                    <td><?php echo $this->lang->line('performer_type'); ?></td>
                    <td><?php echo $this->lang->line('performer_description'); ?></td>
                </tr> 
                              
                <tr>
                    <td align="right" valign="top"><input type="checkbox" name="chk"/></td>
                    <td><input type="text" name="performer_name[]" id="event_form_performer_name[]" value="<?php echo set_value('performer_name[0]'); ?>" /><?= form_error('performer_name[]') ?></td>
                    <td>
                        <select name="performer_type[]" id="event_form_performer_type[]">
                            <option value=""><?=$this->lang->line('select_option');?></option>
                            <?php 
                            $perf_typ=$this->general->get_performet_type();
                            foreach($perf_typ as $p):
                                ?>
                                    <option value="<?=$p->id ?>"><?=$p->performer_type ?></option>
                                
                                <?php    
                            endforeach; ?>
                        </select>
                        <?php /*
                        <!--<input type="text" name="performer_type[]" id="event_form_performer_type[]" value="<?php echo set_value('performer_type[0]'); ?>"/>--> */?>
                    </td>
                    <td><textarea name="performer_description[]" id="event_form_performer_description[]"><?php echo set_value('performer_description[]'); ?></textarea></td>
                </tr>
            </table>
        </div>
    </div>
</div>   
<?php /*
<!--<div id="performer_menu" >
    <div class="form-group">  
        <label class="form-label" for="input01"><?php echo $this->lang->line('performer_information'); ?></label>  
        <div class="col-md-10 col-sm-10 col-xs-10  ">                
            <?php if ($performers) { ?>
                <select name="performer_id" id="performer_id">
                    <option value="0"><?php echo $this->lang->line('no_performer'); ?></option>
                    <?php foreach ($performers as $performer): ?>
                        <option value="<?= $performer->id; ?>"><?= $performer->performer_name; ?></option>
                    <?php endforeach; ?>
                </select>
            <?php } ?>
            <a style="cursor: pointer;" id="add_perfomer">+ Add New</a><?php if ($performers) { ?> | <a style="cursor: pointer;" id="edit_performer"><?php echo $this->lang->line('edit'); ?></a> <?php } ?>
        </div>
    </div>
</div>-->

<!--<div id="performer_form" style="display: none;">
    <div class="form-group">
        <label class="form-label" for="input01"><?php echo $this->lang->line('performer_name'); ?></label>
        <div class="col-md-10 col-sm-10 col-xs-10  ">
            <input type="text" name="performer_name" class="required" id="performer_name" value="<?= set_value('performer_name') ?>" /> 
            <a style="cursor: pointer;" id="cancel_performer"><?php echo $this->lang->line('cancle'); ?></a>
        </div>
    </div>
    <div class="form-group">
        <label class="form-label" for="input01"><?php echo $this->lang->line('performer_type'); ?></label>
        <div class="col-md-10 col-sm-10 col-xs-10  ">
            <input type="text" name="performer_type" class="required" id="performer_type" value="<?= set_value('performer_type') ?>" />
        </div>
    </div>
    <div class="form-group">
        <label class="form-label" for="input01"><?php echo $this->lang->line('performer_description'); ?></label>
        <div class="col-md-10 col-sm-10 col-xs-10  ">
            <textarea name="performer_description" id="performer_description"><?= set_value('performer_description'); ?></textarea>
        </div>
    </div>          
</div>-->
*/?>
<input name="performer_check" id="performer_check" value="<?= ($performers) ? $performers[0]->id : "no"; ?>" type="hidden" />  
<input name="performer_check_edit" id="performer_check_edit" value="" type="hidden" />
<!-- performer blcok end-->



<div class="form-group">  
    <label class="form-label" for="input01"><?php echo $this->lang->line('keywords'); ?></label>  
    <div class="col-md-10 col-sm-10 col-xs-10 ">
        <input type="text" class="form-control" name="event_keywords" id="event_form_keywords" value="<?php echo set_value('event_keywords',$event_keywords); ?>" /><br/><?=$this->lang->line("keywords should be separated by by a comma")?>
        <?= form_error('event_keywords') ?> 
    </div>  
</div>
<?/*
<div class="form-group">  
    <label class="form-label" for="input01"><?php echo $this->lang->line('website'); ?></label>  
    <div class="col-md-10 col-sm-10 col-xs-10   website_buyticket">
        <input type="text"  name="event_website" class="input-medium nicename" id="event_form_website" value="<?php echo set_value('event_website',$data_event->website); ?>"  /> .buyticket.com
        <?= form_error('event_website') ?>              
    </div>  
</div>
*/?>


<script>
$(document).ready(function(){
    $('#wait_1').hide();    
});
function show_sub_category(){
    var category = $("#event_form_event_type_id").val();
    $('#wait_1').show();
    $('#sub_category_div').hide();
    $.ajax({
        type: "POST",
        url: site_url+"/event/show_sub_category",  
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
$(".delete_organiser").click(function(){
    if(confirm("Do you want to delete it?")){
        loaderOn();
        var dis=$(this);
        var id=dis.attr('kds');
        //alert(id);
        $.ajax({
            type: "POST",
            url: site_url+"/event/delete_organiser_rel",  
            data: "id="+id,          
            success: function(msg){          
                $("#delete_r_"+id).empty();
                loaderOff();
                return false;
            }     
        });
    }else{
        return false;
    }
});
$(".delete_sponser").click(function(){
    if(confirm("Do you want to delete it?")){
        var dis=$(this);
        var id=dis.attr('kds');
        loaderOn();
        $.ajax({
            type: "POST",
            url: site_url+"/event/delete_sponser_rel",  
            data: "id="+id,          
            success: function(msg){          
                $("#delete_rl_"+id).empty();
                loaderOff();
                return false;
            }     
        });
    }else{
        return false;
    }
});
$(".delete_performer").click(function(){
    if(confirm("Do you want to delete it?")){
        var dis=$(this);
        var id=dis.attr('kds');
        loaderOn();
        $.ajax({
            type: "POST",
            url: site_url+"/event/delete_performer_rel",  
            data: "id="+id,          
            success: function(msg){          
                $("#delete_pr_"+id).empty();
                loaderOff();
                return false;
            }     
        });    
    }else{
        return false;
    }
    
});
</script>
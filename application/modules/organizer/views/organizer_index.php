<?php echo $this->load->view('common/organizer_nav');?>
<div class="col-md-10">    
    <div class="organizer-info">
    	<h3><?php echo $this->lang->line('organizer_information'); ?></h3>
        <?php if($this->session->flashdata('message')){ ?>
        <div class="alert alert-success">  
          <a class="close" data-dismiss="alert">&times;</a>
          <?php echo $this->session->flashdata('message');?>
        </div>
        <?php  } ?>
        <?php if($this->session->flashdata('error')){ ?>
        <div class="alert alert-danger">  
          <a class="close" data-dismiss="alert">&times;</a>
          <?php echo $this->session->flashdata('error');?>
        </div>
        <?php  } ?>
        <form  method="post" class="frm_rg frm_acc" id="organizer_index_form" name="oraganizer_information" enctype="multipart/form-data" onsubmit="return validation_here(this);">
        <div class="box">            
            <div class="box_content">
                <ul class="for_info">        
                    <li>
                        <label><?php echo $this->lang->line('organizer_name'); ?>*</label>
                        <p>
                            <input name="organizer_name" type="text" value="<?php echo ($organizer)? $organizer->organizer_name: set_value('organizer_name');?>" class="required" title="*" />
                            <?php echo form_error('organizer_name'); ?>
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('contact_number'); ?>*</label>
                        <p>
                            <?php echo $this->lang->line('home');?>: <input name="organizer_home_number" type="text" value="<?php echo ($organizer)? $organizer->organizer_home_number: set_value('organizer_home_number');?>"  />
                            <?php echo $this->lang->line('mobile');?>: <input name="organizer_office_number" type="text" value="<?php echo ($organizer)? $organizer->organizer_office_number: set_value('organizer_office_number');?>"class="required" title="*" />
                        </p>
                    </li>
                    <li>
                        <label><?php echo $this->lang->line('upload_official_doc'); ?>*</label>
                        <p>                            
                            <?php if(!empty($organizer->organizer_official_doc)){ ?>
                            <span id="official_download_linker">
                                <a href="<?=site_url('organizer/document')?>"><?=$organizer->organizer_official_doc; ?></a>&nbsp;<a class="btn btn-mini" onclick="$('#official_download_linker').hide();$('#organizer_official_doc_holder').show();"><?=$this->lang->line('change');?></a>   
                            </span>
                            <?php } ?>
                            <span id="organizer_official_doc_holder" style="display: <?=(!empty($organizer->organizer_official_doc))? 'none': 'block' ;?>;" >
                                <input name="organizer_official_doc" type="file" style="max-width: 240px;" class="required" title="*"/>
                                <?php if(!empty($organizer->organizer_official_doc)){?>
                                    <a class="btn btn-mini"  onclick="$('#official_download_linker').show();$('#organizer_official_doc_holder').hide();"><?=$this->lang->line('cancel');?></a>
                                <?php } ?>    
                            </span> 
                            <i class="fa fa-exclamation-circle tooltip-i" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?=$this->lang->line('organizer_file_msg_tooltip');?>"></i>
                        </p>
                    </li>            
                    <li>
                        <label><?php echo $this->lang->line('organizer_detail'); ?></label>                
                        <textarea name="organizer_description" rows="10"><?php print_r($organizer->organizer_description);?></textarea>                    
                        <?php echo form_error('organizer_description'); ?>                
                    </li>            
                </ul>
            </div>            
        </div>
        <p class="update-btn">
            <button type="submit" id="organizer_update_btn" class="btn btn-warning btn-large"><?php echo $this->lang->line('update'); ?></button>
        </p>
        </form>
     </div>
</div>
<script>  
    $(function (){ 
        $(".tooltip-i").tooltip();  
    });  
</script>
<script>
$("#organizer_index_form").validate();
$(document).ready(function(){
    <?php if($profile_data->organizer=='1'){  ?>
    $("#organizer_update_btn").prop('disabled', true);
    <?php } ?>
    $("form :input").change(function() {
        $("#organizer_update_btn").prop('disabled', false);
    })
})
</script>
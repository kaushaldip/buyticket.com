<?php
$organizer_image = UPLOAD_FILE_PATH."sponsor/thumb_".$organizers_detail->logo;
$organizer_logo = (file_exists($organizer_image))? $organizer_image: UPLOAD_FILE_PATH.'sponsor_logo.jpg';
?>
<form id="edit_sponser" action="<?=site_url('event/event_sponser_ajax') ?>" method="post" name="edit_organiser" class="clrfix form-horizontal" enctype="multipart/form-data">
<div class="event-form-main">
    <div class="form-group">
        <label class="col-md-4"><?=$this->lang->line('sponsor_name')?>: <span class="required_field">*</span></label>
        <div class="col-md-8">
            <input type="text" id="organizer_name_sponsor" name="organiser_name" value="<?=$organizers_detail->name ?>" class="form-control required"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4"><?=$this->lang->line('sponsor_type')?>: <span class="required_field">*</span></label>
        <div class="col-md-8">
            <input type="text" id="organizer_name_sponsor_type" name="organiser_type" value="<?=$organizers_detail->type ?>" class="form-control required"/>
        </div>
    </div>
    <div class="form-group">           
        <label class="col-md-4"><?=$this->lang->line('sponsor_logo')?>: <span class="required_field">*</span></label>
        <div class="col-md-8">
            <input type="file" name="organiser_image" />
            <div class="profile_img_holder1"> 
                <img  src="<?=base_url().$organizer_logo; ?>"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <input type="hidden" id="ticket_id" name="organiser_id" value="<?=$organizers_detail->int ?>" >
        <input type="hidden" id="form_contact_organizer_hidden" name="contact_organizer_image" value="<?=base_url().$organizer_logo; ?>">
        <input type="submit" class="submit btn btn-success" name="submit_organiser_edit" id="searchsubmit" value="update"/>                                 
    </div>
</div>
</form>               
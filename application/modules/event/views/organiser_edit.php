<?php
$organizer_image = UPLOAD_FILE_PATH."organizer/thumb_".$organizers_detail->logo;
$organizer_logo = (file_exists($organizer_image))? $organizer_image: UPLOAD_FILE_PATH.'sponsor_logo.jpg';
?>
<form id="edit_organiser" action="" method="post" name="edit_organiser" class="clrfix form-horizontal" enctype="multipart/form-data">
<div class="event-form-main">
    <div class="form-group">
        <label class="col-md-4"><?=$this->lang->line('organizer_name')?>: <span class="required_field">*</span></label>
        <div class="col-md-8">
            <input type="text" name="organiser_name" value="<?=$organizers_detail->name ?>" class="required form-control"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4"><?=$this->lang->line('organizer_logo')?>: <span class="required_field">*</span></label>
        <div class="col-md-8">
            <input type="file" name="organiser_image" />
            <div class="profile_img_holder"> 
                <img  src="<?=base_url().$organizer_logo; ?>"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        <input type="hidden" id="ticket_id" name="organiser_id" value="<?=$organizers_detail->id ?>" />
        <input type="hidden" id="form_contact_organizer_hidden" name="contact_organizer_image" value="<?=base_url().$organizer_logo; ?>" />
        <input type="submit" class="submit btn btn-success" name="submit_organiser_edit" id="searchsubmit" value="update"/>                                 
    </div>
</div>
</form>

                   
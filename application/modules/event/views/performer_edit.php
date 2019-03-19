<form id="edit_performer_1" action="<?=site_url('event/event_performer_ajax') ?>" method="post" name="edit_organiser" class="clrfix form-horizontal" enctype="multipart/form-data"> 
<div class="event-form-main">   
    <div class="form-group">
        <label class="col-md-4"><?=$this->lang->line('performer_name');?>: <span class="required_field">*</span></label>
        <div class="col-md-8">
        <input type="text" name="performer_name" value="<?=$organizers_detail->performer_name ?>" class="form-control required"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4"><?=$this->lang->line('performer_type');?>: <span class="required_field">*</span></label>
        <div class="col-md-8">
            <select name="performer_type" class="form-control required" >
                <option value=""><?=$this->lang->line('select_option');?></option>
                <?php 
                $perf_typ = $this->general->get_performet_type();
                foreach($perf_typ as $p):
                    ?>
                        <option value="<?=$p->id ?>" <?=($p->id==$organizers_detail->performer_type)? "selected='selected'": "" ; ?>><?=$p->performer_type ?></option>                        
                    
                    <?php    
                
                endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4"><?=$this->lang->line('performer_description');?>: </label>
        <div class="col-md-8">        
            <textarea name="performer_description" class="form-control" id="event_form_organizer_description"><?=$organizers_detail->performer_description ?></textarea>
        </div>    
    </div>
    <div class="form-group">
        <input type="hidden" id="ticket_id" name="performer_id" value="<?=$organizers_detail->id ?>" />
        
        <input type="submit" class="submit btn btn-success" name="submit_performer_edit" id="searchsubmit" value="<?=$this->lang->line('update')?>"/>                                 
    </div>
</div>
</form>
<?php echo $this->load->view('common/organizer_nav'); ?>
<div class="col-md-10">    
    <div class="event-management">
    	<h3><?php echo $this->lang->line('event_management'); ?></h3>
        <div class="box">
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
        
            <ul class='tabs nav nav-tabs'>
                <li class="active"><a href='#tab1' data-toggle="tab"><?php echo $this->lang->line('current_events'); ?></a></li>
                <li><a href='#tab2' data-toggle="tab"><?php echo $this->lang->line('past_events'); ?></a></li>
            </ul>
    
            <div class="tab-content">
                <!--current events list start-->
                <div class="tab-pane active" id='tab1'>            	
                    <?php
                    if ($current_events) {
                        foreach ($current_events as $event) {
                            $publish = $event->publish;
                            $logo_image = UPLOAD_FILE_PATH . "event/thumb_" . $event->logo;
                            $logo = (file_exists($logo_image)) ? $logo_image : UPLOAD_FILE_PATH . 'event_logo_97_78.png';
    						$organizer_name = (!empty($event->organizer_name)) ? $event->organizer_name : $event->first_name . " " . $event->last_name;
                            ?> 
                            <div class="box">
                            	<div class="events-img">
                                	<img src="<?= base_url() . $logo; ?>" alt="" class="img-responsive event_logo_for"/>
                                </div>
                                <div class="events-detail">
                                	<h4><a class="organizing_event" href="<?php echo site_url('event/organize/' . $event->id); ?>" target="_blank"><span class="titllee"><?= ucwords($event->title); ?></span></a></h4>
                                    <p>
                                        <strong><?php echo $this->lang->line('organizer'); ?>:</strong> <?= ucwords($organizer_name); ?><br/>
                                        <?php if ($event->date_id == "0"): ?>
                                            <strong><?php echo $this->lang->line('start_date'); ?></strong>: <?= $event->start_date; ?><br /> 
                                            <strong><?php echo $this->lang->line('end_line'); ?></strong>: <?= $event->end_date; ?> 
                                        <?php else: ?>
                                            <?=$this->general->date_language($event->date_time_detail)?>
                                        <?php endif; ?>
                                        <br/>
                                        <strong><?php echo $this->lang->line('location'); ?>: </strong><span class="location_event"><?= $event->physical_name; ?></span><br/>
                                        <?php
                                        $short_key = array("M", "F", "B");  
                                        $long_term   = array($this->lang->line('male_only'), $this->lang->line('female_only'), $this->lang->line('m_f'));
                                        
                                        $target_gender = str_replace($short_key, $long_term, $event->target_gender);                                    
                                        ?>              
                                        <strong><?php echo $this->lang->line('target_gender'); ?></strong>: <?= $target_gender; ?><br />           
                                    </p>
                                    <p class="text-warning"><strong><?= ($event->status == '1') ? strtoupper($this->lang->line('public')) : strtoupper($this->lang->line('private')); ?></strong></p>
                                    <span class="publish_unpublish text-danger">
                                    <?php if($event->publish != '1'){ ?><p class="text-danger"><strong><?=strtoupper($this->lang->line('temporarily_unavailable'))?></strong> <?php if($profile_data->organizer != '1'){  echo "<nobr>(<a href='".site_url('organizer/index')."'>". (($profile_data->organizer == '2')? $this->lang->line('Pending verification') : $this->lang->line('Verify your account'))."!</a>)</nobr>";} ?></p><?php } ?>
                                    </span> 
                                </div>
                                <div class="event_actions">
                                        <a href="<?= site_url('event/edit/' . $event->id) ?>" class="editing_event" title="<?=$this->lang->line('edit_event'); ?>"><i class="fa fa-pencil-square-o"></i></a>
                                        <a href="javascript:void(0);"  class='dublicate_e' yog="<?= $event->id ?>"><i title="<?=$this->lang->line('re_create'); ?>"  class="fa fa-files-o"></i></a>
                                        <?php
                                        if($this->general->is_organizer($this->session->userdata(SESSION.'user_id'))){ ?>
                                            <?php if ($publish == 1) { ?>
                                            <a href="javascript:void(0);"  class='change_publish_e' yog="<?= $event->id ?>" yogtd="0" ><i title="<?=$this->lang->line('make_offline');?>" class="fa fa-minus"></i></a>
                                            <?php } else { ?>
                                            <a href="javascript:void(0);" class='change_publish_e' yog="<?= $event->id ?>" yogtd="1"><i title="<?=$this->lang->line('make_online');?>" class="fa fa-check"></i></a>
                                            <?php } ?>
                                        <?php } ?>
                                        <a href="javascript:void(0);" onclick="cancel_event_permanently('<?= $event->id ?>',this);" yog="" class="cancel_event_e"><i title="<?=$this->lang->line('cancel_event_permanently');?>" class="fa fa-times"></i></a>         
                                       
                                </div>
                                <div class="clearfix"></div>
                            </div>        
                            
                            <?php
                        }
                        echo '<!--a class="show_more" href="#">Show more...</a-->';
                    }else {
                        ?>
                        <div class="alert alert-info">                            
                            <strong><?php echo $this->lang->line('no_record'); ?>!</strong>
                        </div>
                        <?php
                    }
                    ?> 
    
                </div>
                <!--current events list end-->
    
                <!--past events list start-->
                <div class="tab-pane" id='tab2'>
                    <?php
                    if ($past_events) {
                        foreach ($past_events as $event) {
                            $logo_image = UPLOAD_FILE_PATH . "event/thumb_" . $event->logo;
                            $logo = (file_exists($logo_image)) ? $logo_image : UPLOAD_FILE_PATH . 'event_logo_97_78.png';
                            ?>  
                            <div class="box">
                            	<div class="events-img">
                                	<img src="<?= base_url() . $logo; ?>" alt="" class="img-responsive">
                                </div>
                                <div class="events-detail">
                                	<h4><a href="<?php echo site_url('event/organize/' . $event->id); ?>" target="_blank"><span class="titllee"><?= ucwords($event->title); ?></span></a></h4>
                                    <p>
                                        <strong><?php echo $this->lang->line('organizer'); ?>:</strong> <?= ucwords($organizer_name); ?><br/>
                                        <?php if ($event->date_id == "0"): ?>
                                            <strong><?php echo $this->lang->line('start_date'); ?></strong>: <?= $event->start_date; ?><br /> 
                                            <strong><?php echo $this->lang->line('end_line'); ?></strong>: <?= $event->end_date; ?> 
                                        <?php else: ?>
                                            <?=$this->general->date_language($event->date_time_detail)?>
                                        <?php endif; ?>
                                        <br/>
                                        <strong><?php echo $this->lang->line('location'); ?>: </strong><?= $event->physical_name; ?><br/>
                                        <?php
                                        $short_key = array("M", "F", "B");  
                                        $long_term   = array($this->lang->line('male_only'), $this->lang->line('female_only'), $this->lang->line('m_f'));
                                        
                                        $target_gender = str_replace($short_key, $long_term, $event->target_gender);                                    
                                        ?>              
                                        <strong><?php echo $this->lang->line('target_gender'); ?></strong>: <?= $target_gender; ?><br />           
                                    </p>
                                    <p class="text-warning"><strong><?= ($event->status == '1') ? strtoupper($this->lang->line('public')) : strtoupper($this->lang->line('private')); ?></strong></p>
                                    <p class="text-danger"><strong><?php echo $this->lang->line('closed'); ?></strong></p> 
                                </div>                                
                                <div class="clearfix"></div>
                            </div>
                            <?php
                        }                            
                    }else {
                    ?>
                    <div class="alert alert-info">                            
                        <strong><?php echo $this->lang->line('no_record'); ?>!</strong>
                    </div>
                    <?php
                    }
                    ?>                     
                </div>
                <!--past events end-->
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $(".change_publish_e").click(function(){
        var this_s=$(this);
        var id=$(this).attr('yog');
        var status=$(this).attr('yogtd');
        var child=$(this).children();
        
        var title=child.attr('title');
        
        var event_unpubish_message = "<?=strtoupper($this->lang->line('event_unpubish_message'));?>";
        var event_pubish_message = "<?=strtoupper($this->lang->line('event_pubish_message'));?>";
        
        var publish = "<?=strtoupper($this->lang->line('online'));?>";
        var unpublish = "<?=strtoupper($this->lang->line('temporarily_unavailable'));?>";
        this_s.parent().next().children().next().children('.publish_unpublish').html('<img src="<?=MAIN_IMG_DIR_FULL_PATH.'ajax_loader_small.gif'?>"/>');
        loaderOn();
        $.ajax({
            url: "<?php echo site_url('organizer/change_publish'); ?>",
            type: "post",
            data: 'id='+id+'&status='+status,
            success: function(){
                if(status==0){
                    child.attr('title','publish');
                    child.removeClass('fa fa-minus').addClass('fa fa-check');
                    this_s.attr('yogtd','1');
                    console.log(this_s.parent());
                    $("#mainModal #mainModalBody").html("<span class='text-danger'>"+event_unpubish_message+"</span>");
                    $("#mainModal").modal("show");
                    this_s.parent().parent().find('.publish_unpublish').html('<strong>'+unpublish+'</strong>');
                } else if(status==1) {
                    child.attr('title','unpublish');
                    child.removeClass('fa fa-check').addClass('fa fa-minus');
                    this_s.attr('yogtd','0');
                    console.log(this_s.parent());
                    $("#mainModal #mainModalBody").html(event_pubish_message);
                    $("#mainModal").modal("show");
                    this_s.parent().parent().find('.publish_unpublish').html('');                    
                }
                loaderOff();
            },
            error:function(){
                alert("failure");
                            }   
        }); 
   
    });
    $('.delete_event_org').click(function(){
    var this_s=$(this);
      var id=$(this).attr('yog');
      $.ajax({
            url: "<?php echo site_url('organizer/delete_event'); ?>",
            type: "post",
            data: 'id='+id,
            success: function(){
                this_s.parent().parent().hide();
                          alert('delete successfully');
            },
            error:function(){
                alert("failure");
                            }   
        }); 
    });
    
    $('.dublicate_e').click(function(){
        var this_s=$(this);
        var id=$(this).attr('yog');
        loaderOn();
        $.ajax({
            url: "<?php echo site_url('organizer/dublicate_event'); ?>",
            type: "post",
            data: 'id='+id,
            success: function(msg){ 
                msg = jQuery.trim(msg);
            	data = msg.split(",");
                r = data[0];
                rand = data[1];
            	
                loaderOff();
                
                var event_clon=this_s.parent().parent().clone(true, true);
                event_clon.find('.titllee').prepend('Copy #'+rand);
                
                event_clon.find('.event_logo_for').attr('src',"<?=site_url(UPLOAD_FILE_PATH."event_logo_97_78.png");?>");
                event_clon.find('.editing_event').attr('href',"<?=site_url('event/edit')?>/"+r);
                event_clon.find('.organizing_event').attr('href',"<?=site_url('event/organize')?>/"+r);
                event_clon.find('.location_event').html('');
                event_clon.find('.publish_unpublish').html('<p class="text-error"><strong><?=strtoupper($this->lang->line('temporarily_unavailable'))?></strong></p>');
                
                
                event_clon.find('.dublicate_e').attr('yog',r);
                event_clon.find('.change_publish_e').attr('yog',r).attr('yogtd','1');
                event_clon.find('.change_publish_e i').removeClass('fa fa-minus').addClass('fa fa-check').attr('title','<?=$this->lang->line('make_online');?>');
                event_clon.find('.cancel_event_e').remove();
                event_clon.find('.delete_event_org').attr('yog',r);
                
                event_clon.addClass('blue');
                //setTimeout(function(){ event_clon.removeClass('blue','slow'); }, 3000);
                
                $("#mainModal #mainModalBody").html("<?=$this->lang->line('sucessfully_duplicate');?>");
                $("#mainModal").modal("show");
                
                $('#tab1').prepend(event_clon);
            },
            error:function(){
                alert("<?=$this->lang->line('failed_to_do');?>");
                            }   
        }); 
    });
    
    
    
});

function cancel_event_permanently(event_id, this_one)
{
    loaderOn();
    if(confirm('<?=$this->lang->line('cancel_event_permanently');?>')){
        $.ajax({
            url: "<?php echo site_url('organizer/cancel_event_permanently'); ?>",
            type: "post",
            data: 'id='+event_id,
            success: function(msg){ 
                $("#mainModal #mainModalBody").html(msg);
                $("#mainModal").modal("show");
                $(this_one).parent().parent().hide();
                location.reload();
            },
            error:function(){
                alert("<?=$this->lang->line('failed_to_do');?>");
            }   
        });    
    }else{
        loaderOff();
        return false;
    }
             
}
</script>
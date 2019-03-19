<?php if ($active_event) { ?>
<script>
    $(document).ready(function() {
    $(".change_publish_e").click(function(){
        p = $(this).attr('p');
        if(p=='make_offline'){
            var response = confirm('<?=$this->lang->line('are_you_sure_make_offline')?>');
        }else{
            var response = confirm('<?=$this->lang->line('are_you_sure_make_online')?>');    
        }
         
        if(!response)  return false;        
        var this_s=$(this);
        var id=$(this).attr('kds');
        var status=$(this).attr('kdstd');
        var child=$(this).children();
   
//        var title=child.attr('title');
  //return false;
        $.ajax({
            url: "<?php echo site_url('organizer/change_publish'); ?>",
            type: "post",
            data: 'id='+id+'&status='+status,
            success: function(){
                if(status==0){
                    this_s.html('<?=$this->lang->line('make_online');?>');
                  //  child.removeClass('icon-minus-sign').addClass('icon-ok-sign');
                    this_s.attr('kdstd','1');
                    this_s.attr('p','make_online');
                   // this_s.parent().next().children().next().children('.text-warning').html('<strong>PRIVATE</strong>');
                } else if(status==1) {
                    this_s.html('<?=$this->lang->line('make_offline');?>');
                   // child.removeClass('icon-ok-sign').addClass('icon-minus-sign');
                    this_s.attr('kdstd','0');
                    this_s.attr('p','make_offline');
                   // this_s.parent().next().children().next().children('.text-warning').html('<strong>PUBLIC</strong>');
                }
            },
            error:function(){
                alert("failure");
                            }   
        }); 
   
    });
    $(".wishlist_e").click(function(){
        
        var this_s=$(this);
        var id=$(this).attr('kds');
        var status=$(this).attr('kdstd');
        var child=$(this).children();
   
//        var title=child.attr('title');
  //return false;
        $.ajax({
            url: "<?php echo site_url('organizer/change_wishlist'); ?>",
            type: "post",
            data: 'id='+id+'&status='+status,
            success: function(){
                          if(status=='active'){
                    this_s.html('wishlist inactive');
                  //  child.removeClass('icon-minus-sign').addClass('icon-ok-sign');
                    this_s.attr('kdstd','inactive');
                   // this_s.parent().next().children().next().children('.text-warning').html('<strong>PRIVATE</strong>');
                } else {
                    this_s.html('wishlist active');
                   // child.removeClass('icon-ok-sign').addClass('icon-minus-sign');
                    this_s.attr('kdstd','active');
                   // this_s.parent().next().children().next().children('.text-warning').html('<strong>PUBLIC</strong>');
                }
            },
            error:function(){
                alert("failure");
                            }   
        }); 
   
    });
    $('.delete_event_org').click(function(){
    var response =confirm('Are you sure you want to delete this event?  This cannot be undone.');
    if(!response)  return false;
    var this_s=$(this);
      var id=$(this).attr('kds');
      $.ajax({
            url: "<?php echo site_url('organizer/delete_event'); ?>",
            type: "post",
            data: 'id='+id,
            success: function(){
               // this_s.parent().parent().hide();
                          alert('delete successfully');
                          window.location.href = "<?php echo site_url('organizer/event'); ?>";
            },
            error:function(){
                alert("failure");
                            }   
        }); 
    });
    
    $('.dublicate_e').click(function(){
    //alert('hkasdkl');
    
    var this_s=$(this);
      var id=$(this).attr('kds');
      $.ajax({
            url: "<?php echo site_url('organizer/dublicate_event'); ?>",
            type: "post",
            data: 'id='+id,
            success: function(r){
               // var event_clon=this_s.parent().parent().clone(true, true);
               // event_clon.find('.titllee').prepend('Copy ');
               // event_clon.find('.dublicate_e').attr('kds',r);
               // event_clon.find('.change_publish_e').attr('kds',r);
               // event_clon.find('.delete_event_org').attr('kds',r);
                          alert('successfully dublicate');
//                          var newaddress= $("#addresses div.address").eq(0).clone();
//newaddress.find('input').each(function() {
//    this.name= this.name.replace('[0]', '['+i+']');
//});
$('#tab1').append(event_clon);
            },
            error:function(){
                alert("failure");
                            }   
        }); 
    });
    });
</script>
<?php } ?>
<?php //print_r($data_event); ?>
<div class="jumbotron manage-events-title">
    <div class="container">
        <div class="col-md-8">
            <div class="account-info">                
                <h2><?= $data_event->title ?></h2>
                <?php if ($data_event->date_id == 0): ?>
                    <span><?=$this->general->date_language(date('F j, Y \a\t g:i A', strtotime($data_event->start_date))); ?> - <?= $this->general->date_language(date('F j, Y \a\t g:i A',strtotime($data_event->end_date))); ?></span>                
                <?php else: ?>                
                    <strong><?= $this->general->date_language($data_event->date_time_detail); ?></strong>
                <?php endif; ?>    
                <br />        
                <?= $data_event->address ?>
                            
            </div>
        </div>
        <div class="col-md-4">
        <?php if($organizer_nav == 'yes'){ ?>
            <?php
                $publising =  $data_event->publish;
                $status = $data_event->status;
                $wish = $data_event->withlist;
            ?>   
            <?php if ($active_event) { ?>             
            <ul class="nav nav-pills pull-right options">
                <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?= $this->lang->line('options') ?><b class="caret"></b></a>
                <ul class="link-list clrfix dropdown-menu  bottom-up pull-right">
    
                    <?php if ($publising == 1) { ?>
                    <li class="text link-list__item"><a kdstd="0" href="javascript:void(0)" kds="<?= $data_event->
    id ?>" class="change_publish_e" p="make_offline"><?php echo $this->lang->line('make_offline'); ?></a></li>
                    <?php } else { ?>
                    <li class="text link-list__item"><a kdstd="1" href="javascript:void(0)" kds="<?= $data_event->
    id ?>" class="change_publish_e" p="make_online"><?php echo $this->lang->line('make_online'); ?></a></li>
                    <?php } ?>
    
                    <li class="text link-list__item"><a href="javascript:void(0)" class="dublicate_e" kds="<?= $data_event->id ?>"><?php echo $this->lang->line('copy'); ?></a></li>
                    
                    <?php /*
                    <?php if ($wish = 'inactive') { ?>  
                    <li class="text link-list__item"><a kdstd="active" href="javascript:void(0)" class="wishlist_e" kds="<?= $data_event->id ?>">wishlist active</a></li>
                    <?php } else { ?>
                    <li class="text link-list__item"><a kdstd="inactive" href="javascript:void(0)" class="wishlist_e" kds="<?= $data_event->id ?>">wishlist inactive</a></li>
                    <?php } ?>
                    */ ?>
                    <li class="text link-list__item"><a href="javascript:void(0)"  onclick="cancel_event_permanently_new('<?= $data_event->id ?>')"><?php echo $this->lang->line('cancel'); ?></a></li>
    
                    <?php /*                
                    <li class="text link-list__item"><a href="javascript:void(0)" kds="<?=$data_event->id ?>" class="delete_event_org"><?php echo $this->lang->line('delete'); ?></a></li>
                    */ ?>
    
                </ul>
                </li>
            </ul>
            <?php } ?>
        <?php } ?>     
        </div>
        
        
    </div>
</div>
<?php if($organizer_nav == 'yes'){ ?>
<div class="container substitute-menu">
    <ul class="nav nav-tabs">    
        <li <?php if ($navigation == 'index') { echo ' class="active"'; } ?> ><a href="<?php echo site_url('organizer/event'); ?>" class="upload icon-home"><i style="height: 19px !important; " class="fa fa-home" title="Event Management"></i></a></li>
        <li <?php if ($navigation == 'event') { echo ' class="active"';} ?> ><a href="<?php echo site_url('event/organize/' . $id); ?>" class="upload"><span><?php echo $this->lang->line('event_info_analysis'); ?></span></a></li>        
        <li <?php if ($navigation == 'checkin') { echo ' class="active"'; } ?>><a href="<?php echo site_url('event/checkin/' . $id); ?>" class="ch_pass"><span><?php echo $this->lang->line('check_in'); ?></span></a></li>    
        <li <?php if ($navigation == 'promotioncode') { echo ' class="active"'; } ?>><a href="<?php echo site_url('event/promotion_code/' . $id); ?>" class="ch_pass"><span><?php echo $this->lang->line('promotion_codes'); ?></span></a></li> 
        <?php if ($active_event) { ?>    
        <li <?php if ($navigation == 'order_form') { echo ' class="active"'; } ?>><a href="<?php echo site_url('organizer/order_form/' . $id); ?>" class="ch_pass"><span><?php echo $this->lang->line('order_form'); ?></span></a></li>   
        <li <?php if ($navigation == 'refund_policy') { echo ' class="active"'; } ?>><a href="<?php echo site_url('organizer/refund_policy/' . $id); ?>" class="ch_pass"><span><?php echo $this->lang->line('refund_policy'); ?></span></a></li>
        <?php } ?>
    </ul>
</div>
<?php } ?>

<!--cancel event permanently-->
<script>
function cancel_event_permanently_new(event_id)
{
    if(confirm('<?=$this->lang->line('cancel_event_permanently');?>')){
        $.ajax({
            url: "<?php echo site_url('organizer/cancel_event_permanently'); ?>",
            type: "post",
            data: 'id='+event_id,
            success: function(msg){ 
                alert(msg);                
                location.reload();
            },
            error:function(){
                alert("<?=$this->lang->line('failed_to_do');?>");
            }   
        });    
    }else{
        return false;
    }         
}
</script>
<!--cancel event permanently--> 
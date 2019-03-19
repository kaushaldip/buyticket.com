<style>
select#tickets_date {
    background-color: #FFFFFF;
    border: 1px solid #CCCCCC;
    font-size: 12px;
    height: 18px !important;
    line-height: 20px !important;
    margin-top: 5px;
    padding: 0;
    width: auto;
}
</style>
<div class="row-fluid event_head">
	<div class="span8 left">
    <dl>
    	<dt><?=$data_event->title;?></dt>
        <!--dd><em><?=ucwords($data_event->first_name." ".$data_event->last_name);?></em></dd-->
        <dd><?php //echo $data_event->name; ?></dd>
        <dd>
        <?php if($data_event->date_id =='0'){ ?>            
            <strong><?=$data_event->frequency." Event -"; ?></strong>
            <strong><?php echo $this->lang->line('from'); ?></strong> <?php echo date('l, F j, Y  g:i A',strtotime($data_event->start_date)); ?> <strong><?php echo $this->lang->line('to'); ?></strong> <?php echo date('l, F j, Y  g:i A (T)',strtotime($data_event->end_date)); ?>                    
        <?php }else{ ?>
            <?php echo $data_event->date_time_detail; ?>                                
        <?php } ?>
        </dd>
        <dd><?php echo $data_event->physical_name; ?></dd>
	</dl>
    </div>
    
    <div class="span4 right">
        <?php 
        $logo_image = UPLOAD_FILE_PATH."event/thumb_".$data_event->logo;
        $logo = (file_exists($logo_image))? $logo_image: UPLOAD_FILE_PATH.'event_logo.jpg';
        ?>
    	<img class="event_logo" src="<?=base_url().$logo;  ?>" title="<?=$data_event->title; ?>" />           
    </div>
</div>
<!--error block start -->
<?php if($this->session->flashdata('message')){ ?>
<br clear="all" />
<div class="alert alert-error">  
  <a class="close" data-dismiss="alert">&times;</a>
  <?php echo $this->session->flashdata('message');?>
</div>
<?php  } ?>
<?php if($this->session->flashdata('error')){ ?>
<br clear="all" />
<div class="alert alert-error">  
  <a class="close" data-dismiss="alert">&times;</a>
  <?php echo $this->session->flashdata('error');?>
</div>
<?php  } ?>
<!--error block end -->
<div class="row-fluid">
	<div class="span8">
    
        <div class="box">
            <div class="alert warning-alert">
            <a class="close" data-dismiss="alert">&times;</a>  
            You are in admin view. No ticket information will be listed. If the event is published, you may view event via <a href="<?=site_url('event/view/'.$data_event->id) ?>" target="_blank">link</a>. 
            </div>
        </div>
        <!-- event description start -->
        <?php if(!empty($data_event->description)){?>
        <div class="box">
        	<h1><?php echo $this->lang->line('event_details'); ?></h1>
            <div class="box_content">
            	<?php echo $data_event->description; ?>
            </div>
        </div>
        <?php } ?>
        <!-- event description end -->
        
        <!-- event keywords start -->
        <?php if(!empty($keywords)){ ?>
        <div class="box">
        	<h1><?php echo $this->lang->line('keywords'); ?></h1>
            <div class="box_content">
            	<p>
                <?php
                foreach($keywords as $keyword): 
                    if(empty($keyword->keyword))
                        continue;                   
                ?>
                    <span class="keywords"><?php echo $keyword->keyword; ?></span>
                <?php endforeach; ?>
                </p>
            </div>
        </div>
        <?php } ?>
        <!-- event keywords end -->
    </div>
    
    <div class="span4">
        <!-- location block start -->
        <?php if(!empty($data_event->address)){ ?>
    	<div class="box">
        	<h1><?php echo $this->lang->line('location_map'); ?></h1>
            <div class="box_content">
                <div id="map-canvas" style="height: 205px; width: 270px;"></div>
                <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
                <script>
                var map;
                var loc = new google.maps.LatLng(<?php echo $data_event->latitude; ?>, <?php echo $data_event->longitude; ?>);                
                function initialize() {
                  var mapDiv = document.getElementById('map-canvas');
                  var mapOptions = {
                    zoom: 12,
                    maxZoom:15,
                    minZoom:9,
                    panControl: false,
                    zoomControl: true,
                    scaleControl: false,
                    center: loc,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                  }
                  map = new google.maps.Map(mapDiv, mapOptions);
                    var marker = new google.maps.Marker({
                      position: loc,
                      map: map,
                      title:"Hello World!"
                    });
                
                }                
                google.maps.event.addDomListener(window, 'load', initialize);                
                </script>                
            	<!--<iframe width="270" height="270" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?q=<?php echo $data_event->latitude; ?>,+<?php echo $data_event->longitude; ?>&amp;hl=en&amp;ie=UTF8&amp;t=m&amp;source=embed&amp;z=17&amp;ll=<?php echo $data_event->latitude; ?>,<?php echo $data_event->longitude; ?>&amp;output=embed&amp;iwloc=near"></iframe>-->
                <br clear="all" />
                <ul class="description organizer_each">                    
                    <li><strong><?=ucwords($data_event->physical_name);?></strong></li>                    
                    <li><?=$data_event->address;?></li>
                </ul>
            </div>
        </div>
        <?php }else if(!empty($data_event->physical_name)){ ?>
        <div class="box">
        	<h1><?php echo $this->lang->line('physical_address'); ?></h1>
            <div class="box_content">            	 
                <ul class="description organizer_each">                    
                    <li><strong><?=ucwords($data_event->physical_name);?></strong></li>
                </ul>
            </div>
        </div>
        <?php } ?>
        <!-- location block end -->
        
        <!-- performer block start -->
        <?php if($performer){ ?>
        <div class="box">
        	<h1><?php echo $this->lang->line('performers_detail');?></h1>
            <div class="box_content">
            	<ul class="description">
                	<li><strong><?php echo $this->lang->line('name'); ?>:</strong><?php echo ucwords($performer->performer_name); ?></li>
                    <li><strong><?php echo $this->lang->line('type'); ?>:</strong><?php echo ucwords($performer->performer_type); ?></li>
                    <?php if($performer->performer_description!=''){ ?>
                    <li><a onclick="$('#performer_description').toggle();" style="text-decoration: none; cursor: pointer;"><?php echo $this->lang->line('view_detail'); ?></a></li>
                    <li id="performer_description" style="display: none;"><strong>Description:</strong><?php echo $performer->performer_description; ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>        
        <?php } ?>
        <!-- performer block end -->
        
        <!-- organizers block start -->
        <?php if($organizers){ ?>
        <div class="box">
        	<h1><?php echo $this->lang->line('organizers_information'); ?></h1>
            <div class="box_content">
            <?php foreach($organizers as $organizer): ?>
                <?php               
                $organizer_image = UPLOAD_FILE_PATH."organizer/thumb_".$organizer->logo;
                $organizer_logo = (file_exists($organizer_image))? $organizer_image: UPLOAD_FILE_PATH.'sponsor_logo.jpg';
                ?>
                <ul class="description organizer_each">
                    <span class="organizer_logo"><img src="<?=base_url().$organizer_logo; ?>" title="<?php echo $organizer->name; ?>" /></span>
                	<li><strong><?php echo $this->lang->line('name'); ?>:</strong><?php echo ucwords($organizer->name); ?></li>                    
                    <li><strong><a href="<?=site_url('organizer/view/'.$organizer->organizer_id)?>" target="_blank"><?php echo $this->lang->line('organizer_profile'); ?></a></strong></li>
                </ul> 
                <br clear="all" />           	
            <?php endforeach; ?>                
            </div>
        </div>
        <?php } ?>
        <!-- organizers block end -->
    </div>
</div>
<div class="row-fluid sponsors">
	<?php if($sponsors){ ?>
    <h1 class="title"><span><?php echo $this->lang->line('sponsors'); ?></span></h1>
    
        <?php foreach($sponsors as $sponsor): ?>
            <?php 
            $sponsor_image = UPLOAD_FILE_PATH."sponsor/thumb_".$sponsor->logo;
            $sponsor_image = (file_exists($sponsor_image))? $sponsor_image: UPLOAD_FILE_PATH.'sponsor_logo.jpg';
            ?>
            <img src="<?=base_url().$sponsor_image; ?>" title="<?php echo $sponsor->title; ?>" />
        <?php endforeach;?>
    <?php } ?>
    
</div>
<script>
$("#ticketcheckout").validate();
</script>
<!-- alter order now and register buttons start -->
<script>
$(".ticket_quantity").val(''); //initialize
$(".ticket_quantity").change(function(){
    check_free  = 0;
    $(".ticket_quantity").each(function(){
        var myval = $(this).val();
        if(myval != ""){            
            var paid_free = $(this).attr('paid_free');
            if(paid_free=='paid' && check_free==0){                
                check_free =1;
            }    
            
        }
            
    });
    if(check_free==1){
        $("#order_paid").show();
        $("#order_free").hide();
        $("#promotion_code_tr").show();
    }else{
        $("#order_paid").hide();
        $("#order_free").show();
        $("#promotion_code_tr").hide();
    }
    
});
</script>
<!-- alter order now and register buttons end -->

<script>
function validateSelects()
{
    var m = false;
    $.each($('select.ticket_quantity'),function()
    {
         if($(this).val()!=''){  m=true; }
    })
    return(m);
}
$('#ticketcheckout').on('submit',function()
{
    if(validateSelects())
    {
        return true;
    }
    else
    {
       alert("Please select at least one ticket.");
       return false; 
    }
});
</script>
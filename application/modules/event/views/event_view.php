<div class="row">
    <div class="col-md-3 col-sm-12">
        <!-- location block start -->
        <?php if(!empty($data_event->address)){ ?>
        	<div class="location-map">
            	<h3 class="no-margin-top"><?php echo $this->lang->line('location_map'); ?></h3>
                <div class="box_content">
                    <div id="map-canvas" style="height: 205px; width: 270px;"></div>
                    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=<?=$this->config->item('language_abbr');?>"></script>
                    <script>
                    var map;
                    var loc = new google.maps.LatLng(<?php echo $data_event->latitude; ?>, <?php echo $data_event->longitude; ?>);                
                    function initialize() {
                      var mapDiv = document.getElementById('map-canvas');
                      var mapOptions = {
                        zoom: 14,
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
                          title:"<?=ucwords($data_event->title);?>"
                        });
                    
                    }                
                    google.maps.event.addDomListener(window, 'load', initialize);                
                    </script>                
                	<?php /*<!--<iframe width="270" height="270" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?q=<?php echo $data_event->latitude; ?>,+<?php echo $data_event->longitude; ?>&amp;hl=en&amp;ie=UTF8&amp;t=m&amp;source=embed&amp;z=17&amp;ll=<?php echo $data_event->latitude; ?>,<?php echo $data_event->longitude; ?>&amp;output=embed&amp;iwloc=near"></iframe>-->*/?>
                    <div class="clearfix"></div>
                    <div class="map-name">                                    
                        <p><strong><?=ucwords($data_event->physical_name);?></strong></p>                    
                        <p><?=$data_event->address;?></p>
                    </div>
                </div>
            </div>
        <?php }else if(!empty($data_event->physical_name)){ ?>
            <div class="search-event-small">
                <h3><?php echo $this->lang->line('physical_address'); ?></h3>
                <div class="map-name">
                    <p><strong><?=ucwords($data_event->physical_name);?></strong></p>
                </div>
            </div>
        <?php } ?>
        <!-- location block end -->
        
        <!-- performer block start -->
        <?php if($performers){ $i=1; ?>
        <div class="search-event-small">
        	<h3 class="h3-lower"><?php echo $this->lang->line('performers_detail');?></h3>
            <div class="box_content">
            <?php foreach($performers as $performer): ?>                            
            	<div class="performers-detail">
                	<span><?=$this->event_model->get_performer_name_from_id($performer->performer_type);?>:</span><?php echo ucwords($performer->performer_name); ?>                    
                    <?php if($performer->performer_description!=''){ ?>
                    <a onclick="$('#performer_description<?=$i;?>').toggle();" style="text-decoration: none; cursor: pointer;"><?php echo $this->lang->line('view_detail'); ?></a>
                    <p id="performer_description<?=$i;?>" style="display: none;"><?php echo ucfirst($performer->performer_description); ?></p>
                    <?php } ?>
                </div>                          
            <?php $i++; endforeach; ?>
            </div>
        </div>        
        <?php } ?>
        <!-- performer block end -->
        
        <!-- organizers block start -->
        <?php if($organizers){ ?>
        <div class="search-event-small">
        	<h3 class="h3-lower"><?php echo $this->lang->line('organizers_information'); ?></h3>
            <div class="box_content">
            <?php foreach($organizers as $organizer): ?>
                <?php               
                $organizer_image = UPLOAD_FILE_PATH."organizer/thumb_".$organizer->logo;
                $organizer_logo = (file_exists($organizer_image))? $organizer_image: UPLOAD_FILE_PATH.'event_logo_169_136.png';
                ?>
                <div class="performers-detail">
                    <span class="organizer_logo"><img src="<?=base_url().$organizer_logo; ?>" title="<?php echo $organizer->name; ?>" /></span>
                    <span class="organizer-detail">
                        <p><?php echo ucwords($organizer->name); ?></p>                    
                        <strong><a href="<?=site_url('organizer/view/'.$organizer->organizer_id)?>" target="_blank"><?php echo $this->lang->line('organizer_profile'); ?></a></strong>
                    </span>
                </div>           	
            <?php endforeach; ?>                
            </div>
        </div>
        <?php } ?>
        <!-- organizers block end -->
    </div>
            
    <div class="col-md-9 col-sm-12 list-main">
        <div>
            <!--error block start -->
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
            <div class="clearfix"></div>
            <!--error block end -->
            <div class="col-md-8">
                <h2 class="detail-title2"><?php echo ucwords($data_event->title) ?></h2>
                <h4>
                <?php if($data_event->date_id =='0'){ ?>            
                    <strong><?=(strtolower($data_event->frequency)=='never')? "":$data_event->frequency." Event -"; ?></strong>
                    <strong><?php echo $this->lang->line('from'); ?></strong> <?=$this->general->date_language(date('l, F j, Y  g:i A',strtotime($data_event->start_date))); ?> <strong><?php echo $this->lang->line('to'); ?></strong> <?php echo str_replace('(AST)',$this->lang->line('KSA'),$this->general->date_language(date('l, F j, Y  g:i A (T)',strtotime($data_event->end_date)))); ?>                         
                <?php }else{ ?>        
                    <?php echo str_replace('(AST)',$this->lang->line('KSA'),$this->general->date_language($data_event->date_time_detail)); ?>                                
                <?php } ?></h4>        
                <h4><?php echo $data_event->physical_name; ?></h4>
            </div>   
            <div class="col-md-4">
                <?php 
                $logo_image = UPLOAD_FILE_PATH."event/".$data_event->logo;                
                $logo = (file_exists($logo_image) && !empty($data_event->logo))? $logo_image: UPLOAD_FILE_PATH.'event_logo_269_123.png';
                ?>
            	<img style="width: 100%;" class="event_logo" src="<?=base_url().$logo;  ?>" title="<?=$data_event->title; ?>" />           
            </div>  
            <div class="clearfix"></div>   
            <div class="detail-sections">                        
                <?php if($current_event){ ?>
                    <?php
                    $dateCorrect = true;
                    if($data_event->date_id =='0'){
                        $last_date = $data_event->end_date;
                    }else{
                        $last_date = $this->event_model->last_date_from_event_date_by_id($data_event->date_id);
                    }
                    if($last_date > date("Y-m-d")){       
                    ?>
                        <!--ticket block start-->
                    	<?php if($tickets){ ?>
                        <form id="ticketcheckout" method="post" action="">
                        <div class="box">
                        	<h3 class="ticket_header">
                            <?php echo $this->lang->line('ticket_information'); ?>
                            <?php if($data_event->date_id !=0){ ?>
                            <span  class="pull-right ticket-ranger">              
                                <?php
                                $date_range = $this->event_model->get_date_detail($data_event->id);
                                $begin = new DateTime( $date_range->start_date );
                                $end = new DateTime( $date_range->end );
                                $diff =intval((strtotime($date_range->end_date ) - strtotime($date_range->start_date )));
                                if($diff < 0 ){
                                    $dateCorrect = false; //if date range is mistakly set where enddate is less than start date 
                                }
                
                                $datearr = array();
                                if($date_range->type=='Daily'){
                                    $interval = DateInterval::createFromDateString("$date_range->repeat day");
                                    $period = new DatePeriod($begin, $interval, $end);
                                    foreach ( $period as $dt ):
                                        if(date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime($date_range->end_date. " + $diff seconds")))
                                            continue; //checking last date with today, exclude                            
                                        $datearr[] = $dt->format( "l Y-m-d H:i:s" ).", ".date('l Y-m-d H:i:s', strtotime($date_range->end_date. " + $diff seconds"));
                                    endforeach;    
                                }                    
                                else if($date_range->type=='Weekly'){
                                    $Narr = explode(',',$date_range->repeat_weekday);
                                    $interval = DateInterval::createFromDateString("1 day");
                                    $period = new DatePeriod($begin, $interval, $end);
                                    
                                    foreach ( $period as $dt ):                        
                                        if(date('Y-m-d H:i:s') > date($dt->format( "Y-m-d H:i:s" ). " + $diff seconds"))
                                            continue; //checking last date with today, exclude
                                            
                                        if (in_array($dt->format("N"),$Narr))
                                            $datearr[] = $dt->format( "l Y-m-d H:i:s" ).", ".date('l Y-m-d H:i:s', strtotime($dt->format( "l Y-m-d H:i:s" ). " + $diff seconds"));
                                    endforeach;
                                }                    
                                else if($date_range->type=="Monthly"){
                                    if($date_range->repeat_day == '0'){
                                        $Narr = explode('-',$date_range->repeat_weekday);
                                        $r1 = $Narr[0];
                                        $d1 = $Narr[1];
                                        
                                        $interval = DateInterval::createFromDateString("1 month");
                                        $period = new DatePeriod($begin, $interval, $end);
                                        
                                        $ranges = array('1'=>'first','2'=>'second','3'=>'third','4'=>'fourth','last'=>'last');
                                        $days = array('1'=>'monday','2'=>'tuesday','3'=>'wednesday','4'=>'thursday','5'=>'friday','6'=>'saturday','0'=>'sunday');
                                        
                                        $r = $ranges[$r1];
                                        $d = $days[$d1];
                                                                
                                        foreach ( $period as $dt ):
                                            if(date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s',strtotime($dt->format( "Y-m-d H:i:s" )."$r $d")). " + $diff seconds")))
                                                continue; //checking last date with today, exclude
                                                
                                            $datearr[] = date('l Y-m-d H:i:s',strtotime($dt->format( "l Y-m-d H:i:s" )."$r $d")).", ".date('l Y-m-d H:i:s', strtotime(date('l Y-m-d H:i:s',strtotime($dt->format( "l Y-m-d H:i:s" )."$r $d")). " + $diff seconds"));
                                        endforeach;
                                                                
                                    }else{
                                        $interval = DateInterval::createFromDateString("1 day");
                                        $period = new DatePeriod($begin, $interval, $end);
                                        
                                        foreach ( $period as $dt ):                        
                                            if ($dt->format("j")==$date_range->repeat_day)
                                                $datearr[] = $dt->format( "l Y-m-d H:i:s" ).", ".date('l Y-m-d H:i:s', strtotime($dt->format( "l Y-m-d H:i:s" ). " + $diff seconds"));
                                        endforeach;
                                    }                    
                                }
                                if($dateCorrect){                
                                ?>                
                                <select id="tickets_date" name="tickets_date" class="form-control required input-sm" title="*">
                                    <option value=""><?php echo $this->lang->line('select_date_time'); ?></option>
                                    <?php foreach($datearr as $d): ?>
                                    <option value="<?=$d;?>"><?=$d; ?></option>
                                    <?php endforeach;?>                                        
                                </select>
                                <?php } ?>
                            </span>
                            <?php } ?>
                            </h3>
                            <div class="box_content for_reg">
                            	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table_rows_add table table-striped">
                                    <tr>                            
                                        <th><?php echo $this->lang->line('ticket_type'); ?></th>
                                        <th class="hidden-480"><?php echo $this->lang->line('registration_end'); ?></th>
                                        <th><?php echo $this->lang->line('price'); ?></th>
                                        <th><?php echo $this->lang->line('fee'); ?></th>
                                        <th><?php echo $this->lang->line('quantity'); ?></th>
                                    </tr>                  
                                    <?php
                                    $check_free = 0;
                                    $deadline = -1; 
                                    foreach($tickets as $key=>$ticket):
                                        if($ticket->end_date < date('Y-m-d H:m:s'))
                                        {
                                            $deadline++;
                                            continue;//ticket deadline over
                                        }
                                        if($ticket->paid_free=='paid' && $check_free==0) $check_free = 1;;
                                            
                                        $sold_ticket= $ticket->ticket_used;//$this->event_model->get_sold_tickets($ticket->id);
                                        $total_ticket= $ticket->max_number;
                                        $remain_ticket= $total_ticket - $sold_ticket;
                                        $remain_ticket= $remain_ticket<10 ? $remain_ticket:10;                    
                                    ?>
                                    <tr>                        
                                        <td><?=ucwords($ticket->name); ?></td>
                                        <td class="hidden-480"><nobr><?=$this->general->date_language(date('D, M j, Y  g:i A ', strtotime($ticket->end_date))); ?></nobr></td>
                                        <td><nobr class='currency'><?=$this->general->price($ticket->price); ?></nobr></td>
                                        <td><?=($ticket->web_fee_include_in_ticket == '1')? $this->general->price('0'): $this->general->price($ticket->website_fee); ?></td>
                                        <td>
                                            <?php if($ticket->ticket_used < $ticket->max_number){?>
                                            <input type="hidden" name="ticket_id[]" value="<?=$ticket->id; ?>" />
                                            <select id="ticket_no" name="ticket_no[]" class="ticket_quantity" style="width: 50px;" title="*" paid_free="<?=$ticket->paid_free;?>">
                                                <option value="">0</option>
                                                <?php 
                                                for ($i=1; $i<=$remain_ticket; $i++)
                                                {
                                                    echo "<option value='$i'>$i</option>";  
                                                }
                                                ?>
                                            </select>
                                            <?php }else{?>
                                                N/A
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                    <?php //echo $deadline; echo $key;?>
                                    <?php if($deadline != $key){ //if all tickets overlap deadline?>
                                        <?php if($this->event_model->has_promotion_code($event_id)){ //check for promotion code?>
                                        <tr id="promotion_code_tr">
                                            <td></td>                                                
                                            <td colspan="2" align="right"><?php echo $this->lang->line('promotion_code'); ?></td>
                                            <td colspan="2"><input name="promotional_code" type="text" /></td>                        
                                        </tr>
                                        <?php }?>
                                    <tr>
                                        <td></td>
                                        <td class="hidden-480"></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <span id="order_paid" style="display:<?=($check_free==1)? "block" : "none" ;?>;">
                                            <?php if($dateCorrect){ ?>
                                            <input type="submit" name="order_btn" value="<?=$this->lang->line('ordernow_btn');?>" id="order_paid_btn" class="btn" />
                                            <?php }else{ 
                                                echo "<p class='text-danger'>Incorrect Date range. Contact Organizer for detail.</p>" ; 
                                            } ?>
                                            </span>
                                            <span id="order_free" style="display: <?=($check_free==0)? "block" : "none" ;?>;">
                                            <input type="submit" name="order_btn" value="<?=$this->lang->line('register_btn');?>" id="order_free_btn" class="btn" />
                                            </span>
                                        </td> 
                                    </tr>
                                    <?php }else{?>
                                    <tr>
                                        <td colspan="5" class="text-danger"><?=$this->lang->line('no_ticket_warning');?></td>
                                    </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                        </form>
                        <?php } ?>            
                        <!--ticket block end-->
                    
                    <?php }else{ ?>
                        <div class="box">
                            <div class="alert warning-alert">
                            <a class="close" data-dismiss="alert">&times;</a>
                            <?=$this->lang->line('event_has_been_closed')?>
                            </div>
                        </div>
                    <?php } ?>
                <?php }else{?>
                    <div class="box">
                        <div class="alert warning-alert">
                        <a class="close" data-dismiss="alert">&times;</a>
                        <?=$this->lang->line('event_has_been_closed');?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- event description start -->
            <?php if(!empty($data_event->description)){ ?>
            <div class="detail-sections">
            	<h3><?php echo $this->lang->line('event_details'); ?></h3>
                <div class="box_content">
                    <iframe scrolling="no" onload='javascript:resizeIframe(this);' id="event_description_iframe" src="<?=site_url('event/description_only/'.$data_event->id)?>" style="width: 100%; border:none;"></iframe>
                    <?php //echo $data_event->description; ?>
                    <script language="javascript" type="text/javascript">
                      function resizeIframe(obj) {
                        obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
                      }
                    </script>         	
                </div>
            </div>
            <?php } ?>
            <!-- event description end -->
            
            <!-- event keywords start -->
            <?php if(!empty($keywords)){ ?>
            <div class="detail-sections">
            	<h3><?php echo $this->lang->line('keywords'); ?></h3>
                <?php
                foreach($keywords as $keyword): 
                    if(empty($keyword->keyword))
                        continue;                   
                ?>
                    <span class="keywords"><?php echo $keyword->keyword; ?></span>
                <?php endforeach; ?>                
            </div>
            <?php } ?>
            <!-- event keywords end -->
            
            <?php if($sponsors){ ?>
            <div class="sponsers">
                <h2 class="title"><span><?php echo $this->lang->line('sponsors'); ?></span></h2>    
                <?php foreach($sponsors as $sponsor): ?>
                    <?php 
                    $sponsor_image = UPLOAD_FILE_PATH."sponsor/thumb_".$sponsor->logo;
                    $sponsor_image = (file_exists($sponsor_image))? $sponsor_image: UPLOAD_FILE_PATH.'sponsor_logo.jpg';
                    ?>
                    <div style="width: auto; margin: 0 3px; display: inline-block;">
                        <span style="width: 100%; float:left; text-align:center;"><?=ucwords($sponsor->type)?></span>
                        <img src="<?=base_url().$sponsor_image; ?>" title="<?php echo $sponsor->title; ?>" />
                    </div>
                <?php endforeach;?>
            </div>
            <?php } ?>            
        </div>
    </div>
</div>
<div class="clearfix"></div>
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
        msg = "Please select at least one ticket.";
        $("#mainModal #mainModalBody").html(msg);
        $("#mainModal").modal("show");
        return false; 
    }
});
</script>
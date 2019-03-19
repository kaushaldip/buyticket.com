<div class="row">
    <div class="col-md-3 col-sm-12">
        <div class="location-map">
            <div class='embed-container'>
                <?php 
                $zoom = 15;
                $type = 'ROADMAP';
                $gmap = 'http://maps.googleapis.com/maps/api/geocode/json?address=' .urlencode($location) . '&sensor=false';
                $geocode = file_get_contents($gmap);
                $output = json_decode($geocode);
                //var_dump($output);
                $lat = $output->results[0]->geometry->location->lat;
                $lng = $output->results[0]->geometry->location->lng;
                //echo $lat.",".$lng;
                $latlng ='-6.976622,110.39068959999997';
                ?>
                <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=en"></script>
                <script type="text/javascript">
                
                function initialize() {                    
                    var myLatlng = new google.maps.LatLng(<?php echo $latlng ?>);
                    var myOptions = {
                        zoom: <?php echo $zoom; ?>,
                        center: myLatlng,
                        mapTypeId: google.maps.MapTypeId.<?php echo $type; ?>
                    }
                    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                
                    var marker = new google.maps.Marker({
                        position: myLatlng, 
                        map: map,
                        title:"<?php echo $location; ?>"
                    });   
                }
                google.maps.event.addDomListener(window, 'load', initialize);                     
                </script>
                <div id="map_canvas" style="height: 200px; width: 100%;" ></div>                
            </div>
            <div class="map-name"><?php echo $location;?></div>
        </div>
        <div class="search-event-small">
            <h3>search events</h3>            
            <form action="<?php echo site_url("event/index") ?>" method="get" class="form-horizontal">
                <div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-12 control-label labelfix2"><?=$this->lang->line('search_catalog_keyword')?></label>
                        <div class="col-sm-12">
                            <input type="text" name="keywords" class="form-control search-form" id="autocomplete" placeholder="<?=$this->lang->line('search_catalog_keyword')?>" value="<?php echo @$_GET['keywords'] ?>"/>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div>
                    <label for="inputEmail3" class=" control-label labelfix2"><?=$this->lang->line('location')?></label>
                    <input name="location" class="form-control search-form" type="text" placeholder="<?=$this->lang->line('location')?>" id="event_form_location"/>
                </div>
                <div class="form-group head-btn-fix">
                    <input class="btn head-btn btn-red search-btn2" type="submit" value="<?=$this->lang->line('search')?>" style="min-width: 92px;" />                    
                </div>
            </form>
        </div>
        <div class="search-event-small">
            <h3 class="h3-lower">Post Your Own Event</h3>
            <img src="<?= MAIN_IMAGES_DIR_FULL_PATH;?>logo-mini.png" alt="" class="img-responsive"/>
            <a href="<?php echo site_url("event/create") ?>" class="head-btn btn-red search-btn2">Create Event Now</a>
        </div>
        <?php echo $this->load->view('common/sidebar_left');?>
        <?php /*?>
        <div class="search-event-small">
            <h3 class="center">stay connected</h3>
            <div class="sign-info">
                <span>SIGN UP</span> TODAY AND RECIEVE
                UPDATES IN YOUR EMAIL
            </div>
            <form class="form-horizontal">
                <div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="email" class="form-control search-form3" id="inputEmail3" placeholder="Enter email address here"/>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group head-btn-fix">
                    <a href="#" class="head-btn btn-red search-btn2">SIGN UP</a>
                </div>
            </form>
        </div>
        <?php */?>
    </div>    
    <div class="col-md-9 col-sm-12 list-main">
        <?php if($this->session->flashdata('message')){?> 
            <div class="alert alert-danger">  
                <a class="close" data-dismiss="alert">&times;</a>  
                <?=$this->session->flashdata('message'); ?>  
            </div>
        <?php } ?>
        <div class="clearfix"></div>
        <?php if($featured_events){ ?>
        <div>
            <h2>Featured Events</h2>
            <div class="controls">
                <button class="sort custom" data-sort="myorder:asc">Relevance</button>
                <button class="sort custom" data-sort="myorder:desc">Date</button>
            </div>
            <div class="clearfix"></div>
            <div id="Container1">
                <a href="#" class="event-big mix category-1" data-myorder="1">
                    <div class="row row-fix">
                        <div class="col-md-4 col-sm-12 img-fix1">
                            <img src="images/31.png" alt="" class="img-responsive"/>          
                        </div>
                        <div class="col-md-4 col-sm-12 event-info">
                            <h3>International Food 
                            Festival</h3>
                            <p>Shoreditch small batch elit, retro bicycle rights qui flexitarian nihil nisi Banksy culpa Portland XOXO. Anim do single-</p>
                        </div>
                        <div class="col-md-4 col-sm-12 event-info-location">
                            <div class="event-info-location-main">
                                <i class="fa fa-calendar"></i> <span>Tuesday, 2am ,  14th Mar</span>
                            </div>
                            <div class="event-info-location-main">
                                <i class="fa fa-map-marker"></i> <span>Bricks Cafe Kupondol , 
                                Kathmandu</span>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="#" class="event-big mix category-1" data-myorder="2">
                    <div class="row row-fix">
                        <div class="col-md-4 col-sm-12 img-fix1">
                            <img src="images/31.png" alt="" class="img-responsive"/>          
                        </div>
                        <div class="col-md-4 col-sm-12 event-info">
                            <h3>International Food 
                            Festival</h3>
                            <p>Shoreditch small batch elit, retro bicycle rights qui flexitarian nihil nisi Banksy culpa Portland XOXO. Anim do single-</p>
                        </div>
                        <div class="col-md-4 col-sm-12 event-info-location">
                            <div class="event-info-location-main">
                                <i class="fa fa-calendar"></i> <span>Tuesday, 2am ,  14th Mar</span>
                            </div>
                            <div class="event-info-location-main">
                                <i class="fa fa-map-marker"></i> <span>Bricks Cafe Kupondol , 
                                Kathmandu</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <?php } //featured events ?>
        <div class="other-events">
            <h2>
            <?php 
            if($event_title){
                echo $event_title . " @ ". $location;     
            }else{ 
                echo "Events ";
                if(isset($_GET['location']) && !empty($_GET['location'])){
                    if($_GET['location'] !='1')
                        echo "@ ".$_GET['location'];                    
                    else
                        echo "@ ". (!empty($_GET['city'])? $_GET['city'].", " :"") .$location;
                }                
            }
            ?>
            </h2>            
            
            <div class="controls">
                <button class="sort custom" data-sort="myevent:asc">Relevance</button>
                <button class="sort custom" data-sort="myevent:desc">Date</button>
            </div>
            <div class="clearfix"></div>
            <p class="count"><?php echo $this->lang->line('event_count'); ?>: <?=$total_events;?></p>
            <?php 
            if(isset($_GET['keywords']) && !empty($_GET['keywords'])){
                echo "<p><strong>".$this->lang->line('search_for')." :</strong> ".$_GET['keywords']."</p>";
            }
            ?>
            <div class="clearfix"></div>
            <div id="Container" class="myEvents">
                <div class="row">
                    <?php 
                    if($events)
                    {
                        $i = 1;
                        $toshow = 10;
                        foreach($events as $event) 
                        {
                            
                            $logo_image = UPLOAD_FILE_PATH."event/".$event->logo;
                            $logo = (file_exists($logo_image))? $logo_image: UPLOAD_FILE_PATH.'event_logo.jpg';
                            if($i == $toshow){echo '<div class="collapse" id="collapseExample">';}
                        ?>
                        <a target="_blank" href="<?php echo site_url('event/view/'.$event->id.'/'.$this->general->get_url_name($event->title)); ?>" class="small-event mix category-1 col-md-4 col-sm-12" data-myevent="2">
                            <img src="<?=base_url().$logo;  ?>" alt="" class="img-responsive"/>
                            <div class="location-shade category_box color_<?=strtolower(substr($event->type_name,0,2)) ?>">
                                <p><?=ucwords($event->type_name);?> / <?=ucwords($event->sub_type);?></p>
                    		</div>
                            <div class="col-md-12 col-sm-12 event-info">
                                <h3><?=ucwords($event->title);?></h3>
                                <?php                 
                                $gender = array('M'=>$this->lang->line('male_only'), "F"=>$this->lang->line('female_only'),'MF'=>"Male and Female");                       
                                ?>
                                <span>(<?=(array_key_exists(strtoupper($event->target_gender),$gender))?$gender[strtoupper($event->target_gender)]: $this->lang->line('any_gender');?>)</span>                                
                            </div>
                            <div class="col-md-12 col-sm-12 event-info-location2">
                                <div class="event-info-location-main2">
                                    <i class="fa fa-calendar"></i> 
                                    <?php if($event->date_id == 0 ):?>
                                        <span><?=$this->general->date_language(date('F j, Y \a\t g:i A',strtotime($event->start_date)));?> - <?=$this->general->date_language(date('F j, Y \a\t g:i A',strtotime($event->end_date)));?></span>                
                                    <?php else: ?>                
                                        <span><?=$this->general->date_language($event->date_time_detail);?></span>
                                    <?php endif; ?>                                    
                                </div>
                                <?php if(!empty($event->physical_name)){ ?>                                    
                                    <div class="event-info-location-main2">
                                        <i class="fa fa-location-arrow"></i> <span><?=ucwords($event->physical_name);  ?></span>
                                    </div>
                                <?php } ?>
                                <?php if(!empty($event->address)){ ?>                                    
                                    <div class="event-info-location-main2">
                                        <i class="fa fa-map-marker"></i> <span><?=ucwords($event->address);?></span>
                                    </div>
                                <?php } ?> 
                                
                            </div>
                        </a>
                        <?php
                            if(($i%3)==0){echo "<div class='clearfix'></div>"; } 
                            $i++;
                        }          
                                                 
                    }else{
                    ?>
                        <div class="alert alert-info">
                            <p><?php echo $this->lang->line('no_result'); ?>.</p>
                        </div>
                    <?php        
                    }
                    if($i>$toshow){ 
                        echo '<div class="col-sm-12">'; 
                        echo $this->pagination->create_links();
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="col-sm-12">
                            <a class="btn loadmore" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Load More
                            </a>       
                        </div>';
                    } 
                    ?>
                             
                </div>
            </div>
        </div>
    </div>
</div>




	

<!--map-->
<script src="https://maps.google.com/maps/api/js?sensor=false&libraries=places&language=<?=$this->config->item('language_abbr');?>" type="text/javascript"></script>
<!--script type="text/javascript" src="assets/map/google-map-api.js"></script-->
<script> 
    function initialize() {        
          
        var input = document.getElementById('event_form_location');
        var autocomplete = new google.maps.places.Autocomplete(input);
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    
  
</script>

<link rel="stylesheet" href="<?php echo ASSETS_PATH ?>autocomplete/jquery.ui.all.css"/>
<script src="<?php echo ASSETS_PATH ?>autocomplete/jquery.ui.autocomplete.js"></script>
  
<script>
$(function() {

$( "#autocomplete" ).autocomplete({
  source: "<?=site_url('event/autocomplete')?>"
      });
});
</script>

<?php 
if ($keyword1 || $location1 || $cat1 || $date1 || $type1 || $price1 || $gender1 || $all1){
    
}else{ 
    if(!$this->input->cookie(SESSION.'country_cookie')) :?>
    <!--
    <script type="text/javascript">
    $(document).ready(function(){
        $.colorbox({href:"<?=site_url('event/zform_for_catalog/'.$country_name."/".$city_name)?>", height:'300px'});    
    });
    </script>
    -->
    <?php endif; 

}
?>



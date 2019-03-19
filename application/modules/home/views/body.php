<div class="container">
	<!-- Example row of columns -->
	<div class="row">
		<div class="cat-title">
			<div class="col-md-6 col-sm-8">				
				<h2>POPULAR EVENTS</h2>
				<div class="clearfix"></div>
			</div>
			<div class="col-md-4 col-sm-4 pull-right">
				<a href="<?php echo site_url("event"); ?>" class="view-all">View all</a>				
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="col-sm-12 visible-lg">
			<div class="alert alert-info page-alerts" id="alert-2">
				<button type="button" class="close"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<i class="fa fa-bell"></i> <?php echo $current_location; ?>
			</div>
		</div>
        <?php if($popular_events){ 
            $ctn = 1;
//            echo "<pre>";
//            var_dump($popular_events);
            foreach($popular_events as $p_event){

                if($ctn > 6){ echo '<div class="collapse" id="collapseExample">';}
                $logo = (file_exists(UPLOAD_FILE_PATH."event/".$p_event->logo))? base_url(UPLOAD_FILE_PATH."event/".$p_event->logo): base_url(UPLOAD_FILE_PATH."event_logo_370_242.png");
                ?>
                <div class="col-md-4 pop-items ">
                    <div class="popular-events" style="height: 240px; overflow: hidden;">        			
                        <img src="<?php echo $logo ?>" alt="" class="img-responsive" style="width: 100%;" />                                                                    
        				<a href="<?php echo site_url("event/view/".$p_event->id."/".$this->general->get_nice_name($p_event->title)); ?>" class="overlay-2">
        					<div class="location-shade">
        						<i class="fa fa-calendar"></i>
                                <?php if($p_event->date_id == 0){ ?>
        						<span><?php echo date("l, ga, jS  M Y",strtotime($p_event->start_date)); ?></span>						
                                <?php }else{ ?>
                                <span><?php echo $p_event->date_time_detail; ?></span>
                                <?php } ?>
        					</div> 
        					<div class="event-tile-2">
        						<div class="event-tile-2-main"><?php echo $p_event->title; ?></div>
        						<i class="fa fa-map-marker"></i><span> <?php echo $p_event->address; ?></span>
        					</div>
        				</a>
                    </div>	
        		</div>
                <?php
                if($ctn > 6){ echo '</div>';}
                $ctn++;
            }//endforeach
            ?>
            <?php if(count($popular_events) > 6){ ?>
            <div class="col-sm-12">
    			<a class="btn loadmore" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    				Load More
    			</a>       
    		</div>
            <?php }//count if
        }//if end
        ?>
		   
		
	</div>
	<hr>
</div>

<div class="jumbotron jumb2">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-sm-12">
				<h3> upcoming event</h3>

                    <?php
                    $i=0;
                    if($upcoming_events){
                        $t=count($upcoming_events);
                    foreach($upcoming_events as $u_event){ 
                        $u_logo = (file_exists(UPLOAD_FILE_PATH."event/".$u_event->logo))? base_url(UPLOAD_FILE_PATH."event/".$u_event->logo): site_url(UPLOAD_FILE_PATH."event_logo_269_123.png");
                    ?>
                        <?php
                        if($i%2==0) {
                            ?>
                            <div class="row">
                            <?php
                        }
//                        echo "<pre>";
//                        print_r($u_event);
                    ?>


					<div class="col-md-6 col-sm-12" >						
						<a href="<?php echo site_url("event/view/".$u_event->id."/".$this->general->get_nice_name($u_event->title)); ?>" class="up-event">
                            <div >
    							<img src="<?php echo $u_logo; ?>" alt="" class="img-responsive"/>
    							<div class="up-title"><?php echo $u_event->sub_type; ?></div>
    							<p><?php echo $u_event->title; ?> </p>
    							<div class="up-event-info">
    								<i class="fa fa-calendar"></i>
                                    <?php if($u_event->date_id == 0){ ?>
            						<span><?php echo date("l, ga, jS  M Y",strtotime($u_event->start_date)); ?></span>						
                                    <?php }else{ ?>
                                    <span><?php echo $u_event->date_time_detail; ?></span>
                                    <?php } ?>																
    							</div>
    							<div class="up-event-info">
    								<i class="fa fa-map-marker"></i>
    								<span> <?php echo $p_event->address; ?></span>	
    							</div>
                            </div>                                                        
						</a>
					</div>
                                <?php
                                if(($i+1)%2==0||($t==($i+1))) {
                                ?>
                </div>
                                    <?php
                                }
                        ?>
                    <?php $i++;}
                    }else{
                        echo "<div class=\"row\"><div class='alert alert-info'><p>No events found.</p></div></div>";
                                            
                                            
                    } ?>

			</div> 
			<div class="col-md-3 col-sm-12">
				<h3>Latest events</h3>
				<div class="events-container">
                    <?php 
                    if($latest_events){
                    foreach($latest_events as $l_event){ 
                        $l_logo = (file_exists(UPLOAD_FILE_PATH."event/thumb_".$l_event->logo))? site_url(UPLOAD_FILE_PATH."event/thumb_".$l_event->logo): site_url(UPLOAD_FILE_PATH."event_logo_97_78.png");
                    ?>
					<a href="<?php echo site_url("event/view/".$l_event->id."/".$this->general->get_nice_name($l_event->title)); ?>" class="event-small">
						<img src="<?php echo $l_logo ?>" alt="">
						<div class="event-small-info">
							<h4><?php echo $l_event->title; ?></h4>
							<div>
								<i class="fa fa-calendar"></i>
                                <?php if($l_event->date_id == 0){ ?>
        						<span><?php echo date("ga, jS  M Y",strtotime($l_event->start_date)); ?></span>						
                                <?php }else{ ?>
                                <span><?php echo $l_event->date_time_detail; ?></span>
                                <?php } ?>								
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="location3">
							<i class="fa fa-map-marker"></i>
							<span><?php echo $l_event->address; ?></span>
						</div>
					</a>
                    <?php }
                    }else{
                        echo "<div class='alert alert-info'><p>No events found.</p></div>";
                    } ?>
					<a href="<?php echo site_url("event") ?>" class="all-event">View All Events</a>
				</div>
			</div>
			<div class="col-md-3 col-sm-12 sidebar">
				<div class="row">
					<div class="g6">						
						<div id="eventCalendarHumanDate"></div>
						<script>
						$(document).ready(function() {
							$("#eventCalendarHumanDate").eventCalendar({
								eventsjson: '<?php echo site_url("event/datewise") ?>',
                                jsonDateFormat: 'human',
                                eventsLimit: 2,
    						});
						});
						</script>
					</div>					
					<div class="suscribe-mail">
						<h4>Suscibe To Our Mailing List</h4>
						<p>Butcher try-hard slow-carb, Echo Park tote bag Thundercats taxidermy DIY health goth. Cardigan irony dream</p>
						<form class="form-horizontal">
							<div>
								<div class="col-md-12 col-sm-12">
									<div class="form-group">
										<input type="email" class="form-control suscribe-input" id="inputEmail3" placeholder="Email"/>		
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="form-group form-fix">
									<a href="#" class="suscribe-btn pull-right">SEARCH</a>
								</div>   
								<div class="clearfix"></div> 
							</div>
							<div class="clearfix"></div>
						</form>
					</div>
					<div class="reason">
						<h4>Why Buy Tickat?</h4>
						<p>To know why to choose BUY TICKAT and about our company or to contact us</p>
						<a href="<?php echo site_url("contact-us"); ?>" class="know-reason">Contact us</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="jumbotron post-event2">
	<div class=" container">
		<h2 class="title-post">POST YOUR OWN EVENT</h2>
		<p><?php echo $this->lang->line('browse_create_sell'); ?> </p>
		<a href="<?php echo site_url("event/create"); ?>" class="get-started">get started</a>
	</div>
</div>
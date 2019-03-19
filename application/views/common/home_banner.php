<div class="jumbotron home_banner">
	<div class="container container-32">
		<div>
            <?php if(!empty($main_event_types)){ 
                $cn = 1; 
                foreach($main_event_types as $main_cat){ 
                    if($cn==6){break;}
                    $rowOpenFor = array("1","3","4");
                    $rowCloseFor = array("2","3","5");
                    if(in_array($cn,$rowOpenFor)){ echo '<div class="col-md-4 col-sm-12">'; }
                    ?>
    				<div class="catagories" style="height: <?php echo ($cn==3)? "305px" : "140px"; ?>; overflow: hidden; ">
    					<img src="<?php echo base_url(UPLOAD_FILE_PATH."category/".$main_cat['image']); ?>" alt="" class="" style="<?php echo ($cn==3)? "height:305px; " : ""; ?> width:auto;" />
    					<a href="<?php echo site_url("event?cat=".$main_cat['name']) ?>" class="overlay-pic">
    						<span><?php echo ucfirst($main_cat['name']) ?></span>
    					</a>
    				</div>                
                    <?php 
                    if(in_array($cn,$rowCloseFor)){ echo '</div>'; }
                    $cn++; }
            } 
            ?>
            <div class="clearfix"></div>
		</div>            
		<div class="col-md-12 col-sm-12  visible-lg ">
			<div role="tabpanel">				
				<ul class="nav nav-tabs search-tab" role="tablist">
					<li role="presentation" class="active hidden-1"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
					<li role="presentation"><a class="red" href="#search" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-search nav-i"></i>Search Event</a></li>
					<li role="presentation"><a href="#event" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-tag fa-flip-horizontal nav-i2"></i><?php echo $this->lang->line('event_types'); ?></a></li>
					<li role="presentation"><a href="#location" aria-controls="settings" role="tab" data-toggle="tab"><i class="fa fa-map-marker nav-i"></i><?php echo $this->lang->line('event_location'); ?></a></li>
					<?php /* ?>
                    <li role="presentation"><a class="blue" href="#flight" aria-controls="settings" role="tab" data-toggle="tab"><i class="fa fa-plane nav-i"></i>Flight Ticket</a></li>
                    <?php */ ?>
				</ul>				
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane  active" id="home">
						<div class="col-md-8 col-sm-12"><h1><?php echo $main_title; ?></h1></div>
						<div class="col-md-4 col-sm-12 pull-right">
							<a href="<?php echo $main_url; ?>" class="started"><?php echo $main_button ?></a>
						</div>
                        <div class="clearfix"></div>
					</div>
					<div role="tabpanel" class="tab-pane  fade" id="search">
                        <form action="<?php echo site_url("event/index") ?>" method="get" class="form-horizontal">
                            <div class="col-md-5 col-sm-12">
                                <div class="form-group">
                                    <label for="autocomplete" class="col-sm-12 control-label labelfix"><?=$this->lang->line('search_catalog_keyword')?></label>
                                    <div class="col-sm-12">
                                        <input type="text" name="keywords" class="form-control search-form" id="autocomplete" placeholder="<?=$this->lang->line('search_catalog_keyword')?>" value="<?php echo @$_GET['keywords'] ?>"/>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col-md-5 col-sm-12">
                                <div class="form-group">
                                    <label for="event_form_location" class="col-sm-12 control-label labelfix"><?=$this->lang->line('location')?></label>
                                    <input name="location" class="form-control search-form" type="text" placeholder="<?=$this->lang->line('location')?>" id="event_form_location"/>
                                </div>
                            </div>
                            <?php /* ?>
                            <div class="col-md-3 col-sm-12">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-12 control-label labelfix">Event Date</label>
									<div class="col-sm-12">
										<input id="datepicker-example1" type="text" class="form-control search-form">
									</div>
								</div>
							</div>
                            <?php */ ?>
                            <div class="col-md-2 col-sm-12">
                                <div class="form-group">
                                    <input class="btn head-btn btn-red search-btn" type="submit" value="<?=$this->lang->line('search')?>" style="min-width: 92px;" />                    
                                </div>
                            </div>
                        </form>
					</div>
					<div role="tabpanel" class="tab-pane fade" id="event">
						<div class="">
                            <?php 
                            if(!empty($event_types)){ $cn = 1; 
                                foreach($event_types as $event_type){
                                ?>
    							<div class="col-md-3 col-sm-12 "> 
    								<a href="<?php echo site_url("event?type=".$event_type['sub_type']) ?>" class="event-list"><?php echo ucfirst($event_type['sub_type']) ?></a>
    							</div>
                                <?php
                                }
                            }else{
                                echo "<div class='alert alert-info'><p>No events found.</p></div>";
                            }
                            ?>
						</div>    


					</div>
					<div role="tabpanel" class="tab-pane fade" id="location">

						<div class="">
                            <?php 
                            if($event_locations){
                            foreach($event_locations as $el):
                            ?>  
                                <div class="col-md-3 col-sm-12 "> 
    								<a href="<?php echo site_url("event?city=".strtolower($el->city_en)."&location=1") ?>" class="event-list"><?=$el->city_en ?></a>
    							</div>
                            <?php 
                            endforeach; 
                            }else{
                                echo "<div class='alert alert-info'><p>No events found.</p></div>";
                            }
                            ?>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane fade" id="flight">
						<form class="form-horizontal">
							<div class="col-sm-12">
								<label class="radio-inline">
									<input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> One Way
								</label>
								<label class="radio-inline">
									<input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2"> Two Way 
								</label>
							</div>
							<div>
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-12 control-label labelfix">From</label>
										<div class="col-sm-12">
											<input type="email" class="form-control search-form" id="inputEmail3" placeholder="Email">
										</div>
									</div>   

								</div>
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-12 control-label labelfix">To </label>
										<div class="col-sm-12">
											<input type="email" class="form-control search-form" id="inputEmail3" placeholder="Email">
										</div>
									</div>   
								</div>
								<div class="clearfix"></div>
							</div>
							<div>
								<div class="col-md-4 col-sm-12">
									<label for="inputEmail3" class="col-sm-12 control-label labelfix">Arrival</label>
									<input id="datepicker-example7-start" type="text" class="form-control search-form">
								</div>
								<div class="col-md-4 col-sm-12">
									<label for="inputEmail3" class="col-sm-12 control-label labelfix">Departure</label>
									<input id="datepicker-example7-end" type="text" class="form-control search-form"> 
								</div>
								<div class="clearfix"></div>
							</div>
							<div>
								<div class="col-md-2 col-sm-12">
									<label for="inputEmail3" class="col-sm-12 control-label labelfix">Adult</label>
									<input  type="text" class="form-control search-form">
								</div>
								<div class="col-md-2 col-sm-12">
									<label for="inputEmail3" class="col-sm-12 control-label labelfix">Child</label>
									<input  type="text" class="form-control search-form">
								</div>
								<div class="col-md-2 col-sm-12">
									<label for="inputEmail3" class="col-sm-12 control-label labelfix">Infants</label>
									<input  type="text" class="form-control search-form">
								</div>
								<div class="col-md-4 col-sm-12">
									<label for="inputEmail3" class="col-sm-12 control-label labelfix">Class</label>
									<select class="form-control search-form">
										<option>Economy</option>
										<option>Business</option>
									</select>
								</div>
							</div>
							<div class="col-md-2 col-sm-12">
								<div class="form-group">
									<div class="col-sm-12">
										<a href="#" class="head-btn btn-red search-btn">SEARCH</a>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
        <!--for mobile version-->
		<div class="col-sm-12">
			<div class="panel-group visible-md visible-sm visible-xs" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="panel panel-default panelfix">
					<div class="panel-heading red-acc hide-panel" role="tab" id="headingOne">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								Collapsible Group Item #1
							</a>
						</h4>
					</div>
					<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
							<div class="col-md-5 col-sm-12"><h1 class="center"><?php echo $main_title; ?></h1></div>
							<div class="col-md-3 col-sm-12 col-xs-12 pull-right">
                                <a href="<?php echo $main_url; ?>" class="started"><?php echo $main_button ?></a>								
							</div>
						</div>
					</div>
				</div>
				<div class="panel panel-default panelfix">
					<div class="panel-heading red-acc" role="tab" id="headingTwo">
						<h4 class="panel-title ">
							<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
								Search Event
							</a>
						</h4>
					</div>
					<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
						<div class="panel-body">
							<form class="form-horizontal">
								<div class="col-md-4 col-sm-12">
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-12 control-label labelfix">Event name</label>
										<div class="col-sm-12">
											<input type="email" class="form-control search-form" id="inputEmail3" placeholder="Email">
										</div>
									</div>  
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-12 control-label labelfix">City </label>
										<div class="col-sm-12">
											<input type="email" class="form-control search-form" id="inputEmail3" placeholder="Email">
										</div>
									</div>  
								</div>
								<div class="col-md-3 col-sm-12">
									<div class="form-group">
										<label for="inputEmail3" class="col-sm-12 control-label labelfix">Event Date</label>
										<div class="col-sm-12">
											<input id="datepicker-example1" type="text" class="form-control search-form">
										</div>
									</div>  
								</div>
								<div class="col-md-2 col-sm-12">
									<div class="form-group">
										<div class="col-sm-12">
											<a href="#" class="head-btn btn-red search-btn">SEARCH</a>
										</div>
									</div>   
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="panel panel-default panelfix">
					<div class="panel-heading black-acc" role="tab" id="headingThree">
						<h4 class="panel-title">
							<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
								<?php echo $this->lang->line('event_types'); ?>
							</a>
						</h4>
					</div>
					<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
						<div class="panel-body">
							<div class="">
                                <?php 
                                if(!empty($event_types)){ $cn = 1; 
                                    foreach($event_types as $event_type){
                                    ?>
        							<div class="col-md-3 col-sm-12 "> 
        								<a href="<?php echo site_url("event?type=".$event_type['sub_type']) ?>" class="event-list"><?php echo ucfirst($event_type['sub_type']) ?></a>
        							</div>
                                    <?php
                                    }
                                }else{
                                    echo "<div class='alert alert-info'><p>No events found.</p></div>";
                                }
                                ?>
    						</div>
						</div>
					</div>
				</div>

				<div class="panel panel-default panelfix">
					<div class="panel-heading black-acc" role="tab" id="headingFour">
						<h4 class="panel-title">
							<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
								Event Location
							</a>
						</h4>
					</div>
					<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
						<div class="panel-body">
    						<div class="">
                                <?php 
                                if($event_location){
                                foreach($event_location as $el):
                                ?>  
                                    <div class="col-md-3 col-sm-12 "> 
        								<a href="<?php echo site_url("event?city=".strtolower($el->city_en)."&location=1") ?>" class="event-list"><?=$el->city_en ?></a>
        							</div>
                                <?php 
                                endforeach; 
                                }else{
                                    echo "<div class='alert alert-info'><p>No events found.</p></div>";
                                }
                                ?>
    						</div>
						</div>
					</div>
				</div>
                <?php /* ?>
				<div class="panel panel-default panelfix">
					<div class="panel-heading blue-acc" role="tab" id="headingFive">
						<h4 class="panel-title">
							<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
								Flight/Bus Ticket
							</a>
						</h4>
					</div>
					<div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
						<div class="panel-body">
							<form class="form-horizontal">
								<div class="col-sm-12">

									<label class="radio-inline">
										<input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> One Way
									</label>
									<label class="radio-inline">
										<input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2"> Two Way 
									</label>


								</div>
								<div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label for="inputEmail3" class="col-sm-12 control-label labelfix">From</label>
											<div class="col-sm-12">
												<input type="email" class="form-control search-form" id="inputEmail3" placeholder="Email">
											</div>
										</div>   

									</div>
									<div class="col-md-4 col-sm-12">
										<div class="form-group">
											<label for="inputEmail3" class="col-sm-12 control-label labelfix">To </label>
											<div class="col-sm-12">
												<input type="email" class="form-control search-form" id="inputEmail3" placeholder="Email">
											</div>
										</div>   

									</div>

									<div class="clearfix"></div>

								</div>


								<div>
									<div class="col-md-4 col-sm-12">
										<label for="inputEmail3" class="col-sm-12 control-label labelfix">Arrival</label>
										<span class="Zebra_DatePicker_Icon_Wrapper" style="display: block; position: relative; float: none; top: auto; right: auto; bottom: auto; left: auto;"><input id="datepicker-example7-start" type="text" class="form-control search-form" readonly="readonly" style="position: relative; top: auto; right: auto; bottom: auto; left: auto;"><button type="button" class="Zebra_DatePicker_Icon Zebra_DatePicker_Icon_Inside" style="top: 12px; left: 81px;">Pick a date</button></span>
									</div>
									<div class="col-md-4 col-sm-12">
										<label for="inputEmail3" class="col-sm-12 control-label labelfix">Departure</label>
										<span class="Zebra_DatePicker_Icon_Wrapper" style="display: block; position: relative; float: none; top: auto; right: auto; bottom: auto; left: auto;"><input id="datepicker-example7-end" type="text" class="form-control search-form" readonly="readonly" style="position: relative; top: auto; right: auto; bottom: auto; left: auto;"><button type="button" class="Zebra_DatePicker_Icon Zebra_DatePicker_Icon_Inside" style="top: 12px; left: 81px;">Pick a date</button></span> 
									</div>
									<div class="clearfix"></div>
								</div>

								<div>
									<div class="col-md-2 col-sm-12">
										<label for="inputEmail3" class="col-sm-12 control-label labelfix">Adult</label>
										<input type="text" class="form-control search-form">
									</div>
									<div class="col-md-2 col-sm-12">
										<label for="inputEmail3" class="col-sm-12 control-label labelfix">Child</label>
										<input type="text" class="form-control search-form">
									</div>
									<div class="col-md-2 col-sm-12">
										<label for="inputEmail3" class="col-sm-12 control-label labelfix">Infants</label>
										<input type="text" class="form-control search-form">
									</div>
									<div class="col-md-4 col-sm-12">
										<label for="inputEmail3" class="col-sm-12 control-label labelfix">Class</label>
										<select class="form-control search-form">
											<option>Economy</option>
											<option>Business</option>

										</select>
									</div>

								</div>
								<div class="col-md-2 col-sm-12">
									<div class="form-group">

										<div class="col-sm-12">
											<a href="#" class="head-btn btn-red search-btn">SEARCH</a>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
                <?php */?>                
			</div>
		</div>
        <!--for mobile version-->
	</div>
</div>


<!--for search map location / autocomplete search keywords-->
<script src="https://maps.google.com/maps/api/js?sensor=false&libraries=places&language=<?=$this->config->item('language_abbr');?>" type="text/javascript"></script>
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
<!--for search map location / autocomplete search keywords-->
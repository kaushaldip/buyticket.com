<style>
body input[type="radio"], body input[type="checkbox"]{margin: 0 !important;}
label, input, button, select, textarea {font-size: 16px;}
label.for_event_repeats{display: inline-block;}
label.error{font-size: 12px;position: absolute; }
. {position: relative;}
label.error{right: 0;}
#blah{float:left; margin:0 10px 10px 0px;}
</style>
<div class="row create-event">
    <h1 class="title"><span><?php echo $this->lang->line('create_an_event'); ?></span></h1>
    <div class="row-fluid">
        <form class="form-horizontal create_event"  method="post" enctype="multipart/form-data" action="" id="event_form" >  
            <noscript>
            <input name="js_enabled" type="hidden" value="1"/>
            </noscript>
            <div class="event-div">  
                <div class="event-step"><span>1</span><h2><?php echo $this->lang->line('event_details'); ?></h2></div>        
                <div class="event-form-main">          
                    <div class="form-group">  
                        <label class="form-label" for="input01"><?php echo $this->lang->line('event_title') ; ?>*</label>  
                        <div class="col-md-8 col-sm-8 col-xs-10">  
                            <input type="text" name="event_title" class="form-control input-xxlarge required" id="event_form_title" value="<?php echo set_value('event_title'); ?>" title="<?=$this->lang->line('event_title_is_required') ?>" />                                                        
                            <?= form_error('event_title') ?>            
                        </div>  
                        <div class="col-md-2 col-sm-2"><i class="fa fa-exclamation-circle tooltip-i" data-toggle="tooltip" data-placement="top" title="<?=$this->lang->line('title_for_your_event') ?>"></i></div>
                    </div>
                    <!-- date-time start -->

                    <div class="form-group">
                        <div class="row"> 
                            <div class="col-md-5 col-sm-6"> 
                                <label class="form-label" for="input01"><?php echo $this->lang->line('start_date'); ?></label>                    
                                <div class="col-md-8 col-sm-12">
                                    <input type="text" id="start_date" name="start_date" value="<?php echo (isset($_POST['start_date'])) ? $_POST['start_date'] : $this->general->get_date_ar(date('Y-m-d h:i a')); ?>" class="form-control datepicker" readonly="true"/>
                                    <label class="for_event_repeats" for="event_repeats"><input type="checkbox" id="event_repeats" name="event_repeats" style="margin: 4px;" /><?php echo $this->lang->line('this_event_repeats'); ?>.</label>
                                </div>
                                
                            </div>
                            <div class="col-md-5 col-sm-6">
                                <label class="for_end_date form-label"><?php echo $this->lang->line('end_line'); ?></label>
                                <div class="col-md-8 col-sm-12">                                
                                    <input type="text" id="end_date" name="end_date" value="<?php echo (isset($_POST['end_date'])) ? $_POST['end_date'] : $this->general->get_date_ar(date('Y-m-d h:i a')); ?>" class="form-control datepicker" readonly="true"/>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2"><i class="fa fa-exclamation-circle tooltip-i" data-toggle="tooltip" data-placement="top" title="<?php echo $this->lang->line('duration_of_event_msg'); ?>"></i></div>
                            <div class="clearfix"></div>                            
                        </div>  
                    </div>
                    <div id="date_type_div" style="display: none;">
                        <div class="form-group">
                            <label class="form-label" for="input01"><?php echo $this->lang->line('event_repeats'); ?></label>
                            <div class="col-md-4 col-sm-8 col-xs-10">
                                <select name="date_type" class="form-control">
                                    <option value="Never"><?php echo $this->lang->line('never'); ?></option>
                                    <option value="Daily"><?php echo $this->lang->line('daily'); ?></option>
                                    <option value="Weekly"><?php echo $this->lang->line('weekly'); ?></option>
                                    <option value="Monthly"><?php echo $this->lang->line('monthly'); ?></option>
                                    <?php /*<!--option value="Custom">Custom</option-->*/ ?>
                                </select>                                
                                <input name="date_time_detail" value="" type="hidden" />
                            </div>
                            <div class="col-md-6 col-sm-8 col-xs-10">
                                <span id="date_time_response" style="font-weight: bolder;"></span>
                            </div>
                        </div>
                    </div>        
                    <!-- date-time end -->
                    <div class="form-group">  
                        <label class="form-label" for="input01"><?php echo $this->lang->line('venue'); ?>*</label>  
                        <div class="col-md-8 col-sm-8 col-xs-10">  
                            <input type="text" name="physical_address" class="form-control input-xxlarge required" id="event_form_physical_address" value="<?php echo set_value('physical_address'); ?>" title="<?=$this->lang->line('event_venue_required') ?>" />                            
                            <span class="for_example" style="display: block;"><?php echo $this->lang->line('example_venue'); ?></span>
                            <?= form_error('physical_address') ?>   
                        </div> 
                        <div class="col-md-2 col-sm-2"><i class="fa fa-exclamation-circle tooltip-i" data-toggle="tooltip" data-placement="top" title="<?=$this->lang->line('physical_location_where_tooltip');?>"></i></div> 
                    </div>
                    <div class="form-group">  
                        <label class="form-label" for="input01"><?php echo $this->lang->line('address'); ?>*</label>  
                        <div class="col-md-8 col-sm-8 col-xs-10">  
                            <input type="text" name="location" class="form-control input-xxlarge required" id="event_form_location" value="<?php echo set_value('location'); ?>" title="<?=$this->lang->line('event_location_required')?>" />
                            
                            <br />
                            <span class="for_example"><?php echo $this->lang->line('example_address'); ?></span>
                            <?= form_error('location') ?>
                        </div>
                        <div class="col-md-2 col-sm-2"><i class="fa fa-exclamation-circle tooltip-i" data-toggle="tooltip" data-placement="top" title="<?=$this->lang->line('google_map_location_tooltip_msg')?>"></i></div>
                    </div>
                    <!-- map -->
                    <div class="form-group" id="map_block" style="display: none;">  
                        <label class="form-label" for="input01"></label>
                        <div class="col-md-8 col-sm-8 col-xs-10">
                            <div id="map" style="height: 300px; width: 100%;" ></div>
                            <input id="show_the_map" type="checkbox" checked="checked"/> <?php echo $this->lang->line('show_map'); ?>.
                        </div>
                    </div>
                    <!-- map -->
                    <div class="form-group">  
                        <label class="form-label" for="input01"><?php echo $this->lang->line('target_gender'); ?></label>  
                        <div class="col-md-3 col-sm-3 col-xs-10">
                            <select name="target_gender" class="form-control">
                                <option value="B"><?php echo $this->lang->line('m_f'); ?></option>
                                <option value="M"><?php echo $this->lang->line('male'); ?></option>
                                <option value="F"><?php echo $this->lang->line('female'); ?></option>
                            </select>     
                        </div>  
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="input01"><?php echo $this->lang->line('upload_logo'); ?></label>
                        <div class="col-md-8 col-sm-12">
                            <img id="blah" src="<?= MAIN_IMAGES_DIR_FULL_PATH . "default_upload_logo.gif" ?>" title="Event Logo" />
                            <input type="file" name="event_logo" id="event_form_logo" class=" fileType"  onchange="change_event_logo(this,'blah');pressed(this);" />                            
                            <p class="help-block"><?=$this->lang->line('choose_file');?></p>
                            <?= form_error('event_logo'); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="form-group">  
                        <label class="form-label" for="input01"><?php echo $this->lang->line('description'); ?></label>  
                        <div class="col-md-8 col-sm-8 col-xs-10">  
                            <?php echo form_fckeditor('event_description', set_value('event_description')); ?>
                            <?= form_error('event_description') ?>
                        </div>  
                    </div>
                    <script>
                    CKEDITOR.config.language = '<?=$this->config->item('language_abbr');?>';
                    </script>
                </div>    
            </div>
    
            <!-- ticket detail start -->
            <div class="event-div"> 
                <div class="event-step"><span>2</span><h2><?php echo $this->lang->line('create_tickets'); ?></h2></div>                  
                <div class="event-form-main">
                    <input type="hidden" value="2" id='count' name="ticket_count" />
                    <input type="button" value="<?=$this->lang->line('add_ticket')?>" class="btn" onclick="addNewTicketRow('ticketTable')"  />
                    <input type="button" value="<?=$this->lang->line('remove')?>" class="btn" onclick="deleteNewTicketRow('ticketTable')" />
                    <br clear="all" /> <br />
                    <table id="ticketTable" border="0" cellpadding="0" cellspacing="0" width="100%" class="table_rows_add table table-striped">  
                        <tbody>
                            <tr>    
                                <td width="1"></td>
                                <td><?php echo $this->lang->line('paid_free'); ?></td>
                                <td><?php echo $this->lang->line('ticket_name'); ?>:</td>
                                <td><?php echo $this->lang->line('ticket_quantity'); ?>:</td>
                                <td><?php echo $this->lang->line('ticket_price'); ?></td>
                            </tr>                
                          
                            <tr>
                                <td align="right"><input type="checkbox" class="chk" name="chk"/></td>
                                <td>
                                    <select class="form-control" id="paid_free_select0" name="paid_free_select0" style="width: 100px;" onchange="change_paid_free(this);" index='0'>
                                        <option value="paid"><?php echo $this->lang->line('paid'); ?></option>
                                        <option value="free"><?php echo $this->lang->line('free'); ?></option>
                                    </select>
                                </td>                    
                                <td>
                                    <input type="text" class="form-control" name="ticket_name0" id="event_form_ticket_name0" index="0" value="<?php echo set_value('ticket_name0'); ?>" oname="ticket_name"/>
                                </td>
                                <td>
                                    <input type="text" class="number form-control" name="ticket_quantity0" id="event_form_ticket_quantity0" index="0" value="<?php echo set_value('ticket_quantity0'); ?>" oname="ticket_quantity"/>
                                    <br /><br />                        
                                    <?php echo $this->lang->line('starts_on'); ?>: 
                                    <br />
                                    <input type="text" name="ticket_start_date0" id="ticket_start_date0" class="ticket_start_date datepicker" value="<?= $this->general->get_date_ar(date('Y-m-d h:i a')); ?>" style="width: 200px;" index="0" onclick="set_ticket_start_date(this);" oname="ticket_start_date"/>
                                    <br />
                                    <?php echo $this->lang->line('ends_on'); ?>: 
                                    <br />
                                    <input type="text" name="ticket_end_date0" id="ticket_end_date0" class="ticket_end_date datepicker" value="<?= $this->general->get_date_ar(date('Y-m-d h:i a')); ?>" style="width: 200px;" index="0" onclick="set_ticket_end_date(this);" oname="ticket_end_date"/>
                                </td>
                                <td>
                                    <?php
                                    $convertor = 1;
                                    ?>
                                    <input name="ticket_currency0" type="hidden" id="ticket_form_currency0" index='0' value="<?= CURRENCY_SYMBOL ?>" class="ticket_form_cur" oname="ticket_currency"/>
                                    <?= CURRENCY_SYMBOL ?>
                                    <input type="text" name="ticket_your_price0" value="" style="width: 100px;" class="ticket_your_price number" id="ticket_your_price0" value="<?php echo set_value('ticket_your_price0'); ?>" index='0' onkeyup="price_display(this);" oname="ticket_your_price"/>
                                    <br />
                                    <input type="checkbox" name="web_fee_included_in_ticket0" onclick="price_display(this);"  id="web_fee_included_in_ticket0" index="0" oname="web_fee_included_in_ticket"/>
                                    <em><?php echo $this->lang->line('uncheck_ticket'); ?>.</em>
                                    <br clear="all" /><br />
                                    <?php echo $this->lang->line('web_free'); ?>: <em><a href="<?=site_url('page/pricing')?>" target="_blank"><?php echo $this->lang->line('fees'); ?></a></em>
                                    <br />
                                    <input type="text" style="width: 100px;" value="" disabled="disabled" name="ticket_website_fee0" id="ticket_website_fee0" index="0" oname="ticket_website_fee"/>                                
                                    <br />
                                    <?php echo $this->lang->line('ticket_price'); ?>:
                                    <br />
                                    <input type="text" name="ticket_main_price0" style="width: 100px;"  disabled="disabled" id="ticket_main_price0" index="0" oname="ticket_main_price"/>
                                </td>
    
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- ticket detail end -->
    
            <!-- publish event start -->
            <div class="event-div">   
                <div class="event-step"><span>3</span><h2><?php echo $this->lang->line('publish_events'); ?></h2></div>       
                <div class="event-form-main">
                    <div class="form-group">
                        <label class="form-label" for="input01"><?php echo $this->lang->line('publicize_private'); ?></label>
                        <div class="  col-md-10 col-sm-10 col-xs-10">
                            <input type="radio" name="status" value="1" onclick="show_public();" class="required" title="<?=$this->lang->line('this_field_required') ?>" /> <span class="for_status"><?php echo $this->lang->line('public'); ?></span>
                            <input type="radio" name="status" value="2"  onclick="show_private();" class="required" class="<?=$this->lang->line('this_field_required') ?>" /> <span class="for_status"><?php echo $this->lang->line('private'); ?></span>                
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div id="hide_section_public" style="display: none;"><?php include('event_create_public.php'); ?></div>
                    <div id="hide_section_private" style="display: none;"><?php include('event_create_private.php'); ?></div>
                </div>
                <!-- buttons -->
                <div class="form-btn-grp">                    
                    <input type="submit" name="preview" class="btn btn-blue form-btn-fix  cancel" value="<?php echo $this->lang->line('preview'); ?>" />
                    <input type="submit" name="publish" class="btn btn-blue form-btn-fix" value="<?php echo $this->lang->line('make_online'); ?>" />  
                    <?php /*<!--<input type="submit" name="save" class="btn btn-red form-btn-fix cancel" value="<?php echo $this->lang->line('save'); ?>" />--> */?>  
                    <button class="btn btn-red form-btn-fix" type="button" onclick="window.location.href='<?= site_url(); ?>';"><?php echo $this->lang->line('cancel'); ?> </button>        
                </div>
                <!-- buttons -->
            </div>
            <!-- publish event detail end -->
        </form>
    </div>
    <?php include("event_create_date.php"); //includes all the date modals ?>
</div>
<!--map-->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=en&libraries=places"></script>
<?php /*<!--script type="text/javascript" src="assets/map/google-map-api.js"></script--> */?>
<script> 
    function initialize() {
        var myLatlng = new google.maps.LatLng(-33.8688, 151.2195);
        var mapOptions = {
            center: new google.maps.LatLng(-33.8688, 151.2195),
            zoom: 17,            
            mapTypeId: google.maps.MapTypeId.ROADMAP,        
            
            zoomControl: true           
        };        
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);
        
        var input = document.getElementById('event_form_location');
        //console.log(input.val+'d');
                
        var autocomplete = new google.maps.places.Autocomplete(input);
        
        autocomplete.bindTo('bounds', map);
        
        
        var infowindow = new google.maps.InfoWindow();
        infowindow.setContent('<b>???????</b>');
        marker = new google.maps.Marker({
            position: myLatlng, 
            map: map
        });
        
        /*new added*/        
        

        google.maps.event.addListener(map, 'mouseup', function(){
            var location = map.getCenter();
            //new added
            placeMarker(location);
            displayLocation(location.lat(),location.lng());
        	
        });
        google.maps.event.addListener(map, 'zoom_changed', function() {
            zoomLevel = map.getZoom();    	
        });
        google.maps.event.addListener(marker, 'dblclick', function() {
            zoomLevel = map.getZoom()+1;
            if (zoomLevel == 20) {
                zoomLevel = 10;
       	    }
            map.setZoom(zoomLevel);
    	 
        });
               
        /*new added*/
        
        
        google.maps.event.addListener(autocomplete, 'place_changed', function() {            
            $("#map_block").show();
            $('input#show_the_map').attr('checked','checked');
            //new added
            google.maps.event.trigger(map, 'resize');
            
            infowindow.close();
            var place = autocomplete.getPlace();
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }
            //alert(autocomplete.getBounds());
            var image = new google.maps.MarkerImage(
            place.icon, new google.maps.Size(71, 71),
            new google.maps.Point(0, 0), new google.maps.Point(17, 34),
            new google.maps.Size(35, 35));
            marker.setIcon(image);
            marker.setPosition(place.geometry.location);
            
            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] &&
                        place.address_components[0].short_name || ''),
                    (place.address_components[1] &&
                        place.address_components[1].short_name || ''),
                    (place.address_components[2] &&
                        place.address_components[2].short_name || '')].join(' ');
            }
            
            //infowindow.setContent('<div><b>' + place.name + '</b><br>' + address);
            //infowindow.open(map, marker);
            //infowindow.open(map); //remove marker  
        });
        
        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        <?php /*not required
        var setupClickListener = function(id, types) {
            var radioButton = document.getElementById(id);
            google.maps.event.addDomListener(radioButton, 'click', function() {
                autocomplete.setTypes(types);
            });
        }
        
        setupClickListener('changetype-all', []);
        //setupClickListener('changetype-establishment', ['establishment']);
        //setupClickListener('changetype-geocode', ['geocode']);
        */?>
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    
    function placeMarker(location) {    
        var clickedLocation = new google.maps.LatLng(location);
        marker.setPosition(location);
    }

    function displayLocation(latitude,longitude){
        var request = new XMLHttpRequest();

        var method = 'GET';
        var url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+latitude+','+longitude+'&sensor=true&language=<?=$this->config->item('language_abbr');?>';
        var async = true;

        request.open(method, url, async);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                var data = JSON.parse(request.responseText);
                var address = data.results[0];
                //document.write(address.formatted_address);
                document.getElementById("event_form_location").value = address.formatted_address;
            }
        };
        request.send();
    };


</script>
<!--map-->

<script>

    $(document).ready(function(){
        $("#event_form").validate({
            errorClass: "error text-danger",
    		validClass: "valid",
    		errorElement: "div",
        }); 
    });
</script>
<script>
    $("#show_the_map").click( function(){
        if( $(this).is(':checked') ) $("#map").show();
    }
);

    $("#show_the_map").click( function(){
        if(! $(this).is(':checked') ) $("#map").hide();
    }
);
</script>
<script>
    $(document).keypress(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) { 
            return false;
        }
    });
</script>

<!--event start and end date start-->

<script>
    $(function() {
        
        $( "#start_date" ).datetimepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,        
            dateFormat: "yy-mm-dd",
            timeFormat: "hh:mm tt",
            stepHour: 1,
            stepMinute: 10,
        
            onClose: function( selectedDate ) {
                $( "#end_date" ).datetimepicker( "option", "minDate", selectedDate);                
                $(".ticket_end_date").datetimepicker( "option", "maxDate", selectedDate);                
                $(".ticket_end_date").val(selectedDate);
                $(".ticket_start_date").datetimepicker( "option", "maxDate", selectedDate);
                $("#end_date").val(selectedDate);
                
            }
        });
        $( "#end_date" ).datetimepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,        
            dateFormat: "yy-mm-dd",
            timeFormat: "hh:mm tt",
            stepHour: 1,
            stepMinute: 10,
            onClose: function( selectedDate ) {
                $( "#start_date" ).datetimepicker( "option", "maxDate", selectedDate);
                $(".ticket_end_date").datetimepicker( "option", "maxDate", selectedDate);                
                $(".ticket_end_date").val(selectedDate);
                
            }
        });
    });
</script>
<!--event start and end date end-->

<!--ticket datepicker start-->
<script>
    set_ticket_start_date();
    set_ticket_end_date();
    function set_ticket_start_date(input)
    {    
        $('.ticket_start_date').each(function(){
            maxDateOfTicket = $("#start_date").val();
            $(this).datetimepicker({
                timeFormat: "hh:mm tt",
                changeMonth: true,
                maxDate: maxDateOfTicket,
                dateFormat: "yy-mm-dd"
            });
            index = $(this).attr('index');
        });
        console.log(index);
        
        $( "#ticket_start_date"+index ).datetimepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                timeFormat: "hh:mm tt",
                maxDate: maxDateOfTicket,
                dateFormat: "yy-mm-dd",
                onClose: function( selectedDate ) {
                    $( "#ticket_end_date"+index ).datetimepicker( "option", "minDate", selectedDate );
                    }
        });
        
    }

    function set_ticket_end_date(input)
    {   
        $('.ticket_end_date').each(function(){            
            maxDateOfTicket = $("#end_date").val();
            $(this).datetimepicker({
                timeFormat: "hh:mm tt",
                changeMonth: true,
                maxDate: maxDateOfTicket,
                dateFormat: "yy-mm-dd",
                onClose: function( selectedDate ) {
                    $(this).datetimepicker( "option", "maxDate", maxDateOfTicket);
                    
                }
            });
            index = $(this).attr('index');
        });
        
        $( "#ticket_end_date"+index ).datetimepicker({
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 1,
                timeFormat: "hh:mm tt",
                maxDate: maxDateOfTicket,
                dateFormat: "yy-mm-dd",
                onClose: function( selectedDate ) {
                    $( "#ticket_start_date"+index ).datetimepicker( "option", "minDate", selectedDate );
                    }
            });
    }
</script>
<!--ticket datepicker end -->

<script type="text/javascript">	
    function addRow(tableID) {

        var table = document.getElementById(tableID);
    
        var rowCount = table.rows.length;
        //alert(rowCount);
        var row = table.insertRow(rowCount);

        var colCount = table.rows[0].cells.length;

        for(var i=0; i<colCount; i++) {

            var newcell	= row.insertCell(i);
        
            newcell.innerHTML = table.rows[1].cells[i].innerHTML;
            //console.log(newcell.childNodes);
            switch(newcell.childNodes[0].type) {
                case "text":
                    newcell.childNodes[0].value = "";                    
                    console.log(newcell.childNodes[0]);
                    break;
                case "file":
                    newcell.childNodes[0].value = "";
                    break;		
                case "checkbox":
                    newcell.childNodes[0].checked = false;
                    break;
                case "select-one":
                    newcell.childNodes[0].selectedIndex = 0;
                    break;                
            }
            if(newcell.childNodes[1]){
                console.log(newcell.childNodes[1]);
                newcell.childNodes[1].innerHTML = "<?=$this->lang->line('choose_file')?>";
            }
                 
        }
    }

    function deleteRow(tableID) {
        try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;

            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    if(rowCount <= 2) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }

            }
        }catch(e) {
            alert(e);
        }
    }
</script>


<script>
    web_fee_rate = parseFloat("<?= WEBSITE_FEE; ?>") ;
    web_fee_price = parseFloat("<?= WEBSITE_FEE_PRICE * $convertor; ?>") ;

    function price_display(myprice)
    {
    
        index = $(myprice).attr('index');    
        your_price = $("#ticket_your_price"+index).val();
        your_price = parseFloat(your_price);
    
        //old_we_fee = web_fee_rate /100 * your_price + web_fee_price;
        web_fee = your_price - ((your_price - web_fee_price)/(1 + (web_fee_rate /100))); 
        web_fee = parseFloat(web_fee);    
         
        twf = parseFloat(web_fee).toFixed(2);
        if(twf=='NaN')
            twf = "<?=$this->lang->line('enter_a_number')?>";         
        $('#ticket_website_fee'+index).val(twf);
        //alert(index);
        //flag = document.getElementById("web_fee_included_in_ticket"+index).checked; if ($('#web_fee_included_in_ticket'+index).is(":checked"))    
        if($("input[id='web_fee_included_in_ticket"+index+"']").is(":checked"))    
            ticket_price = your_price;
        else{
            ticket_price  = your_price + web_fee;  
            ticket_price = parseFloat(ticket_price).toFixed(2)
        }
        if(ticket_price =='NaN')
            ticket_price = "<?=$this->lang->line('enter_a_number')?>";                     
        $('#ticket_main_price'+index).val(ticket_price); 
    }
</script>
<script>
    function change_paid_free(selector)
    {
        index = $(selector).attr('index');
        paid = $(selector).val();
        if(paid=='free'){
            $("#ticket_your_price"+index).prop('disabled', true);
            $("#ticket_your_price"+index).val('0');
            $("#ticket_website_fee"+index).val('0');
            $("#ticket_main_price"+index).val('0');
            $("input[name=web_fee_included_in_ticket"+index+"]").attr("disabled",true);
        }        
        else{
            $("#ticket_your_price"+index).prop('disabled', false);
            $("input[name=web_fee_included_in_ticket"+index+"]").attr("disabled",false);
        }    
        
    
    }
</script>
<!--change logo-->
<script>
    function change_event_logo(input,fileid)
    {    
        input_id = $(input).attr('id');
    
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            extension = input.files[0].type;
            size = input.files[0].size;
            
        
            reader.onload = function (e) { 
                if(size <= '2048000'){
                    if(extension == 'image/jpeg' || extension == 'image/png'|| extension == 'image/gif' ){
                        $('#'+fileid)
                        .attr('src', e.target.result)                
                        .height(100);    
                    }else{
                        $('#'+fileid)
                        .attr('src', '')
                        .attr('alt', 'Invalid image')                
                        .width(100);
                        $("#"+input_id).val('');
                    }    
                }else{
                    $('#'+fileid)
                    .attr('src', '')
                    .attr('alt', 'File size more than 2MB.')                
                    .width(100);
                    $("#"+input_id).val('');
                }
                            
            
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>






<!--add row ticket -->
<script>
    $("#count").val('2');         
    
    currentIndex = 0;
    // to add new row
    function addNewTicketRow(tableId){
        
        
        currentIndex ++;
        var secondlast = $("#"+tableId+' tr:last');
        var newClone = secondlast.clone();
        // find all the inputs within your new clone and for each one of those
        newClone.find('td').each(function() {
            jQuery(this).children("input[type='checkbox'].chk").attr("name", "chk"+currentIndex).removeAttr('checked');
            
            jQuery(this).children("input[name='ticket_name"+(currentIndex-1)+"']").attr("name", "ticket_name"+currentIndex).attr("id", "event_form_ticket_name"+currentIndex).val('').attr('index', currentIndex);
            
            jQuery(this).children("input[name='ticket_quantity"+(currentIndex-1)+"']").attr("name", "ticket_quantity"+currentIndex).attr("id", "event_form_ticket_quantity"+currentIndex).val('').attr('index', currentIndex);
            
            jQuery(this).children("input[name='ticket_start_date"+(currentIndex-1)+"']").attr("name", "ticket_start_date"+currentIndex).attr("id", "ticket_start_date"+currentIndex).attr("index", currentIndex).attr('onclick',"set_ticket_start_date(this);").attr('class','ticket_start_date datepicker');
                        
            jQuery(this).children("input[name='ticket_end_date"+(currentIndex-1)+"']").attr("name", "ticket_end_date"+currentIndex).attr("id", "ticket_end_date"+currentIndex).attr("index", currentIndex).attr('onclick',"set_ticket_end_date(this);").attr('class','ticket_end_date datepicker ');
            
            jQuery(this).children("input[name='ticket_currency"+(currentIndex-1)+"']").attr("name", "ticket_currency"+currentIndex).attr("id", "ticket_form_currency"+currentIndex).attr("index", currentIndex);
            
            
            jQuery(this).children("input[name='ticket_your_price"+(currentIndex-1)+"']").attr("name", "ticket_your_price"+currentIndex).attr("id", "ticket_your_price"+currentIndex).attr("index", currentIndex).prop('disabled', false).removeAttr('disabled').val('');
            
            jQuery(this).children("input[type='checkbox'].ticket_form_cur").attr("name", "web_fee_included_in_ticket"+currentIndex).attr("id", "web_fee_included_in_ticket"+currentIndex).attr("index", currentIndex);            
            
            jQuery(this).children("input[name='ticket_website_fee"+(currentIndex-1)+"']").attr("name", "ticket_website_fee"+currentIndex).attr("id", "ticket_website_fee"+currentIndex).attr("index", currentIndex);
            
            jQuery(this).children("input[name='ticket_main_price"+(currentIndex-1)+"']").attr("name", "ticket_main_price"+currentIndex).attr("id", "ticket_main_price"+currentIndex).attr("index", currentIndex);
            
            jQuery(this).children("select[name='paid_free_select"+(currentIndex-1)+"']").attr("name", "paid_free_select"+currentIndex).attr("id", "paid_free_select"+currentIndex).attr("index", currentIndex);
           
            console.log(currentIndex);
             
        });
        // insert after is I assume what you want
        newClone.insertAfter(secondlast);
        total_ticket_row_count(tableId);
        set_ticket_start_date();
        set_ticket_end_date();
    }
    
    function rearrangeAttributesHere(tableId){
        jQuery("#"+tableId+" tbody tr").each(function(){
            // to reassign name            
            var cIndex = jQuery(this).index();
            
            console.log(cIndex);
            if(cIndex == '0')
                return;
            currentIndex = cIndex - 1;
            jQuery(this).children().children("input[type='checkbox']").attr("name", "chk"+currentIndex);
            
            jQuery(this).children().children("select").attr("name", "paid_free_select"+currentIndex).attr('id', "paid_free_select"+currentIndex).attr('index', currentIndex);
            
            jQuery(this).children().children("input[oname='ticket_name']").attr("name", "ticket_name"+currentIndex).attr("id", "event_form_ticket_name"+currentIndex).attr("index", currentIndex);
            
            jQuery(this).children().children("input[oname='ticket_quantity']").attr("name", "ticket_quantity"+currentIndex).attr("id", "event_form_ticket_quantity"+currentIndex).attr("index", currentIndex);

            jQuery(this).children().children("input[oname='ticket_start_date']").attr("name", "ticket_start_date"+currentIndex).attr("id", "ticket_start_date"+currentIndex).attr("index", currentIndex).attr('onclick',"set_ticket_start_date(this);").attr('class','ticket_start_date datepicker');
                        
            jQuery(this).children().children("input[oname='ticket_end_date']").attr("name", "ticket_end_date"+currentIndex).attr("id", "ticket_end_date"+currentIndex).attr("index", currentIndex).attr('onclick',"set_ticket_end_date(this);").attr('class','ticket_end_date datepicker ');
            
            jQuery(this).children().children("input[oname='ticket_currency']").attr("name", "ticket_currency"+currentIndex).attr("id", "ticket_form_currency"+currentIndex).attr("index", currentIndex);
            
            
            jQuery(this).children().children("input[oname='ticket_your_price']").attr("name", "ticket_your_price"+currentIndex).attr("id", "ticket_your_price"+currentIndex).attr("index", currentIndex);
            
            jQuery(this).children().children("input[type='checkbox']").attr("name", "web_fee_included_in_ticket"+currentIndex).attr("id", "web_fee_included_in_ticket"+currentIndex).attr("index", currentIndex);            
            
            jQuery(this).children().children("input[oname='ticket_website_fee']").attr("name", "ticket_website_fee"+currentIndex).attr("id", "ticket_website_fee"+currentIndex).attr("index", currentIndex);
            
            jQuery(this).children().children("input[oname='ticket_main_price']").attr("name", "ticket_main_price"+currentIndex).attr("id", "ticket_main_price"+currentIndex).attr("index", currentIndex);
            
            jQuery(this).children().children("select[oname='paid_free_select']").attr("name", "paid_free_select"+currentIndex).attr("id", "paid_free_select"+currentIndex).attr("index", currentIndex);
                        
            
        });
        // to uncheck checkbox
        jQuery("#"+tableId+" tr:last").children().children("input[type='text']").attr("checked", "false");
               
    };
        
    // to remove selected row
    function deleteNewTicketRow(tableId){
        var rows = jQuery("#"+tableId+" tr").length;
        var chek = jQuery("#"+tableId+" input.chk:checked").length + 1;
        console.log(rows);
        console.log(chek);
        if (chek === rows) {
            alert ("You cant delete all the rows")
        } else {
            jQuery("#"+tableId+" input.chk:checked").each(function () {
                jQuery(this).parent().parent().remove();
            });
        }
        rearrangeAttributesHere(tableId);
        total_ticket_row_count(tableId);
    }
    function total_ticket_row_count(tableId){
        count = 0;
        jQuery("#"+tableId+" tbody tr").each(function(){
            count++;                
        });
        $("#count").val(count);         
    }        
    
</script>
<!-- ticket end -->
<script>
    $.validator.addMethod("nicename",function(value,element)
    {
        return this.optional(element) || /^[a-zA-Z0-9._-]{3,16}$/i.test(value);
    },"This field must be 3 to 16");
</script>
<style>
    input.error{border: 1px solid #ff0000;}
</style>

<!--performer js start-->
<script>
    $(window).load(function(){
        var performer_id = $("#performer_id").val();
        if(performer_id==undefined || performer_id==null || performer_id=='' || performer_id=='0')
            $("#performer_check").val("no");
        else
            $("#performer_check").val(performer_id); 
        $("#performer_check_edit").val(""); 
        $("#performer_name").val('');
        $("#performer_type").val('');
        $("#performer_description").val('');  
    });
    $('#add_perfomer').on('click',function(){    
        $("#performer_menu").hide();
        $("#performer_form").show(200);    
        $("#performer_check").val("new"); 
        $("#performer_check_edit").val(""); 
        $("#performer_name").val('');
        $("#performer_type").val('');
        $("#performer_description").val('');  
    });

    $('#cancel_performer').on('click',function(){
        $("#performer_menu").show();
        $("#performer_form").hide(200);
        var performer_id = $("#performer_id").val();
        if(performer_id==undefined || performer_id==null || performer_id=='' || performer_id=='0')
            $("#performer_check").val("no");
        else
            $("#performer_check").val(performer_id);
        $("#performer_check_edit").val("");
        $("#performer_name").val('');
        $("#performer_type").val('');
        $("#performer_description").val('');
    });

    $('#edit_performer').on('click',function(){
        var performer_id = $("#performer_id").val();
    
        $.post(site_url+'event/show_performer_detail',
        {performer_id:performer_id},
        function(data)
        {                
            data=jQuery.trim(data);
            msg=data.split("@@");
            var result_storer=msg[0].split("=");
            var result=jQuery.trim(result_storer[1]);
    	
            var message_result=msg[1].split("=");
            var message=jQuery.trim(message_result[1]);
          
            if(result=='error')
            {
                alert(message);
            }
            else if(result=='success')
            {                                        
                $("#performer_menu").hide();
                $("#performer_form").show(200);
                $("#performer_check").val(performer_id);
                $("#performer_check_edit").val(performer_id);
            
                var name_result=msg[1].split("=");
                var name=jQuery.trim(name_result[1]);
                $("#performer_name").val(name);
            
                var type_result=msg[2].split("=");
                var type=jQuery.trim(type_result[1]);
                $("#performer_type").val(type);
            
                var description_result=msg[3].split("=");
                var description=jQuery.trim(description_result[1]);
                $("#performer_description").val(description);
            
            }        
        });
    });

</script>
<!--performer js end-->

<!-- affiliate js start-->
<script>
    val = $("input[name='affilate_event']:checked").val();
    if(val=='yes')
        $("#event_affilate_block").show();
    else
        $("#event_affilate_block").hide();
    
    $("input[name='affilate_event']").click(function(){
        val = $(this).val();
        if(val=='yes')
        {   
            paid_ticket = false;
            $("#ticketTable tr").each(function()
            {
                t_type = $(this).find('> td > select').val();           
                t_name = $(this).find('> td > input[type="text"]').val();
                t_price = $(this).find('> td > input.ticket_your_price');
                
                if(t_type == 'paid' && t_name != '' && t_price != ''){
                    paid_ticket = true;
                    return false;              
                }           
            });
            
            if(paid_ticket){                
                $("#event_affilate_block").show();
                $('label#error_event_mgmt').html('');
            }else{
                $(this).removeAttr('checked');
                $("#event_affilate_block").hide();
                $('label#error_event_mgmt').html('<?=$this->lang->line('error_event_mgmt')?>');
                //$(this).find('no').attr('checked','checked');    
            }
        }
        else{
            $("#event_affilate_block").hide();
            $('label#error_event_mgmt').html('');
        }
            
    });
</script>
<!-- affiliate js end-->

<!-- datetime js start-->
<script>
    $("input[name='date_time_detail']").val(""); //initialize
    $("input[name='event_repeats']").removeAttr('checked');
    $("input[name='event_repeats']").each(function(){
        if(this.checked == true)
            $("#date_type_div").show();
        else
            $("#date_type_div").hide();
    });

    $("input[name='event_repeats']").on('click',function(){
        if(this.checked == true)
            $("#date_type_div").show();
        else
            $("#date_type_div").hide();
    });

    $("select[name='date_type']").val('never');

    $("select[name='date_type']").change(function(){
        date_type = $(this).val();    
        $(".modal").modal('hide');
        if(date_type=="Never"){
            $("#date_time_response").html("");
            $("input[name='date_time_detail']").val("");        
            return false;
        }
        else    
            $("#"+date_type+"Modal").modal('show');        
    });
</script>
<!-- datetime js end-->

<!-- preview start -->
<script>
    function preview(){
        newwindow=window.open('<?= site_url('event/preview'); ?>','_blank','resizable=yes,height=600,width=800,scrollbars=1,scroll=yes');
        if (window.focus) {newwindow.focus()}
    }
</script>
<!-- preview end -->

<script>
function show_public()
{
    $('#hide_section_public').show();$('#hide_section_private').hide();
    $("input[name='op']").removeClass('required');
}

function show_private()
{
    $('#hide_section_public').hide();$('#hide_section_private').show();
    $("input[name='op']").addClass('required').attr('title',"<?=$this->lang->line('this_field_required');?>");
}
</script>
<script>
$(document).ready(function(){
    $('input[type="radio"],input[type="checkbox"]').removeAttr('checked');
    
    // Refresh the jQuery UI buttonset.                  
    //$('input[type="radio"],input[type="checkbox"]').buttonset('refresh'); 
});
</script>


<div align="center" class="error">
    <?php 
        if($this->session->flashdata('message')){
            echo "<div class='message'>".$this->session->flashdata('message')."</div>";
        }   
    ?>
</div>
<form method="post" enctype="multipart/form-data" action="" id="event_form" class="for_form box">
    <h1>Event Information &raquo; <span class="current_form">Location Information</span> &raquo; Organizer Information &raquo; Sponsor Information </h1>
    <fieldset class="for_inputs box_content">
        <div class="for_inputs"> 
            <div id="map"style="width: 100%; height: 300px;"></div>
            <ul>
                <li>                
                    <label>Google Map Location*</label>                
                    <p>
                    <input type="text" name="location" id="event_form_location" value="<?php echo set_value('location');?>" />
                    <?=form_error('location') ?>                    
                    </p>
                </li>
                <li>                
                    <label>Address*</label>                
                    <p>
                    <input type="text" name="physical_address" id="event_form_physical_address" value="<?php echo set_value('physical_address');?>" />
                    <?=form_error('physical_address') ?>                    
                    </p>
                </li>
            </ul>                   
        </div>        
    </fieldset>
    <fieldset>
        <br clear="all" />
        <p style="text-align: center; float: right;">
          <input type="submit" name="post_event" value="Add Location" class="submit" />
        </p>
    </fieldset>
</form>
<!--map-->
<script src="https://maps.google.com/maps/api/js?sensor=false&libraries=places" type="text/javascript"></script>
<!--script type="text/javascript" src="assets/map/google-map-api.js"></script-->
<script> 
    function initialize() {
      var mapOptions = {
        center: new google.maps.LatLng(-33.8688, 151.2195),
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };
      var map = new google.maps.Map(document.getElementById('map'), mapOptions);
 
      var input = document.getElementById('event_form_location');
      var autocomplete = new google.maps.places.Autocomplete(input);
 
      autocomplete.bindTo('bounds', map);
 
      var infowindow = new google.maps.InfoWindow();
      var marker = new google.maps.Marker({
        map: map
      });
 
      google.maps.event.addListener(autocomplete, 'place_changed', function() {
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
 
        infowindow.setContent('<div><b>' + place.name + '</b><br>' + address);
        infowindow.open(map, marker);
      });
 
      // Sets a listener on a radio button to change the filter type on Places
      // Autocomplete.
      var setupClickListener = function(id, types) {
        var radioButton = document.getElementById(id);
        google.maps.event.addDomListener(radioButton, 'click', function() {
          autocomplete.setTypes(types);
        });
      }
 
      setupClickListener('changetype-all', []);
      //setupClickListener('changetype-establishment', ['establishment']);
      //setupClickListener('changetype-geocode', ['geocode']);
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>
<!--map-->
<div class="row-fluid">
    <div class="span3">
        <ul class="nav nav-tabs nav-stacked">  
            <li class="active"><a href="#">Change Event Logo</a></li>     
            <li><a href="#">Change Category</a></li>
            <li><a href="#">Change Event Information</a></li>
            <li><a href="#">Change Location</a></li>   
            <li><a href="#">Change Organizer</a></li>
            <li><a href="#">Change Performer</a></li>   
        </ul>
    </div>
    <div class="span8">
    <div class="box">
        <form method="post" enctype="multipart/form-data" action="<?=site_url('event/change_event_logo/'.$data_event->id) ?>" id="event_form" class="for_form box">
            <h1>Change Event Logo</h1>
            
        </form>
    </div>
    </div>

</div>
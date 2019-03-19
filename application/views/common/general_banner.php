<?php 
//var_dump($main_event_types);
if($main_event_types){
    $cnn = 1;
?>    
<div class="jumbotron list-jumb">
    <div class="container container-32">
        <div>
            <?php foreach($main_event_types as $main_cat){ ?>            
            <div class="<?php echo ($cnn==3)? "col-md-4" : "col-md-2"; ?> col-sm-12">
                <div class="catagories list-thumb" style="height: 130px; overflow: hidden;">
                    <img src="<?php echo base_url(UPLOAD_FILE_PATH."category/".$main_cat['image']); ?>" alt="" class=""/>
                    <a href="<?php echo site_url("event?cat=".$main_cat['name']) ?>" class="overlay-pic">
                        <span><?php echo ucfirst($main_cat['name']) ?></span>
                    </a>
                </div>
            </div>
            <?php $cnn++; } ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<?php } ?>
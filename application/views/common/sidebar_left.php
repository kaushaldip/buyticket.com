<?php 
$current_url=$this->event_model->current_url();
$get=$_GET;
$add_url_l='';
$add_url_ci='';
$add_url_t='';
$add_url_c='';
$add_url_p='';
$add_url_g='';
$add_url_t1='';
$add_url_k='';
$p_price='';
$p_gender='';
$p_time='';
$p_cat='';
$p_type='';
$p_location='';
$p_city = '';

if(isset ($get['time'])){
    $add_url_t='&time='.$get['time'];
    $p_time=$get['time'];
}
if(isset ($get['price'])){
    $add_url_p='&price='.$get['price'];
    $p_price=$get['price'];
}
if(isset ($get['gender'])){
    $add_url_g='&gender='.$get['gender'];
    $p_gender=$get['gender'];
}
if(isset ($get['cat'])){
    $add_url_c='&cat='.$get['cat'];
      $p_cat=$get['cat'];
}
if(isset ($get['type'])){
    $add_url_t1='&type='.$get['type'];
     $p_type=$get['type'];
}
if(isset ($get['location'])){
    $add_url_l='&location='.$get['location'];
     $p_location=$get['location'];
}else{
    $add_url_l='&location=1';
}
if(isset($get['keywords'])){
    $add_url_k='&keywords='.$get['keywords'];
}
if(isset($get['city'])){
    $add_url_ci='&city='.$get['city'];
    $p_city = $get['city'];
}
?>

<div class="search-event-small left-search-one" >
    <h3 data-toggle="collapse" data-target="#collapseEventLocation" aria-expanded="false" aria-controls="collapseEventLocation"><?php echo $this->lang->line('event_location'); ?></h3>
    <div class="search_info <?php if(($p_city == '')) echo 'collapse'; ?> no-margin-bottom" id="collapseEventLocation">
    	<ul class="right_menu">
        	<li <?php if(($p_city=='1' || $p_city == '')) echo 'class="active_search"'; ?>>
                <?php if(!empty($p_city) || (!empty($p_location) && $p_location !='1')){?>
                <?/*
                <a href="<?=site_url("event?city=1"); ?><?=$add_url_l.$add_url_t.$add_url_c.$add_url_p.$add_url_t1.$add_url_g.$add_url_k ?>"><?php echo $this->lang->line('all'); ?></a>
                */?>
                <a href="<?=site_url("event?location=1"); ?><?=$add_url_t.$add_url_c.$add_url_p.$add_url_t1.$add_url_g.$add_url_k ?>"><?php echo $this->lang->line('show_all_cities'); ?></a>
                <?php }else{ ?>
                <a href="<?=site_url("event?location=1"); ?><?=$add_url_t.$add_url_c.$add_url_p.$add_url_t1.$add_url_g.$add_url_k ?>"><?php echo $this->lang->line('all'); ?></a>
                <?php } ?>                                                
            </li>                 
            <?php 
            if($event_location){
            foreach($event_location as $el):
                //echo $this->input->cookie(SESSION.'city_cookie');
                //if(empty($el->city)) continue;
                
            ?>    
                
                <?php if(!$this->general->city_has_active_event($el->city_en))
                    continue;?>                    
                    <li <?php if($p_city==$el->city_en ) echo 'class="active_search"'; ?>><a href="<?=site_url("event?city=$el->city_en"); ?><?=$add_url_l.$add_url_t.$add_url_c.$add_url_p.$add_url_t1.$add_url_g.$add_url_k ?>"><?=$el->city_en ?></a></li>
                
            <?php 
            endforeach; 
            }
            ?>
            <?php /*<li <?php if(($p_location=='1')) echo 'class="active_search"'; ?>></li>*/?>
        </ul>
    </div>
    <div class="clearfix"></div>
    <h3 data-toggle="collapse" data-target="#collapseEventDateRange" aria-expanded="false" aria-controls="collapseEventDateRange"><?php echo $this->lang->line('date_range'); ?></h3>
    <div class="search_info <?php if($p_time=='') echo 'collapse'; ?> no-margin-bottom" id="collapseEventDateRange">
    	<ul class="right_menu">
        	<li <?php if($p_time=='1' || $p_time=='') echo 'class="active_search"'; ?>><a href="<?=site_url('event?time=1'); ?><?=$add_url_p.$add_url_c.$add_url_t1.$add_url_l.$add_url_g.$add_url_k.$add_url_ci ?>"><?php echo $this->lang->line('all'); ?></a></li>
            <li <?php if($p_time=='today') echo 'class="active_search"'; ?>><a href="<?=site_url('event?time=today'); ?><?=$add_url_p.$add_url_c.$add_url_t1.$add_url_l.$add_url_g.$add_url_k.$add_url_ci ?>"><?php echo $this->lang->line('today'); ?></a></li>
            <li <?php if($p_time=='tomorrow') echo 'class="active_search"'; ?>><a href="<?=site_url('event?time=tomorrow'); ?><?=$add_url_p.$add_url_c.$add_url_t1.$add_url_l.$add_url_g.$add_url_k.$add_url_ci ?>"><?php echo $this->lang->line('tomorrow'); ?></a></li>
            <li <?php if($p_time=='week') echo 'class="active_search"'; ?>><a href="<?=site_url('event?time=week'); ?><?=$add_url_p.$add_url_c.$add_url_t1.$add_url_l.$add_url_g.$add_url_k.$add_url_ci ?>"><?php echo $this->lang->line('this_week'); ?></a></li>
            <li <?php if($p_time=='month') echo 'class="active_search"'; ?>><a href="<?=site_url('event?time=month'); ?><?=$add_url_p.$add_url_c.$add_url_t1.$add_url_l.$add_url_g.$add_url_k.$add_url_ci ?>"><?php echo $this->lang->line('this_month'); ?></a></li>
            <li <?php if($p_time=='months') echo 'class="active_search"'; ?>><a href="<?=site_url('event?time=months'); ?><?=$add_url_p.$add_url_c.$add_url_t1.$add_url_l.$add_url_g.$add_url_k.$add_url_ci ?>"><?php echo $this->lang->line('three_months'); ?></a></li>
        </ul>
    </div>

	<h3 data-toggle="collapse" data-target="#collapseEventPrice" aria-expanded="false" aria-controls="collapseEventPrice"><?php echo $this->lang->line('price'); ?></h2>
    <div class="search_info <?php if($p_price=='') echo 'collapse'; ?> no-margin-bottom" id="collapseEventPrice">
    	<ul class="right_menu">
        	<li <?php if($p_price=='1' || $p_price=='') echo 'class="active_search"'; ?>><a href="<?=site_url('event?price=1'); ?><?=$add_url_t.$add_url_c.$add_url_t1.$add_url_l.$add_url_g.$add_url_k.$add_url_ci ?>"><?php  echo $this->lang->line('all'); ?></a></li>
            <li <?php if($p_price=='paid') echo 'class="active_search"'; ?>><a href="<?=site_url('event?price=paid'); ?><?=$add_url_t.$add_url_c.$add_url_t1.$add_url_l.$add_url_g.$add_url_k.$add_url_ci ?>"><?php echo $this->lang->line('paid'); ?></a></li>
            <li <?php if($p_price=='free') echo 'class="active_search"'; ?>><a href="<?=site_url('event?price=free'); ?><?=$add_url_t.$add_url_c.$add_url_t1.$add_url_l.$add_url_g.$add_url_k.$add_url_ci ?>"><?php echo $this->lang->line('free'); ?></a></li>
           
        </ul>
    </div>

	<h3 data-toggle="collapse" data-target="#collapseEventGender" aria-expanded="false" aria-controls="collapseEventGender"><?php echo $this->lang->line('gender'); ?></h3>
    <div class="search_info <?php if($p_gender=='') echo 'collapse'; ?> no-margin-bottom" id="collapseEventGender">
    	<ul class="right_menu">
        	<li <?php if($p_gender=='1' || $p_gender=='') echo 'class="active_search"'; ?>><a href="<?=site_url('event?gender=1'); ?><?=$add_url_t.$add_url_c.$add_url_t1.$add_url_l.$add_url_p.$add_url_k.$add_url_ci ?>"><?php  echo $this->lang->line('all'); ?></a></li>
            <li <?php if($p_gender=='both') echo 'class="active_search"'; ?>><a href="<?=site_url('event?gender=both'); ?><?=$add_url_t.$add_url_c.$add_url_t1.$add_url_l.$add_url_p.$add_url_k.$add_url_ci ?>"><?php echo $this->lang->line('both'); ?></a></li>
            <li <?php if($p_gender=='male') echo 'class="active_search"'; ?>><a href="<?=site_url('event?gender=male'); ?><?=$add_url_t.$add_url_c.$add_url_t1.$add_url_l.$add_url_p.$add_url_k.$add_url_ci ?>"><?php echo $this->lang->line('male'); ?></a></li>
            <li <?php if($p_gender=='female') echo 'class="active_search"'; ?>><a href="<?=site_url('event?gender=female'); ?><?=$add_url_t.$add_url_c.$add_url_t1.$add_url_l.$add_url_p.$add_url_k.$add_url_ci ?>"><?php echo $this->lang->line('female'); ?></a></li>
           
        </ul>
    </div>

	<h3 data-toggle="collapse" data-target="#collapseEventCatalog" aria-expanded="false" aria-controls="collapseEventCatalog"><?php echo $this->lang->line('event_catalog'); ?></h3>
    <div class="search_info <?php if($p_cat=='') echo 'collapse'; ?> no-margin-bottom" id="collapseEventCatalog">
    	<ul class="right_menu">
        	<li <?php if($p_cat=='1' || $p_cat=='') echo 'class="active_search"'; ?>><a href="<?=site_url('event?cat=1'); ?><?=$add_url_t.$add_url_p.$add_url_t1.$add_url_l.$add_url_g.$add_url_k.$add_url_ci ?>"><?php echo $this->lang->line('all'); ?></a></li>
            <?php $event_catolog=$this->general->get_event_catalog();
            
            
            foreach($event_catolog as $ec):
            ?>
                <li <?php if($p_cat==$ec->name) echo 'class="active_search"'; ?>><a href="<?=site_url('event?cat='.urlencode($ec->name)); ?><?=$add_url_t.$add_url_p.$add_url_t1.$add_url_l.$add_url_g.$add_url_k.$add_url_ci ?>"><?=$ec->name ?></a></li>
                
           <?php endforeach; ?>
               
        </ul>
    </div>

	<h3 data-toggle="collapse" data-target="#collapseEventTypes" aria-expanded="false" aria-controls="collapseEventTypes"><?php echo $this->lang->line('event_types'); ?></h3>
    <div class="search_info <?php if($p_type=='') echo 'collapse'; ?> no-margin-bottom" id="collapseEventTypes">
    	<ul class="right_menu">
        	<li <?php if($p_type=='1' || !$p_type) echo 'class="active_search"'; ?>><a href="<?=site_url('event?type=1'); ?><?=$add_url_t.$add_url_c.$add_url_p.$add_url_l .$add_url_g.$add_url_k.$add_url_ci?>"><?php echo $this->lang->line('all'); ?></a></li>
            <?php $event_catolog=$this->general->get_event_sub_catalog();
            
            
            foreach($event_catolog as $ec):
            ?>
                <li <?php if($p_type==$ec->sub_type) echo 'class="active_search"'; ?>><a href="<?=site_url('event?type='.urlencode($ec->sub_type)); ?><?=$add_url_t.$add_url_c.$add_url_p.$add_url_l .$add_url_g.$add_url_k.$add_url_ci?>"><?=$ec->sub_type ?></a></li>
                
           <?php endforeach; ?>
        </ul>
    </div>
</div>
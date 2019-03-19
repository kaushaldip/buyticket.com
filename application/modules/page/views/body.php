<?php if($cms_slug!='refund-policy'){?>
<ul class="nav nav-tabs">
    <?php $all_cms =  $this->general->get_cms_lists();if($all_cms){for($i=0;$i<4;$i++){?>
    <li class="<?php if($nav==$all_cms[$i]->cms_slug) echo "active";?>">
        <a href="<?php echo site_url("/page/".$all_cms[$i]->cms_slug);?> ">
            <?php echo $all_cms[$i]->heading;?>
                       
        </a>
    </li>
    <?php }}?>
    <li><a href="<?php echo site_url('help/index');?>"><?php echo $this->lang->line('help'); ?></a></li>
    <li><a href="<?php echo site_url('home/contact');?>"><?php echo $this->lang->line('contact_us'); ?></a></li>
</ul>
<?php } ?>
<?php if($cms_slug=='pricing') {?>
    <div class="price_upper_box">
    	<div class="proce_upper_box_l">
    	<h1><?=$this->lang->line('organizing_free_event');?></h1>
        <p><?=$this->lang->line('there_no_cost_free');?></p>
        </div>
        <div class="proce_upper_box_r">
        	<img src="<?=MAIN_IMG_DIR_FULL_PATH?>tick.jpg"  />
            
            <?=$this->lang->line('alwayz_free')?>
        </div>
    </div>
    
    <div class="price_upper_box">
    	<div class="proce_upper_box_l">
    	<h1><?=$this->lang->line('collecting_money_for_event') ?></h1>
        <p><?=$this->lang->line('you_only_get_charged') ?></p>
        </div>
        <div class="proce_upper_box_r1">
        	<span><?=$this->lang->line('buyticket_service_fee') ?></span>
            <div>
            	<?=WEBSITE_FEE?>%<br />
                <span>+ <?=$this->general->price(WEBSITE_FEE_PRICE)?> <?=$this->lang->line('per ticket'); ?></span>
            </div>
        </div>
        <?php /*
        <i>+</i>
        <div class="proce_upper_box_r2">
        	<span>Credit Card Processing Fee</span>
            <div>0%
            </div>
        </div>
        */ ?>
    </div>
    
    <div class="how_fee">
    	<?php 
            if(isset($cms->heading))echo "<h5>".$cms->heading."</h5>";//heading 
            if(isset($cms->content)):
                echo "<div>";
                if($cms->id==23){    
                    $parseValue=WEBSITE_FEE.'%&nbsp;+&nbsp;$'.WEBSITE_FEE_PRICE;
                    $content=$cms->content;
                    echo str_replace("[SERVICEFEE]",$parseValue,$content);
                }else {
                    echo $cms->content;
                }
                echo "</div>";
            endif;
        ?>
    </div>
<?php }else{ ?>
    <?php 
        if(isset($cms->heading))echo "<h1>".$cms->heading."</h1>";//heading 
        if(isset($cms->content)):
            echo "<div>";
            if($cms->id==23){    
                $parseValue=WEBSITE_FEE.'%&nbsp;+&nbsp;$'.WEBSITE_FEE_PRICE;
                $content=$cms->content;
                echo str_replace("[SERVICEFEE]",$parseValue,$content);
            }else {
                echo $cms->content;
            }
            echo "</div>";
        endif;
    ?>    
<?php } ?>



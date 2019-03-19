<div class="jumbotron post-event2">
    <div class="container">
    	<!-- Example row of columns -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="title center"><span><?php echo $this->lang->line('features'); ?></span></h1>
                 <?php 
                 $all_how_cms =  $this->general->get_how_lists_affiliate();
                 if($all_how_cms){
                     for($i=0;$i<3;$i++){                   
                        $text=strip_tags($all_how_cms[$i]->content);
                        if($text){
                            $length = 310;
                            if(strlen($text)<$length+10){ 
                                $cont=strip_tags($text);
                
                            }//don't cut if too short
                            else {
                                $break_pos = strpos($text, ' ', $length);//find next space after desired length
                                $visible = substr($text, 0, $break_pos);        
                                $cont=$visible;
                            }
                        } 
                        if($i==0){ ?>
                        <div class="col-md-4 how_each center">
                        	<img src="<?=MAIN_IMAGES_DIR_FULL_PATH ?>home/one.png" />
                            <h2><?= $all_how_cms[$i]->heading; ?></h2>
                           
                            <p><?=$cont ?></p>
                            <!--
                    		<a class="read_more" href="<?php echo site_url("/page/".$all_how_cms[$i]->cms_slug);?>"><?php echo $this->lang->line('read_more'); ?>...</a>
                    		-->
                        </div>
                        <?php } elseif($i==1){ ?>        
                        <div class="col-md-4 how_each center">
                        	<img src="<?=MAIN_IMAGES_DIR_FULL_PATH ?>home/two.png" />
                            <h2><?= $all_how_cms[$i]->heading; ?></h2>
                            <p><?=$cont ?></p>
                    		<!--
                            <a class="read_more" href="<?php echo site_url("/page/".$all_how_cms[$i]->cms_slug);?>"><?php echo $this->lang->line('read_more'); ?>...</a>
                    	   	-->
                        </div>
                        <?php } else { ?>     
                        <div class="col-md-4 how_each center last_right">
                        	<img src="<?=MAIN_IMAGES_DIR_FULL_PATH ?>home/three.png" />
                            <h2><?= $all_how_cms[$i]->heading; ?></h2>
                            <p><?=$cont ?></p>
                    		<!--
                            <a class="read_more" href="<?php echo site_url("/page/".$all_how_cms[$i]->cms_slug);?>"><?php echo $this->lang->line('read_more'); ?>...</a>
                    		-->
                        </div>
                        <?php 
                        } 
                    } 
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="center container">
	<h2 class="title-post"><?=$this->lang->line('market_event_make_money') ?></h2>
	<p><?=$this->lang->line('join_event_affiliate') ?></p>
	<a href="<?=site_url("affiliate/event_list") ?>" class="get-started"><?php echo $this->lang->line('join_event_affiliate_program'); ?></a>
</div>

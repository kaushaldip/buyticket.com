<div class="container header" >
    <div class="head">
        <div class="col-md-2 col-sm-12">
            <a href="<?php echo site_url(""); ?>"><img src="<?php echo MAIN_IMAGES_DIR_FULL_PATH; ?>logo.png" alt="buy-tickat" class="img-responsive"/></a>
            <a id="nav-toggle1" class="mm_open visible-md visible-sm visible-xs"><span></span><span class="spanfix">Catagories</span></a>
        </div>
        <div class="col-md-7 col-sm-12 col-xs-12 pull-right">
            <a href="<?php echo site_url("event/create"); ?>" class="head-btn btn-red no-margin-left"><i class="fa fa-pencil"></i><?php echo $this->lang->line('create_event'); ?></a>
            <a href="<?php echo site_url("event/index"); ?>" class="head-btn btn-blue no-margin-left"><i class="fa fa-search"></i><?php echo $this->lang->line('find_event'); ?></a>
            <? if (!$this->session->userdata(SESSION.'user_id')) { ?>
                <a href="<?php echo site_url("login"); ?>" class="head-btn btn-trans no-margin-left"><i class="fa fa-sign-in"></i>sign in</a>
                
            <?php } else{ ?>    
                <div class="dropdown inline_block ">
                  <button class="head-btn btn-trans btn dropdown-toggle account_button" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                    <i class="fa fa-user"></i>
                    <?php echo "Account"; ?>
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('users/account');?>" class=""><?php echo strtoupper($this->session->userdata(SESSION.'email')); ?></a></a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('myticket');?>" class=""><?php echo strtoupper($this->lang->line('my_tickets')); ?></a></a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('users/logout');?>" class=""><?php echo strtoupper($this->lang->line('logout')); ?></a></a></li>
                  </ul>
                </div>                
                                
            <?php } ?>
            
            
                        
            <a id="nav-toggle" class="mm_open hidden-md hidden-sm hidden-xs"><span></span><span class="spanfix">Catagories</span></a>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="panel">
    <div class="container">
        <?php
        $event_types_arr = ($event_types)? $event_types : $this->general->get_event_type_lists();
        if($event_types_arr){
            echo '<div class="col-md-3 col-sm-6 col-xs-12">
                    <ul>';
            $prev_main_type = "";
            $i = 1;
            foreach($event_types_arr as $event_type){ 
                if($event_type['name'] != $prev_main_type){
                    if(!empty($prev_main_type)){
                        echo '</ul>
                            </div>';                  
                        echo '<div class="col-md-3 col-sm-6 col-xs-12">
                            <ul>';
                    }             
                          
                    
                ?>
                    <li class="nav-item bold-nav"><a href="<?php echo site_url("event?cat=".$event_type['name']) ?>"><?php echo ucwords($event_type['name']) ?></a></li>
                <?php
                }
                ?>
                <li class="nav-item"><a href="<?php echo site_url("event?type=".$event_type['sub_type']) ?>"><?php echo ucwords($event_type['sub_type']) ?></a></li>
            <?php
                $prev_main_type = $event_type['name'];
                $i++;
            }
            echo '</ul>
                </div>'; 
            
        }
        ?>
    </div>
</div>
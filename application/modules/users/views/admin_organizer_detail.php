<style>
.admin_orgnizer_detail ul{list-style: none;}
.admin_orgnizer_detail ul li label{width: 200px; float: left;margin-right: 10px; background: silver; padding: 5px 8px;}
.admin_orgnizer_detail ul li p{width: auto;  float: left;}
.admin_orgnizer_detail ul li {display: block; clear: both; }
</style>
<div class="box_content admin_orgnizer_detail">
    <h3>Organizer Detail:</h3>
    <h5>Email: <?=$organizer->email;?></h5>
    <ul class="for_info">        
        <li>
            <label><?php echo $this->lang->line('organizer_name'); ?></label>
            <p>
                <?php echo ($organizer)? $organizer->organizer_name: "";?>                
            </p>
        </li>
        <li>
            <label><?php echo $this->lang->line('contact_number'); ?></label>
            <p>
                <?php echo ($organizer)? $organizer->organizer_home_number ." (Res)": "";?>
                <?php echo ($organizer)? $organizer->organizer_office_number." (Mobile)": "";?>
            </p>
        </li>
        <li>
            <label><?php echo $this->lang->line('upload_official_doc'); ?></label>
            <p>
                <?php if(!empty($organizer->organizer_official_doc)){?>
                <span id="official_download_linker">
                    <a href="<?=site_url(ADMIN_DASHBOARD_PATH.'/users/organizer_document/'.$organizer_id)?>"><?=$organizer->organizer_official_doc; ?></a>  
                </span>
                <?php }else{ ?>
                    No file upload.
                <?php } ?>                                    
            </p>
        </li>            
        <li>
            <label><?php echo $this->lang->line('organizer_detail'); ?></label>                
            <p><?php print_r($organizer->organizer_description);?></p>
        </li>            
    </ul>
</div>
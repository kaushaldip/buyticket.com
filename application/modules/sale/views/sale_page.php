<script type="text/javascript">
function doconfirm()
{
	job=confirm("Are you sure to delete permanently?");
	if(job!=true)
	{
		return false;
	}
}
</script>
    <div style="padding:6px 20px; float:left; width:610px; background:#202020; color:#ABABAB;">
        <span class="breed"><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; Sale  Management </span>
    </div>
    <div style="padding:3px 20px; float:right; width:80px; background:#202020; color:#ABABAB; line-height:18px;">
        <a href="javascript:history.go(-1)" style="text-decoration:none;">
            <img src="<?php print(ADMIN_IMG_DIR_FULL_PATH);?>/back.gif" width="18" height="18" alt="back" style="padding:0; margin:0; width:18px; height:18px;" align="right" />
        </a>
        <span class="breed"><a href="javascript:history.go(-1)"> go Back</a></span>
    </div>
    <h2>View Sale Details </h2>
    <div class="mid_frm">
    
        <div style="background:#FFFFFF; border:1px dashed #333333; padding:10px 5px; margin:10px 0 20px 0;">
        
            <ul id="vList">
            <?php if($this->uri->segment(3)) $catid = $this->uri->segment(3); else $catid = '1';?> 
            <?php
                if($category_result){
                    foreach($category_result as $category){
                    ?>
                      
                        <li>[ <?php if($catid!=$category->id){ echo anchor(ADMIN_DASHBOARD_PATH."/sale/index/$category->id", "$category->name", "title='$category->name'");} else { echo $category->name;}?> ]</li>
                    <?php          
                    }
                } 
            ?>
               
            </ul>	  
            <div style="clear:both"></div>
        </div>        
        <div style="color:#CC0000; width:610px; margin-left:0px; font-weight:bold;" align="center">
            <?php if($this->session->flashdata('message')){
                echo "<div class='message'>".$this->session->flashdata('message')."</div>";
            }
            ?>
        </div>

        <table width="100%" border="0" cellspacing="0" cellpadding="4" class="contentbl">
            <tr> 
                <th align="left" width="200px"><div align="center">Album</div></th>
                <th align="center"><div align="center">Bought By</div></th>                                
                <th align="center"><div align="center">Cost <small>(credits)</small></div></th>
                <th align="center"><div align="center">Bought On</div></th>
                <th colspan="2" align="center" style="border-right:none;"><div align="center">Options</div></th>
            </tr>
        	<?php 
        	if($this->uri->segment(3)) $catid = $this->uri->segment(3); else $catid = '1';        	
            if($result_data)
        	{
        	   foreach($result_data as $data)
        	   {
            	?>
                <tr> 
                    <td align="left">
                        <div align="left" style="float: left;">
                            <img src="<?php echo site_url($data->album_image);?>" height="80" width="80" />
                        </div>
                        <div align="right">
                            <h2><?php echo $data->album_name; ?><br /></h2>
                            <?php echo  $data->popular_song_name; ?> <br />
                            <em><?php echo  $data->artist_name; ?> <br /></em>
                        </div>
                    </td>
                    <td align="left"><div align="center"><strong><?php echo ucwords($data->title." ".$data->first_name." ".$data->last_name);?></strong><br /><?php echo $data->user_name;?> </div></td>
                    <td align="left"><div align="center"><?php echo ($data->buy_cost==0)? "(FREE)" :$data->buy_cost; ?></div></td>
                    <td align="left"><div align="center"><?php print $this->general->date_formate($data->date);?></div></td>
                    <td colspan="2" align="center" style="border-right:none;">
                        <a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/winners/voters/<?php print($data->id);?>">Voted Users</a>
                    </td>
                    
                </tr>
                <?php
              	}
            	if($this->pagination->create_links())
            	{
                ?>
                <tr> 
                    <td colspan="7" align="center" style="border-right:none;" class="paging"><?php echo $this->pagination->create_links();?></td>
                </tr>
                <?php
              	}
        	}
            else
        	{
            ?>
                <tr> 
                    <td colspan="7" align="center" style="border-right:none;"> (0) Zero Record Found </td>
                </tr>
            <?php
          	}
            ?>
        </table>
    </div>
    <div class="clear"></div>
</div>
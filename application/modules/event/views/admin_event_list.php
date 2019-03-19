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

<div class="breadcum">
    <div class="breadcum_inside">
        <a href="<?=	site_url(ADMIN_DASHBOARD_PATH)?>">Dashboard</a> &raquo; Event Management
        <a class="back_button" href="javascript:history.go(-1)" style="text-decoration:none;">
        <img src="<?php	print(ADMIN_CSS_DIR_FULL_PATH);?>css/icons/24/bended-arrow-left.png" width="24" height="24" alt="back" align="right" title="Go Back" />
        </a> 
    </div>   
</div>
 
<div class="mws-panel grid_8 mws-collapsible">
	<div class="mws-panel-header">         
    	<span class="mws-i-24 i-table-1">Event Lists</span>  
        <div class="mws-collapse-button mws-inset"><span></span></div>      
    </div>
    <div class="mws-panel-body">
        <div class="mws-panel-toolbar top clearfix">
        	<ul>
            	<li><a class="mws-ic-16 ic-direction" href="<?=site_url(ADMIN_DASHBOARD_PATH).'/event/index/1'; ?>" >Public : <strong id="event_active_number"><?php echo $total_public_events ?></strong></a></li>
                <li><a class="mws-ic-16 ic-direction" href="<?=site_url(ADMIN_DASHBOARD_PATH).'/event/index/2'; ?>" >Private : <strong id="event_active_number"><?php echo $total_private_events ?></strong></a></li>
                <li><a class="mws-ic-16 ic-direction" href="<?=site_url(ADMIN_DASHBOARD_PATH).'/event/index'; ?>" >Total Events : <strong><?php echo $total_events ?></strong></a></li>            	
            </ul>
        </div>
        <table class="mws-datatable mws-table admin_event_list">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name / Title</th>
                    <th>Organizer</th>
                    <th>Max tickets</th>                    
                    <th>Created Date</th>
                    <th>Updated Date</th>
                    <th>Targeted Gender</th>    
                    <th>Type</th>
                    <th>Publish</th>                
                </tr>
            </thead>
            <tbody>
            <?php 
            if($events)
            {
                foreach($events as $event)
                {
                ?>
                <tr class="gradeU">
                    <td align="left"><?php print($event->id);?></td>
                    <td align="left">
                        <a href="<?=site_url(ADMIN_DASHBOARD_PATH.'/event/view/'.$event->id);?>" target="_blank">
                        <strong><?php print($event->name);?></strong>
                        <br/>
                        <em><?=ucwords($event->title);?></em>
                        </a>
                    </td>
                    <td>
                    <a href="<?=site_url(ADMIN_DASHBOARD_PATH.'/users/view/'.$event->userid);?>">
                        <?=$event->email;?>
                    </a>
                    </td>
                    <td><?php print($event->visit_count); ?></td>                                   
                    <td align="left"><div align="center"><?php print($this->general->date_time_formate($event->created_date));?></div></td>
                    <td align="left"><div align="center"><?php print($this->general->date_time_formate($event->updated_date));?></div></td>
                    <td><?php print($event->target_gender=='B')? "Male & Female" :(($event->target_gender=='M')? "Male only": "Female only") ; ?></td>
                    <td align="center">                        
                        <span id="event_status<?=$event->id; ?>">
                        <?php 
                            $status = "<font color='green'>PUBLIC</font>";
                            if($event->status=='0')
                                $status = "<font color='red'>CLOSED</font>";
                            else if ($event->status=='2')
                                $status = "<font color='#A98B15'>PRIVATE</font>";
                            print($status); 
                        ?>           
                        </span>
                        <select onchange="change_event_status('<?php echo site_url(ADMIN_DASHBOARD_PATH);?>','<?php echo site_url();?>','<?=$event->id; ?>',this.value);">
                            <option>Change...</option>
                            <option value="1">PUBLIC</option>
                            <option value="2">PRIVATE</option>
                            <option value="0">CLOSE</option>                            
                        </select>
                    </td>
                    <td align="center">
                        <span id="event_publish<?=$event->id; ?>">
                        <?=($event->publish == '1')? "<font color='green'>PUBLISHED</font>" :(($event->publish == '0')? "<font color='#A98B15'>NOT PUBLISHED</font>" : "<font color='red'>CLOSED</font>") ; ?>
                        <br />
                        </span>
                        <select onchange="change_event_publish('<?php echo site_url(ADMIN_DASHBOARD_PATH);?>','<?php echo site_url();?>','<?=$event->id; ?>',this.value);">
                            <option>Change...</option>
                            <option value="1">PUBLISH</option>
                            <option value="0">UNPUBLISH</option>
                            <option value="2">CLOSE</option>                          
                        </select>
                    </td>
                </tr>
            <?php
            	}            	
            }            
            ?>
            </tbody>
        </table>
    </div>
</div>

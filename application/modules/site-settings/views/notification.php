<style>
ul.mws-summary li span.little{font-size:12px; width: 180px !important; white-space: normal; padding: 6px 0;}
ul.mws-summary li a{text-decoration: none;}
ul.mws-summary li a.unread{color: #FF8000;}
ul.mws-summary li a.read{color:#000;}

</style>
<div class="breadcum clearfix">
    <div class="breadcum_inside">
        <a href="<?=site_url(ADMIN_DASHBOARD_PATH);?>">Dashboard</a>
        &raquo; Notifications         
    </div>
    <?php if($this->session->flashdata('error')){
		echo "<div class='mws-form-message error' style='border: 1px solid;'>".$this->session->flashdata('error')."</div>";
		}
    ?>   
</div>
<br class="clear" />
<div class="mws-panel grid_10 mws-collapsible">
    <div class="mws-panel-header">
    	<span class="mws-i-24 i-books-2">Notifications</span>
        <div class="mws-collapse-button mws-inset"><span></span></div>
    </div>
    <div class="mws-panel-body">
        <ul class="mws-summary">
        <?php
        $notification = $this->general->get_notification(10);
        if($notification){
            foreach($notification as $n){
            ?>
            <li id="notification_<?=$n->id?>">
                <span class="little"><?=date('g:i a, j F, Y ', strtotime($n->date))?></span> 
                <a class="<?=($n->read=='yes')? 'read': 'unread'; ?>" href="#" onclick="change_to_read('<?=$n->id?>','<?=site_url(ADMIN_DASHBOARD_PATH).'/'.$n->link;?>')" ><?=$n->notification;?></a> 
                <span style="color: #990000; font-size: small; font-style: italic; cursor: pointer;" onclick="delete_notification('<?=$n->id?>');">Delete</span>               
             </li>
            <?php 
            }
        }else{
        ?>
            <li>
                <span class="little">No notifications</span>
            </li>
        <?php
        }
        ?>
        </ul>
    </div>
</div>
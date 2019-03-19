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
<div style="padding:6px 20px; float:left; width:610px; background:#202020; color:#ABABAB;"><span class="breed"><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo; <?php echo $this->lang->line('members_management'); ?></span></div>
    <div style="padding:3px 20px; float:right; width:80px; background:#202020; color:#ABABAB; line-height:18px;">
    <a href="javascript:history.go(-1)" style="text-decoration:none;">
    <img src="<?php print(ADMIN_IMG_DIR_FULL_PATH);?>/back.gif" width="18" height="18" alt="back" style="padding:0; margin:0; width:18px; height:18px;" align="right" />
    </a><span class="breed"><a href="javascript:history.go(-1)"> <?php echo $this->lang->line('go_back'); ?></a></span></div>
	<h2><?php echo $this->lang->line('view_memebers_details'); ?></h2>
    <div class="mid_frm">
    
      <div style="background:#FFFFFF; border:1px dashed #333333; padding:10px 5px; margin:10px 0 20px 0;">
	  <?php if($this->uri->segment(3)) $status = $this->uri->segment(3); else $status = 'active';?>
      <ul id="vList">
		   <li>[ <?php if($status!='active'){ echo anchor(ADMIN_DASHBOARD_PATH.'/members/index/active', 'Active Members', 'title="Active Members"');} else { echo "Active Members";}?> ]</li>
		  
		  <li>[ <?php if($status!='inactive'){ echo anchor(ADMIN_DASHBOARD_PATH.'/members/index/inactive', 'Inactive Members', 'title="Inactive Members"');} else { echo "Inactive Members";}?> ]</li>
		  
		   <li>[ <?php if($status!='close'){ echo anchor(ADMIN_DASHBOARD_PATH.'/members/index/close', 'Closed Members', 'title="Closed Members"');} else { echo "Closed Members";}?> ]</li>
		   
		    <li>[ <?php if($status!='suspended'){ echo anchor(ADMIN_DASHBOARD_PATH.'/members/index/suspended', 'Suspended Members', 'title="Suspended Members"');} else { echo "Suspended Members";}?> ]</li>
	</ul>	  
		 <div style="clear:both"></div>
</div>
<div style="background:#FFFFFF; border:1px dashed #333333; padding:10px 5px; margin-bottom:10px;">
  <form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="220"><strong><?php echo $this->lang->line('search_name_username_email'); ?>: </strong></td>
    <td width="202"><input name="srch" type="text" id="srch" size="30" /></td>
    <td><input type="submit" name="Submit" value="Search Member" /></td>
  </tr>
</table>
  </form>
</div>    

     <div style="color:#CC0000; width:610px; margin-left:0px; font-weight:bold;" align="center">
<?php if($this->session->flashdata('message')){
		echo "<div class='message'>".$this->session->flashdata('message')."</div>";
		}
	?></div>

<table width="100%" border="0" cellspacing="0" cellpadding="4" class="contentbl">
  <tr> 
  <th align="left"><div align="left"><?php echo $this->lang->line('name'); ?></div></th>
    <th align="left"><div align="left"><?php echo $this->lang->line('username'); ?></div></th>
    <th align="center"><div align="left"><?php echo $this->lang->line('email'); ?></div></th>
    <th align="center"><div align="left"><?php echo $this->lang->line('reg_date'); ?></div></th>
   
    <th align="center"><div align="center"><?php echo $this->lang->line('balance'); ?></div></th>
    
    <th colspan="2" align="center" style="border-right:none;"><div align="center"><?php echo $this->lang->line('options'); ?></div></th>
    </tr>
	<?php 
			if($this->uri->segment(3)) $status = $this->uri->segment(3); else $status = 'active';
			
			if($result_data)
			{
				foreach($result_data as $data)
				{
	?>
  <tr> 
    <td align="left"><div align="left"><?php print($data->first_name.' '.$data->last_name);?></div></td>
    <td align="left"><div align="left"><?php print($data->user_name);?></div></td>
    <td align="left"><div align="left"><?php print($data->email);?></div></td>
    <td align="left"><div align="left"><?php print($this->general->date_time_formate($data->reg_date));?></div></td>
    <td align="left"><div align="center"><?php print($data->balance);?></div></td>
    <td colspan="2" align="center" style="border-right:none;">
	<a href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/members/edit_member/<?php print($status);?>/<?php print($data->id);?>" style="margin-right:5px;">
      <img src='<?php print(ADMIN_IMG_DIR_FULL_PATH);?>/edit.gif' title="Edit"></a>   <a  style="margin-left:5px;" href="<?php echo site_url(ADMIN_DASHBOARD_PATH);?>/members/delete_member/<?php print($status);?>/<?php print($data->id);?>">
      <img  src='<?php print(ADMIN_IMG_DIR_FULL_PATH);?>/delete.gif' title="Delete" onClick="return doconfirm();" ></a> 
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
    <td colspan="7" align="center" style="border-right:none;"><?php echo $this->lang->line('zero_record_found'); ?> </td>
    </tr>
  <?php
  			}
  ?>
</table>
</div>
    <div class="clear"></div>
</div>

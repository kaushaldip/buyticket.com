<div class="content">
    
    <div style="padding:6px 20px; float:left; width:610px; background:#202020; color:#ABABAB;"><span class="breed"><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo;  Language  Management </span></div>
    <div style="padding:3px 20px; float:right; width:80px; background:#202020; color:#ABABAB; line-height:18px;">
    <a href="javascript:history.go(-1)" style="text-decoration:none;">
    <img src="<?php print(ADMIN_IMG_DIR_FULL_PATH);?>/back.gif" width="18" height="18" alt="back" style="padding:0; margin:0; width:18px; height:18px;" align="right" />
    </a><span class="breed"><a href="javascript:history.go(-1)"> go Back</a></span></div>
	<h2><?php echo $jobs;?> Language Settings </h2>
    <div class="mid_frm">

    
<?php
//print_r($site_set);
?>
<form name="sitesetting" method="post" action=""  enctype="multipart/form-data">

<table width=90% align=center border=0 cellspacing=4 cellpadding=2 class="light">

<tr>
  <td width="229" valign="top" class="hmenu_font">Winner Name </td>
  <td width="429"><input name="winner_name" type="text" class="inputtext" id="winner_name" value="<?php echo set_value('winner_name',$data->winner_name);?>" size="30" />
      <?=form_error('winner_name')?></td>
  </tr>
<tr>
  <td valign="top" class="hmenu_font">Product Name </td>
  <td><input name="product_name" type="text" class="inputtext" id="product_name" value="<?php echo set_value('product_name',$data->product_name);?>" size="30" />
    <?=form_error('product_name')?></td>
</tr>
<tr>
<td width=229 class="hmenu_font">Language Flag </td>
<td width="429">
<input name="img" type="file" id="img" />(Size 16px X 11px)
  <?=$this->upload->display_errors('<div class="error">', '</div>');?>
<input type="hidden" name="img_old" value="<?php echo $data->image;?>" />  </td>
</tr>
<tr>
  <td valign="top" class="hmenu_font">Description</td>
  <td><textarea name="description" cols="40" rows="4" class="inputtext" id="description"><?php echo set_value('description',$data->description);?></textarea>
    <?=form_error('description')?></td>
</tr>

<tr height="30">
  <td>&nbsp;</td>
  <td colspan="2"><input class="bttn" type="submit" name="Submit" value="Update" /></td>
</tr>
</table>
</form>

 </div>
    <div class="clear"></div>
</div>



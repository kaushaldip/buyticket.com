<?php error_reporting(0);?>
<div class="content">
    
    <div style="padding:6px 20px; float:left; width:610px; background:#202020; color:#ABABAB;"><span class="breed"><a href="<?=site_url(ADMIN_DASHBOARD_PATH)?>">ADMIN</a> &raquo;  <a href="<?=site_url(ADMIN_DASHBOARD_PATH).'/members/index'?>"><?php echo $this->lang->line('members_management'); ?></a></span></div>
    <div style="padding:3px 20px; float:right; width:80px; background:#202020; color:#ABABAB; line-height:18px;">
    <a href="javascript:history.go(-1)" style="text-decoration:none;">
    <img src="<?php print(ADMIN_IMG_DIR_FULL_PATH);?>/back.gif" width="18" height="18" alt="back" style="padding:0; margin:0; width:18px; height:18px;" align="right" />
    </a><span class="breed"><a href="javascript:history.go(-1)"><?php echo $this->lang->line('go_back'); ?> </a></span></div>
	<h2><?php echo $this->lang->line('edit_member'); ?> </h2>
	
    <div class="mid_frm">

    
<form name="member" method="post" action=""  enctype="multipart/form-data">
<input name="user_id" type="hidden" class="inputtext" id="user_id" value="<?php echo $profile->id;?>" size="15" />
<table width=100% align=center border=0 cellspacing=4 cellpadding=2 class="light">


<tr>
  <td colspan="2" bgcolor="#FFFFFF"><div style=" background-color:#FFFFFF; padding:5px 10px;"><strong><?php echo $this->lang->line('personal_detail'); ?></strong></div></td>
  </tr>
<tr>
  <td width="229" class="hmenu_font"><?php echo $this->lang->line('title'); ?></td>
  <td width="429"><select name="title" class="reg-sel">
  <option <?php if('Mr' == $profile->title)echo 'selected="selected"'; ?>><?php echo $this->lang->line('mr'); ?></option>
  <option <?php if('Mrs' == $profile->title)echo 'selected="selected"'; ?>><?php echo $this->lang->line('mrs'); ?></option>
  <option <?php if('Miss' == $profile->title)echo 'selected="selected"'; ?>><?php echo $this->lang->line('miss'); ?></option>
</select></td>
  </tr>
<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('first_name'); ?></td>
  <td><input name="first_name" type="text" class="inputtext" id="first_name" value="<?php echo set_value('first_name',$profile->first_name);?>" size="15" />
    <?=form_error('first_name')?></td>
</tr>
<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('last_name'); ?></td>
  <td><input name="last_name" type="text" class="inputtext" id="last_name" value="<?php echo set_value('last_name',$profile->last_name);?>" size="15" />
    <?=form_error('last_name')?></td>
</tr>
<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('email'); ?></td>
  <td><input name="email" type="text" class="inputtext" id="email" value="<?php echo set_value('email',$profile->email);?>" size="30" />
    <?=form_error('email')?></td>
</tr>
<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('user_name'); ?>User Name </td>
  <td height="20"><?php echo $profile->user_name;?></td>
</tr>

<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('balance'); ?></td>
  <td height="20"><?php echo $profile->balance;?> Credits </td>
</tr>
<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('registered_date'); ?></td>
  <td height="20"><?php echo $this->general->date_time_formate($profile->reg_date);?></td>
</tr>
<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('last_login_date'); ?> </td>
  <td height="20"><?php echo $this->general->date_time_formate($profile->last_login_date);?></td>
</tr>


<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('registered_ip'); ?></td>
  <td height="20"><?php echo $profile->reg_ip_address;?></td>
</tr>
<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('last_login_ip'); ?> </td>
  <td height="20"><?php echo $profile->last_ip_address;?></td>
</tr>
<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('status'); ?></td>
  <td height="20">
  <input name="status" type="radio" value="active" checked="checked" />
   <?php echo $this->lang->line('active'); ?>
      <input name="status" type="radio" value="inactive" <?php if($profile->status == 'inactive'){ echo 'checked="checked"';}?> />
      <?php echo $this->lang->line('inactive'); ?>
	  <input name="status" type="radio" value="suspended" <?php if($profile->status == 'suspended'){ echo 'checked="checked"';}?> />
	  <?php echo $this->lang->line('suspended'); ?>
	  <input name="status" type="radio" value="close" <?php if($profile->status == 'close'){ echo 'checked="checked"';}?> />
	   <?php echo $this->lang->line('close'); ?></td>
</tr>
<tr>
  <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
</tr>
<tr>
  <td colspan="2" bgcolor="#FFFFFF"><div style=" background-color:#FFFFFF; padding:5px 10px;"><strong><?php echo $this->lang->line('billing_address'); ?></strong></div></td>
  </tr>
<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('address').$this->lang->line('1'); ?></td>
  <td><input name="address" type="text" class="inputtext" id="address" value="<?php echo set_value('address',$profile->address);?>" size="25" />
    <?=form_error('address')?></td>
</tr>
<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('address').$this->lang->line('2'); ?></td>
  <td><input name="address2" type="text" class="inputtext" id="address2" value="<?php echo set_value('address2',$profile->address2);?>" size="25" />
    <?=form_error('address2')?></td>
</tr>
<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('country'); ?></td>
  <td>
  <select name="country" class="reg-sel-country" id="country">

  <option value=""><?php echo $this->lang->line('select').$this->lang->line('country'); ?></option>
  <?php foreach($this->general->get_country() as $country){?>
  <option value="<?php echo $country->id;?>" <?php if($country->id == $profile->country)echo 'selected="selected"'; ?>  ><?php echo $country->country;?></option>
  <?php } ?>
</select>  </td>
</tr>
<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('city'); ?></td>
  <td><input name="city" type="text" class="inputtext" id="city" value="<?php echo set_value('city',$profile->city);?>" size="25" />
    <?=form_error('city')?></td>
</tr>

<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('postcode'); ?></td>
  <td><input name="post_code" type="text" class="inputtext" id="post_code" value="<?php echo set_value('post_code',$profile->post_code);?>" size="25" />
    <?=form_error('post_code')?></td>
</tr>
<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('phone'); ?></td>
  <td><input name="phone" type="text" class="inputtext" id="phone" value="<?php echo set_value('phone',$profile->phone);?>" size="25" />
    <?=form_error('phone')?></td>
</tr>
<tr>
  <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
</tr>
<tr>
  <td colspan="2" bgcolor="#FFFFFF"><div style=" background-color:#FFFFFF; padding:5px 10px;"><strong><?php echo $this->lang->line('shipping_address'); ?> </strong></div></td>
  </tr>
<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('name'); ?></td>
  <td>
  <input name="ship_id" type="hidden" class="inputtext" id="name" value="<?php echo $ship_addr->id;?>" size="25" />
  <input name="name" type="text" class="inputtext" id="name" value="<?php echo set_value('name',$ship_addr->name);?>" size="25" />
    <?=form_error('name')?></td>
</tr>
<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('address').$this->lang->line('1'); ?></td>
  <td><input name="ship_address" type="text" class="inputtext" id="ship_address" value="<?php echo set_value('ship_address',$ship_addr->address);?>" size="25" />
    <?=form_error('ship_address')?></td>
</tr>
<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('address').$this->lang->line('2'); ?></td>
  <td><input name="ship_address2" type="text" class="inputtext" id="ship_address2" value="<?php echo set_value('ship_address2',$ship_addr->address2);?>" size="25" />
    <?=form_error('ship_address2')?></td>
</tr>
<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('country'); ?></td>
  <td>
  <select name="ship_country" class="reg-sel-country" id="country">

  <option value=""><?php echo $this->lang->line('select').$this->lang->line('country'); ?></option>
  <?php foreach($this->general->get_country() as $country){?>
  <option value="<?php echo $country->id;?>" <?php if($country->id == $ship_addr->country_id)echo 'selected="selected"'; ?>  ><?php echo $country->country;?></option>
  <?php } ?>
</select>  </td>
</tr>
<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('city'); ?></td>
  <td><input name="ship_city" type="text" class="inputtext" id="ship_city" value="<?php echo set_value('ship_city',$ship_addr->city);?>" size="25" />
    <?=form_error('ship_city')?></td>
</tr>

<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('postcode'); ?></td>
  <td><input name="ship_post_code" type="text" class="inputtext" id="ship_post_code" value="<?php echo set_value('ship_post_code',$ship_addr->post_code);?>" size="25" />
    <?=form_error('ship_post_code')?></td>
</tr>
<tr>
  <td class="hmenu_font"><?php echo $this->lang->line('phone'); ?></td>
  <td><input name="ship_phone" type="text" class="inputtext" id="ship_phone" value="<?php echo set_value('ship_phone',$ship_addr->phone);?>" size="25" />
    <?=form_error('ship_phone')?></td>
</tr>

<tr height="30">
  <td colspan="2">&nbsp;</td>
</tr>
<tr height="30">
  <td>&nbsp;</td>
  <td colspan="2"><input class="bttn" type="submit" name="Submit" value="Update" />  </td>
</tr>
</table>
</form>

 </div>
    <div class="clear"></div>
</div>
	
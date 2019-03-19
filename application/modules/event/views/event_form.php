<!--message block start -->
<?php if($this->session->flashdata('message')){ ?>
<div class="alert alert-success">  
  <a class="close" data-dismiss="alert">x</a>
  <?php echo $this->session->flashdata('message');?>
</div>
<?php  } ?>
<!--message block end -->
<!--error block start -->
<?php if($this->session->flashdata('error')){ ?>
<div class="alert alert-error">  
  <a class="close" data-dismiss="alert">x</a>
  <?php echo $this->session->flashdata('error');?>
</div>
<?php  } ?>
<!--error block end -->
<h1 class="title"><span><?php echo $this->lang->line('create_event'); ?></span></h1>
<form method="post" enctype="multipart/form-data" action="" id="event_form" class="for_form box">
<h1><span class="current_form">Event Information</span> &raquo; Location Information &raquo; Organizer Information &raquo; Sponsor Information </h1>
  <fieldset class="for_inputs box_content">    
    <ul>
      <li>
        <label>Event Type*</label>
        <p>
          <select name="event_type_id" id="event_form_event_type_id" size="10">
            <option value="0" onclick="show_event_type_detail('<?php echo site_url();?>','0');">Select category type</option>
            <?php foreach($categories as $category): ?>
            <option value="<?=$category->id; ?>" onclick="show_event_type_detail('<?php echo site_url();?>','<?=$category->id; ?>');">
            <?=ucwords($category->name.' / '.$category->sub_type); echo (!empty($category->sub_sub_type))? ' / '.$category->sub_sub_type: ''; ?>
            </option>
            <?php endforeach; ?>
          </select>
          <?= form_error('event_type_id'); ?>
        </p>        
      </li>
      <div id="loading11" class="error"></div>
      <!-- all these fields are from the ajax, so disabled //category@@sub_category@@sub_sub_category@@paid@@perfomer_name@@performer_type@@performer_description   -->
      <div title="Disabled, auto filled fields according to category type." class="autofilled">
          <li>
            <label>Category Name</label>
            <p><input id="event_category" value="" class="event_autofilled" disabled="disabled"  /></p>
          </li>
          <li>
            <label>Sub Category</label>
            <p><input id="event_sub_category" value="" class="event_autofilled" disabled="disabled" style="width: 120px;" />&nbsp;<input id="event_sub_sub_category" value="" class="event_autofilled" disabled="disabled" style="width: 120px;" /></p>
          </li>
          <li>
            <label>Paid</label>
            <p><input id="event_paid" value="" disabled="disabled" class="event_autofilled" style="width: 40px;" /></p>
          </li>   
            
          <li class="hidden_fields">
            <label>Performer Detail</label>
            <p><input type="checkbox" name="change_performer" id="event_change_performer" <?php echo (set_value('change_performer')=='on')?"checked='checked'": ""; ?> onclick="toggleDisabledPerformer()" />            
            <em>Click to enter new performer other than default.</em></p>
            <br />
            <div id="event_show_old_performer_form" style="display: <?php echo (set_value('change_performer')=='on')?"none": "block"; ?>;">            
                <p><b class="label_b">Name: </b><input id="event_performer_name" class="event_autofilled" value="" disabled="disabled" style="width: 120px;" /></p>        
                <p><b class="label_b">Type: </b><input id="event_performer_type" class="event_autofilled" value="" disabled="disabled" style="width: 120px;" /></p>
                <p><b class="label_b">Description: </b><br /><textarea id="event_performer_description" class="event_autofilled" disabled="disabled" ></textarea></p>
            </div>
            <div id="event_show_new_performer_form" style="display:<?php echo (set_value('change_performer')=='on')?"block": "none"; ?>;">
                <p><b class="label_b">Name: </b><input id="event_performer_name" name="performer_name" class="event_autofilled" value="<?php echo set_value('performer_name');?>" style="width: 120px;" /></p>        
                <p><b class="label_b">Type: </b><input id="event_performer_type" name="performer_type" class="event_autofilled" value="<?php echo set_value('performer_type');?>"  style="width: 120px;" /></p>
                <p><b class="label_b">Description: </b><br /><textarea id="event_performer_description" name="performer_description" class="event_autofilled" ><?php echo set_value('performer_description');?></textarea></p>
            </div>
          </li>
      </div>
      <!-- all these fields are from the ajax, so disabled-->      
      <li>
        <label>Event Title*</label>
        <p>
          <input type="text" name="title" id="event_form_title" value="<?php echo set_value('title');?>" />
          <?=form_error('title') ?>
        </p>
      </li>
      <li>
        <label>Date Time</label>
        <p>
          <?php
                    if(isset($_POST))
                    {
                        $show_days = "none";
                        $from_to_date = "block";
                        $show_never_end = "block";
                        $custom_date = "none";
                        $frequency_checked = "Daily";
                        $if_never_end_checked = "";
                        if(isset($_POST['frequency']) and !empty($_POST['frequency']))
                        {
                            $frequency_checked = $_POST['frequency'];
                            if($_POST['frequency']=='Custom')
                            {
                                $show_days = "none";
                                $from_to_date = "none";
                                $show_never_end = "none";
                                $custom_date = "block";
                            }
                            else if($_POST['frequency']=='Daily')
                            {
                                $show_days = "none";
                                $from_to_date = "block";
                                $show_never_end = "block";
                                $custom_date = "none";
                            }
                            else
                            {
                                $show_days = "block";
                                $from_to_date = "block";
                                $show_never_end = "block";
                                $custom_date = "none";
                            }
                        }
                        if(isset($_POST['if_never_end']) and !empty($_POST['if_never_end']))
                            $if_never_end_checked = "checked";
                    }
                    ?>
        <div class="configuration_options">
          <div class="when_left">
            <p>
              <?php 
                $frequency = array('Daily'=>'Daily','Weekday'=>'Weekday Only','Weekly'=>'Weekly','Monthly'=>'Monthly','Custom'=>'Custom');
                foreach($frequency as $freKey=>$freValue)   {
                        
                       $checked = ($freKey==$frequency_checked) ? 'checked="checked"' : '';
                       echo "<input class=\"radio\" type=\"radio\" name=\"frequency\" value=\"$freKey\"  onClick=\"showFrequency('".$freKey."')\" ".$checked." />".$freValue;
                }
            ?>
            </p>
            <label>&nbsp;</label>
            <p id="show_days" style="display:<?php echo $show_days?>;">
            <?php
            $day = array('1'=>'Mon','2'=>'Tue','3'=>'Wed','4'=>'Thu','5'=>'Fri','6'=>'Sat','0'=>'Sun');
            foreach($day as $key=>$value)   {
               $checked = (isset($_POST['days']) and in_array($key,$_POST['days'])) ? 'checked="checked"' : '';
               echo '<input name="days[]" class="radio" type="checkbox" value="'.$key.'" '.$checked.'/>'.$value;
            }
            ?>
            </p>
          </div>
          <div class="when_right">
            <p id="from_to_date" style="display:<?php echo $from_to_date?>"> Start Date
              <input type="text" name="start_date" value="<?php echo (isset($_POST['start_date']))?$_POST['start_date']:""?>" class="datepicker"/>
              End Date
              <input type="text" name="end_date" value="<?php echo (isset($_POST['end_date']))?$_POST['end_date']:""?>" class="datepicker"/>
            </p>
            <p id="show_never_end" style="display:<?php echo $show_never_end?>"> Never Ends
              <input class="radio" type="checkbox" name="if_never_end" id="if_never_end" <?php echo $if_never_end_checked?>/>
            </p>
            <p id="custom_date" style="display:<?php echo $custom_date?>;">On Date
              <input type="text" name="custom_date" value="<?php echo (isset($_POST['custom_date']))?$_POST['custom_date']:""?>" class="datepicker" />
            </p>
          </div>
        </div>
        </p>
      </li>
      <!--event schedule end-->
      
      <li>
        <label>Description</label>
        <p>&nbsp;</p>
      </li>
      <li>
        <p>
          <?php echo form_fckeditor('description', set_value('description') );?>
          <?=form_error('description')?>
        </p>
      </li>
      <li>
        <label>Target Gender</label>
        <p>
          <select name="target_gender" id="event_form_target_gender">
            <option value="MF">Male/Female</option>
            <option value="M">Male</option>
            <option value="F">Female</option>
          </select>
        </p>
      </li>
      <li>
        <label>Event Logo</label>
        <p>
          <input type="file" name="logo" id="event_form_logo" />
          <?=form_error('logo') ?>
        </p>
      </li>
      <li>
        <label>Event File</label>
        <p>
          <input type="file" name="event_file" id="event_form_event_file" />
          <?=form_error('event_file') ?>
        </p>
      </li>
      <li>
        <label>Website</label>
        <p>
          <input type="text" name="website" id="event_form_website" value="<?php echo set_value('website'); ?>" />
          <?=form_error('website') ?>
        </p>
      </li>
      <li>
        <label>Keywords</label>
        <p>
          <input type="text" name="keywords" id="event_form_keywords" value="<?php echo set_value('keywords'); ?>" />
          <?=form_error('keywords') ?>
        </p>
      </li>
    </ul>
  </fieldset>
  <fieldset>
    <br clear="all" />
    <p style="text-align: center;">
      <input class="submit" type="submit" name="post_event" value="Create Event" />
    </p>
  </fieldset>
</form>

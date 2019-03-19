<div class="row">
    <div class="col-md-12">
        <?php  
        //echo "<pre>";
        //print_r($arr);
        if (!empty($selected_question->order_form_details)) {
            $s=1;
            $arr=json_decode($selected_question->order_form_details);
        }
        else {
            $s=2;
        }
        ?>
        <!--message block start -->
        <?php if($this->session->flashdata('message')){ ?>
        <div class="alert alert-success">  
          <a class="close" data-dismiss="alert">&times;</a>
          <?php echo $this->session->flashdata('message');?>
        </div>
        <?php  } ?>
        <!--message block end -->
        <!--error block start -->
        <?php if($this->session->flashdata('error')){ ?>
        <div class="alert alert-danger">  
          <a class="close" data-dismiss="alert">&times;</a>
          <?php echo $this->session->flashdata('error');?>
        </div>
        <?php  } ?>
        <!--error block end -->
        <h3><?php echo $this->lang->line('order_form'); ?></h3>
        <div class="box_content">
            <form method="post" class="form-horizontal order-form">
                <div class="table-responsive">
                    <table cellpadding="5" cellspacing="0" width="100%">
                        <tbody>
                        <tr>
            				<td><b><?=$this->lang->line('you_have_two_option') ?>:</b></nobr></td>
            				<td>
            					<label for="collectinfo_basicinfo">
            						<input style="margin-top:0;" type="radio" name="survey_type" value="direct" class="checkbox" id="collectinfo_basicinfo" <?php if($s==2) echo 'checked=""'?> onclick="javascript: checkDirect();"/>
            						<?=$this->lang->line('collect_basic_information') ?>
            					</label>
            				</td>
            			</tr>
            			<tr>
            				<td></td>
            				<td>
            					<label for="collectinfo_ticketbuyer">
            						<input style="margin-top:0;" type="radio" name="survey_type" value="ticket_buyer" class="checkbox" id="collectinfo_ticketbuyer"<?php if($s==1) echo 'checked=""'?>  onclick="javascript: checkTicketBuyer();"/>
            						<?=$this->lang->line('collect_information_below'); ?>
            					</label>
            				</td>
            			</tr>
                        </tbody>
                    </table>        
                </div>
               
                <div id="questionnaire" <?php if($s==2) echo 'class="hide"'?> >
                    <div class="panel_head3"><b><?=$this->lang->line('information_to_collect') ?></b></div>
                	<div class="panel_body"> 
                    	<div class="table-responsive">                                                           
                		<table class="table" cellpadding="10" cellspacing="0" border="0">
                        	<tbody>
                                <tr>
                        			<td width="50%" valign="top" style="border-right: solid 1px #ccc;">
                        
                        				<table cellpadding="0" cellspacing="0" border="0" class="table contact-info" >
                        				<tbody><tr>
                        					<th valign="bottom"><b><?=$this->lang->line('contact'); ?></b></td>
                                            <th width="22%"><?=$this->lang->line('include'); ?></th>
                        					<th><?=$this->lang->line('required'); ?></th>
                        				</tr>
                        
                        				<tr>
                        					<td width="200"><?=$this->lang->line('first_name'); ?>:</td>
                        					<td><input type="checkbox" name="first_name" value="1" <?php if(isset ($arr->first_name)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"></td>
                        					<td><input type="checkbox" name="first_name_required" value="1" <?php if(isset ($arr->first_name_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);"/></td>
                        				</tr>
                        
                        				<tr>
                        					<td width="200"><?=$this->lang->line('last_name'); ?>:</td>
                        					<td><input type="checkbox" name="last_name" value="1" <?php if(isset ($arr->last_name)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"/></td>
                        					<td><input type="checkbox" name="last_name_required" value="1" <?php if(isset ($arr->last_name_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);"/></td>											
                        				</tr>
                        				<tr>
                        					<td width="200"><?=$this->lang->line('home_number'); ?>:</td>
                        					<td><input type="checkbox" name="home_number" value="1" <?php if(isset ($arr->home_number)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"></td>
                        					<td><input type="checkbox" name="home_number_required" <?php if(isset ($arr->home_number_required)) echo 'checked=""'?> value="1" onclick="javascript: checkInclude(this);"></td>
                        				</tr>
                        
                        				<tr>
                        					<td width="200"><?=$this->lang->line('mobile_number'); ?>:</td>
                        					<td><input type="checkbox" name="mobile_number" value="1" <?php if(isset ($arr->mobile_number)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"></td>
                        					<td><input type="checkbox" name="mobile_number_required" value="1" <?php if(isset ($arr->mobile_number_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);"></td>
                        				</tr>
                        				<tr>
                        					<td colspan="3"><b><?=$this->lang->line('contact_information'); ?></b></td>
                        				</tr>
                        				<tr>
                        					<td width="200"><?=$this->lang->line('address'); ?>:</td>
                        					<td><input type="checkbox" name="address" value="1" <?php if(isset ($arr->address)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"></td>
                        					<td><input type="checkbox" name="address_required" value="1" <?php if(isset ($arr->address_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);"></td>
                        				</tr>
                        				<tr>
                        					<td width="200"><?=$this->lang->line('address2'); ?>:</td>
                        					<td><input type="checkbox" name="address1" value="1" <?php if(isset ($arr->address1)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"></td>
                        					<td><input type="checkbox" name="address1_required" value="1" <?php if(isset ($arr->address1_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);"></td>
                        				</tr>                                                                                 
                        				<tr>
                        					<td width="200"><?=$this->lang->line('street'); ?>:</td>
                        					<td><input type="checkbox" name="street" value="1" <?php if(isset ($arr->street)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"></td>
                        					<td><input type="checkbox" name="street_required" value="1" <?php if(isset ($arr->street_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);"></td>
                        				</tr>
                                        <tr>
                        					<td width="200"><?=$this->lang->line('city'); ?>:</td>
                        					<td><input type="checkbox" name="city" value="1" <?php if(isset ($arr->city)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"></td>
                        					<td><input type="checkbox" name="city_required" value="1" <?php if(isset ($arr->city_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);"></td>
                        				</tr>
                                        <tr>
                        					<td width="200"><?=$this->lang->line('state'); ?>:</td>
                        					<td><input type="checkbox" name="state" value="1" <?php if(isset ($arr->state)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"></td>
                        					<td><input type="checkbox" name="state_required" value="1" <?php if(isset ($arr->state_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);"></td>
                        				</tr>
                                        <tr>
                        					<td width="200"><?=$this->lang->line('country'); ?>:</td>
                        					<td><input type="checkbox" name="country" value="1" <?php if(isset ($arr->country)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"></td>
                        					<td><input type="checkbox" name="country_required" value="1" <?php if(isset ($arr->country_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);"></td>
                        				</tr>
                                        <tr>
                        					<td width="200"><?=$this->lang->line('zip'); ?>:</td>
                        					<td><input type="checkbox" name="zip" value="1" <?php if(isset ($arr->zip)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"></td>
                        					<td><input type="checkbox" name="zip_required" value="1"<?php if(isset ($arr->zip_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);"></td>
                        				</tr>
                        				</tbody></table>
                        			</td>
                        			<td width="50%" valign="top">
                        			<table cellpadding="0" cellspacing="0" border="0" class="table contact-info" style="margin-left:4%;">
                        			<tbody>
                        				<tr>
                        					<th><b><?=$this->lang->line('work_information'); ?></b></td>
                        					<th width="22%"><?=$this->lang->line('include'); ?></th>
                        					<th><?=$this->lang->line('required'); ?></th>
                        				</tr>
                        				<tr>
                        					<td width="200"><?=$this->lang->line('job_title'); ?>:</td>
                        					<td><input type="checkbox" name="work_job_title" value="1" <?php if(isset ($arr->work_job_title)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"></td>
                        					<td><input type="checkbox" name="work_job_title_required" value="1" <?php if(isset ($arr->work_job_title_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);"></td>
                        				</tr>
                        				<tr>
                        					<td width="200"><?=$this->lang->line('work_company'); ?>:</td>
                        					<td><input type="checkbox" name="work_company" value="1" <?php if(isset ($arr->work_company)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"></td>
                        					<td><input type="checkbox" name="work_company_required" value="1" <?php if(isset ($arr->work_company_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);"></td>
                        				</tr>
                        				<tr>
                        					<td width="200"><?=$this->lang->line('work_address'); ?>:</td>
                        					<td><input type="checkbox" name="work_address" value="1" <?php if(isset ($arr->work_address)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"></td>
                        					<td><input type="checkbox" name="work_address_required" value="1" <?php if(isset ($arr->work_address_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);"></td>
                        				</tr>
                        				<tr>
                        					<td width="200"><?=$this->lang->line('work_phone'); ?>:</td>
                        					<td><input type="checkbox" name="work_number" value="1" <?php if(isset ($arr->work_number)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"></td>
                        					<td><input type="checkbox" name="work_number_required" value="1" <?php if(isset ($arr->work_number_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);"></td>
                        				</tr>
                        				<tr>
                        					<td width="200"><?=$this->lang->line('work_city'); ?>:</td>
                        					<td><input type="checkbox" name="work_city" value="1" <?php if(isset ($arr->work_city)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"></td>
                        					<td><input type="checkbox" name="work_city_required" value="1" <?php if(isset ($arr->work_city_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);"></td>
                        				</tr>
                        				<tr>
                        					<td width="200"><?=$this->lang->line('work_state'); ?>:</td>
                        					<td><input type="checkbox" name="work_state" value="1" <?php if(isset ($arr->work_state)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"></td>
                        					<td><input type="checkbox" name="work_state_required" value="1" <?php if(isset ($arr->work_state_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);"></td>
                        				</tr>
                                                                                <tr>
                        					<td width="200"><?=$this->lang->line('work_country'); ?>:</td>
                        					<td><input type="checkbox" name="work_country" value="1" <?php if(isset ($arr->work_country)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"></td>
                        					<td><input type="checkbox" name="work_country_required" value="1" <?php if(isset ($arr->work_country_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);"></td>
                        				</tr>
                                        <tr>
                        					<td width="200"><?=$this->lang->line('work_zip'); ?>:</td>
                        					<td><input type="checkbox" name="work_zip" value="1" <?php if(isset ($arr->work_zip)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"></td>
                        					<td><input type="checkbox" name="work_zip_required" value="1" <?php if(isset ($arr->work_zip_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);"></td>
                        				</tr>
                                        <tr>
                        			 	<td colspan="3"><b><?=$this->lang->line('other'); ?></b></td>
                                        </tr>
                        				<tr>
                        					<td width="200"><?=$this->lang->line('gender'); ?>:</td>
                        					<td><input type="checkbox" name="gender" value="1" <?php if(isset ($arr->gender)) echo 'checked=""'?> onclick="javascript: checkRequired(this);"></td>
                        					<td><input type="checkbox" name="gender_required" value="1" <?php if(isset ($arr->gender_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);"></td>
                        				</tr>
                        			</tbody></table>
                        			</td>
                        		</tr>
                        	</tbody>
                        </table>
                        </div>
                        <div class="fixed_width_hr_wrapper"><hr/></div>
                	</div>
                    <input class="btn btn-primary" type="submit" name="question" value="<?=$this->lang->line('submit');?>"/>
            	</div>
                <div id="noquestion" <?php if($s==1) echo 'class="hide"'?>>
                    <input class="btn btn-primary" type="submit" name="question1" value="<?=$this->lang->line('submit');?>"/>
                </div>
            </form>
       </div>
    </div>
</div>
<script>
function checkTicketBuyer(){
    $("#questionnaire").show().removeClass("hide");
    $("#noquestion").hide().addClass("hide");
}
function checkDirect(){
    $("#questionnaire").hide().addClass("hide");
    $("#noquestion").show().removeClass("hide");
}
</script>
<script>
function checkInclude(ch){
    v = $(ch).parent().parent(); 
    if($(ch).is(':checked')) {
        v.find('input[type=checkbox]').attr('checked','checked');
    } else {
        v.find('input[type=checkbox]').removeAttr('checked');
    }
}
</script>
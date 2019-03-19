<?php $this->load->view('common/organizer_event_nav'); 
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
<div class="box">
    <h1><?php echo $this->lang->line('order_form'); ?></h1>
    <div class="box_content">
    <form method="post">
    <fieldset>
        <table cellpadding="5" cellspacing="0" width="100%">


							<tbody><tr>
								<td><nobr><b>You have 2 options:</b></nobr></td>
								<td>
									<label for="collectinfo_basicinfo">
										<input style="margin-top:0;" type="radio" name="survey_type" value="direct" class="checkbox" id="collectinfo_basicinfo" <?php if($s==2) echo 'checked=""'?> onclick="javascript: checkDirect();">
										Collect only <strong>basic information</strong> (email, name)
									</label>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<label for="collectinfo_ticketbuyer">
										<input style="margin-top:0;" type="radio" name="survey_type" value="ticket_buyer" class="checkbox" id="collectinfo_ticketbuyer"<?php if($s==1) echo 'checked=""'?>  onclick="javascript: checkTicketBuyer();">
										Collect information below for the <strong>ticket buyer only</strong>
									</label>
								</td>
							</tr>
							
							</tbody></table>        
    </fieldset>
   
    <div id="questionnaire" <?php if($s==2) echo 'class="hide"'?> >
							<div class="panel_head3">Information to collect</div>
							<div class="panel_body">
                                                            
								<table class="table" cellpadding="10" cellspacing="0" border="0">
								<tbody><tr>
									<td width="50%" valign="top" style="border-right: solid 1px #ccc;">

										<table cellpadding="0" cellspacing="0" border="0">
										<tbody><tr>
											<th valign="bottom" align="right"><b>Contact</b></td>
                                            <th>
                                                <div class="required_indicator">
                                                    <span class="label_include">Include</span>
                                                    <span class="label_required">Required</span>
                                                </div>
                                            </th>
											<th>
											
											</th>
										</tr>

										

										<tr>
											<td align="right" width="200">First Name:</td>
											<td>&nbsp;
                                                                                            <input type="checkbox" name="first_name" value="1" <?php if(isset ($arr->first_name)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">

													<input type="checkbox" name="first_name_required" value="1" <?php if(isset ($arr->first_name_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);">

											</td>
										</tr>

										<tr>
											<td align="right" width="200">Last Name:</td>
											<td>&nbsp;
												<input type="checkbox" name="last_name" value="1" <?php if(isset ($arr->last_name)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">

													<input type="checkbox" name="last_name_required" value="1" <?php if(isset ($arr->last_name_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);">

											</td>
										</tr>

										

										

										<tr>
											<td align="right" width="200">Home Phone:</td>
											<td>&nbsp;
												<input type="checkbox" name="home_number" value="1" <?php if(isset ($arr->home_number)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">

													<input type="checkbox" name="home_number_required" <?php if(isset ($arr->home_number_required)) echo 'checked=""'?> value="1" onclick="javascript: checkInclude(this);">

											</td>
										</tr>

										<tr>
											<td align="right" width="200">Cell Phone:</td>
											<td>&nbsp;
												<input type="checkbox" name="mobile_number" value="1" <?php if(isset ($arr->mobile_number)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">

													<input type="checkbox" name="mobile_number_required" value="1" <?php if(isset ($arr->mobile_number_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);">

											</td>
										</tr>


										<tr>
											<td align="right"><b>Address Information</b></td>
											<td></td>
										</tr>

										<tr>
											<td align="right" width="200">Address:</td>
											<td>&nbsp;
												<input type="checkbox" name="address" value="1" <?php if(isset ($arr->address)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">
												<input type="checkbox" name="address_required" value="1" <?php if(isset ($arr->address_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);">
											</td>
										</tr>


										<tr>
											<td align="right" width="200">Address1:</td>
											<td>&nbsp;
												<input type="checkbox" name="address1" value="1" <?php if(isset ($arr->address1)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">
												<input type="checkbox" name="address1_required" value="1" <?php if(isset ($arr->address1_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);">
											</td>
										</tr>
                                                                                 <tr>
											<td align="right" width="200">Street:</td>
											<td>&nbsp;
												<input type="checkbox" name="street" value="1" <?php if(isset ($arr->street)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">
												<input type="checkbox" name="street_required" value="1" <?php if(isset ($arr->street_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);">
											</td>
										</tr>
                                                                                <tr>
											<td align="right" width="200">City:</td>
											<td>&nbsp;
												<input type="checkbox" name="city" value="1" <?php if(isset ($arr->city)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">
												<input type="checkbox" name="city_required" value="1" <?php if(isset ($arr->city_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);">
											</td>
										</tr>
                                                                                <tr>
											<td align="right" width="200">State:</td>
											<td>&nbsp;
												<input type="checkbox" name="state" value="1" <?php if(isset ($arr->state)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">
												<input type="checkbox" name="state_required" value="1" <?php if(isset ($arr->state_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);">
											</td>
										</tr>
                                                                                <tr>
											<td align="right" width="200">Country:</td>
											<td>&nbsp;
												<input type="checkbox" name="country" value="1" <?php if(isset ($arr->country)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">
												<input type="checkbox" name="country_required" value="1" <?php if(isset ($arr->country_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);">
											</td>
										</tr>
                                                                                <tr>
											<td align="right" width="200">Zip:</td>
											<td>&nbsp;
												<input type="checkbox" name="zip" value="1" <?php if(isset ($arr->zip)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">
												<input type="checkbox" name="zip_required" value="1"<?php if(isset ($arr->zip_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);">
											</td>
										</tr>
										</tbody></table>
									</td>
									<td width="50%" valign="top">
									<table cellpadding="0" cellspacing="0" border="0" align="center">
									<tbody><tr>
										<td align="right"><b>Work</b></td>
										<td>
                                            <div class="required_indicator">
                                                <span class="label_include">Include</span>
                                                <span class="label_required">Required</span>
                                            </div>
                                        </td>
									</tr>
										<tr>
											<td align="right" width="200">Job Title:</td>
											<td>&nbsp;
												<input type="checkbox" name="work_job_title" value="1" <?php if(isset ($arr->work_job_title)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">
												<input type="checkbox" name="work_job_title_required" value="1" <?php if(isset ($arr->work_job_title_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);">
											</td>
										</tr>
										<tr>
											<td align="right" width="200">Company / Organization:</td>
											<td>&nbsp;
												<input type="checkbox" name="work_company" value="1" <?php if(isset ($arr->work_company)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">
												<input type="checkbox" name="work_company_required" value="1" <?php if(isset ($arr->work_company_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);">
											</td>
										</tr>
										<tr>
											<td align="right" width="200">Work Address:</td>
											<td>&nbsp;
												<input type="checkbox" name="work_address" value="1" <?php if(isset ($arr->work_address)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">
												<input type="checkbox" name="work_address_required" value="1" <?php if(isset ($arr->work_address_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);">
											</td>
										</tr>
										<tr>
											<td align="right" width="200">Work Phone:</td>
											<td>&nbsp;
												<input type="checkbox" name="work_number" value="1" <?php if(isset ($arr->work_number)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">
												<input type="checkbox" name="work_number_required" value="1" <?php if(isset ($arr->work_number_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);">
											</td>
										</tr>
										<tr>
											<td align="right" width="200">Work City:</td>
											<td>&nbsp;
												<input type="checkbox" name="work_city" value="1" <?php if(isset ($arr->work_city)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">
												<input type="checkbox" name="work_city_required" value="1" <?php if(isset ($arr->work_city_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);">
											</td>
										</tr>
										<tr>
											<td align="right" width="200">Work State:</td>
											<td>&nbsp;
												<input type="checkbox" name="work_state" value="1" <?php if(isset ($arr->work_state)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">
												<input type="checkbox" name="work_state_required" value="1" <?php if(isset ($arr->work_state_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);">
											</td>
										</tr>
                                                                                <tr>
											<td align="right" width="200">Work Country:</td>
											<td>&nbsp;
												<input type="checkbox" name="work_country" value="1" <?php if(isset ($arr->work_country)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">
												<input type="checkbox" name="work_country_required" value="1" <?php if(isset ($arr->work_country_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);">
											</td>
										</tr>
                                                                                <tr>
											<td align="right" width="200">Work Zip:</td>
											<td>&nbsp;
												<input type="checkbox" name="work_zip" value="1" <?php if(isset ($arr->work_zip)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">
												<input type="checkbox" name="work_zip_required" value="1" <?php if(isset ($arr->work_zip_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);">
											</td>
										</tr>
                                        <tr>
									 	<td align="right"><b>Other</b></td>
									 	<td></td>
                                        </tr>

										<tr>
											<td align="right" width="200">Gender:</td>
											<td>&nbsp;
												<input type="checkbox" name="gender" value="1" <?php if(isset ($arr->gender)) echo 'checked=""'?> onclick="javascript: checkRequired(this);">
												<input type="checkbox" name="gender_required" value="1" <?php if(isset ($arr->gender_required)) echo 'checked=""'?> onclick="javascript: checkInclude(this);">
											</td>
										</tr>

										

										
									</tbody></table>
									</td>
								</tr>
								</tbody></table>
								<br>
								

<div id="customQuestionsDiv">
<span class="customQuestionTitle">Your questions:</span>
    Not finding what you are looking for on this list?  Create your own questions with more options.
<div class="fixed_width_hr_wrapper"><hr></div>
<br>
<br>

</div>
                                                            
							</div>
                                                        <input class="btn btn-primary" type="submit" name="question" value="submit"/>
						</div>
        <div id="noquestion" <?php if($s==1) echo 'class="hide"'?>>
            <input class="btn btn-primary" type="submit" name="question1" value="submit"/>
        </div>
    
    </form>
   </div>
</div>
<script>
function checkTicketBuyer(){
    $("#questionnaire").show();
     $("#noquestion").hide();
}
function checkDirect(){
    $("#questionnaire").hide();
     $("#noquestion").show();
}
</script>
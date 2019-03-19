<style>
.form_errors label{margin: 20px 0 0 0; padding: 0 !important;}
</style>
<script src="<?=MAIN_JS_DIR_FULL_PATH.'date.js'?>"></script>
<!-- date-time modals start -->
<div class="modal fade" id="DailyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" class="form-horizontal" id="form_daily_modal">    
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel"><?php echo $this->lang->line('when_event_repeat'); ?></h3>
            </div>    
            <div class="modal-body event-form-main">        
                <p id="error_messages" class="error_inline"></p>
                <div class="form-group">
                    <label for="contact_name" class="form-label"><?php echo $this->lang->line('repeats_every'); ?>: </label>    
                    <div class="controls col-md-9 col-sm-9 col-xs-10">
                        <select name="repeat" style="width: 50px;" id="daily_repeat">
                            <?php for($i=1;$i<=31;$i++):?>
                            <option value="<?=$i?>"><?=$i?></option>
                            <?php endfor;?>
                        </select>
                        <?php echo $this->lang->line('days'); ?>    
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label for="contact_name" class="form-label"><?php echo $this->lang->line('start_time'); ?>: </label>    
                            <div class="controls col-md-5 col-sm-5 col-xs-12">
                                <select name="start_time" style="width: 90px;" id="daily_start_time">
                                    <?php for($i = 0; $i < 24; $i++): ?>
                                        <option value="<?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? $this->lang->line('pm') :  $this->lang->line('am') ?></option>
                                        <option value="<?= $i % 12 ? $i % 12 : 12 ?>:30 <?= $i >= 12 ? 'pm' : 'am' ?>"><?= $i % 12 ? $i % 12 : 12 ?>:30 <?= $i >= 12 ?  $this->lang->line('pm') :  $this->lang->line('am') ?></option>
                                    <?php endfor ?>              
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label for="contact_name" class="form-label"><?php echo $this->lang->line('end_time'); ?>: </label>
                            <div class="controls col-md-5 col-sm-5 col-xs-12">          
                                <select name="end_time" style="width: 90px;" id="daily_end_time">
                                    <?php for($i = 0; $i < 24; $i++): ?>
                                        <option value="<?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ?  $this->lang->line('pm') :  $this->lang->line('am') ?></option>
                                        <option value="<?= $i % 12 ? $i % 12 : 12 ?>:30 <?= $i >= 12 ? 'pm' : 'am' ?>"><?= $i % 12 ? $i % 12 : 12 ?>:30 <?= $i >= 12 ?  $this->lang->line('pm'):  $this->lang->line('am') ?></option>
                                    <?php endfor ?> 
                                </select>          
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>        
                <div class="form-group">        
                    <label for="contact_email" class="form-label"><?php echo $this->lang->line('ends_after'); ?>: </label>
                    <div class="controls col-md-9 col-sm-9 col-xs-10">
                        <input type="text" id="daily_end" name="end" value="<?php echo (isset($_POST['end']))?$_POST['end']: date('Y-m-d');?>" class="dateonlypicker"/>
                    </div>
                </div>    
                <input type="hidden" name="type" value="Daily" /> 
                <div class="clearfix"></div>   
            </div>
            <div class="modal-footer">        
                <input type="submit" class="submit btn btn-blue form-btn-fix" name="submit" id="saveDailyEvent" value="<?=ucwords($this->lang->line('save'))?>"/>
                <button class="btn form-btn-fix btn-red" data-dismiss="modal" aria-hidden="true"><?php echo $this->lang->line('cancel'); ?></button>
                <?php /*<script src="http://malsup.github.com/jquery.form.js"></script> */?> 
                <script>       
                $("#form_daily_modal").validate({
                    submitHandler: function(form) {
                        loaderOn();
                        $(form).ajaxSubmit({
                            url:"<?php echo site_url('event/create_date_time'); ?>",
                            type:"POST",
                            success: function(data){  
                                    data=jQuery.trim(data);
                                	message=data.split("@@");
                                    var result_storer=message[0].split("=");
                                	var result=jQuery.trim(result_storer[1]);
                                    
                                    if(result=='error'){
                                        var msg_result=msg[1].split("=");
                                        var msg=jQuery.trim(msg_result[1]);
                                        $("#date_time_response").html(msg);
                                        $("input[name='date_time_detail']").val("");
                                    }else{
                                        //alert(r);
                                        repeat = $("#daily_repeat").val();
                                        start_time = $("#daily_start_time").val();
                                        end_time = $("#daily_end_time").val();
                                        end = $("#daily_end").val();
                                        var d1 = Date.parse(end);
                                        end1 = d1.toString('dddd, MMMM dd, yyyy');                                
                                        repeat_msg = (repeat=='1')? "Daily Event ": "Every "+repeat+" Days ";
                                        edit = '<a href="#DailyModal" role="button" data-toggle="modal"><?=ucwords($this->lang->line('edit'))?></a>';
                                        msg = repeat_msg + ": "+start_time+" to "+end_time+" until "+end1 ;
                                        $("#date_time_response").html(msg+" "+ edit);
                                        $("input[name='date_time_detail']").val(msg);
                                    }
                                    $('#DailyModal').modal('hide');    
                                    $('#saveDailyEvent').attr('value', '<?=ucwords($this->lang->line('save'))?>').removeAttr('disabled');    
                                    loaderOff();                    
                            },
                            beforeSend:function(){
                                  $('#saveDailyEvent').attr('value', '<?=$this->lang->line('please_wait')?>');
                            }
                        });        
                        return false;
                    }
                });
                </script>
            </div>
        </div>
    </div>
</form>    
</div>

<div id="WeeklyModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" class="form-horizontal" id="form_weekly_modal"> 
    <div class="modal-dialog">
        <div class="modal-content">   
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel"><?php echo $this->lang->line('when_event_repeat'); ?>?</h3>
            </div>    
            <div class="modal-body event-form-main">        
                <p id="error_messages" class="error_inline"></p>
                <div class="form-group">
                    <label for="contact_name" class="form-label"><?php echo $this->lang->line('repeats_every'); ?>:</label>    
                    <div class="controls  col-md-9 col-sm-9 col-xs-10">
                        <select name="repeat" style="width: 50px;" id="weekly_repeat">
                            <?php for($i=1;$i<=31;$i++):?>
                            <option value="<?=$i?>"><?=$i?></option>
                            <?php endfor;?>
                        </select>
                        <?php echo $this->lang->line('weeks'); ?>    
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label for="contact_name" class="form-label"><?php echo $this->lang->line('start_time'); ?>: </label>    
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <select name="start_time" style="width: 120px;" id="weekly_start_time">
                                    <?php for($i = 0; $i < 24; $i++): ?>
                                        <option value="<?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ?  $this->lang->line('pm') :  $this->lang->line('am') ?></option>
                                        <option value="<?= $i % 12 ? $i % 12 : 12 ?>:30 <?= $i >= 12 ? 'pm' : 'am' ?>"><?= $i % 12 ? $i % 12 : 12 ?>:30 <?= $i >= 12 ?  $this->lang->line('pm') :  $this->lang->line('am') ?></option>
                                    <?php endfor ?>              
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label for="contact_name" class="form-label"><?php echo $this->lang->line('end_time'); ?>: </label>
                            <div class="col-md-5 col-sm-5 col-xs-12">          
                                <select name="end_time" style="width: 120px;" id="weekly_end_time">
                                    <?php for($i = 0; $i < 24; $i++): ?>
                                        <option value="<?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ?  $this->lang->line('pm') :  $this->lang->line('am') ?></option>
                                        <option value="<?= $i % 12 ? $i % 12 : 12 ?>:30 <?= $i >= 12 ? 'pm' : 'am' ?>"><?= $i % 12 ? $i % 12 : 12 ?>:30 <?= $i >= 12 ?  $this->lang->line('pm') :  $this->lang->line('am') ?></option>
                                    <?php endfor ?> 
                                </select>          
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">        
                    <label for="contact_email" class="form-label"><?php echo $this->lang->line('repeat_on'); ?>: </label>
                    <div class="controls  col-md-9 col-sm-9 col-xs-10">
                        <div class="form_errors"></div>
                        <?php
                        
        				$day = array('1'=>'Mon','2'=>'Tue','3'=>'Wed','4'=>'Thu','5'=>'Fri','6'=>'Sat','0'=>'Sun');
                        
                        foreach($day as $key=>$value)   {
                           $checked = (isset($_POST['days']) and in_array($key,$_POST['days'])) ? 'checked="checked"' : '';
                           echo ' <input name="days[]" class="my_checkbox_group" title="'.$this->lang->line('select_at_least_one').'" type="checkbox" value="'.$key.'" '.$checked.'/> '.$value;
                        }
                        ?>
                    </div>
                </div>        
                <div class="form-group">        
                    <label for="contact_email" class="form-label"><?php echo $this->lang->line('ends_after'); ?>: </label>
                    <div class="controls  col-md-9 col-sm-9 col-xs-10">
                        <input type="text" id="weekly_end" name="end" value="<?php echo (isset($_POST['end']))?$_POST['end']: date('Y-m-d');?>" class="dateonlypicker"/>
                    </div>
                </div>    
                <input type="hidden" name="type" value="Weekly" />    
            </div>
            <div class="modal-footer">        
                <input type="submit" class="submit btn btn-blue form-btn-fix" name="submit" id="saveWeeklyEvent" value="<?=ucwords($this->lang->line('save'))?>"/>
                <button class="btn form-btn-fix btn-red" data-dismiss="modal" aria-hidden="true"><?php echo $this->lang->line('cancel'); ?></button>
                <?php /*<script src="http://malsup.github.com/jquery.form.js"></script> */?>  
                <script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>jquery.validate.additional.js"></script>
                <script>     
                $("#form_weekly_modal").validate({
                    /*checkbox validate start*/
                    errorLabelContainer: ".form_errors",
                    wrapper: "",
                    groups: {
                        name: "days[]"
                    },
                    rules: {
                        'days[]': {
                            require_from_group: [1, ".my_checkbox_group"]
                        },
                    },
                    /*checkbox validate end*/
                    submitHandler: function(form) {
                        loaderOn();
                        $(form).ajaxSubmit({
                            url:"<?php echo site_url('event/create_date_time'); ?>",
                            type:"POST",
                            success: function(data){                            
                                    data=jQuery.trim(data);
                                	message=data.split("@@");
                                    var result_storer=message[0].split("=");
                                	var result=jQuery.trim(result_storer[1]);
                                    //alert(r);
                                    if(result=='error'){
                                        var msg_result=msg[1].split("=");
                                        var msg=jQuery.trim(msg_result[1]);
                                        $("#date_time_response").html(msg);
                                        $("input[name='date_time_detail']").val("");
                                    }else{
                                        repeat = $("#weekly_repeat").val();
                                        start_time = $("#weekly_start_time").val();
                                        end_time = $("#weekly_end_time").val();
                                        end = $("#weekly_end").val();
                                        var d1 = Date.parse(end);
                                        end1 = d1.toString('dddd, MMMM dd, yyyy');  
                                        
                                        repeat_msg = (repeat=='1')? "Weekly Event ": "Every "+repeat+" Weeks ";
                                        edit = '<a href="#WeeklyModal" role="button" data-toggle="modal"><?=ucwords($this->lang->line('edit'))?></a>';
                                        msg = repeat_msg + ": "+start_time+" to "+end_time+" until "+end1 ;
                                        
                                        $("#date_time_response").html(msg+" "+ edit);
                                        $("input[name='date_time_detail']").val(msg);
                                    }
                                    $('#WeeklyModal').modal('hide');    
                                    $('#saveWeeklyEvent').attr('value', '<?=ucwords($this->lang->line('save'))?>').removeAttr('disabled');                
                                    loaderOff();        
                            },
                            beforeSend:function(){
                                  $('#saveDailyEvent').attr('value', '<?=$this->lang->line('please_wait')?>');
                            }
                        });        
                        return false;
                    }
                });
                </script>
            </div>
        </div>
    </div>
</form>    
</div>

<div id="MonthlyModal" class="modal  fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<form method="post" class="form-horizontal" id="form_monthly_modal">
    <div class="modal-dialog">
        <div class="modal-content">    
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel"><?php echo $this->lang->line('when_event_repeat'); ?></h3>
            </div>    
            <div class="modal-body event-form-main">        
                <p id="error_messages" class="error_inline"></p>
                <div class="form-group">
                    <label for="contact_name" class="form-label"><?php echo $this->lang->line('repeats_on_the'); ?>: </label>    
                    <div class="controls col-md-9 col-sm-9 col-xs-10">
                        <input type="hidden" id="check_repeat" name="check_repeat" value="day"/>
                        <div id="select_by_day">
                            <select name="repeat_day" style="width: 50px;" id="monthly_repeat_weekdate">
                                <?php for($i=1;$i<=31;$i++):?>
                                <option value="<?=$i?>"><?=$i?></option>
                                <?php endfor;?>
                            </select>
                            <?php echo $this->lang->line('day_month'); ?> <a style="cursor: pointer;" onclick="$('#select_by_date').show();$('#select_by_day').hide();$('#check_repeat').val('weekday');"><?php echo $this->lang->line('select_day_week'); ?></a>
                        </div>
                        <div id="select_by_date" style="display: none;">
                            <select name="repeat_rank" style="width: 90px;" id="monthly_repeat_rank" >
                                <option value="1" attr="First"><?php echo $this->lang->line('first'); ?></option>
                                <option value="2" attr="Second"><?php echo $this->lang->line('second'); ?></option>
                                <option value="3" attr="Third"><?php echo $this->lang->line('third'); ?></option>
                                <option value="4" attr="Fourth"><?php echo $this->lang->line('fourth'); ?></option>
                                <option value="last" attr="Last"><?php echo $this->lang->line('last'); ?></option>
                            </select>
                            <?php  $day = array('1'=>$this->lang->line('monday'),'2'=>$this->lang->line('tuesday'),'3'=>$this->lang->line('wednesday'),'4'=>$this->lang->line('thursday'),'5'=>$this->lang->line('friday'),'6'=>$this->lang->line('saturday'),'0'=>$this->lang->line('sunday')); ?>
                            <select name="repeat_weekday"  style="width: 90px;" id="monthly_repeat_weekday">
                            <?php foreach($day as $key=>$value): ?>
                                <option value="<?=$key; ?>" attr="<?=$value ?>"><?=$value ?></option>
                            <?php endforeach;?>
                            </select>                   
                            <?php echo $this->lang->line('of_the_month'); ?> <a style="cursor: pointer;" onclick="$('#select_by_date').hide();$('#select_by_day').show();$('#check_repeat').val('day');"><?php echo $this->lang->line('select_by_date'); ?></a>
                        </div>   
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label for="contact_name" class="form-label"><?php echo $this->lang->line('start_time'); ?>: </label>    
                            <div class="controls col-md-5 col-sm-5 col-xs-12">
                                <select name="start_time" style="width: 90px;" id="monthly_start_time">
                                    <?php for($i = 0; $i < 24; $i++): ?>
                                        <option value="<?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? $this->lang->line('pm') : $this->lang->line('am') ?></option>
                                        <option value="<?= $i % 12 ? $i % 12 : 12 ?>:30 <?= $i >= 12 ? 'pm' : 'am' ?>"><?= $i % 12 ? $i % 12 : 12 ?>:30 <?= $i >= 12 ? $this->lang->line('pm') : $this->lang->line('am') ?></option>
                                    <?php endfor ?>              
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label for="contact_name" class="form-label"><?php echo $this->lang->line('end_time'); ?>: </label>
                            <div class="controls col-md-5 col-sm-5 col-xs-12">          
                                <select name="end_time" style="width: 90px;" id="monthly_end_time">
                                    <?php for($i = 0; $i < 24; $i++): ?>
                                        <option value="<?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? $this->lang->line('pm') : $this->lang->line('am') ?></option>
                                        <option value="<?= $i % 12 ? $i % 12 : 12 ?>:30 <?= $i >= 12 ? 'pm' : 'am' ?>"><?= $i % 12 ? $i % 12 : 12 ?>:30 <?= $i >= 12 ? $this->lang->line('am') : $this->lang->line('am') ?></option>
                                    <?php endfor ?> 
                                </select>          
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="contact_name" class="form-label"><?php echo $this->lang->line('repeats_every'); ?>: </label>    
                    <div class="controls col-md-9 col-sm-9 col-xs-10">
                        <select name="repeat" style="width: 50px;" id="monthly_repeat">
                            <?php for($i=1;$i<=12;$i++):?>
                            <option value="<?=$i?>"><?=$i?></option>
                            <?php endfor;?>
                        </select>
                        <?php echo $this->lang->line('months'); ?>    
                    </div>
                </div>        
                <div class="form-group">        
                    <label for="contact_email" class="form-label"><?php echo $this->lang->line('ends_after'); ?>: </label>
                    <div class="controls col-md-9 col-sm-9 col-xs-10">
                        <input type="text" id="monthly_end" name="end" value="<?php echo (isset($_POST['end']))?$_POST['end']: date('Y-m-d');?>" class="dateonlypicker"/>
                    </div>
                </div>    
                <input type="hidden" name="type" value="Monthly" />    
            </div>
            <div class="modal-footer">        
                <input type="submit" class="submit btn btn-blue form-btn-fix" name="submit" id="saveMonthlyEvent" value="<?=ucwords($this->lang->line('save'))?>"/>
                <button class="btn btn-red form-btn-fix" data-dismiss="modal" aria-hidden="true"><?php echo $this->lang->line('cancel'); ?></button>
                <?php /*<script src="http://malsup.github.com/jquery.form.js"></script> */?>  
                <script>       
                $("#form_monthly_modal").validate({
                    submitHandler: function(form) {
                        loaderOn();
                        $(form).ajaxSubmit({
                            url:"<?php echo site_url('event/create_date_time'); ?>",
                            type:"POST",
                            success: function(data){  
                                    data=jQuery.trim(data);
                                	message=data.split("@@");
                                    var result_storer=message[0].split("=");
                                	var result=jQuery.trim(result_storer[1]);
                                    
                                    if(result=='error'){
                                        var msg_result=msg[1].split("=");
                                        var msg=jQuery.trim(msg_result[1]);
                                        $("#date_time_response").html(msg);
                                        $("input[name='date_time_detail']").val("");
                                    }else{
                                        //alert(r);
                                        repeat = $("#monthly_repeat").val();
                                        start_time = $("#monthly_start_time").val();
                                        end_time = $("#monthly_end_time").val();
                                        end = $("#monthly_end").val();
                                        var d1 = Date.parse(end);
                                        end1 = d1.toString('dddd, MMMM dd, yyyy');  
                                        
                                        repeat_msg = (repeat=='1')? "Monthly Event, ": "Every "+repeat+" Months, ";
                                        check_repeat = $('#check_repeat').val();
                                        
                                        weekdate = $("#monthly_repeat_weekdate").val();                              
                                        var rank = $("#monthly_repeat_rank").find(':selected').attr('attr');
                                        var weekday = $("#monthly_repeat_weekday").find(':selected').attr('attr');
                                        
                                        repeater = (check_repeat=='day')? "Day "+weekdate+" of the month " : rank+" "+weekday+" of the month "  ; 
                                        edit = '<a href="#MonthlyModal" role="button" data-toggle="modal"><?=ucwords($this->lang->line('edit'))?></a>';
                                        msg = repeat_msg + repeater + ": "+start_time+" to "+end_time+" until "+end1 ;
                                        
                                        $("#date_time_response").html(msg+" "+ edit);
                                        $("input[name='date_time_detail']").val(msg);
                                    }
                                    $('#MonthlyModal').modal('hide');    
                                    $('#saveMonthlyEvent').attr('value', '<?=ucwords($this->lang->line('save'))?>').removeAttr('disabled');
                                    loaderOff();                        
                            },
                            beforeSend:function(){
                                  $('#saveMonthlyEvent').attr('value', '<?=$this->lang->line('please_wait')?>');
                            }
                        });        
                        return false;
                    }
                });
                </script>
            </div>
        </div>
    </div>
</form>    
</div>
<!-- date-time modals start -->

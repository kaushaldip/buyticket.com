<style type="text/css" title="currentStyle">
@import "<?php echo MAIN_JS_DIR_FULL_PATH  ?>datatables/demo_page.css";
@import "<?php echo MAIN_JS_DIR_FULL_PATH  ?>datatables/demo_table_jui.css";
@import "<?php echo MAIN_JS_DIR_FULL_PATH  ?>datatables/themes/smoothness/jquery-ui-1.8.4.custom.css";
</style>
<script src="<?php echo MAIN_JS_DIR_FULL_PATH  ?>datatables/jquery.dataTables-min.js"></script>

<script type="text/javascript" charset="utf-8">
$.fn.dataTableExt.afnSortData['dom-text'] = function  ( oSettings, iColumn )
{
	var aData = [];
	$( 'td:eq('+iColumn+') input', oSettings.oApi._fnGetTrNodes(oSettings) ).each( function () {
		aData.push( this.value );
	} );
	return aData;
}

$(document).ready(function() {
	oTable = $('#example').dataTable({
                        "bRetrieve":true,
                        "bDestroy":true,
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
        "aoColumns": [
                    { "sSortDataType": "dom-text" },
                        null,
                        null,
                        null,
                        null,
                        null
                    ],
        "oLanguage": {
            "sSearch": "<?=$this->lang->line('search');?>: ",
            "sZeroRecords": "<?=$this->lang->line('no_records');?>",
            "sLengthMenu": '<?=$this->lang->line('show');?> <select>'+
                '<option value="10">10</option>'+
                '<option value="20">20</option>'+
                '<option value="30">30</option>'+
                '<option value="40">40</option>'+
                '<option value="50">50</option>'+
                '<option value="-1">All</option>'+
                '</select> <?=$this->lang->line('records');?>',
            "sInfo": "<?=$this->lang->line('showing_start_end');?>",
            "oPaginate": {
                    "sPrevious": "<?=$this->lang->line('previous');?>",
                    "sNext": "<?=$this->lang->line('next');?>",
                    "sLast": "<?=$this->lang->line('last');?>",
                    "sFirst": "<?=$this->lang->line('first');?>",
                  },
                
          }
	});
});
</script>
<div class="row">
    <div class="col-md-12">
        <h3><?=$this->lang->line('check_in') ?></h3>
        <?php if($data_event->date_id !=0){ ?>
            <span style="float: right;">              
            <?php
            $date_range = $this->event_model->get_date_detail($data_event->id);
        
            $begin = new DateTime( $date_range->start_date );
            $end = new DateTime( $date_range->end );
            
            $diff =intval((strtotime($date_range->end_date ) - strtotime($date_range->start_date )));
            
            $datearr = array();
            if($date_range->type=='Daily'){
                $interval = DateInterval::createFromDateString("$date_range->repeat day");
                $period = new DatePeriod($begin, $interval, $end);
                foreach ( $period as $dt ):
                    $datearr[] = $dt->format( "l Y-m-d H:i:s" ).", ".date('l Y-m-d H:i:s', strtotime($date_range->end_date. " + $diff days"));
                endforeach;    
            }else if($date_range->type=='Weekly'){
                $Narr = explode(',',$date_range->repeat_weekday);
                $interval = DateInterval::createFromDateString("1 day");
                $period = new DatePeriod($begin, $interval, $end);
                
                foreach ( $period as $dt ):                        
                    if (in_array($dt->format("N"),$Narr))
                        $datearr[] = $dt->format( "l Y-m-d H:i:s" ).", ".date('l Y-m-d H:i:s', strtotime($dt->format( "l Y-m-d H:i:s" ). " + $diff seconds"));
                endforeach;
            }else if($date_range->type=="Monthly"){
                if($date_range->repeat_day == '0'){
                    $Narr = explode('-',$date_range->repeat_weekday);
                    $r1 = $Narr[0];
                    $d1 = $Narr[1];
                    
                    $interval = DateInterval::createFromDateString("1 month");
                    $period = new DatePeriod($begin, $interval, $end);
                    
                    $ranges = array('1'=>'first','2'=>'second','3'=>'third','4'=>'fourth','last'=>'last');
                    $days = array('1'=>'monday','2'=>'tuesday','3'=>'wednesday','4'=>'thursday','5'=>'friday','6'=>'saturday','0'=>'sunday');
                    
                    $r = $ranges[$r1];
                    $d = $days[$d1];
                                            
                    foreach ( $period as $dt ):
                        $datearr[] = date('l Y-m-d H:i:s',strtotime($dt->format( "l Y-m-d H:i:s" )."$r $d")).", ".date('l Y-m-d H:i:s', strtotime(date('l Y-m-d H:i:s',strtotime($dt->format( "l Y-m-d H:i:s" )."$r $d")). " + $diff seconds"));
                    endforeach;
                                            
                }else{
                    $interval = DateInterval::createFromDateString("1 day");
                    $period = new DatePeriod($begin, $interval, $end);
                    
                    foreach ( $period as $dt ):                        
                        if ($dt->format("j")==$date_range->repeat_day)
                            $datearr[] = $dt->format( "l Y-m-d H:i:s" ).", ".date('l Y-m-d H:i:s', strtotime($dt->format( "l Y-m-d H:i:s" ). " + $diff seconds"));
                    endforeach;
                }                    
            }               
            ?> 
            
        <?php 
        
        if(!isset ($default_check_in)){
        
        $default_time=$datearr[0];
        $def_time=  explode(',', $default_time);
        $def_start_time=  trim($def_time[0]);
        $def_end_time=  trim($def_time[1]);
        $def_start_time1=strtotime($def_start_time);
        $def_end_time1=strtotime($def_end_time);
        $def_end_time_str=date('Y-m-d H:i:s',$def_end_time1);
        $def_start_time_str=date('Y-m-d H:i:s',$def_start_time1);
        
        
        $default_check_in=$this->event_model->get_default_checkin($def_start_time_str,$def_end_time_str);
        
        }
        ?>
            <form method="post" >
                <select id="tickets_date" name="tickets_date" class="required" title="*" style="width:100%;">
                    <?php 
                    $i = 1;
                    if(!isset ($default_check_in1)){
                        $s=1;
                    }else {
                        $s=$default_check_in1;
                    }
                    foreach($datearr as $d):
                    ?>
                        <option <?php if($s==$d){ echo 'selected=""'; } ?> value="<?=$d;?>"><?=$d; ?></option>
                    <?php ++$i;
                    endforeach;?>                                       
                </select>
            </form>
            </span>
        <?php } else {
            $default_check_in=$this->event_model->get_default_checkin($data_event->start_date,$data_event->end_date);
        }?>
        
        <div id="progress_by_headcount" class="alert alert-warning no-margin">
            <nobr>
            <span id="progress_checked_in">1</span> <?=$this->lang->line('out_of');?> <span id="progress_total_attendees">15</span> <?=$this->lang->line('checked_in');?>
            </nobr>
        </div>
        <div class="check_in_table table-responsive">
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
            	<thead>
            		<tr>
            			<th style="width: 18%;"><?=$this->lang->line('status');?></th>
            			<th style="width: 28%;"><?=$this->lang->line('attendee');?></th>
            			<th style="width: 20%;"><?=$this->lang->line('email');?></th>
                        <th style="width: 15%;"><?=$this->lang->line('order_id');?></th>
            			<th style="width: 20%;"><?=$this->lang->line('ticket_name');?></th>
            			<th style="width: 10%;"><?=$this->lang->line('ticket_type');?></th>
            		</tr>
            	</thead>
                    
                <tbody >
                <?php 
                    if($default_check_in): 
                    foreach($default_check_in as $key=>$d_c): 
                    //var_dump($d_c);
                        $totalticketsold = $this->event_model->get_total_tick_sold_new($d_c->ticket_id, $d_c->email, $d_c->order_id);
                        $totalcheckin = $this->event_model->get_total_tick_checkin($d_c->etsid);
                        $c_no = $totalcheckin->check_in;
                        $hide = '';
                        $hide1 = 'hide';
                        if($c_no==$totalticketsold) {$hide='hide'; $hide1='';}
                        //print_r($totalcheckin);
                        ?>
                		<tr class="odd gradeX">
                            <td>
                                <span class='<?=$hide ?>'>
                                    <select class="chnage_check_in" kds="<?=$d_c->etsid ?>" kds_t="<?=$totalticketsold ?>" style="width: 100px;">
                                        <?php   for ($i = 0; $i <= $totalticketsold; $i++) { ?>
                                        <option <?php if($c_no==$i) {?>selected="selected"<?php } ?> value="<?=$i ?>" ><?=$i ?></option>
                                        <?php } ?>  
                                    </select>&nbsp;/&nbsp;<?=$totalticketsold ?>
                                    <input type="hidden" class="total_ticket_input"value="<?=$totalticketsold ?>" />
                                </span>
                                <button class="undo_button <?=$hide1 ?> btn btn-danger btn-sm" type="button" kds="<?=$d_c->etsid ?>"><?=$this->lang->line('undo_check_in')?></button>
                            </td>
                			<td>                            
                                <a class="btn btn-xs btn-info" href="#attendee_details_<?= $key ?>" data-toggle="modal"><?php echo $this->lang->line('view_detail'); ?></a>
                                <!-- Modal -->
                                <div class="modal fade" id="attendee_details_<?=$key;?>" tabindex="-1" role="dialog" aria-labelledby="attendee_detailsLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="attendee_details_<?=$key;?>Label"><?php echo $this->lang->line('order_id')." : ".$d_c->order_id ; ?></h4>
                                            </div>
                                            <div class="modal-body" id="attendee_details_<?=$key;?>mainModalBody">
                                                <div id="" class="row">
                                                <?php
                                                $ar = json_decode($d_c->order_form_detail, true);
                                                for($j = 1; $j<=$totalticketsold; $j++)
                                                {
                                                    echo "<div class='col-md-6'>";
                                                    echo "<h5 class='contact_information'>".$this->lang->line('contact_information')."</h5>";
                                                    echo "<strong>".$this->lang->line('full_name')."</strong> ".ucwords($ar['first_name'.$j]." ".$ar['last_name'.$j]);                                
                                                    echo "<br/>";
                                                	if(isset($ar['home_number'.$j])){
                                                	    echo "<strong>".$this->lang->line('home_number')."</strong> ".ucwords($ar['home_number'.$j]);                                
                                                		echo "<br/>";
                                                	}
                                                	if(isset($ar['mobile_number'.$j])){
                                                		echo "<strong>".$this->lang->line('mobile_number')."</strong> ".ucwords($ar['mobile_number'.$j]);                                
                                                		echo "<br/>";
                                                	}
                                                	if((isset ($ar['billing_country'.$j])) || (isset ($ar['billing_address'.$j])) || (isset ($ar['billing_address2'.$j])) || (isset ($ar['street_address'.$j])) || (isset ($ar['billing_city'.$j])) || (isset ($ar['billing_state'.$j])) || (isset ($ar['billing_postal_code'.$j])) )
                                                    {
                                                		echo "<h5>".$this->lang->line('biling_information')."</h5>";
                                                		if(isset($ar['billing_country'.$j])){
                                                			echo "<strong>".$this->lang->line('billing_country')."</strong> ".ucwords($ar['billing_country'.$j]);                                
                                                			echo "<br/>";
                                                		}
                                                		if(isset($ar['billing_address'.$j])){
                                                			echo "<strong>".$this->lang->line('billing_address')."</strong> ".ucwords($ar['billing_address'.$j]);                                
                                                			echo "<br/>";
                                                		}
                                                                            if(isset($ar['billing_address2'.$j])){
                                                			echo "<strong>".$this->lang->line('billing_address2')."</strong> ".ucwords($ar['billing_address2'.$j]);                                
                                                			echo "<br/>";
                                                		}
                                                                            if(isset($ar['street_address'.$j])){
                                                			echo "<strong>".$this->lang->line('street')."</strong> ".ucwords($ar['street_address'.$j]);                                
                                                			echo "<br/>";
                                                		}
                                                                            if(isset($ar['billing_city'.$j])){
                                                			echo "<strong>".$this->lang->line('billing_city')."</strong> ".ucwords($ar['billing_city'.$j]);                                
                                                			echo "<br/>";
                                                		}
                                                                            if(isset($ar['billing_state'.$j])){
                                                			echo "<strong>".$this->lang->line('billing_state')."</strong> ".ucwords($ar['billing_state'.$j]);                                
                                                			echo "<br/>";
                                                		}
                                                                            if(isset($ar['billing_postal_code'.$j])){
                                                			echo "<strong>".$this->lang->line('postal_code')."</strong> ".ucwords($ar['billing_postal_code'.$j]);                                
                                                			echo "<br/>";
                                                		}
                                                	}
                                                            
                                                    if((isset ($ar['work_job_title'.$j])) || (isset ($ar['work_company'.$j])) || (isset ($ar['work_address'.$j])) || (isset ($ar['work_number'.$j])) || (isset ($ar['work_city'.$j])) || (isset ($ar['work_state'.$j])) || (isset ($ar['work_country'.$j])) || (isset ($ar['work_zip'.$j])) || (isset ($ar['gender'.$j])) )
                                                    {
                                                        echo "<h5>".$this->lang->line('work_information')."</h5>";
                                                        if(isset($ar['work_job_title'.$j])){
                                                            echo "<strong>".$this->lang->line('work_job_title')."</strong> ".ucwords($ar['work_job_title'.$j]);                                
                                                            echo "<br/>";
                                                        }
                                                        if(isset($ar['work_company'.$j])){
                                                            echo "<strong>".$this->lang->line('work_company')."</strong> ".ucwords($ar['work_company'.$j]);                                
                                                            echo "<br/>";
                                                        }    
                                                        if(isset($ar['work_address'.$j])){
                                                            echo "<strong>".$this->lang->line('work_address')."</strong> ".ucwords($ar['work_address'.$j]);                                
                                                            echo "<br/>";
                                                        }     
                                                        if(isset($ar['work_number'.$j])){
                                                            echo "<strong>".$this->lang->line('work_phone')."</strong> ".ucwords($ar['work_number'.$j]);                                
                                                            echo "<br/>";
                                                        }     
                                                        if(isset($ar['work_city'.$j])){
                                                            echo "<strong>".$this->lang->line('work_city')."</strong> ".ucwords($ar['work_city'.$j]);                                
                                                            echo "<br/>";
                                                        } 
                                                        if(isset($ar['work_state'.$j])){
                                                            echo "<strong>".$this->lang->line('work_state')."</strong> ".ucwords($ar['work_state'.$j]);                                
                                                            echo "<br/>";
                                                        }
                                                        if(isset($ar['work_country'.$j])){
                                                            echo "<strong>".$this->lang->line('work_country')."</strong> ".ucwords($ar['work_country'.$j]);                                
                                                            echo "<br/>";
                                                        }
                                                        if(isset($ar['work_zip'.$j])){
                                                            echo "<strong>".$this->lang->line('work_zip')."</strong> ".ucwords($ar['work_zip'.$j]);                                
                                                            echo "<br/>";
                                                        }
                                                        if(isset($ar['gender'.$j])){
                                                            echo "<strong>".$this->lang->line('gender')."</strong> ".ucwords($ar['gender'.$j]);                                
                                                            echo "<br/>";
                                                        }
                                                    }
                                                    echo "</div>";
                                                }
                                                ?>
                                                </div>                                    
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal -->                    		
                            </td>
                            <td><?=$d_c->email ?></td>
                            <td><?=$d_c->order_id ?></td>
                            <td class="center"><?=$d_c->name ?></td>
                            <td class="center"><?=strtoupper($d_c->ticket_type); ?></td>
                		</tr>
                        <?php 
                    endforeach; 
                    endif; ?>
            	</tbody>
            </table>
        </div>
        <?php if($active_event){?>
            <br />
            <a href="<?php echo site_url('event/add_attendees/' . $id); ?>" target="_blank" class="btn btn-small btn-success"><?=$this->lang->line('add_attendee')?></a>
        <?php }?>        
    </div>
</div>

<script>
$(document).ready(function(){
    var total_price=0;
    var total_selected=0;
    $( ".total_ticket_input" ).each(function( index ) {
        // console.log( index + ": " + $(this).next().next().text().replace('$', '') );
        var tr=$(this).val();
        total_price += Number(tr);
    });
    $('.chnage_check_in').each(function(index){
        var tm=$(this).find('option:selected').val();
        total_selected +=Number(tm);
    });
    $('#progress_checked_in').text(total_selected);
    $('#progress_total_attendees').text(total_price);
});

$("#tickets_date").change(function(){
    $(this).closest('form').trigger('submit');
});

$('.chnage_check_in').change(function(){
    loaderOn();
    var s_this=$(this);
    var sel_val=$(this).val();
    var par_td=$(this).parent().parent();
    var par_td1=$(this).parent();
    var id=$(this).attr('kds');
    var t_tick=$(this).attr('kds_t');
    
    $('#progress_checked_in').html('<img src='+'<?=MAIN_IMAGES_DIR_FULL_PATH?>'+'ajax-loader.gif>');
    $.ajax({
        url:'<?php echo site_url('event/change_checking'); ?>',
        type:'POST',
        data:'id='+id+'&value='+sel_val,
        success:function(r){
            if(sel_val==t_tick){                
                //$('option:selected', this).remove();
                s_this.parent().hide().addClass("hide");
                console.log(par_td1);
                par_td.find(".undo_button").show().removeClass("hide");
            }
            var total_selected=0;
            $('.chnage_check_in').each(function(index){
                var tm=$(this).find('option:selected').val();
                total_selected +=Number(tm);
            });
            $('#progress_checked_in').text(total_selected);
            // oTable.fnClearTable();
            loaderOff();
        }
    })
});

$('.undo_button').click(function(){
    loaderOn();
    var s_this=$(this);
    var sel_val=0;
    var par_td=$(this).parent().parent();
    var par_td1=$(this).parent();
    var id=$(this).attr('kds');
    
    $('#progress_checked_in').html('<img src='+'<?=MAIN_IMAGES_DIR_FULL_PATH?>'+'ajax-loader.gif>');
    $.ajax({
        url:'<?php echo site_url('event/change_checking'); ?>',
        type:'POST',
        data:'id='+id+'&value='+sel_val,
        success:function(r){
            s_this.prev().find('option:selected').removeAttr("selected");
            s_this.hide().addClass("hide");
            s_this.prev().show().removeClass("hide");
            var total_selected=0;
            $('.chnage_check_in').each(function(index){
                var tm=$(this).find('option:selected').val();
                total_selected +=Number(tm);
            });
            $('#progress_checked_in').text(total_selected);
            loaderOff();
        }
    })
});

</script>

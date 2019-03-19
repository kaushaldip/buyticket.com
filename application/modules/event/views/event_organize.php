<script src="<?php echo ASSETS_PATH ?>highchart/js/highcharts.js"></script>
<script src="<?php echo ASSETS_PATH ?>highchart/js/modules/exporting.js"></script>
<?php
if($ticket_details):
foreach($ticket_details as $tic):
    $sale_count=$this->event_model->get_ticket_type_sale($tic->id);
    
    $group_tick_arr[] ="'$tic->name'";
    $group_tick_price[] = "'$tic->ticket_price'";
    if($sale_count)  {  $no_tick_arr[] =$sale_count->total_quantity;} else { $no_tick_arr[]=0; }    
endforeach;
echo '<script>$(function () {
        $("#container").highcharts({
            chart: {
                type: "column"                
            },
            
            credits: {
      enabled: false
  },
            title: {
                text: ""
            },
            subtitle: {
                text: ""
            },
            xAxis: {
                categories: ['.join($group_tick_arr, ',').']
            },
            yAxis: {
                title: {
                    text: "'.$this->lang->line("total_tickets").'"
                }
            },
            tooltip: {
                enabled: false,
                formatter: function() {
                   return "<b>"+ this.series.name +"</b><br/>"+
                        this.x +": "+ this.y +"°C";
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            tooltip: {
                formatter: function() {
                    var point = this.point,
                        s = this.x +":<b>"+ this.y +" '.$this->lang->line('tickets').'</b><br/>";
                        s += "'."".'";
                        
                        
                    return s;
                }
            },
            series: [{
                name: "'.$this->lang->line("sales").'",
                data : ['.join($no_tick_arr, ',').'],               
                dataLabels: {
                    enabled: true,
                    rotation: 0,
                    color: "#333",
                    align: "center",
                    x: 0,
                    y: 0,
                    style: {
                        fontSize: "13px",
                        fontFamily: "Verdana, sans-serif"
                    }
                }
            }]
        });
    }); </script>';
endif;
if($event_page_view):
foreach($event_page_view as $epv):
    
$event_page_date[] ="'$epv->on_date'";
    $even_page_view[] =$epv->count_event;
endforeach;
echo '<script type="text/javascript">

     $(function () {
        $("#containe").highcharts({
            chart: {
                type: "line"
            },
            credits: {
      enabled: false
  },
            title: {
                text: ""
            },
            subtitle: {
                text: ""
            },
            xAxis: {
                categories: ['.join($event_page_date, ',').']
            },
            yAxis: {
                title: {
                    text: "'.$this->lang->line("visits").'"
                }
            },
            tooltip: {
                enabled: false,
                formatter: function() {
                    return "<b>"+ this.series.name +"</b><br/>"+
                        this.x +": "+ this.y +"°C";
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: "'.$this->lang->line("visits").'",
                data: ['.join($even_page_view, ',').']
            }]
        });
    });
    
    

		</script>';
endif;

//echo $date;
?>

<div class="row">
    <div class="col-md-6">
        <h3><?php echo $this->lang->line('visits'); ?></h3>
        <ul class="breadcrumb">
            <li><?php echo $this->lang->line('total_views'); ?><span class="divider">&#61;</span></li><li><?=$no_views;?></li>
        </ul>
        <div id="containe" style="height: 300px;"></div>
    </div>
    <div class="col-md-6">
        <h3><?php echo $this->lang->line('ticket_sales'); ?></h3>
        <ul class="breadcrumb">
            <li><?php echo $this->lang->line('total_sales'); ?><span class="divider">&#61;</span></li><li><?=$total_sold;?></li>
        </ul>
        <div id="container" style="height:300px ;"></div>        
    </div>
</div>
<span id="button2"></span>

<h3><?php echo $this->lang->line('total_tickets'); ?></h3>
<div class="table-responsive">
    <table width="100%" border="0" cellpadding="0" cellspacing="0"  class="ticket_table table table-bordered">
        <tbody>
            <tr>
                <th colspan="4" style="text-align: center;"><?=$this->lang->line('total_tickets_sales_details')?></th>
                <th colspan="5" style="text-align: center;"><?=$this->lang->line('total_profit_details')?></th>
            </tr>
            <tr>
                <th><?php echo $this->lang->line('tickets_sold'); ?></th>
                <th><?php echo $this->lang->line('free_tickets'); ?></th>
                <th><?php echo $this->lang->line('paid_tickets'); ?></th>
                <th><?php echo $this->lang->line('tickets_pending'); ?></th>
                <th><?php echo ucwords($this->lang->line('total_sales')); ?></th>
                <th><?php echo ucwords($this->lang->line('service_fee')); ?></th>
                <th><?php echo ucwords($this->lang->line('promotional_discount')); ?></th>
                <th><?php echo ucwords($this->lang->line('affilates')); ?></th>
                <th><?php echo ucwords($this->lang->line('net_profit')); ?></th>
            </tr>
            <tr>
                <td style="text-align: center;"><?= ($total_sold)? $total_sold : 0; ?></td>
                <td style="text-align: center;"><?= ($total_sold_free)? $total_sold_free : 0; ?></td>
                <td style="text-align: center;"><?= ($total_sold_paid)? $total_sold_paid : 0; ?></td>
                <td style="text-align: center;"><?= ($total_sold_pending)? $total_sold_pending : 0; ?></td>
                <td style="text-align: center;"><nobr class='currency'><?=($sale_service)? $this->general->price($sale_service->total_sales  + $sale_service->total_discount) : 0;?></nobr></td>
                <td style="text-align: center;"><nobr class='currency'><?=($sale_service)? $this->general->price($sale_service->total_fee) : 0;?></nobr></td>
                <td style="text-align: center;"><nobr class='currency'><?=($sale_service)? $this->general->price($sale_service->total_discount) : 0;?></nobr></td>
                <td style="text-align: center;"><nobr class='currency'><?=($sale_service)? $this->general->price($sale_service->affilate_total) : 0;?></nobr></td>
                <td style="text-align: center;"><nobr class='currency'><?=($sale_service)? $this->general->price($sale_service->total_price) : 0;?></nobr></td>
            </tr>
        </tbody>
    </table>
</div>
<h3><?php echo $this->lang->line('order_info'); ?></h3>
<div class="table-responsive">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="ticket_table table table-bordered sortable">
        <thead>
            <tr class="ticket_table_head">
                <th><?php echo $this->lang->line('attendee'); ?> #</th>            
                <th><?php echo $this->lang->line('quantity'); ?></th>            
                <th><?php echo $this->lang->line('ticket_name'); ?></th>
                <th><?php echo $this->lang->line('order_by'); ?></th>
                <th><?php echo $this->lang->line('price'); ?></th>
                <th><?php echo $this->lang->line('order_date'); ?></th>
                <th><?php echo $this->lang->line('payment_method'); ?></th>
                <th><?php echo $this->lang->line('payment_information'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($attendes): foreach ($attendes as $at): ?>
            <tr class="ticket_row">
                <td>
                    <a class="colorajax" onclick="showAttendees('<?=site_url('event/show_attendees/'.$at->id);?>')" href="javascript:void(0);"><?= $at->order_id ?></a>
                </td>            
                <td><nobr><?= $at->ticket_quantity ?></nobr></td>
                <td><nobr><?= $at->ticket_name ?></nobr></td>
                <td><strong><?= $at->email ?></strong></td>
                <td><nobr  class='currency'><?=$this->general->price($at->total)  ?></nobr></td>
                <td><nobr><?=$this->general->date_language(date('l, F j, Y  g:i A',strtotime($at->order_date))); ?></nobr></td>
                <td><nobr><?=strtoupper($at->transaction_method); ?></nobr></td>
                <td><nobr><?=strtoupper($at->payment_status); ?></nobr></td>
            </tr>
        <?php endforeach;
    endif; ?>
    
        </tbody>
    </table>
</div>
<div class="panel_footer">
    <a class="btn btn-primary btn-sm" href="javascript:void(0);" onclick="printAttendes('<?= site_url(); ?>','<?= $id ?>')"><?php echo $this->lang->line('attendees_list'); ?></a>
    <?php if($active_event){?>
    <a class="btn btn-success btn-sm" href="<?php echo site_url('event/add_attendees/' . $id); ?>" target="_blank"><?php echo $this->lang->line('add_attendee'); ?></a>
    <?php }?>
    <a class="btn btn-info btn-sm" href="<?php echo site_url('event/email_attendees/' . $id); ?>" target="_blank"><?php echo $this->lang->line('email_attendees'); ?></a>
    <div class="clearfloat"></div>
</div>
<script>
    function printAttendes(site_url, event_id)
    {
        url = site_url+"/event/printAttendes/"+event_id;
    
        newwindow=window.open(url,'name','resizable=yes,height=600,width=800,scrollbars=1,scroll=yes');
        if (window.focus) {newwindow.focus()}
   
    }
</script>

<h3><?php echo $this->lang->line('ticket_management'); ?></h3>
<div class="table-responsive">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="ticket_table table table-bordered">
        <tbody>
            <tr>
                <td colspan="<?=($active_event)? 6 : 5;?>" style="text-align: center;"><?php echo $this->lang->line('ticket_details'); ?></td>
                <td colspan="6" style="text-align: center;"><?php echo $this->lang->line('ticket_profit_details'); ?></td>
            </tr>
            <tr class="ticket_table_head">
                <th><?php echo $this->lang->line('name'); ?></th>
                <th><?php echo $this->lang->line('seats'); ?></th>
                <th><?php echo $this->lang->line('type'); ?></th>
                <th><?php echo $this->lang->line('ticket_price'); ?></th>
                <th><?php echo $this->lang->line('ticket_rate'); ?></th>            
                <?php if($active_event){?>
                <th style="text-align: center;"><?php echo $this->lang->line('actions'); ?></th>
                <?php }?>
                <th><?=$this->lang->line('ticket_sold') ?></th>            
                <th><?=$this->lang->line('total_sales') ?></th>
                <th><?=$this->lang->line('service_fee'); ?></th>
                <th><?=$this->lang->line('promotion_discount') ?></th>
                <th><?=$this->lang->line('affiliate') ?></th>
                <th><?=$this->lang->line('net_profit') ?></th>
            </tr>
    
            <?php
            $i=99999;
            if ($ticket_details):
                foreach ($ticket_details as $td):
                $price=  $td->price;  
                ?>
            <tr class="ticket_row_<?= $td->id ?>">
                <td id="<?= $td->id ?>"><strong><?= $td->name ?></strong></td>
                <td><nobr id="max_number<?=$td->id;?>"><?= $td->max_number ?></nobr></td>
                <td><nobr id="p_f<?=$td->id;?>"><?=(strtolower($td->paid_free)=="free")?"Free" :(($td->web_fee_include_in_ticket=='1')? "Paid": "Paid"); ?></nobr></td>
                <td id="pr_<?= $td->id ?>"><nobr class='currency' ><?=$this->general->price($td->ticket_price);  ?></nobr></td>
                <td id="p_<?= $td->id ?>"><nobr class='currency' ><?=$this->general->price($td->ticket_price - $td->website_fee); ?></nobr></td>            
                <?php if($active_event){?>
                <td style="text-align: center;">
                <nobr>
                    <a class="btn btn-xs btn-info" href="#edit_ticket_<?= $td->id ?>" data-toggle="modal"><?php echo $this->lang->line('edit'); ?></a>
                    <a class="btn btn-xs btn-primary" href="#seat_<?= $td->id ?>" data-toggle="modal"><?php echo $this->lang->line('add_remove_seats'); ?></a>
                    <a class="btn btn-xs btn-danger delete_ticket" href="javascript:void(0);" kds="<?= $td->id ?>" class="delete_ticket"><?php echo $this->lang->line('delete'); ?></a>
                </nobr>
                </td>
                <?php }?>            
                <?php
                    $query23 = $this->db->query("SELECT SUM(ticket_quantity) as total_tickets, SUM(ticket_quantity * fee) as service_fee, SUM(total) as total_sales, SUM(discount * ticket_quantity ) as promotion_discount, SUM(organizer_payment) as net_profit, SUM(event_referral_payment) as affiliate_total
                            FROM  `es_event_ticket_order` 
                            WHERE ticket_id =$td->id
                            AND payment_status = 'COMPLETE'
                            AND create_ticket = 'yes'
                            AND refund_id = 0
                            LIMIT 1");
                    $t_detail = $query23->row();
                    //echo $this->db->last_query();
                ?>
                <td><nobr><?=$t_detail->total_tickets?></nobr></td> <?php /*<?=$td->ticket_used?> // total used*/?>
                <td><nobr class='currency'><?=$this->general->price($t_detail->total_sales + $t_detail->promotion_discount); ?></nobr></td>
                <td><nobr class='currency'><?=$this->general->price($t_detail->service_fee); ?></nobr></td>
                <td><nobr class='currency'><?=$this->general->price($t_detail->promotion_discount); ?></nobr></td>
                <td><nobr class='currency'><?=$this->general->price($t_detail->affiliate_total); ?></nobr></td>
                <td><nobr class='currency'><?=$this->general->price($t_detail->net_profit); ?></nobr></td>
            </tr>
            <div class="modal fade" id="edit_ticket_<?= $td->id ?>" tabindex="-1" role="dialog" aria-labelledby="mainModalLabel" aria-hidden="true">        
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h2 class="no-margin" id="myModalLabel_<?= $td->id ?>"><?php echo $this->lang->line('edit_ticket'); ?></h2>
                        </div>
            			<div class="modal-body">
                        <form id="edit_ticket<?= $td->id ?>" action="" method="post" name="add_remove_seats" class="clrfix form-horizontal">
                            <div class="form-group">
                                <label class="form-label" for="contact_name"><?php echo $this->lang->line('ticket_name'); ?>: <span class="required_field">*</span> </label> 
                                <div class="col-md-4">
                                    <input type="text" id="from_name" value="<?= $td->name ?>" name="from_name"  class="required"/>
                                </div>
                                <div class="col-md-4">
                                    <select id="paid_free_select0" name="paid_free_select0" style="width: 100px;" onchange="change_paid_free(this);" index='0'>
                                        <option <?php if(strtolower($td->paid_free)=="paid"){echo "selected";}?> value="paid"><?php echo $this->lang->line('paid'); ?></option>
                                        <option <?php if(strtolower($td->paid_free)=="free"){echo "selected";}?> value="free"><?php echo $this->lang->line('free'); ?></option>
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label"><?php echo $this->lang->line('starts_on'); ?>: </label>
                                <div class="col-md-8">
                                    <input type="text" name="ticket_start_date0" id="ticket_start_date<?=$i ?>" class="ticket_start_date datepicker" value="<?= $td->start_date; ?>" style="width: 200px;" index="<?=$i ?>" onclick="set_ticket_start_date(this);"/>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><?php echo $this->lang->line('ends_on'); ?>:</label>
                                <div class="col-md-8">
                                    <input type="text" name="ticket_end_date0" id="ticket_end_date<?=$i ?>" class="ticket_end_date datepicker" value="<?= $td->end_date; ?>" style="width: 200px;" index="<?=$i ?>" onclick="set_ticket_end_date(this);"/>
                                </div>
                                <div class="clearfix"></div>
                            </div>                        
                            <div class="form-group">
                                <label class="form-label"><?=CURRENCY_SYMBOL;?></label>
                                <div class="col-md-8">
                                    <input type="text" name="ticket_your_price0" value="<?=$this->general->price_clean($td->price); ?>" style="width: 100px;" class="ticket_your_price number" id="ticket_your_price<?=$i ?>" index='<?=$i ?>' onkeyup="price_display(this);" />
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            
                            <div class="form-group">
                                <input type="checkbox" name="web_fee_included_in_ticket0" onclick="price_display(this);" <?php if($td->web_fee_include_in_ticket==1) echo "checked" ?>  id="web_fee_included_in_ticket<?=$i ?>" index="<?=$i ?>"/>
                                <em><?php echo $this->lang->line('uncheck_cost_ticket'); ?>.</em>
                                <div class="clearfix"></div>
                            </div>
                            
                            <div class="form-group">                        
                                <label class="form-label"><?php echo $this->lang->line('web_free'); ?>:</label>
                                <div class="col-md-8">
                                <input type="text" style="width: 100px;" value="<?=$this->general->price_clean($td->website_fee) ?>" disabled="disabled" name="ticket_website_fee0" id="ticket_website_fee<?=$i ?>" index="<?=$i ?>" />
                                <em><?php echo $this->lang->line('note'); ?>:<?php echo $this->lang->line('web_charge'); ?> <?= WEBSITE_FEE; ?>% +  <?= $this->general->price(WEBSITE_FEE_PRICE); ?>. </em>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="form-group">
                            <?php if($td->web_fee_include_in_ticket==1) $price=$td->website_fee+$td->price ?>
                                <label class="form-label"><?php echo $this->lang->line('ticket_price'); ?>:</label>
                                <div class="col-md-8">
                                    <input type="text" name="ticket_main_price0" style="width: 100px;" value="<?=$this->general->price_clean($td->ticket_price) ?>" disabled="disabled" id="ticket_main_price<?=$i ?>" index="<?=$i ?>" />
                                </div>
                                <div class="clearfix"></div>
                            </div>
            			</div>				
                        <div class="modal-footer">
                            <input type="hidden" id="ticket_id" name="ticket_id" value="<?= $td->id ?>" >
                            <input type="hidden" id="ticket_name" name="ticket_name" value="<?= $td->name ?>" >
                            <input type="hidden" id="form_contact_organizer_hidden" name="contact_organizer_submit" value="1">
                            <input type="submit" class="btn btn-sm btn-success submit" name="submit" id="searchsubmit" value="<?=$this->lang->line('update')?>"/>
                            <button class="btn btn-sm btn-danger" data-dismiss="modal" aria-hidden="true"><?php echo $this->lang->line('cancel'); ?></button>
                            
                        </div>
                        </form>
                    </div>
                </div>			
            </div>
            <script>       
                $("#edit_ticket<?= $td->id ?>").validate({
                    submitHandler: function(form) {
                        $(form).ajaxSubmit({
                            url:"<?php echo site_url('event/edit_ticket_name'); ?>",
                            type:"GET",
                            success: function(r){
                                $('#searchsubmit').attr('value', '<?=$this->lang->line('update')?>');
                                if(r==1){
                                    alert('48 hour exceed');
                                    $('#edit_ticket_<?= $td->id ?>').modal('hide');
                                    return false;
                                }
                                //alert(r);
                                //console.log(r);
                                //return false;                            
                                var n=r.split("@#@");
                                // $('.modal-body').find("input[type=text], textarea").val("");
                                if(n[2]){
                                    $("#"+n[1]).html('<strong>'+n[0]+'</strong>');
                                    $("#p_"+n[1]).html('<strong>'+n[2]+'</strong>');
                                    $("#pr_"+n[1]).html('<strong>'+n[3]+'</strong>');
                                    $("#p_f"+n[1]).html('<strong>'+n[4]+'</strong>');
                                    $('#edit_ticket_'+n[1]).modal('hide'); 
                                }
                                else {
                                    $("#"+n[1]).html('<strong>'+n[0]+'</strong>')
                                    $('#edit_ticket_'+n[1]).modal('hide');  
                                }
                                
                                alert('<?=$this->lang->line('update_successfull_message')?>');
                                // $('#myModal3').modal('show');
                                
                            },
                            beforeSend:function(){
                                $('#searchsubmit').attr('value', '<?=$this->lang->line('please_wait')?>')
                            }
                        });
                    
                        return false;
                    }
                });
            </script>
            <div class="modal fade" id="seat_<?= $td->id ?>" tabindex="-1" role="dialog" aria-labelledby="mainModalLabel" aria-hidden="true">            
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h2 class="no-margin" id="myModalLabel_<?= $td->id ?>"><?php echo $this->lang->line('add_remove_seats'); ?></h2>
                        </div>
                        <form id="add_remove_seats<?= $td->id ?>" action="" method="post" name="add_remove_seats" class="clrfix">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="form-label"><?php echo $this->lang->line('ticket_quantity'); ?>: <span class="required_field">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" id="max_number_<?=$td->id;?>"value="" name="from_name"  class="required"/>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" id="ticket_id" name="ticket_id" value="<?= $td->id ?>" >
                                <input type="hidden" id="form_contact_organizer_hidden" name="contact_organizer_submit" value="1"/>
                                <input type="submit" class="submit btn btn-sm btn-success" name="submit" id="searchsubmit" value="<?=$this->lang->line('update')?>"/>
                                <button class="btn btn-sm btn-danger" data-dismiss="modal" aria-hidden="true"><?php echo $this->lang->line('cancel'); ?></button>
                                <?php /*<script src="http://malsup.github.com/jquery.form.js"></script> */?>
                                  
            
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <script>                
                $("#add_remove_seats<?= $td->id ?>").validate({
                    submitHandler: function(form) {
                        $(form).ajaxSubmit({
                            url:"<?php echo site_url('event/update_seats'); ?>",
                            data:'ticket_id='+<?=$td->id;?>,
                            type:"GET",
                            success: function(r){
                                max_val = $("#max_number_<?=$td->id;?>").val();
                                if(r=='empty'){
                                    alert("<?=$this->lang->line('empty_error_msg')?>");
                                }else if(r=='value_exceed'){
                                    alert("<?=$this->lang->line('value_exceed_error_msg')?>");
                                    $('#seat_<?= $td->id ?>').modal('hide');
                                }else if(r=='successfully'){
                                    alert("<?=$this->lang->line('update_successfull_message')?>");
                                    $("#max_number"+<?=$td->id ?>).html(max_val);
                                    $('#seat_<?= $td->id ?>').modal('hide');
                                }
                                $('#searchsubmit').attr('value', '<?=$this->lang->line('update')?>');
                                return false;
                            },
                            beforeSend:function(){
                                $('#searchsubmit').attr('value', '<?=$this->lang->line('please_wait')?>');
                            }
                        });
                    
                        return false;
                    }
                });
                </script>        
        <?php $i++;endforeach;
        endif; ?>
        </tbody>
    </table>
</div>
<?php if($active_event){?>
<div class="">
    <a class="btn btn-primary btn-sm" href="javascript:void(0)" onclick="$('#create_ticket').toggle('slow')"><?php echo $this->lang->line('add_ticket'); ?></a>
</div>

<div  id="create_ticket" style="display: none;">    
    <fieldset>   
        <legend><?php echo $this->lang->line('create_tickets'); ?></legend>
        <form id="add_new_ticket"  method="post">                   
            <div class="control-group">
                <input type="hidden" value="2" id='count' name="ticket_count" />
                <input type="button" value="<?=$this->lang->line('add_ticket')?>" class="btn" onclick="addNewTicketRow('ticketTable')"  />
                <input type="button" value="<?=$this->lang->line('remove')?>" class="btn" onclick="deleteNewTicketRow('ticketTable')" />
                <br clear="all" /> <br />
                <table id="ticketTable" border="0" cellpadding="0" cellspacing="0" width="100%" class="table_rows_add table table-striped">  
                    <tbody>                    
                        <tr>    
                            <td width="1"></td>
                            <td><?php echo $this->lang->line('paid_free'); ?></td>
                            <td><?php echo $this->lang->line('ticket_name'); ?>:</td>
                            <td><?php echo $this->lang->line('ticket_quantity'); ?>:</td>
                            <td><?php echo $this->lang->line('ticket_price'); ?></td>
                        </tr>                
                      
                        <tr>
                            <td align="right"><input type="checkbox" class="chk" name="chk"/></td>
                            <td>
                                <select id="paid_free_select0" name="paid_free_select0" style="width: 100px;" onchange="change_paid_free(this);" index='0'>
                                    <option value="paid"><?php echo $this->lang->line('paid'); ?></option>
                                    <option value="free"><?php echo $this->lang->line('free'); ?></option>
                                </select>
                            </td>                    
                            <td>
                                <input type="text" class="required" name="ticket_name0" id="event_form_ticket_name0" index="0" value="<?php echo set_value('ticket_name0'); ?>" oname="ticket_name"/>
                                <?php echo form_error("ticket_name0") ?>
                            </td>
                            <td>
                                <input type="text" class="number required" name="ticket_quantity0" id="event_form_ticket_quantity0" index="0" value="<?php echo set_value('ticket_quantity0'); ?>" oname="ticket_quantity"/>
                                <br /><br />                        
                                <?php echo $this->lang->line('starts_on'); ?>: 
                                <br />
                                <input type="text" name="ticket_start_date0" id="ticket_start_date0" class="ticket_start_date datepicker" value="<?= $this->general->get_date_ar(date('Y-m-d h:i a')); ?>" style="width: 200px;" index="0" onclick="set_ticket_start_date(this);" oname="ticket_start_date"/>
                                <br />
                                <?php echo $this->lang->line('ends_on'); ?>: 
                                <br />
                                <?php
                                $last_date = ($data_event->date_id == 0)? $data_event->end_date : $this->general->get_value_from_id("es_event_date", $data_event->date_id, "end");
                                ?>
                                <input type="text" name="ticket_end_date0" id="ticket_end_date0" class="ticket_end_date datepicker" value="<?= $this->general->get_date_ar(date('Y-m-d h:i a', strtotime($last_date))); ?>" style="width: 200px;" index="0" onclick="set_ticket_end_date(this);" oname="ticket_end_date"/>
                            </td>
                            <td>
                                <?php
                                $convertor = '1';
                                ?>
                                <input name="ticket_currency0" type="hidden" id="ticket_form_currency0" index='0' value="<?= CURRENCY_SYMBOL ?>" oname="ticket_currency" />
                                <?= CURRENCY_SYMBOL ?>
                                <input type="text" name="ticket_your_price0" value="" style="width: 100px;" class="ticket_your_price number" id="ticket_your_price0" value="<?php echo set_value('ticket_your_price0'); ?>" index='0' onkeyup="price_display(this);" oname="ticket_your_price" />
                                <br />
                                <input type="checkbox" name="web_fee_included_in_ticket0" onclick="price_display(this);"  id="web_fee_included_in_ticket0" index="0"/>
                                <em><?php echo $this->lang->line('uncheck_ticket'); ?>.</em>
                                <br clear="all" /><br />
                                <?php echo $this->lang->line('web_free'); ?>: <em><a href="<?=site_url('page/pricing')?>" target="_blank"><?php echo $this->lang->line('fees'); ?></a></em>
                                <br />
                                <input type="text" style="width: 100px;" value="" disabled="disabled" name="ticket_website_fee0" id="ticket_website_fee0" index="0" oname="ticket_website_fee" />                                
                                <br />
                                <?php echo $this->lang->line('ticket_price'); ?>:
                                <br />
                                <input type="text" name="ticket_main_price0" style="width: 100px;"  disabled="disabled" id="ticket_main_price0" index="0" oname="ticket_main_price"  />
                            </td>
    
                        </tr>
                    </tbody>
                </table>
                <div class="margin-bottom-10">
                <input type="submit" class="submit btn btn-success " name="submit" id="saveWeeklyEvent" value="Save"/>
                </div>
            </div>
        </form>            
    </fieldset>
</div>
<?php }?>

<script>
$(document).ready(function(){
    $("#add_new_ticket").validate(); 
});
</script>

<!-- delete ticket start -->
<script>
$(".delete_ticket").click(function(){
    if(confirm("<?=$this->lang->line('are_you_sure');?>")){
        var id=$(this).attr('kds')
        //alert(id);
        $(this).parent().append("<span><img src ='<?=MAIN_IMG_DIR_FULL_PATH."ajax-loader.gif";?>'/></span>");

        $.ajax({
            url:'<?php echo site_url('event/delete_ticket'); ?>',
            type:'POST',
            data:'id='+id,
            success:function(r){
                if(r==0){
                    alert('<?=$this->lang->line('ticket_not_deleted');?>')
                } else {
                    //alert(r);
                    alert('<?=$this->lang->line('ticket_delete_msg');?>');
                    $(".ticket_row_"+id).html("").remove();
                    ln = $("#event_edit_ticket_lists tr").length;
                    //alert(ln);
                    if(ln=='1')
                        $("#event_edit_ticket_lists").html("").hide();
                }
                
                $(this).parent().find('span').remove();
            }
        })    
    }else{
        return false;
    }    
});
</script>
<!-- delete ticket end -->
<script>
    maxDateOfTicket = "<?= ($data_event->date_id == 0)? $data_event->end_date : $this->general->get_value_from_id("es_event_date", $data_event->date_id, "end");?>"; //"$("#start_date").val();
        
    $('.ticket_start_date').each(function(){
        $(this).datetimepicker({
            timeFormat: "hh:mm tt",
            maxDate: maxDateOfTicket,
            dateFormat: "yy-mm-dd"
        });
        
    });
    $('.ticket_end_date').each(function(){
        $(this).datetimepicker({
            timeFormat: "hh:mm tt",
            maxDate: maxDateOfTicket,
            dateFormat: "yy-mm-dd",
            onClose: function( selectedDate ) {
                $(this).datetimepicker( "option", "maxDate", maxDateOfTicket);
                
            }
        });
        
    });
    function set_ticket_start_date(input)
    {    
        index = $(input).attr('index');        
        $( "#ticket_start_date"+index ).datetimepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            timeFormat: "hh:mm tt",
            maxDate: maxDateOfTicket,
            dateFormat: "yy-mm-dd",
            onClose: function( selectedDate ) {
                alert(selectedDate);
                $( "#ticket_end_date"+index ).datetimepicker( "option", "minDate", selectedDate );
            }
        });
        
    }

    function set_ticket_end_date(input)
    {   
        index = $(input).attr('index');
        $( "#ticket_end_date"+index ).datetimepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            timeFormat: "hh:mm tt",
            maxDate: maxDateOfTicket,
            dateFormat: "yy-mm-dd",
            onClose: function( selectedDate ) {
                alert(selectedDate);
                $( "#ticket_start_date"+index ).datetimepicker( "option", "minDate", selectedDate );
            }
        });
    }
</script>
<!--add row ticket -->
<script>
    $("#count").val('2');         
    
    currentIndex = 0;
    // to add new row
    function addNewTicketRow(tableId){
        currentIndex ++;
        var secondlast = $("#"+tableId+' tr:last');
        var newClone = secondlast.clone();
        // find all the inputs within your new clone and for each one of those
        newClone.find('td').each(function() {
            jQuery(this).children("input[type='checkbox']").attr("name", "chk"+currentIndex).removeAttr('checked');
            
            jQuery(this).children("input[name='ticket_name"+(currentIndex-1)+"']").attr("name", "ticket_name"+currentIndex).attr("id", "event_form_ticket_name"+currentIndex).val('').attr('index', currentIndex);
            
            jQuery(this).children("input[name='ticket_quantity"+(currentIndex-1)+"']").attr("name", "ticket_quantity"+currentIndex).attr("id", "event_form_ticket_quantity"+currentIndex).val('').attr('index', currentIndex);
            
            jQuery(this).children("input[name='ticket_start_date"+(currentIndex-1)+"']").attr("name", "ticket_start_date"+currentIndex).attr("id", "ticket_start_date"+currentIndex).attr("index", currentIndex).attr('onclick',"set_ticket_start_date(this);").attr('class','ticket_start_date datepicker');
                        
            jQuery(this).children("input[name='ticket_end_date"+(currentIndex-1)+"']").attr("name", "ticket_end_date"+currentIndex).attr("id", "ticket_end_date"+currentIndex).attr("index", currentIndex).attr('onclick',"set_ticket_end_date(this);").attr('class','ticket_end_date datepicker ');
            
            jQuery(this).children("input[name='ticket_currency"+(currentIndex-1)+"']").attr("name", "ticket_currency"+currentIndex).attr("id", "ticket_form_currency"+currentIndex).attr("index", currentIndex);
            
            
            jQuery(this).children("input[name='ticket_your_price"+(currentIndex-1)+"']").attr("name", "ticket_your_price"+currentIndex).attr("id", "ticket_your_price"+currentIndex).attr("index", currentIndex).prop('disabled', false).removeAttr('disabled').val('');
            
            jQuery(this).children("input[type='checkbox']").attr("name", "web_fee_included_in_ticket"+currentIndex).attr("id", "web_fee_included_in_ticket"+currentIndex).attr("index", currentIndex);            
            
            jQuery(this).children("input[name='ticket_website_fee"+(currentIndex-1)+"']").attr("name", "ticket_website_fee"+currentIndex).attr("id", "ticket_website_fee"+currentIndex).attr("index", currentIndex);
            
            jQuery(this).children("input[name='ticket_main_price"+(currentIndex-1)+"']").attr("name", "ticket_main_price"+currentIndex).attr("id", "ticket_main_price"+currentIndex).attr("index", currentIndex);
            
            jQuery(this).children("select[name='paid_free_select"+(currentIndex-1)+"']").attr("name", "paid_free_select"+currentIndex).attr("id", "paid_free_select"+currentIndex).attr("index", currentIndex);
           
            console.log(currentIndex);
             
        });
        // insert after is I assume what you want
        newClone.insertAfter(secondlast);
        total_ticket_row_count(tableId);
    }
    
    function rearrangeAttributesHere(tableId){
        jQuery("#"+tableId+" tbody tr").each(function(){
            // to reassign name            
            var cIndex = jQuery(this).index();
            
            console.log(cIndex);
            if(cIndex == '0')
                return;
            currentIndex = cIndex - 1;
            jQuery(this).children().children("input[type='checkbox']").attr("name", "chk"+currentIndex);
            
            jQuery(this).children().children("select").attr("name", "paid_free_select"+currentIndex).attr('id', "paid_free_select"+currentIndex).attr('index', currentIndex);
            
            jQuery(this).children().children("input[oname='ticket_name']").attr("name", "ticket_name"+currentIndex).attr("id", "event_form_ticket_name"+currentIndex).attr("index", currentIndex);
            
            jQuery(this).children().children("input[oname='ticket_quantity']").attr("name", "ticket_quantity"+currentIndex).attr("id", "event_form_ticket_quantity"+currentIndex).attr("index", currentIndex);

            jQuery(this).children().children("input[oname='ticket_start_date']").attr("name", "ticket_start_date"+currentIndex).attr("id", "ticket_start_date"+currentIndex).attr("index", currentIndex).attr('onclick',"set_ticket_start_date(this);").attr('class','ticket_start_date datepicker');
                        
            jQuery(this).children().children("input[oname='ticket_end_date']").attr("name", "ticket_end_date"+currentIndex).attr("id", "ticket_end_date"+currentIndex).attr("index", currentIndex).attr('onclick',"set_ticket_end_date(this);").attr('class','ticket_end_date datepicker ');
            
            jQuery(this).children().children("input[oname='ticket_currency']").attr("name", "ticket_currency"+currentIndex).attr("id", "ticket_form_currency"+currentIndex).attr("index", currentIndex);
            
            
            jQuery(this).children().children("input[oname='ticket_your_price']").attr("name", "ticket_your_price"+currentIndex).attr("id", "ticket_your_price"+currentIndex).attr("index", currentIndex);
            
            jQuery(this).children().children("input[type='checkbox']").attr("name", "web_fee_included_in_ticket"+currentIndex).attr("id", "web_fee_included_in_ticket"+currentIndex).attr("index", currentIndex);            
            
            jQuery(this).children().children("input[oname='ticket_website_fee']").attr("name", "ticket_website_fee"+currentIndex).attr("id", "ticket_website_fee"+currentIndex).attr("index", currentIndex);
            
            jQuery(this).children().children("input[oname='ticket_main_price']").attr("name", "ticket_main_price"+currentIndex).attr("id", "ticket_main_price"+currentIndex).attr("index", currentIndex);
            
            jQuery(this).children().children("select[oname='paid_free_select']").attr("name", "paid_free_select"+currentIndex).attr("id", "paid_free_select"+currentIndex).attr("index", currentIndex);
                        
            
        });
        // to uncheck checkbox
        jQuery("#"+tableId+" tr:last").children().children("input[type='text']").attr("checked", "false");
               
    };
        
    // to remove selected row
    function deleteNewTicketRow(tableId){
        var rows = jQuery("#"+tableId+" tr").length;
        var chek = jQuery("#"+tableId+" input.chk:checked").length + 1;
        console.log(rows);
        console.log(chek);
        if (chek === rows) {
            alert ("You cant delete all the rows")
        } else {
            jQuery("#"+tableId+" input.chk:checked").each(function () {
                jQuery(this).parent().parent().remove();
            });
        }
        rearrangeAttributesHere(tableId);
        total_ticket_row_count(tableId);
    }
    function total_ticket_row_count(tableId){
        count = 0;
        jQuery("#"+tableId+" tbody tr").each(function(){
            count++;                
        });
        $("#count").val(count);         
    }        
    
</script>
<!-- ticket end -->
<script>
    function change_paid_free(selector)
    {
        index = $(selector).attr('index');
        paid = $(selector).val();
        if(paid=='free'){
            $("#ticket_your_price"+index).prop('disabled', true);
            $("#ticket_your_price"+index).val('0');
            $("#ticket_website_fee"+index).val('0');
            $("#ticket_main_price"+index).val('0');
        }        
        else{
            $("#ticket_your_price"+index).prop('disabled', false);
        }    
        
    
    }
</script>
<script>
    web_fee_rate = parseFloat("<?= WEBSITE_FEE ?>") ;
    web_fee_price = parseFloat("<?= WEBSITE_FEE_PRICE * 1; ?>") ;

    function price_display(myprice)
    {
    //alert('hello');
        index = $(myprice).attr('index');    
        your_price = $("#ticket_your_price"+index).val();
        your_price = parseFloat(your_price);
    
        //old_we_fee = web_fee_rate /100 * your_price + web_fee_price;
        web_fee = your_price - ((your_price - web_fee_price)/(1 + (web_fee_rate /100))); 
        web_fee = parseFloat(web_fee);    
         
        $('#ticket_website_fee'+index).val(parseFloat(web_fee).toFixed(2));
        //alert(index);
        //flag = document.getElementById("web_fee_included_in_ticket"+index).checked; if ($('#web_fee_included_in_ticket'+index).is(":checked"))    
        if($("input[id='web_fee_included_in_ticket"+index+"']").is(":checked"))    
            ticket_price = your_price;
        else{
            ticket_price  = your_price + web_fee;  
            ticket_price = parseFloat(ticket_price).toFixed(2)
        }
                    
        $('#ticket_main_price'+index).val(ticket_price); 
    }
</script>


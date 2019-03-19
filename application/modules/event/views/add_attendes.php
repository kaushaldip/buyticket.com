<div class="row">
    <div class="col-md-12">                
        <h3 class="no-margin-top"><?php echo $this->lang->line('add_attendess'); ?></h3>
        <div class="alert alert-warning"> 
            <?php echo $this->lang->line('add_tickets_purchased'); ?>
        </div>
        
        <div class="subsection">
            <form name="ticketForm" action="" method="post" id="fieldsform_addattendees" class="fieldsform form-horizontal">
                <table class="ticket_table table table-bordered">
                    <thead>
                        <tr>
                            <th>
                                <?php echo $this->lang->line('ticket_type'); ?>
                            </th>
                            <th align="center">
                                <?php echo $this->lang->line('price'); ?> *
                            </th>
                            <th align="center">
                                <?php echo $this->lang->line('fee'); ?>
                            </th>
                            <th align="center">
                                <?php echo $this->lang->line('quantity'); ?>
                            </th>
                            <th align="center">
                                <?php echo $this->lang->line('amount_paid'); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($ticket_details): foreach ($ticket_details as $td): ?>
                                <tr class="ticket_row">
                                    <td>
                                        <?= $td->name ?>
                                    </td>
                                    <td align="center">                                
                                        <?=$this->general->price($td->price)  ?>
                                    </td>
                                    <td align="center">                                
                                        <?=$this->general->price($td->payment_method_fee); ?>
                                    </td>
                                    <td align="center">
                                        <input type="hidden" name="ticket_id[]" id="first_id" value="<?= $td->id ?>"/>
                                        <input type="hidden" name="ticket_quantity_total_18291541" id="ticket_quantity_total_18291541" value="100"/>
                                        <input type="hidden" name="ticket_quantity_sold_18291541" id="ticket_quantity_sold_18291541" value="<?= $this->general->price_clean($td->price) ?>"/>
                                        <input type="text" maxlength="5" class="gross_price input_qty required digits" name="ticket_no[]" id="quant_18291541" value=""/>
                                    </td>
                                    <td align="center">
                                        <?=CURRENCY_CODE?>
                                        <input type="hidden" name="cost_18291541" id="cost_18291541" value="0.00"/>
                                        <input type="text" class="ind_total" kds="<?= $this->general->price_clean($td->paid_free) ?>" maxlength="7" name="gross_18291541" id="gross_18291541" value=""/>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif ?>
                    </tbody>
                    <tfoot>
                        <tr class="ticket_table_foot">
                            <td colspan="2">
                                <span class="disclaimer">
                                </span>
                            </td>
                            <td align="right">
                                <label for="gross">
                                    <?php echo $this->lang->line('total_paid'); ?>
                                </label>
                            </td>
                            <td colspan="2" align="center">
                                <?=CURRENCY_CODE?>
                                <input type="text" class="total_main_p" maxlength="7" onkeyup="CheckNumeric(this.name,'F');" name="gross" disabled="disabled" id="gross" value=""/>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <script>
                    $(".gross_price").keyup(function() {
        
                        var val1 = $(this).val();
                        var cost = $(this).prev().val();
                        var total = val1 * cost;
                        var tottal = 0;
                        $(this).parent().next().children('.ind_total').val(total);
                        $('.ind_total').each(function() {
                            var tot = $(this).val();
        
        
                            tottal += Number(tot);
                        })
                        $('.total_main_p').val(tottal);
                        var main_tot = $('.total_main_p').val();
                        if (main_tot > 0) {
                            $("#order_paid_btn").val('Order Now');
                        } else {
                            $("#order_paid_btn").val('Register');
                        }
                    });
                </script>
                <?php /*
                <!--<span class="form_row">
                <label for="pp_payment_status">Payment Type:</label>
                <select id="pp_payment_status" name="pp_payment_status" onclick="javascript:UpdateGross();">
                <option value="check">Paid with check
                </option><option value="cash">Paid with cash
                </option><option value="paypal">Paid directly online with PayPal
                </option><option value="online">Paid online non-PayPal
                </option><option value="googlem"> Paid by Google Checkout
                </option><option value="comp">Complimentary
                </option><option value="free">No payment necessary
                </option><option value="other">Other
                </option></select>
                </span>-->
                */?>
                <?php if($data_event->date_id !=0){ ?>
                    <span class="pull-right">              
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
                                if(date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime($date_range->end_date. " + $diff seconds")))
                                    continue; //checking last date with today, exclude                            
                                $datearr[] = $dt->format( "l Y-m-d H:i:s" ).", ".date('l Y-m-d H:i:s', strtotime($date_range->end_date. " + $diff seconds"));
                            endforeach;    
                        }                    
                        else if($date_range->type=='Weekly'){
                            $Narr = explode(',',$date_range->repeat_weekday);
                            $interval = DateInterval::createFromDateString("1 day");
                            $period = new DatePeriod($begin, $interval, $end);
                            
                            foreach ( $period as $dt ):                        
                                if(date('Y-m-d H:i:s') > date($dt->format( "Y-m-d H:i:s" ). " + $diff seconds"))
                                    continue; //checking last date with today, exclude
                                    
                                if (in_array($dt->format("N"),$Narr))
                                    $datearr[] = $dt->format( "l Y-m-d H:i:s" ).", ".date('l Y-m-d H:i:s', strtotime($dt->format( "l Y-m-d H:i:s" ). " + $diff seconds"));
                            endforeach;
                        }                    
                        else if($date_range->type=="Monthly"){
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
                                    if(date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s',strtotime($dt->format( "Y-m-d H:i:s" )."$r $d")). " + $diff seconds")))
                                        continue; //checking last date with today, exclude
                                        
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
                        <select id="tickets_date" name="tickets_date" class="required" title="*">
                            <option value=""><?php echo $this->lang->line('select_date_time'); ?></option>
                            <?php foreach($datearr as $d): ?>
                            <option value="<?=$d;?>"><?=$d; ?></option>
                            <?php endforeach;?>                                        
                        </select>
                    </span>
                <?php } ?>
                <div class="form-group">
                    <label class="form-label"><?php echo $this->lang->line('promotion_code'); ?>:</label>
                    <div class="col-md-6">
                        <input name="promotional_code" type="text" class="form-control" />
                    </div>
                </div>
                <div class="form-group">                    
                    <label class="form-label"><?php echo $this->lang->line('notes'); ?>:</label>
                    <div class="col-md-6">
                        <textarea name="notes" class="form-control"></textarea>
                    </div>
                </div>
                <div class="action_buttons lower form-actions margin-bottom-10">
                    <label class="form-label">&nbsp;</label>
                    <input type="submit" name="order_btn" value="Register" id="order_paid_btn" class="btn btn-success"/>
                </div>
                <div class="clearfix"></div>
                
            </form>
        </div>
        <script>
        $("#fieldsform_addattendees").validate();
        </script>
    </div>
</div>
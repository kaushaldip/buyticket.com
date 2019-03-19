<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>jquery.min.js"></script>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="ticket_table" style="border-collapse: collapse;">
    <tbody>
    <tr class="ticket_table_head">
        <th><?php echo $this->lang->line('order_id'); ?> #</th>
        <th><?php echo $this->lang->line('attendee'); ?></th>
        <th><?php echo $this->lang->line('quantity'); ?></th>
        <th><?php echo $this->lang->line('ticket_name'); ?></th>
        <th><?php echo $this->lang->line('price'); ?></th>
        <th><?php echo $this->lang->line('date_attending'); ?></th>
    </tr>
    <?php if($attendes): foreach ($attendes as $at):?>
    <tr class="ticket_row">
        <td><?=$at->order_id; ?></td>
        <td>
            <strong style="cursor: pointer; text-decoration: underline;" onclick="$('#tr_<?=$at->id;?>').toggle();"><?=$this->lang->line('view_detail')?></strong>
        </td>
        <td><nobr><?=$at->ticket_quantity ?></nobr></td>
        <td><nobr><?= $this->general->get_single_record('es_event_ticket','name','id',$at->ticket_id);  ?></nobr></td>
        <td><nobr></nobr><nobr><?=$this->general->price($at->total); ?></nobr></td>
        <td><nobr><?=date('l, F j, Y  g:i A',strtotime($at->order_date)) ?></nobr></td>
    </tr>
    <tr style="display: none;" id="tr_<?=$at->id;?>">        
        <td colspan="6">        
            <?php                                      
            $ar = json_decode($at->order_form_detail, true);
            for($j = 1; $j<=$at->ticket_quantity; $j++){
            ?>
            <div style="background: #ddd; padding: 0 8px;">
            <?php
                echo "<h5>#".$j." ".$this->lang->line('contact_information')."</h5>";
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
                if((isset ($ar['billing_country'.$j])) || (isset ($ar['billing_address'.$j])) || (isset ($ar['billing_address2'.$j])) || (isset ($ar['street_address'.$j])) || (isset ($ar['billing_city'.$j])) || (isset ($ar['billing_state'.$j])) || (isset ($ar['billing_postal_code'.$j])) ){
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
                
                if((isset ($ar['work_job_title'.$j])) || (isset ($ar['work_company'.$j])) || (isset ($ar['work_address'.$j])) || (isset ($ar['work_number'.$j])) || (isset ($ar['work_city'.$j])) || (isset ($ar['work_state'.$j])) || (isset ($ar['work_country'.$j])) || (isset ($ar['work_zip'.$j])) || (isset ($ar['gender'.$j])) ){
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
            ?>
            </div>
            <?php
            }
            ?>        
        </td>
    </tr>
    <?php endforeach; endif;?>    
    </tbody>
</table>
<?php if($this->session->flashdata('message')){
    echo '<div align="center" class="error">';
            echo "<div class='message'>".$this->session->flashdata('message')."</div>";
    echo '</div>';
}  ?>
<?php if(is_ajax()){ ?>
<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>jquery.min.js"></script>
<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>jquery.validate.js"></script>
<?php /* <script src="http://malsup.github.com/jquery.form.js"></script> */?> 
<script type="text/javascript" src="<?php echo MAIN_JS_DIR_FULL_PATH;?>malsup.jquery.form.min.js"></script>

<?php } ?>
<div class="row-fluid" >
	<div class="span">   
    <form id="event_order_register" class="form-horizontal" method="post" action=""> 	
        <!-- order summary start -->
        <?php /*
        <div>
            <p>
                Fill the form before 2 hours of time to claim your ticket 
            </p>
        </div>
        */ ?>
        <!-- order summary end -->
        
        <div class="box" style="margin: 0 !important;">
            <h1><?php echo $this->lang->line('registration_information'); ?></h1>
            
            <div class="box_content" id="event_order_bank_page">
                <h5 class="for_h5"><?=$this->lang->line('orderpayment_message')." : #".$order_id;?></h5>
                <legend><?php echo $this->lang->line('payment_made_from'); ?></legend>
                
                <div class="control-group">
                    <label class="control-label"><?php echo $this->lang->line('bank_name'); ?>: *</label>
                    <div class="controls">
                        <input class="input-medium required" title="*" type="text" name="bank_name_from" value="" />
                        <?=form_error('bank_name_from') ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><?php echo $this->lang->line('account_holder_name'); ?>: *</label>
                    <div class="controls">
                        <input class="input-medium required" title="*" type="text" name="account_holder_name" value="" />
                        <?=form_error('account_holder_name') ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"><?php echo $this->lang->line('amount'); ?>: *</label>
                    <div class="controls">
                        <?php /*
                        <select name="currency" class="input-small">
                            <option value="USD">USD</option>
                            <option value="SAR">SAR</option>
                        </select>
                        */?>
                        <?=CURRENCY_CODE;?>
                        <input class="input-medium required number" title="*" type="text" name="amount" value="" />
                        <?=form_error('amount') ?>
                        <nobr>(<?=$this->lang->line('to_pay')?> :<?=$this->general->price($total_amount->due);?> )</nobr>
                    </div>
                </div> 
                
                <legend><?php echo $this->lang->line('payment_made_to'); ?></legend>
                
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <select name="bank_name_to" class="required input-medium" title="*">
                            <option value=""><?=$this->lang->line('select_option') ?></option>
                            <?php if($banks){?>
                            <?php foreach($banks as $bank): ?>
                                
                                <option value="<?=$bank->bank_name ?>"><?=$bank->bank_name ?></option>
                                                               
                            <?php endforeach; ?>
                            <?php } ?>
                        </select>                        
                    </div>
                </div>  
                
                <div class="form-actions">  
                    <input type="submit" name="register" value="<?=$this->lang->line('complete_reg'); ?>" class="btn btn-success" id="register_btn_bank" />
                </div>             
                
            </div>
        </div>
    </form>
    </div>   
</div>
<script> 
$(document).ready(function(){    
    
    $("#event_order_register").validate({
        submitHandler: function(form) {            
            console.log(form);
            $(form).ajaxSubmit({
                url:"<?php echo site_url('/event/bank/'.$tran_id.'/'.$order_id); ?>",
                type: "POST",
                success: function(r){                    
                    if(r=='wrong_amount'){                        
                        alert("<?=$this->lang->line('amount_not_equal_msg')?>");
                        $('#register_btn_bank').attr('value', '<?=$this->lang->line('complete_reg'); ?>');
                    }else{
                        alert('<?=$this->lang->line('successfully_paid')?>');                
                        $("#event_order_bank_page").html(r);    
                    }         
                },
                beforeSend:function(){
                    $('#register_btn_bank').attr('value', 'Please wait..');
                }
            });
        }
            
    });    
});      

</script>
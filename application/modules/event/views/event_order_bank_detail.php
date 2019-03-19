<style>
	.bank_transaction h1{font-family:Arial, Helvetica, sans-serif;}
	.bank_wrap{width:524px; padding:23px 31px 23px 35px; border:solid 1px #ccc; background:#fcfbfb; overflow:hidden;}
	.bank_wrap p{font:12px Arial, Helvetica, sans-serif;}
	.step{width:100%; float:left; margin-bottom:10px;}
	.step span{width:30px; height:30px; float:left; border-radius:50px; -moz-border-radius:50px; -webkit-border-radius:50px; background:#408dc8; font:bold 22px/30px Arial, Helvetica, sans-serif; color:#fff; text-shadow:1px 1px 0 #3779ab; text-align:center;}
	.step strong{font:bold 14px Arial, Helvetica, sans-serif; color:#408dc8; border-bottom:solid 1px #408dc8; padding-bottom:8px; width:483px; float:right;}
	
	.bankinfo{width:504px; padding:10px; background:#f3f3f3; overflow:hidden}
	.bankinfo_l{width:110px; float:left; font-weight:bold; font-size:12px;}
	
	.bankinfo_r{width:365px; float:right;}
	.bankinfo_r p{font:bold 10px Arial, Helvetica, sans-serif; color:#000; margin:0 0 15px; width:100%; float:left;}
	.bankinfo_r p span{width:234px; float:right; margin:0 20px;}
	.bankinfo_r img{width:auto; float:left;}
	
	a.payment_btn{background:url('<?=MAIN_IMG_DIR_FULL_PATH."pay.jpg"?>') repeat-x; border-left: 1px solid #4B9ED4;
    border-radius: 3px 3px 3px 3px;
    border-right: 1px solid #4B9ED4;
    color: #FFFFFF;
    display: block;
    float: left;
    height: 39px;
    margin: 10px 0;
    text-align: center;
    width: 166px;
	line-height:36px;
	font-weight:bold;
	}
	a.payment_btn:hover{opacity:0.8; text-decoration:none}
	.payment_btn.ajax121.cboxElement > span {
    font-size: 14px;
    letter-spacing: -2px;
    line-height: 25px;
    margin: 0 0 0 4px;
}
</style>
<div class="bank_transaction">
	<h1><?=$this->lang->line('bank_transaction_details') ?></h1>
    <div class="bank_wrap">
    <div class="step">
    	<span>1</span>
        <strong><?=$this->lang->line('step1') ?></strong>
    </div>
    <p><?=$this->lang->line('user_information_msg_online') ?></p>
    <p><strong><em><?=$this->lang->line('account_name')?>: buyticket E-marketing</em></strong></p>
    <div class="bankinfo">
    	<div class="bankinfo_l">
        	<?=$this->lang->line('bank_information')?>:
        </div>
        <div class="bankinfo_r">
        	<?php if($banks){?>
            <?php foreach($banks as $bank): ?>
            <p>
            	<img src="<?=site_url('',TRUE).UPLOAD_FILE_PATH.'bank/'.$bank->bank_logo?>" />
                <span><?=strtoupper($this->lang->line('account_number'))?>: <?=$bank->bank_account_number;?><br />
				<?=strtoupper($this->lang->line('iban_number'))?>: <?=$bank->bank_iban_number;?></span>
            </p>
            <?php endforeach; ?>
            <?php } ?>
        </div>
    </div>
    <p><strong><?=$this->lang->line('amount_to_send') ?>:</strong> <?=$this->general->price($total_amount->due)?></p>
    
    <div class="step">
    	<span>2</span>
        <strong><?=$this->lang->line('step2') ?></strong>
    </div>
    <p><?=$this->lang->line('once_you_hace') ?></p>
    <a href="<?=site_url('event/bank/'.$tran_id.'/'.$order_id)?>" class="payment_btn ajax121"><?=$this->lang->line('identify_payment');?><span>&gt;&gt;</span></a>
    </div>
</div>
<!--color box-->
<link rel="stylesheet" href="<?php echo ASSETS_PATH ?>colorbox/colorbox.css" />
<script src="<?php echo ASSETS_PATH ?>colorbox/jquery.colorbox.js"></script>
<!--color box-->
<script>
$(document).ready(function(){
    $(".ajax121").colorbox({
        width:"auto",
        height:"auto",
        onComplete: function() {
            $(this).resize();
        }
    });
});
</script>
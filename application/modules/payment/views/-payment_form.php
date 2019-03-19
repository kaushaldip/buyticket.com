<?php 
if($payment_detail){
    $pay_id=$payment_detail->id;
    $url=site_url(ADMIN_DASHBOARD_PATH.'/payment/pay_edit/'.$pay_id);
    $val=$payment_detail->details;
}
else {
    $url=site_url(ADMIN_DASHBOARD_PATH.'/payment/pay_add/');
    $val='';
}
    ?>

<form method="post" action="<?=$url ?>">
    <label>payment details</label>
    <input value="<?=$event_id ?>" type="hidden" name="event_id"/>
    <textarea name="payment_details"><?=$val ?></textarea>
    <input  type="submit" value="send"/>
    
</form>
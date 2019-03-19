<?php
$merchant_id = "1431";
$txn_amount = "200";
$moco_user_id = "9851000000";
$secret_key = "";
$moco_end_point = "https://xxx.moco.com.np/merchant/payment";


//generate hmac md5 hash using secret key
$hash = hash_hmac("md5", $merchant_id, $txn_amount, $moco_user_id, $secret_key);

$post_params = array(
	"mid" => $merchant_id,
 	"userid" => $moco_user_id,
	"amount" => $txn_amount,
	"hash" => $hash
);

$content = "";

while(list($key, $val) = each($data)){
	$content .= "$key". urlencode($val). "&";
}

//call web service endpoint
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $moco_end_point);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
$ret = curl_eXec($ch);

$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Response Message: $ret<br>";
echo "Response code: $http_status";

?>
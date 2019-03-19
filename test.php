<form name="MyForm" method="POST" action="https://www.ipay.com.np//Payment" >
<input name="OrderNo" type="text" value="Invoice or Bill No.">
<input name="MerchantId" type="text" value="939a8cc6-cda2-47f7-a25a-a1ccf0f45721">
<input name="Description" type="text" value="Service ID, Service Type, Service Details">
<input name="ReturnUrl" type="text" value="http://esignature.com.np/igate.php?success">
<input name="CurrencyCode" type="text" value="NPR">
<input name="customer_email" type="text" value="like: raju.accpro@gmail.com">
<input name="ErrorUrl" type="text" value="http://esignature.com.np/igate.php?cancel">
<input name="Amount" type="text" value="1000.00">
<input name="Session_Key" type="text" value="ValueFromClient">
</form>
Post Back Details from iPay to Esignature order No: Invoice No. or Bill No. posted from Esignature Description: Transaction Details like: Service ID, Service Type, Service Details (posted from Esignature) 
Amount : Paid Amount at iPay
Customer Email : Returns customer’s email
Confirmation Code : If payment is done successfully then IPAY returns 16 digits code (like: KDOLE515LALITPOO) otherwise it returns NULL value.
Session Key : It will return same value that client send to Ipay while request Payment..
Posting Detail for Verification from Esignature to iPay.com.np

<form name="MyForm" method="POST" action="https://www.ipay.com.np/Payment/VerifyTransaction" >
<input name="MerchantId" type="text" value="939a8cc6-cda2-47f7-a25a-a1ccf0f45721">
<input name="TransactionId" type="text" value="Service ID, Service Type, Service Details">
<input name="Confirmation_Code" type="text" value="Confirmation_Code">
<input name="ReturnUrl" type="text" value=" http://www.esignature.com.np/igate.php?success">
<input name="ErrorUrl" type="text" value=" http://www.esignature.com.np /igate.php?cancel">
<input name="Amount" type="text" value="1000.00">
<input name="SessionKey" type="text" value="SessionKey">
</form>
After verify return
StatusCode = 200
StatusDescription = "Success"
context value = "Success|serviceId| Amount|confirmation_Code
IPAY verify transaction set payment status to paid and send payment slip to customer and returns to ReturnUrl.
If verification failed it returns to ErrorUrl
For test use these details; 
Username:- testnewipay@gmail.com  
Password:- password & Transaction 
password:- Sure123subas
<pre>
<h3>Posting Details from  esignature.com.np to ipay.com.np</h3>
<form name="MyForm" method="POST" action="https://www.ipay.com.np/Payment" >
    <input name="OrderNo" type="text" value="Invoice or Bill No." />
    <input name="MerchantId" type="text" value="939a8cc6-cda2-47f7-a25a-a1ccf0f45721" />
    <input name="Description" type="text" value="Service ID, Service Type, Service Details" />
    <input name="ReturnUrl" type="text" value="http://http://esignature.com.np//igate.php?success" />
    <input name="CurrencyCode" type="text" value="NPR" />
    <input name="customer_email" type="text" value="esajayyogal@gmail.com" />
    <input name="ErrorUrl" type="text" value="http://http://esignature.com.np//igate.php?cancel" />
    <input name="Amount" type="text" value="1000.00" />            
    <input name="Session_Key" type="text" value="ValueFromClient" />
    <input name="ok" value="payment" type="submit" />
</form> 


<h3>Posting Detail for Verification from Esignature to iPay.com.np</h3>
<form name="MyForm" method="POST" action="https://www.ipay.com.np/Payment/VerifyTransaction" >
    <input name="MerchantId" type="text" value="939a8cc6-cda2-47f7-a25a-a1ccf0f45721" />
    <input name="TransactionId" type="text" value="Service ID, Service Type, Service Details" /> 
    <input name="Confirmation_Code" type="text" value="Confirmation_Code" />
    <input name="ReturnUrl" type="text" value=" http://www.esignature.com.np/igate.php?success" />
    <input name="ErrorUrl" type="text" value=" http://www.esignature.com.np /igate.php?cancel" />
    <input name="Amount" type="text" value="1000.00" />
    <input name="SessionKey" type="text" value="SessionKey" />
    <input name="ok" value="verify" type="submit" />         
</form> 

</pre>
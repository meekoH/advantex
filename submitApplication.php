<?php

$json = json_decode($_POST['data'], true);
if ($json === NULL) {
    die(json_encode(array(
        "result"=>"error",
        "message"=>"Bad data received (927)"
    )));
}

//Data, connection, auth
$soapUrl = "https://69.46.97.42/nexus/services/mcawebservice/?applyV1"; // staging URL
$soapUser = "test";  //  staging username
$soapPassword = "test"; // staging password
$soapUser = "MCA_WEB";  //  production username
$soapPassword = "m3cF0rT3sting!F1n3l"; // production password


// xml post structure
$xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://webservices.services.nexus.adx.com" xmlns:xsd="http://data.services.nexus.adx.com/xsd">
<soapenv:Header/>
<soapenv:Body>
<web:applyV1>
<xsd:requestingUser>' . $soapUser . '</xsd:requestingUser>
<web:application>
<xsd:externalRequestID>'.$json['externalRequestID'].'</xsd:externalRequestID>
<xsd:source>ADVANTEX</xsd:source>
<xsd:merchantName>'.$json['merchantName'].'</xsd:merchantName>
<!--Optional:-->
<xsd:legalName></xsd:legalName>
<xsd:address1>'.$json['address1'].'</xsd:address1>
<!--Optional:-->
<xsd:address2></xsd:address2>
<xsd:city>'.$json['city'].'</xsd:city>
<xsd:province>'.$json['province'].'</xsd:province>
<!--Optional:-->
<xsd:postalCode>'.$json['postalCode'].'</xsd:postalCode>
<xsd:businessTypeID>'.$json['businessTypeID'].'</xsd:businessTypeID>
<xsd:firstName>'.$json['firstName'].'</xsd:firstName>
<xsd:lastName>'.$json['lastName'].'</xsd:lastName>
<xsd:positionInBusiness>'.$json['positionInBusiness'].'</xsd:positionInBusiness>
<xsd:phoneBusiness>'.$json['phoneBusiness'].'</xsd:phoneBusiness>
<!--Optional:-->
<xsd:phoneDirect></xsd:phoneDirect>
<!--Optional:-->
<xsd:phoneFax>'.$json['phoneFax'].'</xsd:phoneFax>
<xsd:email>'.$json['email'].'</xsd:email>
<xsd:yearsInBusiness>'.$json['yearsInBusiness'].'</xsd:yearsInBusiness>
<!--Optional:-->
<xsd:totalSales>'.$json['totalSales'].'</xsd:totalSales>
<!--Optional:-->
<xsd:totalDebitCreditSales>'.$json['totalDebitCreditSales'].'</xsd:totalDebitCreditSales>
<xsd:leaseProperty>'.$json['leaseProperty'].'</xsd:leaseProperty>
<!--Optional:-->
<xsd:monthsRemainingOnLease>'.$json['monthsRemainingOnLease'].'</xsd:monthsRemainingOnLease>
<xsd:openBankruptcies>'.$json['openBankruptcies'].'</xsd:openBankruptcies>
<!--Optional:-->
<xsd:currentlyUseFinancing>'.$json['currentlyUseFinancing'].'</xsd:currentlyUseFinancing>
<!--Optional:-->
<xsd:existingBalanceOutstanding>'.$json['existingBalanceOutstanding'].'</xsd:existingBalanceOutstanding>
<!--Optional:-->
<xsd:existingInitialAdvance>'.$json['existingInitialAdvance'].'</xsd:existingInitialAdvance>
<xsd:desiredAdvance>'.$json['desiredAdvance'].'</xsd:desiredAdvance>
</web:application>
</web:applyV1>
</soapenv:Body>
</soapenv:Envelope>';

$headers = array(
        "Content-type: text/xml;charset=\"utf-8\"",
        "Accept: text/xml",
        "Cache-Control: no-cache",
        "Pragma: no-cache",
        "SOAPAction: https://69.46.97.42/nexus/services/mcawebservice/?applyV1", 
        "Content-length: ".strlen($xml_post_string),
    ); //SOAPAction: your op URL

$url = $soapUrl;

// PHP cURL  for https connection with auth
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// converting
$response = curl_exec($ch); 
curl_close($ch);

/*
Example success output

<?xml version="1.0" encoding="utf-8"?> 
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"> 
        <soapenv:Body> 
                <ns:applyV1Response xmlns:ns="http://webservices.services.nexus.adx.com"> 
                        <ns:return xmlns:ax21="http://mca.businessobject.dinex.adx.com/xsd" xmlns:ax23="http://data.services.nexus.adx.com/xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="ax23:MCAAppResponseV1"> 
                                <ax23:responseCode>0</ax23:responseCode> 
                                <ax23:responseMessage>Thank you for your inquiry. Based on the information provided, your business easily qualifies for $30K to $50K (rounded to nearest thousand). An account specialist will contact you shortly to further discuss your needs and to outline advance options that suit you best.</ax23:responseMessage> 
                        </ns:return> 
                </ns:applyV1Response> 
        </soapenv:Body> 
</soapenv:Envelope> 
*/

/*
Example error output

<html><head><title>Request Rejected</title></head><body>The requested URL was rejected. Please consult with your administrator.<br><br>Your support ID is: 11510335293263535625</body></html>
*/

/*
Example error output

<?xml version="1.0" encoding="utf-8"?> 
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"> 
        <soapenv:Body> 
                <ns:applyV1Response xmlns:ns="http://webservices.services.nexus.adx.com"> 
                        <ns:return xmlns:ax21="http://mca.businessobject.dinex.adx.com/xsd" xmlns:ax23="http://data.services.nexus.adx.com/xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="ax23:MCAAppResponseV1"> 
                                <ax23:responseCode>1</ax23:responseCode> 
                                <ax23:responseMessage>Invalid data</ax23:responseMessage> 
                        </ns:return> 
                </ns:applyV1Response> 
        </soapenv:Body> 
</soapenv:Envelope> */

/*
Example error output

<?xml version="1.0" encoding="utf-8"?> 
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"> 
        <soapenv:Body> 
                <ns:applyV1Response xmlns:ns="http://webservices.services.nexus.adx.com"> 
                        <ns:return xmlns:ax21="http://mca.businessobject.dinex.adx.com/xsd" xmlns:ax23="http://data.services.nexus.adx.com/xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="ax23:MCAAppResponseV1"> 
                                <ax23:responseCode>99</ax23:responseCode> 
                                <ax23:responseMessage>System Error</ax23:responseMessage> 
                        </ns:return> 
                </ns:applyV1Response> 
        </soapenv:Body> 
</soapenv:Envelope> */

/*
Example error output

<?xml version="1.0" encoding="utf-8"?> 
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"> 
        <soapenv:Body> 
                <ns:applyV1Response xmlns:ns="http://webservices.services.nexus.adx.com"> 
                        <ns:return xmlns:ax21="http://mca.businessobject.dinex.adx.com/xsd" xmlns:ax23="http://data.services.nexus.adx.com/xsd" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="ax23:MCAAppResponseV1"> 
                                <ax23:responseCode>98</ax23:responseCode> 
                                <ax23:responseMessage>Duplicate Request</ax23:responseMessage> 
                        </ns:return> 
                </ns:applyV1Response> 
        </soapenv:Body> 
</soapenv:Envelope> */

$responseCode = 'NULL';
$responseMessage = 'NULL';
if (strpos($response, 'Request Rejected') !== FALSE) {
    $responseCode = '-1';
    $responseMessage = 'Request Rejected';
}
if (strpos($response, 'responseCode>') !== FALSE) {
    $responseCode = explode('responseCode>', $response);
    $responseCode = explode('</', $responseCode[1]);
    $responseCode = $responseCode[0];
}
if (strpos($response, 'responseCode>') !== FALSE) {
    $responseMessage = explode('responseMessage>', $response);
    $responseMessage = explode('</', $responseMessage[1]);
    $responseMessage = $responseMessage[0];
}

$result = "error";
if ($responseCode === '0') {
    $result = "success";
}

die(json_encode(array(
    "result"=>$result,
    "code"=>$responseCode,
    "message"=>$responseMessage
)));
?>
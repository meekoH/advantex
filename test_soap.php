<?php


error_reporting(E_ALL);
ini_set("display_errors", 1);


?><?php 
        //Data, connection, auth
        $soapUrl = "https://connecting.website.com/soap.asmx?op=DoSomething"; // asmx URL of WSDL
        $soapUrl = "https://69.46.97.42/nexus/services/mcawebservice/?applyV1";
        $soapUser = "test";  //  username
        $soapPassword = "test"; // password

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

        // xml post structure
        $xml_post_string ='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://webservices.services.nexus.adx.com" xmlns:xsd="http://data.services.nexus.adx.com/xsd">
<soapenv:Header/>
<soapenv:Body>
<web:applyV1>
<xsd:requestingUser>1sasdf23</xsd:requestingUser>
<web:application>
<xsd:externalRequestID>132376FG</xsd:externalRequestID>
<xsd:source>ADVANTEX</xsd:source>
<xsd:merchantName>AK</xsd:merchantName>
<!--Optional:-->
<xsd:legalName></xsd:legalName>
<xsd:address1>123</xsd:address1>
<!--Optional:-->
<xsd:address2></xsd:address2>
<xsd:city>Tomcat</xsd:city>
<xsd:province>ON</xsd:province>
<!--Optional:-->
<xsd:postalCode>L5G3W1</xsd:postalCode>
<xsd:businessTypeID>123</xsd:businessTypeID>
<xsd:firstName>A</xsd:firstName>
<xsd:lastName>K</xsd:lastName>
<xsd:positionInBusiness>123</xsd:positionInBusiness>
<xsd:phoneBusiness>416-5555555</xsd:phoneBusiness>
<!--Optional:-->
<xsd:phoneDirect>416-5555555</xsd:phoneDirect>
<!--Optional:-->
<xsd:phoneFax>416-5555555</xsd:phoneFax>
<xsd:email>it@advantex.com</xsd:email>
<xsd:yearsInBusiness>4</xsd:yearsInBusiness>
<!--Optional:-->
<xsd:totalSales>200000</xsd:totalSales>
<!--Optional:-->
<xsd:totalDebitCreditSales>1009000</xsd:totalDebitCreditSales>
<xsd:leaseProperty>false</xsd:leaseProperty>
<!--Optional:-->
<xsd:monthsRemainingOnLease>1</xsd:monthsRemainingOnLease>
<xsd:openBankruptcies>false</xsd:openBankruptcies>
<!--Optional:-->
<xsd:currentlyUseFinancing>false</xsd:currentlyUseFinancing>
<!--Optional:-->
<xsd:existingBalanceOutstanding></xsd:existingBalanceOutstanding>
<!--Optional:-->
<xsd:existingInitialAdvance></xsd:existingInitialAdvance>
<xsd:desiredAdvance>1000</xsd:desiredAdvance>
</web:application>
</web:applyV1>
</soapenv:Body>
</soapenv:Envelope>';   // data from the form, e.g. some ID number

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

            // converting
            $response1 = str_replace("<soap:Body>","",$response);
            $response2 = str_replace("</soap:Body>","",$response1);

            // convertingc to XML
            // $parser = simplexml_load_string($response2);
            // user $parser to get your data out of XML response and to display it.

    ?>
<html>
<head>
    <title></title>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
function formatXml(xml) {
    var formatted = '';
    var reg = /(>)(<)(\/*)/g;
    xml = xml.replace(reg, '$1\r\n$2$3');
    var pad = 0;
    jQuery.each(xml.split('\r\n'), function(index, node) {
        var indent = 0;
        if (node.match( /.+<\/\w[^>]*>$/ )) {
            indent = 0;
        } else if (node.match( /^<\/\w/ )) {
            if (pad != 0) {
                pad -= 4;
            }
        } else if (node.match( /^<\w[^>]*[^\/]>.*$/ )) {
            indent = 4;
        } else {
            indent = 0;
        }
 
        var padding = '';
        for (var i = 0; i < pad; i++) {
            padding += '  ';
        }
 
        formatted += padding + node + '\r\n';
        pad += indent;
    });
 
    return formatted;
}
 
xml_raw = '<?php $response = str_replace("'",'"',$response); echo $response; ?>';
 
xml_formatted = formatXml(xml_raw);

xml_escaped = xml_formatted.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/ /g, '&nbsp;').replace(/\n/g,'<br />');

xml_escaped = xml_escaped.replace(/="/g,'=<span style="color:#090;font-weight:normal;">"');
xml_escaped = xml_escaped.replace(/"&nbsp;/g,'"</span>&nbsp;');
xml_escaped = xml_escaped.replace(/"&gt;/g,'"</span>&gt;');
xml_escaped = xml_escaped.replace(/"\?&gt;/g,'"</span>?&gt;');
 
xml_escaped = xml_escaped.replace(/&lt;/g,'<span style="color:#00f;font-weight:normal;">&lt;');
xml_escaped = xml_escaped.replace(/&gt;/g,'&gt;</span>');

xml_escaped = xml_escaped.replace(/&lt;\?/g,'<span style="color:#999;font-weight:normal;font-style:italic;">&lt;?');
xml_escaped = xml_escaped.replace(/\?&gt;/g,'?&gt;</span>');

$(document).ready(function() {
$('body').append('<div>'+xml_escaped+'</div>');
 });
</script>
<style>
    body {
        padding: 15px;
        font-family: Menlo, 'Courier New', monospace;
        font-size: 16px;
        font-weight: bold;
    }
</style>
</head>
<body>
</body>
</html>
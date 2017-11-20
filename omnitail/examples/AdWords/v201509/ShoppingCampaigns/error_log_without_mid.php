[Feb 05 2016 10:57:11.000000 - INFO] POST /api/adwords/cm/v201509/BudgetService HTTP/1.1
Host: adwords.google.com
Connection: Keep-Alive
User-Agent: PHP-SOAP/5.5.12, gzip
Accept-Encoding: gzip, deflate
Content-Encoding: gzip
Content-Type: text/xml; charset=utf-8
SOAPAction: ""
Content-Length: 462
Authorization: Bearer ya29.fwInZPTkHt3cLZP3qW0L3Hu6Ej-7fQbOtk0nS80P5slwmxGpCHWmTKNb-Qbukmm5VeErkg

<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="https://adwords.google.com/api/adwords/cm/v201509">
  <SOAP-ENV:Header>
    <ns1:RequestHeader>
      <ns1:clientCustomerId>7461228875</ns1:clientCustomerId>
      <ns1:developerToken>dDdipQC2xWmL2WIIDCDvYw</ns1:developerToken>
      <ns1:userAgent>vbridge (AwApi-PHP/7.0.0, Common-PHP/7.0.0, PHP/5.5.12)</ns1:userAgent>
    </ns1:RequestHeader>
  </SOAP-ENV:Header>
  <SOAP-ENV:Body>
    <ns1:mutate>
      <ns1:operations>
        <ns1:operator>ADD</ns1:operator>
        <ns1:operand>
          <ns1:name>Interplanetary Cruise Budget #56b471f273c42</ns1:name>
          <ns1:period>DAILY</ns1:period>
          <ns1:amount>
            <ns1:microAmount>1000000</ns1:microAmount>
          </ns1:amount>
          <ns1:deliveryMethod>STANDARD</ns1:deliveryMethod>
        </ns1:operand>
      </ns1:operations>
    </ns1:mutate>
  </SOAP-ENV:Body>
</SOAP-ENV:Envelope>

HTTP/1.1 200 OK
Content-Type: text/xml; charset=UTF-8
Content-Encoding: gzip
Date: Fri, 05 Feb 2016 09:57:12 GMT
Expires: Fri, 05 Feb 2016 09:57:12 GMT
Cache-Control: private, max-age=0
X-Content-Type-Options: nosniff
X-Frame-Options: SAMEORIGIN
X-XSS-Protection: 1; mode=block
Content-Length: 463
Server: GSE

<?xml version="1.0"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Header>
    <ResponseHeader xmlns="https://adwords.google.com/api/adwords/cm/v201509">
      <requestId>00052b02e00925500a4c120ba30df37a</requestId>
      <serviceName>BudgetService</serviceName>
      <methodName>mutate</methodName>
      <operations>1</operations>
      <responseTime>318</responseTime>
    </ResponseHeader>
  </soap:Header>
  <soap:Body>
    <mutateResponse xmlns="https://adwords.google.com/api/adwords/cm/v201509">
      <rval>
        <ListReturnValue.Type>BudgetReturnValue</ListReturnValue.Type>
        <value>
          <budgetId>455664180</budgetId>
          <name>Interplanetary Cruise Budget #56b471f273c42</name>
          <period>DAILY</period>
          <amount>
            <ComparableValue.Type>Money</ComparableValue.Type>
            <microAmount>1000000</microAmount>
          </amount>
          <deliveryMethod>STANDARD</deliveryMethod>
          <isExplicitlyShared>true</isExplicitlyShared>
          <status>ENABLED</status>
        </value>
      </rval>
    </mutateResponse>
  </soap:Body>
</soap:Envelope>

[Feb 05 2016 10:57:27.000000 - ERROR] POST /api/adwords/cm/v201509/CampaignService HTTP/1.1
Host: adwords.google.com
Connection: Keep-Alive
User-Agent: PHP-SOAP/5.5.12, gzip
Accept-Encoding: gzip, deflate
Content-Encoding: gzip
Content-Type: text/xml; charset=utf-8
SOAPAction: ""
Content-Length: 610
Authorization: Bearer ya29.fwInZPTkHt3cLZP3qW0L3Hu6Ej-7fQbOtk0nS80P5slwmxGpCHWmTKNb-Qbukmm5VeErkg

<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="https://adwords.google.com/api/adwords/cm/v201509" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
  <SOAP-ENV:Header>
    <ns1:RequestHeader>
      <ns1:clientCustomerId>7461228875</ns1:clientCustomerId>
      <ns1:developerToken>dDdipQC2xWmL2WIIDCDvYw</ns1:developerToken>
      <ns1:userAgent>vbridge (AwApi-PHP/7.0.0, Common-PHP/7.0.0, PHP/5.5.12)</ns1:userAgent>
    </ns1:RequestHeader>
  </SOAP-ENV:Header>
  <SOAP-ENV:Body>
    <ns1:mutate>
      <ns1:operations>
        <ns1:operator>ADD</ns1:operator>
        <ns1:operand>
          <ns1:name>Shopping campaign #56b472055b2a0</ns1:name>
          <ns1:status>PAUSED</ns1:status>
          <ns1:budget>
            <ns1:budgetId>455664180</ns1:budgetId>
          </ns1:budget>
          <ns1:settings xsi:type="ns1:ShoppingSetting">
            <ns1:salesCountry>US</ns1:salesCountry>
            <ns1:campaignPriority>0</ns1:campaignPriority>
            <ns1:enableLocal>true</ns1:enableLocal>
          </ns1:settings>
          <ns1:advertisingChannelType>SHOPPING</ns1:advertisingChannelType>
          <ns1:biddingStrategyConfiguration>
            <ns1:biddingStrategyType>MANUAL_CPC</ns1:biddingStrategyType>
          </ns1:biddingStrategyConfiguration>
        </ns1:operand>
      </ns1:operations>
    </ns1:mutate>
  </SOAP-ENV:Body>
</SOAP-ENV:Envelope>

HTTP/1.1 500 Internal Server Error
Content-Type: text/xml; charset=UTF-8
Content-Encoding: gzip
Date: Fri, 05 Feb 2016 09:57:28 GMT
Expires: Fri, 05 Feb 2016 09:57:28 GMT
Cache-Control: private, max-age=0
X-Content-Type-Options: nosniff
X-Frame-Options: SAMEORIGIN
X-XSS-Protection: 1; mode=block
Content-Length: 497
Server: GSE

<?xml version="1.0"?>
<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Header>
    <ResponseHeader xmlns="https://adwords.google.com/api/adwords/cm/v201509">
      <requestId>00052b02e1015c480a4c0d2a5d047ac1</requestId>
      <serviceName>CampaignService</serviceName>
      <methodName>mutate</methodName>
      <operations>1</operations>
      <responseTime>177</responseTime>
    </ResponseHeader>
  </soap:Header>
  <soap:Body>
    <soap:Fault>
      <faultcode>soap:Server</faultcode>
      <faultstring>[RequiredError.REQUIRED @ operations[0].operand.settings[0].merchantId]</faultstring>
      <detail>
        <ApiExceptionFault xmlns="https://adwords.google.com/api/adwords/cm/v201509">
          <message>[RequiredError.REQUIRED @ operations[0].operand.settings[0].merchantId]</message>
          <ApplicationException.Type>ApiException</ApplicationException.Type>
          <errors xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="RequiredError">
            <fieldPath>operations[0].operand.settings[0].merchantId</fieldPath>
            <trigger/>
            <errorString>RequiredError.REQUIRED</errorString>
            <ApiError.Type>RequiredError</ApiError.Type>
            <reason>REQUIRED</reason>
          </errors>
        </ApiExceptionFault>
      </detail>
    </soap:Fault>
  </soap:Body>
</soap:Envelope>




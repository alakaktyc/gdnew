<?php

$soap_url = 'http://195.222.65.76:8080/TMF/ws/d_exchange.1cws?wsdl';
$soap_login = 'zagr';
$soap_passwd = '123123';

$departure = htmlspecialchars($_POST["Departure"]);
$destination = htmlspecialchars($_POST["Destination"]);
$weight = htmlspecialchars($_POST["Weight"]);
$volume = htmlspecialchars($_POST["Volume"]);
$dimensionsOnePlace = htmlspecialchars($_POST["Dimensions_one_place"]);
$oversized = htmlspecialchars($_POST["Oversized"]);
$customerDelivery = htmlspecialchars($_POST["Customer_delivery"]);

$xml = '<PACKAGE xmlns="http://www.sample-package.org" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">';
$xml .= '<Departure>'.$departure.'</Departure>';
$xml .= '<Destination>'.$destination.'</Destination>';
$xml .= '<Weight>'.$weight.'</Weight>';
$xml .= '<Volume>'.$volume.'</Volume>';
$xml .= '<Dimensions_one_place>'.$dimensionsOnePlace.'</Dimensions_one_place>';
$xml .= '<Oversized>'.$oversized.'</Oversized>';
$xml .= '<Customer_delivery>'.$customerDelivery.'</Customer_delivery>';
$xml .= '</PACKAGE>';


try {
    $soap = new SoapClient($soap_url, [
        'login'             => $soap_login,
        'password'          => $soap_passwd,
        'soap_version'      => SOAP_1_2,
        'exceptions'        => true,
        'cache_wsdl'        => WSDL_CACHE_NONE,
        'trace'                     => 1,
    ]);

    $result = $soap->__call('getCostCalculator', [
        'DeliveryCalculator' => [
            'DeliveryOptions' => $xml
        ],
    ]);

    $xml = new SimpleXMLElement($result->return);

    $json = json_encode($xml);
    //$array = json_decode($json);

} catch (Exception $e) {
    die($e->getMessage());
}
//Date_download":"2020-03-27","Date_delivery":"2020-03-30

/*
$arResponse = array(
  'Date_download' => $xml->Date_download,
  'Date_delivery' => $xml->Date_delivery,
  'Cost_Delivery' => $xml->Cost_Delivery
  );

echo json_encode($arResponse);
*/
echo $json;
//echo $xml->Cost_Delivery;

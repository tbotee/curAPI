<?php

include_once dirname(__FILE__) . '/currencyDb.class.php';

$api = new CurrencyDb('jdh32lk3432');


$api->withDates(array('2017-04-19', '2017-04-20'));
$api->withCurrencyTypes(array('HUF')); 
$api->withInstitutes(array('BNR', 'BT'));

//$result = $api->getCurrencyValues();
//$result = $api->getInstitutes();
$result = $api->getCurrencyValues();

print_r($result);


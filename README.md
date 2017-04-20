# curAPI
A class that lets fetches you the latest or custom currency data from romanian banck

## Usage
```php
include_once dirname(__FILE__) . '/currencyDb.class.php';
$api = new CurrencyDb('jdh32lk3432');
```

## Methods
```php
$result = $api->getInstitutes();
```
Returns all the institute codes which are supported (BNR, BCR, BT...)

```php
$result = $api->getCurrencyTypes();
```
Returns all the currency type codes which are supported (EUR, USD...)

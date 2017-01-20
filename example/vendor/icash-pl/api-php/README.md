iCash.pl: API PHP
==
## Quick Installation
```php   
composer require icash-pl/api-php
```

## Getting started
```php
<?php
use iCashpl\ApiPhp\iCash;

if (isset($_POST['code'])) {
    
    require 'icash/api_php/src/iCash.php';
    
    $icash = new iCash('YOU_APP_KEY');
    $icash->getStatusCode(array(
            'service' => 'rGiDLltiS4OrAntBHae664P7BKbNWECL',
            'number' => '7055',
            'code' => '9AB5KJ'
    ));

    // ok
    if ($icash->statusOk()) {

    }
    // error
    else {

    }
}
?>
```
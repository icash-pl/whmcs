iCash.pl: WHMCS
==

## Getting started

```php
<?php
use iCashpl\Whmcs\Whmcs;

$whmcs = new Whmcs('YOU_APP_KEY');

$whmcs->setService('EdyEm5QfbSm7oSg8XojpkH87xz8qVHx2', 'ICH.TEST');

$whmcs->setNumbers([
    [
        'min' => 10.01,
        'max' => 11.01,
        'number' => 7955,
        'net' => 10.00
    ],
    [
        'min' => 11.01,
        'max' => 14.01,
        'number' => 91155,
        'net' => 14.00
    ],
    [
        'min' => 14.01,
        'max' => 19.01,
        'number' => 91955,
        'gross' => 23.37
    ],
]);

$whmcs->setOrder([
    'id' => 123,
    'amount' => 15.00
]);

if (isset($_POST['code'])) {    
    $whmcs->getStatusCode($_POST['code']);
    
    // ok
    if ($whmcs->icash()->statusOk()) {

    }
    // error
    else {

    }
}
?>
```
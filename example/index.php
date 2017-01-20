<?php
require 'vendor/autoload.php';

use iCashpl\Whmcs\Whmcs;

$status = '';

/**
 * $whmcs = new Whmcs('APP_KEY_ICASH');
 */
$whmcs = new Whmcs('x5snnjaKUz7OkC0veJHGpBgOpiGQGCZd');

// Dane o usłudze
$whmcs->setService('A7ieZSQZrDZwMXBX7DWmCUPrRxeQECPX', 'ICH.TEST');

// Numery SMS Premium
$whmcs->setNumbers([
    [
        'min' => 10.01, // brutto
        'max' => 11.01, // brutto
        'number' => 7955,
        'net' => 10.00, // netto
    ],
    [
        'min' => 11.01,
        'max' => 14.01,
        'number' => 91155,
        'net' => 14.00,
    ],
    [
        'min' => 14.01, // brutto
        'max' => 19.01, // brutto
        'number' => 91955,
        'gross' => 23.37, // brutto
    ],
]);

// Zamówienie
$whmcs->setOrder([
    'id' => 123, // ID zamówienia
    'amount' => 15.00, // brutto
]);

/**
 * Weryfikujemy, czy formularz został wysłany
 */
if (isset($_POST['code'])) {
    $whmcs->getStatusCode($_POST['code']);
    
    /**
     * Jeśli kod jest prawidłowy
     */
    if ($whmcs->icash()->statusOk()) {
        $status .= '<div class="alert alert-success">Twój kod jest prawidłowy. Dziękujemy za zakupy.</div>';
        
        /**
         * Tutaj możesz również wykonywać inne operacje
         * Np. wysyłanie danych do API
         */
    } else {
        $status .= '<div class="alert alert-danger">Przesłany kod jest nieprawidłowy, przepisz go ponownie.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css">
        <title>Przykladowy skrypt platnosci SMS</title>
    </head>
    <body>
        <div class="container">            
            <div class="row">
                <div class="col-sm-6">
                    <img src="http://icash.pl/img/logo.png">
                </div>
                <div class="col-sm-6 text-right">
                    <h3>Payment Gateway</h3>
                </div>
            </div>
            
            <hr>
            
            <?php echo $status; ?>
            
            <?php if (!$whmcs->getNumber()): ?>
                <div class="alert alert-danger">
                    Wprowadzono niepoprawną kwotę zamówienia, niemożliwą do płatności poprzez SMS Premium.
                </div>
            <?php else: ?>
                <div style="overflow: hidden;">
                    <div class="pull-left">
                        <h4>Faktura nr #<?php echo $whmcs->order()->id; ?></h4>
                    </div>
                    <div class="pull-right">
                        <h4>Cena: <?php echo $whmcs->getNumber()->getGross(); ?> zł</h4>
                    </div>
                </div>
            
                <hr>
                
                <div class="clear">
                    <p>Aby opłacić fakturę, wyślij SMS o treści <b><?php echo $whmcs->getServiceText(); ?></b> 
                        na numer <b><?php echo $whmcs->getNumber()->number; ?></b></p>
                    <p class="margin-bottom-25">W wiadomości zwrotnej otrzymasz jednorazowy kod, za pomocą którego będziesz mógł potwierdzić zamówienie.</p>

                    <div class="text-center margin-bottom-25">
                        <h4 class="margin-bottom-15">Wprowadź otrzymany kod</h4>
                        <form method="post">
                            <div class="form-group" style="width: 300px; margin: 0 auto;">
                                <div class="input-group">
                                    <input name="code" placeholder="Kod sms" type="text" class="form-control" required />
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-success">Sprawdź kod</button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <p><small>Właścicielem serwisu jest <b>Nazwa firmy</b>. Wysyłając wiadomość akceptujesz regulamin serwisu <b>Regulamin serwisu Partnera</b>, 
                    oraz regulamin <a href="https://icash.pl/documents/regulamin-icash-pl-platnosci-sms.pdf" target="_blank">systemu płatności 
                    <strong>iCash.pl</strong></a>, który jest dostawcą usług mikropłatności SMS Premium. 
                    W razie problemów z płatnością prosimy o kontakt poprzez <a href="https://icash.pl/reklamacje">formularz reklamacyjny</a>.</small></p>
                </div>
            <?php endif; ?>
        </div>
    </body>
</html>
<?php

/**
 * PayPal Setting & API Credentials
 * Created by Raza Mehdi <srmk@outlook.com>.
 */
return [
    'client_id' => 'AQaljuBdmrJuJ-doHvC70XYmiOK125sfv8538WKHNheHJMgoUkEoWnG5E7pwYHRJO11lXM-5h1az7Tt-',
    'secret' => 'EBfT-BTKaTOB6D2-CoLtUTF8kpj4o5DIvNOxsTPsHnP9bRpWgJXJ_bjoB3OTLKKUbisJHi9jmTlytBbt',
    'settings' => array(
        'mode' => 'sandbox',
        'http.ConnectionTimeOut' => 1000,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'FINE',

    ),
];

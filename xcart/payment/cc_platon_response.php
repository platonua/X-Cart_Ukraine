<?php

require './auth.php';

if (!func_is_active_payment('cc_platon.php')) {
    die("ERROR: Payment method is not active");
}

$callbackParams = $_POST;

func_pp_debug_log('platon', 'C', array('query' => http_build_query($callbackParams)));

$module_params = func_get_pm_params('cc_platon.php');

// generate signature from callback params
$sign = md5(
        strtoupper(
                strrev($callbackParams['email']) .
                $module_params['param02'] .
                $callbackParams['order'] .
                strrev(substr($callbackParams['card'], 0, 6) . substr($callbackParams['card'], -4))
        )
);

// verify signature
if ($callbackParams['sign'] !== $sign) {
    // answer with fail response
    die("ERROR: Invalid signature");
} else {
    x_load('order');
    $bill_output['sessid'] = func_query_first_cell("SELECT sessid FROM $sql_tbl[cc_pp3_data] WHERE ref='" . $callbackParams['order'] . "'");
    // do processing stuff
    switch ($callbackParams['status']) {
        case 'SALE':
            define('STATUS_CHANGE_REF', 2);
            func_change_order_status(array($callbackParams['order']), 'P');
            break;
        case 'REFUND':
            define('STATUS_CHANGE_REF', 12);
            func_change_order_status(array($callbackParams['order']), 'B');
            break;
        case 'CHARGEBACK':
            break;
        default:
            die("ERROR: Invalid callback data");
    }

    // answer with success response
    exit("OK");
}
?>
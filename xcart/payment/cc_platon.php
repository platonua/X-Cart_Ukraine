<?php

if (!empty($_GET['platon_result']) && !(empty($_GET['order']))) {
    require './auth.php';

    if (!func_is_active_payment('cc_platon.php'))
        exit;

    func_pp_debug_log('platon', 'B', $_GET);

    $result = $_GET['platon_result'];
    $skey = $_GET['order'];
    if ($result == 'success') {

        $url = "cart.php?mode=order_message&orderids=" . $skey;

        $tmp = explode("\n", chunk_split($url, 254, "\n"));
        $update_params = array();

        foreach ($tmp as $i => $v) {
            $update_params['param' . ($i + 1)] = addslashes($v);
        }

        $trstat = func_query_first_cell("SELECT trstat FROM $sql_tbl[cc_pp3_data] WHERE ref = '" . $skey . "'");

        $oids_tmp = explode('|', $trstat);
        $oids_tmp[0] = 'CALL';

        $update_params['trstat'] = addslashes(implode('|', $oids_tmp));
        $update_params['is_callback'] = 'N';

        func_array2update(
                'cc_pp3_data', $update_params, "ref = '" . $skey . "'"
        );

        x_session_register('cart');

        $cart = '';

        $bill_output['code'] = 1;

        require($xcart_dir . '/payment/payment_ccview.php');
    } else {
        $bill_output['sessid'] = func_query_first_cell("SELECT sessid FROM $sql_tbl[cc_pp3_data] WHERE ref='$skey'");
        $bill_output['billmes'] .= func_get_langvar_by_name('txt_payment_transaction_is_failed', array(), false, true, true);
        include $xcart_dir . '/payment/payment_ccend.php';
    }
} else {

    if (!defined('XCART_START')) {
        header("Location: ../");
        die("Access denied");
    }

    $result['key'] = $module_params['param01'];

    $ordr = join("-", $secure_oid);
    db_query("REPLACE INTO $sql_tbl[cc_pp3_data] (ref,sessid,trstat) VALUES ('" . addslashes($ordr) . "','" . $XCARTSESSID . "','GO|" . implode('|', $secure_oid) . "')");

    $result['order'] = $ordr;

    $cb_url = $current_location . '/payment/cc_platon.php';
    $result['url'] = $cb_url . '?platon_result=success';
    $result['error_url'] = $cb_url . '?platon_result=error';

    /* Prepare product data for coding */
    $result['data'] = base64_encode(
            json_encode(
                    array(
                        'amount' => sprintf("%01.2f", $cart['total_cost']),
                        'name' => 'Order from ' . $config['Company']['company_name'],
                        'currency' => $module_params['param04']
                    )
            )
    );

    /* Calculation of signature */
    $sign = md5(
            strtoupper(
                    strrev($result['key']) .
                    strrev($result['data']) .
                    strrev($result['url']) .
                    strrev($module_params['param02'])
            )
    );

    $result['sign'] = $sign;


    func_create_payment_form($module_params['param03'], $result, 'Platon');
    exit();
}
?>
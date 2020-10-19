INSERT INTO xcart_ccprocessors SET module_name='Platon', type='C', processor='cc_platon.php', template='cc_platon.tpl', param01='', param02='', param03='https://secure.platononline.com/payment/auth', param04='USD', param05='', param06='', param07='', param08='', param09='', disable_ccinfo='Y', background='N', testmode='N', is_check='', is_refund='', c_template='', paymentid='0', cmpi='';

INSERT INTO xcart_languages (code, name, value, topic)
VALUES 
('en', 'lbl_cc_platon_key', 'Merchant Key', 'Labels'), 
('en', 'lbl_cc_platon_password', 'Merchant Password', 'Labels'),
('en', 'lbl_cc_platon_gateway_url', 'Gateway URL', 'Labels'),
('en', 'lbl_cc_platon_currency', 'Preffered Currency', 'Labels')
;
            
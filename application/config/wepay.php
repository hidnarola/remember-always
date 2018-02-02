<?php

if (WEPAY_ENVIRONMENT == 'Production') {
    //-- Live Credentials
    $config['client_id'] = 15140;
    $config['client_secret'] = "44c05bb748";
    $config['access_token'] = "PRODUCTION_6eb3aafabc0e4832b694f781bfbf28b3ea08e0544520f682eecf5f77d777ee5d";
    $config['account_id'] = 1165038399;
} else {
    //-- Staging Credentials
    $config['client_id'] = 73302;
    $config['client_secret'] = "501ee5c044";
    $config['access_token'] = "STAGE_7e9ea0e682d9c3a982270c107b2584c8d4d15352c39b304ca90681f415aa54da";
    $config['account_id'] = 934870822;
}
?>
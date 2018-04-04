<?php

/**
 * Configuration file to configure wildly used.
 *
 * @author vinay
 */
$var = array(
    'debug' => 2 /* Debug Level 0,1,2 */
    , 'disableHistory' => true /* Enable/Disable Back Button of browser. */
    , 'disableCut' => true /* Enable/Disable Cut. */
    , 'disableCopy' => true /* Enable/Disable Copy. */
    , 'disablePaste' => true /* Enable/Disable Paste. */
    , 'disableRightClick' => true /* Enable/Disable Mouse Right Click. */
    , 'disableRefresh' => true /* Enable/Disable Browser Refresh. */
    , 'icon' => 'favicon.ico' /* Title Logo. */
    , 'title' => 'Payment(BO)' /* Title of Application. */
    , 'masterController' => 'pwBoPayment' /* Default Controller Name of Application. */
    , 'logo' => 'logo_white.png' /* Logo of your Application. */
    , 'theme' => 'skin-blue-light.min' /* Theme of Application (skin-red-velvet.min|skin-blue-light.min). */
    , 'login_logo' => 'logo_blue.png' /* Logo displayed on login screen,reset password. */
    , 'login_text' => 'Login to continue...' /* Text to display on login screen. */
    , 'logo_mini' => 'logo_white_mini.png' /* Mini Logo of your Application. */
    , 'CONSTANT_PwBank' => '2' /* 2 is the 'id' of PwBank in st_payment_provider_master */
    , 'CONSTANT_PwEcollect' => '6' /* 6 is the 'id' of PwEcollect in st_payment_provider_master */
    , 'CONSTANT_CASHINOFFICE' => '1' /* 1 is the 'id' of PwOffice in st_payment_provider_master */
    , 'CONSTANT_ExlProvider' => array('1', '8') /* 1,5 is the 'id' of Provider in st_payment_provider_master */
    , 'toggle_logo' => 'sidebar-toggler-inverse.png'
//    , 'CONST_PW_API_URL' => 'http://172.20.2.37/server/JwtApi/new/'  /// API
    , 'CONST_PW_API_URL' => 'http://172.20.2.37/userchetan/JwtApi/new/'  /// API
);
Configure::write($var);

<!-- Cac hang so -->
<?php
    const _MODULE = 'home';
    const _ACTION = 'dashboard';

    const _CODE = true;

    // Thiet lap host
    define('_WEB_HOST', 'http://'. $_SERVER['HTTP_HOST'] .'/73DCTT23/manager_users');
    define('_WEB_HOST_TEMPLATES', _WEB_HOST .'/templates' );

    // Thiet lap path
    define('_WEB_PATH', __DIR__);
    define('_WEB_PATH_TEMPLATES', _WEB_PATH .'\templates');

    // Thông tin kết nối
    const _HOST = 'localhost';
    const _DB = 'hoangganh_php';
    const _USER = 'root';
    const _PASS = '';
?>
<?php 
    declare(strict_types=1);

    //getting .env values
    require_once('vendor/autoload.php');
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();

    //getting constant values
    if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
    define('HOST',$uri .$_SERVER['SERVER_NAME'].'/account');
    define('img_folder','images');
    define('MAX_REG',10);
    define('secret_key',$_ENV['SECRET_KEY']);
    define('site_key',$_ENV['SITE_KEY']);
    define('site_name','Webman');

    //defining database variables
    $db_user = "adminui";
    $db_pass = "#J4dIg0Mn4PiJm0Ck4#";
    $db_name = "admin_ui";
    $db_host = "localhost";

    //connecting to database
    $db = new PDO("mysql:host={$db_host}; dbname={$db_name};charset=utf8", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    //getting user device type
    function isMobile() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    //starting a user session
    session_start();
?>
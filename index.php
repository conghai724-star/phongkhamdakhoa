<?php

ob_start();
error_reporting(0);
@ini_set('display_errors', '0');

 /*** define the site path ***/
 $site_path = realpath(dirname(__FILE__));
 define ('__SITE_PATH', $site_path);

 /*** include the config.php file ***/
 include_once 'config.php';
  
 /*** include the init.php file ***/
 include_once 'includes/init.php';

 /*** load the router ***/
 $registry->router = new router($registry);

 /*** set the controller path ***/
 $registry->router->setPath (__SITE_PATH . '/controller');

 /*** load the controller ***/

 $registry->router->loader();
    
?>

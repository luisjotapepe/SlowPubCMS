<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Mongo
 * Date: 23/01/12
 * Time: 7:46 PM
 * To change this template use File | Settings | File Templates.
 */

ini_set( "display_erros", true);
date_default_timezone_set("America/Edmonton");
define( "DB_DSN", "mysql:host=localhost;dbname=test");
define( "DB_USERNAME", "tester");
define( "DB_PASSWORD", "Allegjdm93");
define( "CLASS_PATH", "classes");
define( "TEMPLATE_PATH", "templates");
define( "ADMIN_USERNAME", "admin");
define( "ADMIN_PASSWORD", "123");
require( CLASS_PATH . "/DailyMenuItem.php");
require( CLASS_PATH . "/RegularMenuItem.php");
require( CLASS_PATH . "/WeeklySpecialItem.php");
require( CLASS_PATH . "/DrinkCollectionItem.php");
require( CLASS_PATH . "/EventItem.php");
require( CLASS_PATH . "/SupplierItem.php");
require( CLASS_PATH . "/OffsaleItem.php");
?>

<meta charset="UTF-8">
<?php
/**
 * functions
 * 
 * @package  2swap
 * @author   Álvaro Suárez
 */

require_once("config.php");

if (DEBUG == "true") {
    ini_set('display_errors', 1);
} else {
    ini_set('display_errors', 0);
}

require_once("Tools.php");
require_once("usersClass.php");
require_once("walletsClass.php");
?>
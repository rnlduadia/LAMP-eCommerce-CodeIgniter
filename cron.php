#!/usr/bin/php
<?php
/**
* cron.php param1 param2 ...
*
* param1 = controller
* param2 = method
*
* Examples:
*
*   php execScript.php welcome
*   php execScript.php mymodule mymethod
*   php execScript.php mycontroller mymethod
*/

// Set time limit and memory for script execution
set_time_limit(0);
ini_set('memory_limit', '3584M');

// If this script are called from any other source, exit
if (isset($_SERVER['REMOTE_ADDR'])) die('Permission denied.');

// Define commmand line script, your can protect your controller checking this.
// First line of your controller (if only allowed to be executed from commandline):
//  <?php if (!defined("IS_CRON")) die('Bad request');
define("IS_CRON", TRUE);

// Unset argv for this php
unset($argv[0]);
// Set necessary server info
$_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'] = '/' . implode('/', $argv) . '/';

// Include index.php as normal call
include(dirname(__FILE__).'/index.php');

?>
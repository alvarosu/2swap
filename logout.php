<?php
/**
 * Log Out
 */
require_once 'inc/functions.php';

if ( isset($_REQUEST['userremove-email']) ) {
	$users = new users();
	$email = stripslashes($_REQUEST['userremove-email']);
	$user_updated = $users->delete($email);
}

session_start();
// Destroy session
if(session_destroy()) {
	// Redirecting To Home Page
	header("Location: login.php");
}
?>
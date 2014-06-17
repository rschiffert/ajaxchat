<?php

/* Database Configuration. Add your details below */
$dbOptions = array(
	'db_host' => 'localhost',
	'db_user' => 'joe',
	'db_pass' => 'joe',
	'db_name' => 'webchat'
);

/* Database Config End */
error_reporting(E_ALL ^ E_NOTICE);

require "classes/DB.class.php";
require "classes/Chat.class.php";
require "classes/ChatBase.class.php";
require "classes/ChatLine.class.php";
require "classes/ChatUser.class.php";

// when Twilio submits a SMS request to us we get the fields FROM, TO and BODY
if (isset($_REQUEST['From'])) {
	$From = $_REQUEST['From'];
} else {
	$From = "UnknownNumber";
}

if (isset($_REQUEST['Body'])) {
	$Body = $_REQUEST['Body'];
} else {
	$Body = "empty message";
}

echo $From;
echo $Body;

// $Body = mysql_real_escape_string($Body);

try{
	// Connecting to the database
	DB::init($dbOptions);
	$response = array();
}
catch(Exception $e){
	die(json_encode(array('error' => $e->getMessage())));
}

$gravatar = "";

DB::query("
			INSERT INTO webchat_users (name, gravatar)
			VALUES (
				'".DB::esc($From)."',
				'".DB::esc($gravatar)."'
		)");


DB::query("
			INSERT INTO webchat_lines (author, gravatar, text)
			VALUES (
				'".DB::esc($From)."',
				'".DB::esc($gravatar)."',
				'".DB::esc($Body)."'
		)");
?>

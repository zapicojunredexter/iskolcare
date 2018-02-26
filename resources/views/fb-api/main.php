<?php
	require "fbsdk/src/Facebook/autoload.php";
	session_start();
$fb = new Facebook\Facebook([
 'app_id' => '866438290189041',
 'app_secret' => '197ecc05c5303c7ecb1ec4ad7c5329a6',
 'default_graph_version' => 'v2.2',
]);
?>
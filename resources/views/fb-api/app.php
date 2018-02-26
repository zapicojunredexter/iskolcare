<?php
	require "main.php";
	$message=$_GET['message'];
	$link=$_GET['link'];
	$helper = $fb->getRedirectLoginHelper();
	try {
	  	$accessToken = $helper->getAccessToken();
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  	echo $e->getMessage();
	  	exit;
	}
	 
	if (isset($accessToken)) {
	
		$cilent = $fb->getOAuth2Client();
		try {
		  $accessToken = $cilent->getLongLivedAccessToken($accessToken);
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  echo $e->getMessage();
		  exit;
		}
		$_SESSION['token'] = (string) $accessToken;
	  	header("Location: index.php?message=$message&link=$link");
	  	
	} elseif ($helper->getError()) {
	 	echo "Sorry, You cannot use the app without these permissions. Go back to <a href = 'index.php'>home</a>.";
	  	exit;
	}
		
?>
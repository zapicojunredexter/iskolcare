
	 
<?php
        // @include('fb-api.main')
	require "main.php";
	if (isset($_SESSION['token'])) {
	  try {
	 	
          ?>
<!--
    <form method = "post" action ="status.php">
        <input type = "text" name = "status" placeholder = "Status">
        <input type = "submit">
    </form>
-->
    <form method = "post" action ="link.php">
        <input type = "text" name = "link" placeholder = "Link" value="<?php echo $_GET['link'];?>">
        <input type = "text" name = "message" placeholder = "Message">
        <input type = "submit">
    </form>
    
<a href="http://127.0.0.1:8000/">to index</a>

            <?php
          
	  } catch( Facebook\Exceptions\FacebookSDKException $e ) {
	    echo $e->getMessage();
	    exit;
	  }
	}
	else{
		$helper = $fb->getRedirectLoginHelper();
		$permissions = ['email', 'user_posts', 'publish_actions'];
		$callback    = 'http://localhost/facebook-rv/app.php';
        $callback    = 'http://localhost/iskolcare-rv/resources/views/fb-api/app.php?message=qweqweqw&link='.$link;
        //$callback    = 'http://127.0.0.1:8000/app';
		$loginUrl    = $helper->getLoginUrl($callback, $permissions);
		echo '<center><a href="' . $loginUrl . '"><img src="http://127.0.0.1:8000/default-img/signin-facebook-large.png" style="width:400px;" alt="Login with facebook!"></a></center>';
		//echo '<button onclick="window.close();">close</button>';
	}
?>

	 
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
<link href="http://127.0.0.1:8000/css/bootstrap.min.css" rel="stylesheet" />
<body style="padding:0px;">
<div style="background-color:#336699;padding:10px;color:white;margin:0px;">Post to facebook
</div>
    <form method = "post" action ="link.php" style="padding:20px;">
        <input type = "text" name = "message" placeholder = "Say something" class="form-control">
        <div style="width:100%">
            <div style="width:33%;float:left;">
                <img src="http://127.0.0.1:8000/default-img/logo.png" style="width:100%;" alt="Login with facebook!">
            </div>
            <div style="width:65%;float:right;">
                <input type = "hidden" name = "link" placeholder = "link" value="<?php echo $_GET['link'];?>">
                <small><?php echo $_GET['link'];?></small>
                <p style="font-weight:bold;"><?php echo $_GET['message'];?></p>
            </div>
        </div>
        <br>
        <input type = "submit" value="SHARE" style="float:right;background-color:#336699;color:white;border:solid black 0px;padding:10px;">
    </form>
    

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
        $link=$_GET["link"];
        $message=$_GET["message"];
        //$callback    = 'http://localhost/iskolcare-rv/resources/views/fb-api/app.php?message=qweqweqw&link='.$link;
        $callback    = 'http://localhost/iskolcare-rv/public/fb-api/app.php?link='.$link.'&message='.$message;
        $loginUrl    = $helper->getLoginUrl($callback, $permissions);
		echo '<center><a href="' . $loginUrl . '"><img src="/default-img/signin-facebook-large.png" style="width:400px;" alt="Login with facebook!"></a></center>';
		//echo '<button onclick="window.close();">close</button>';
	}
?>
</body>
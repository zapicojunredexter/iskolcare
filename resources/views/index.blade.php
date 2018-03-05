<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Skol Care</title>
	<link rel="icon" href="img/logo.png">
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="landing/css/bootstrap.min.css" type="text/css">


    <!-- Plugin CSS -->
    <link rel="stylesheet" href="landing/css/animate.min.css" type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="landing/css/creative.css" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<style>
	.modal {
	background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.8); /* Black w/ opacity */
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 120px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    
}

/* Modal Content */
.modal-content {
    position: relative;
    margin: auto;
	text-align: center;
    padding: 0;
    border: none;
    width: 30%;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 0.4s;
    animation-name: animatetop;
    animation-duration: 0.4s
	padding-top: 2px;
	background: white;
	margin: auto;
	border-radius: 0;
	height: 480px;
}

.modal-content input{
	width: 80%;
	padding: 5px;
	height: 50px;
	font-size: 15px;
	margin: 15px  auto 10px auto;
	 border-bottom: 3px solid rgba(0,0,0,0.3);
	 border-top: none;
	 border-left: none;
	 border-right: none;
  font-family: Merriweather,'Helvetica Neue',Arial,sans-serif;
  background-color: transparent;	
}

/* Add Animation */
@-webkit-keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
}

@keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
}

/* The Close Button */
.close {
    color: black;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-header {
    padding: 2px 16px;
    background-color:transparent;
    color: #ffffff;
    border:none;
}

.modal-body {padding: 2px 16px;
 background-color: transparent;
 padding-bottom: 30px;
}
#hg{
	border: none;
}

	html {
    overflow: scroll;
    overflow-x: hidden;
}
::-webkit-scrollbar {
    width: 0px;  /* remove scrollbar space */
    background: transparent;  /* optional: just make scrollbar invisible */
}
/* optional: show position indicator in red */
::-webkit-scrollbar-thumb {
    background: #FF0000;
}

#button{
border: none;
style: none;
}
	</style>
	
</head>


<meta charset="utf-8">
<body>
<!--
<div class="btn-group btn-breadcrumb">
    <a href="http://" class="btn btn-default"><i class="glyphicon glyphicon-home"></i></a>
    <a href="http://" class="btn btn-default">qq</a>
    <a href="http://" class="btn btn-default">qq</a>
    <a href="http://" class="btn btn-default">qq</a>
</div>
-->
<div id="myModal" class="modal">
<!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close"></span>
    </div>
    <div class="modal-body">
				<div class='home'>
					<img src="default-img/useer.png" style="padding-top:3px; padding-bottom:2px; width: 50%;">
					<script>
                        function login(){
                            $.ajax({
                                url: "{{url('login')}}",
                                type: "post", 
		                        data: $("#loginForm").serialize(),
                                success: function(response) {
                                    response=JSON.parse(response);
                                    if(response.Message === 'Successful Login'){
                                        window.location.href="{{url('getProfile')}}";   
                                    }else{
                                        alert(response.Message);
                                    }
                                },
                                error: function(xhr) {
                                    console.log('error'+xhr);
                                    alert('Something went wrong!');
                                }
                            });                            
                        }
                    </script>
                    <form action="login" id="loginForm" method="post" onSubmit="login();return false;">
                        {{csrf_field()}}
                        <input type="text" name="username" placeholder="Username">
						<br>
						<input type="password"  placeholder="Password" name="password">
						<br><br>
                        
						<button type="submit" class="btn btn-primary btn-xl page-scroll" style="width: 80%;background-color:reguserhea#1b593e!important;">LOGIN NOW</button>
						
						<br>
						<p>Don't have any account yet? <a href="{{url('/registration')}}?type=subsc">SUBSCRIBE NOW!</a></p>
						<!--<div class='noty'>
						</div>
						<input type='submit' name='submit' value='Login' class='loginbutton'>
						<input type='reset' name='cancel' value='Cancel' class='loginbutton'>-->
                    </form>
					
				</div>
				            </div>
        </div>
  </div>

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top" >
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top"><img src="default-img/logo.png"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="#about" padding-top="27px">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#services" padding-top="27px">Services</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact" padding-top="27px">Contact</a>
                    </li>
					<li>
                        <a class="page-scroll" id="myBtn" href="#login" padding-top="27px">Login</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <header>
	
        <div class="header-content">
            <div class="header-content-inner" style="padding-top: 40px;">
				<h2>You only have to know one thing:</h2>
				<h1>Everyone can do something!</h1>
                <hr>
                <p><b>Start where you are. Use what you have. Do what you can.</b></p>
                <br><br>
            </div>
        </div>
    </header>

    <section class="bg-primary" id="about" style="background-color:#1b593e!important;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">We've got what you need!</h2>
                    <hr class="light">
                    <p class="text-faded text-justify">
                    ISKOLCARE is a platform that offers services School-based Community Extension Services could greatly benefit from.  It aids these services to manage their projects in a much more effecient manner. The ISKOLCARE platform could be seen as a tool that could be used to solve social problems these services aim to solve. Through the ISKOLCARE website, our users will be able to achieve more but be hassled less. Our aim is to promote the idea of volunteerism by eliminating common inconveniences a School-based Extension Department would normally encounter.
                    
                    </p>
                    <a href="{{url('/registration')}}?type=subsc" class="btn btn-default btn-xl wow tada page-scroll" >Become a Subscriber now!</a>
                </div>
            </div>
        </div>
    </section>

    <section id="services">
       <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Subscriptions Offered</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        
        
        
        
        <div class="container">
            <div class="row">
                <div style="float: left; text-align: center; width: 25%; margin-left: 5%; margin-top: 5%; background-color: rgb(120,207,191); color: white;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);">
		 <h3>PREMIUM</h3>
		 <div style="text-align: left; background-color: rgb(130,218,202); height: 100%; padding-top: 10%; padding-bottom: 10%; padding-left: 5%;">
		 <small style="font-size: 40px; padding-left: 15%;">₱ 249.99</small>
		 </div>
		 <div style="text-align: center; background-color: #f3f3f3; height: 100%; padding-top: 3%; color: rgb(195,195,195); padding-bottom: 10%;">
		 <h5 style="padding-bottom: 2%; padding-top: 2%;">Can add 10 activites</h5>
		 <h5 style="padding-top: 2%; padding-bottom: 2%;">Chu chu chu</h5>
		 <h5 style="padding-top: 2%; padding-bottom: 2%;">Cha cha cha cha</h5>
		 <h5 style="padding-top: 2%; padding-bottom: 2%;">Eklabosh ek ek</h5>
		 <h5 style="padding-top: 2%; padding-bottom: 2%;">Amen</h5>
		 <button>Go Premium</button>
		 </div>
		 </div>
		 
		 <div style="float: right; text-align: center; width: 25%; margin-left: 2.5%; margin-right: 5%; margin-top: 5%; background-color: rgb(227,83,108); color: white;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);">
		 <h3>PLATINUM</h3>
		 <div style="text-align: left; background-color: rgb(235,99,121); height: 100%; padding-top: 10%; padding-bottom: 10%; padding-left: 5%;">
		 <small style="font-size: 40px; padding-left: 12%;">₱ 1,149.99</small>
		 </div>
		 <div style="text-align: center; background-color: #f3f3f3; height: 100%; padding-top: 3%; color: rgb(195,195,195); padding-bottom: 10%;">
		 <h5 style="padding-bottom: 2%; padding-top: 2%;">Can add 50 activites</h5>
		 <h5 style="padding-top: 2%; padding-bottom: 2%;">Chu chu chu</h5>
		 <h5 style="padding-top: 2%; padding-bottom: 2%;">Cha cha cha cha</h5>
		 <h5 style="padding-top: 2%; padding-bottom: 2%;">Eklabosh ek ek</h5>
		 <h5 style="padding-top: 2%; padding-bottom: 2%;">Amen</h5>
		 <button class="button2">Go Platinum</button>
		 </div>
		 </div>
		 
		 <div style="float: right; text-align: center; width: 25%; margin-left: 5%; margin-right: 5%; margin-top: 5%; background-color: rgb(62,198,224); color: white;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);">
		 <h3>GOLD</h3>
		 <div style="text-align: left; background-color: rgb(83,207,233); height: 100%; padding-top: 10%; padding-bottom: 10%; padding-left: 5%;">
		 <small style="font-size: 40px; padding-left: 15%;">₱ 459.99</small>
		 </div>
		 <div style="text-align: center; background-color: #f3f3f3; height: 100%; padding-top: 3%; color: rgb(195,195,195); padding-bottom: 10%;">
		 <h5 style="padding-bottom: 2%; padding-top: 2%;">Can add 20 activites</h5>
		 <h5 style="padding-top: 2%; padding-bottom: 2%;">Chu chu chu</h5>
		 <h5 style="padding-top: 2%; padding-bottom: 2%;">Cha cha cha cha</h5>
		 <h5 style="padding-top: 2%; padding-bottom: 2%;">Eklabosh ek ek</h5>
		 <h5 style="padding-top: 2%; padding-bottom: 2%;">Amen</h5>
		 <button class="button1">Go Gold</button>
		 </div>
		 </div>
            </div>
        </div>
        
        
        
       <div class="container" style="padding-top: 35px">
        <div class="row">
                	<div class="col-xl-12 text-center">
                    <!--<a href="#portfolio" class="btn btn-primary btn-xl wow tada page-scroll">Get me started!</a>-->
                    </div>
                    </div>
                    </div>
    </section>
 <aside class="bg-dark">
        <div class="container text-center">
            <div class="call-to-action">
                <h2>Any Questions You Would Like To Ask?</h2>
                <a href="#contact" class="btn btn-default btn-xl wow tada page-scroll">Contact Us!</a>
            </div>
        </div>
    </aside>

    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <h2 class="section-heading">Let's Get In Touch!</h2>
                    <hr class="primary">
                    <p>Ready to capture your memories with us? That's great! Give us a call or send us an email and we will get back to you as soon as possible!</p>
                </div>
                <div class="col-lg-4 col-lg-offset-2 text-center">
                    <i class="fa fa-phone fa-3x wow bounceIn"></i>
                    <p>032-45F-OCUS (032-453-6287)</p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="fa fa-envelope-o fa-3x wow bounceIn" data-wow-delay=".1s"></i>
                    <p><a href="mailto:your-email@your-domain.com">iskolcare@feedback.com</a></p>
                </div>
            </div>
        </div>
    </section>

    <!-- jQuery -->
    <script src="landing/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="landing/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="landing/js/jquery.easing.min.js"></script>
    <script src="landing/js/jquery.fittext.js"></script>
    <script src="landing/js/wow.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="landing/js/creative.js"></script>
	
	<script>
			// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
		</script>
	
</body>

</html>

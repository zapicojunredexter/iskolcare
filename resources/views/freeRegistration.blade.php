<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content={{csrf_token()}}>
		
        <title>Laravel</title>
		<script src="{{asset('js/jquery.min.js')}}"></script>
        @include('includes.libs')
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
	height: 450px;
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


.loginform{
	padding-top: 0;
	width: 48%;
	background: rgba(0,0,0,0.1);
	margin: auto;
	height: 440px;
	padding-bottom: 0;
	padding-left: 30px;
	float: left;
}

.loginform1{
	padding-top: 0;
	width: 48%;
	background: rgba(0,0,0,0.1);
	margin: auto;
	height: 440px;
	padding-bottom: 0;
	padding-left: 30px;
	float: right;
}

.hg{
	background-color: white;
}

#a{
	color: black;
	
}

#a:hover{
color: #4ba4ff;
}

.loginform input{
	width: 40%;
	padding: 5px;
	height: 20px;
	font-size: 15px;
	margin: 15px  auto 10px auto;
	 border-bottom: 3px solid rgba(0,0,0,0.3);
	 border-top: none;
	 border-left: none;
	 border-right: none;
  font-family: Merriweather,'Helvetica Neue',Arial,sans-serif;
  background-color: transparent;	
}

.loginform1 input{
	width: 40%;
	padding: 5px;
	height: 20px;
	font-size: 15px;
	margin: 15px  auto 10px auto;
	 border-bottom: 3px solid rgba(0,0,0,0.3);
	 border-top: none;
	 border-left: none;
	 border-right: none;
  font-family: Merriweather,'Helvetica Neue',Arial,sans-serif;
  background-color: transparent;	
}

.loginform button {
    /* Size and position */
    width: 30%;
    height: 102px;
    float: right;
    position: relative;
    overflow: hidden;

    /* Styles */
    background: 
    	url(../images/noise.png), 
    	radial-gradient(ellipse at center, #29d159 0%,#197f36 100%);
    border-radius: 0 5px 5px 0;
    box-shadow:
        inset 0 0 4px rgba(255, 255, 255, 0.7), 
        inset 0 0 0 1px rgba(0, 0, 0, 0.2);
    border: none;
    border-left: 1px solid silver;
    cursor: pointer;  
    line-height: 300px; /* Same as height */
}

.loginform button i {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: -20px;
    font-size: 30px;
    line-height: 300px;
    color: black;
    opacity: 0;
    text-shadow: 0 1px 0 rgba(255,255,255,0.4);
    transition: all 0.2s ease-out;
}

.loginform button span {
    display: block;

    /* Font styles */ 
    color: #8d1645;
    font-family: 'Montserrat', Arial, sans-serif; 
    font-size: 20px;
    text-shadow: 0 1px 0 white;
    transform: rotate(-90deg);
    transition: all 0.2s linear;
	text-align: center;
}
.loginform button:focus {
    outline: none;
}

.loginform button:hover span,
.loginform button:focus span {
    color: white;
    
}

.loginform button:hover i,
.loginform button:focus i {
    opacity: 0.5;
    left: 0;
    transition-delay: 0.2s;
}

/* Click on button */

.loginform button:active span,
.loginform button:active i {
    transition: none; 
}

.loginform button:active span {
    opacity: 0;
}

.loginform button:active i {
    opacity: 0.5;
    left: 0;
    color: #fff;
}	


.loginform1 button {
    /* Size and position */
    width: 30%;
    height: 102px;
    float: right;
    position: relative;
    overflow: hidden;

    /* Styles */
    background: 
    	url(../images/noise.png), 
    	radial-gradient(ellipse at center, #29d159 0%,#197f36 100%);
    border-radius: 0 5px 5px 0;
    box-shadow:
        inset 0 0 4px rgba(255, 255, 255, 0.7), 
        inset 0 0 0 1px rgba(0, 0, 0, 0.2);
    border: none;
    border-left: 1px solid silver;
    cursor: pointer;  
    line-height: 300px; /* Same as height */
}

.loginform1 button i {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: -20px;
    font-size: 30px;
    line-height: 300px;
    color: black;
    opacity: 0;
    text-shadow: 0 1px 0 rgba(255,255,255,0.4);
    transition: all 0.2s ease-out;
}

.loginform1 button span {
    display: block;

    /* Font styles */ 
    color: #8d1645;
    font-family: 'Montserrat', Arial, sans-serif; 
    font-size: 20px;
    text-shadow: 0 1px 0 white;
    transform: rotate(-90deg);
    transition: all 0.2s linear;
	text-align: center;
}
.loginform1 button:focus {
    outline: none;
}

.loginform1 button:hover span,
.loginform1 button:focus span {
    color: white;
    
}

.loginform1 button:hover i,
.loginform1 button:focus i {
    opacity: 0.5;
    left: 0;
    transition-delay: 0.2s;
}

/* Click on button */

.loginform1 button:active span,
.loginform1 button:active i {
    transition: none; 
}

.loginform1 button:active span {
    opacity: 0;
}

.loginform1 button:active i {
    opacity: 0.5;
    left: 0;
    color: #fff;
}
	</style>
    </head>
    <body>
        
        
        <nav id="mainNav" class="navbar navbar-default navbar-fixed-top" style="border-bottom: 1px solid rgba(0,0,0,0.3); background: transparent;">
        <div class="container-fluid" style="color: black;">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll"><img  style="width:60px;height:35px;" src="default-img/logo.png"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="{{url('/')}}?#about" padding-top="27px" id="a">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="{{url('/')}}?#services" padding-top="27px" id="a">Services</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="{{url('/')}}?#contact" padding-top="27px" id="a">Contact</a>
                    </li>
					<li>
                        <a class="page-scroll" id="myBtn" href="#login" padding-top="27px" style="color: black;">Login</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
        
        
        <div class="container">
            <div style="margin-left:200px;margin-right:200px;">
                <h3>FREE USERS REGISTRATION</h3>
                <form method="POST" action='{{ url('/normalRegistration')}}'>{{csrf_field()}}
                <br>First Name: 
                <input type="text" name="name" placeholder="Name" class="form-control"><br>Last Name: 
                <input type="text" name="lastName" placeholder="lastName" class="form-control">
                <br>Username:
                <input type="text" name="username" placeholder="Username" class="form-control">
                <br>Password:
                <input type="text" name="password" placeholder="Password" class="form-control">
                <br>Contact Number
                <input type="text" name="contactNumber" placeholder="Contact Number" class="form-control">
                <br>Address
                <input type="text" name="address" placeholder="Address" class="form-control">
                <br>E-mail Address
                <input type="text" name="emailAddress" placeholder="Email Address" class="form-control">
    <br>Birthdate
                <input type="date" name="birthdate" value="<?php echo date('Y-m-d'); ?>" class="form-control">
    <br>Gender<br>
                Male <input type="radio" value="Male" name="gender"><br>
                Female<input type="radio" value="Female" name="gender"><br>



                <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </body>
</html>

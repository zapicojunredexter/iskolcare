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
        

<body id="page-top">

<meta charset="utf-8">
<body onload='loadmodal()'>
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
                        <a class="page-scroll" href="{{url('/')}}#about" padding-top="27px">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="{{url('/')}}#services" padding-top="27px">Services</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="{{url('/')}}#contact" padding-top="27px">Contact</a>
                    </li>
					<li>
                        <a class="page-scroll" id="myBtn" href="{{url('/')}}#login" padding-top="27px">Login</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <div class="row" style="margin-top:100px;">
	
        <div class="col-sm-3">
        
        </div>
        <div class="col-sm-6">
            <h3>Registration Form</h3>
            
            <form method="POST" id="registrationForm" onsubmit="validateForm();return false;">{{csrf_field()}}
                
                
            <div class="row">
                <div class="col-sm-12" style="margin-top:30px;">
                    <input type="email" name="emailAddress" placeholder="Email Address*" class="form-control" required>
                </div>
                <div class="col-sm-12" style="margin-top:30px;">
                    <input type="text" name="contactNumber" placeholder="Contact Number*" class="form-control" required>
                </div>
                <div class="col-sm-12" style="margin-top:30px;">
                    <input type="text" name="address" placeholder="Address*" class="form-control" required>
                </div>
                <div class="col-sm-12" style="margin-top:30px;">
                    <input type="text" name="username" placeholder="Username" class="form-control" required>
                </div>
                <div class="col-sm-6" style="margin-top:30px;">
                    <input type="password" id="password" name="password" placeholder="Password*" class="form-control" required>
                </div>
                <div class="col-sm-6" style="margin-top:30px;">
                    <input type="password" id="confirm_password" name="password1" placeholder="Re-type Password" class="form-control" required>
                </div>

                
            </div>
            
            <input type="button" onclick="validateForm()" value="Submit">
            </form>
            <script>
                function validateForm(){
                    var password=document.getElementById("password"),confirm_password=document.getElementById("confirm_password");
                    if(password.value != confirm_password.value){
                        alert("Passwords must match");
                        //confirm_password.setCustomValidity("Passwords do not match!");
                    }else{
                            $.ajax({
                                url: "{{ url('/becomeSubscriber') }}",
                                type: "post", 
		                        data: $("#registrationForm").serialize(),
                                success: function(response) {
                                    if(response === "Successfully Created new Account"){
                                        window.location.href="{{url('getProfile')}}";
                                    }else{
                                        alert(response);
                                    }
                                },
                                error: function(xhr) {
                                    console.log('error'+xhr);
                                    alert('Something went wrong!');
                                }
                            });                            
                        
                    }
                 //   alert('in here');
                }
            </script>
        </div>
        <div class="col-sm-3">
    
        </div>
    </div>



	@include('includes.scripts')
</body>

</html>

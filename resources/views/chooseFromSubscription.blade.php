<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.libs')
    <title>Upgrade Account</title>
</head>

<body>
    <div class="wrapper" style="background-color:#e6eaeb;">

        @if(Session::get('type')==='Director')
            @include('includes.directorSidebar')
        @elseif(Session::get('type')==='Coordinator')
            @include('includes.coordinatorSidebar')
        @else
            @include('includes.regUserSidebar')
        @endif
        <div class="main-panel">
            <?php
                $label="Subscriptions";
            ?>
            @include('includes.regUserHeader')
            <div class="content">
                <div class="container-fluid">
				<!--
                    <div>
                        <table class="table table-striped">
                        @foreach($subscriptions as $subscription)
                            <tr>
                                <td>{{$subscription->SubscriptionName}}</td>
                                <td>{{$subscription->SubscriptionDuration}}</td>
                                <td>{{$subscription->SubscriptionPrice}}</td>
                                <td><a href="{{url('payWithPayPal')}}?id={{$subscription->SubscriptionId}}">Checkout with paypal</a></td>
                            </tr>
                        @endforeach
                        </table>
                        
                    </div>
                   --> 
                    
                    
        <div class="container">
            <div class="row">
                
                <div class="col-sm-4">
                <div style="text-align: center; background-color: rgb(120,207,191); color: white;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);padding:0px;">
		 <h3 style="padding-top:10px;">{{$subscriptions[0]->SubscriptionName}}</h3>
		 <div style="text-align: left; background-color: rgb(130,218,202);">
		 <small style="font-size: 40px; padding-left: 15%;">₱ {{$subscriptions[0]->SubscriptionPrice}}</small>
		 </div>
		 <div style="text-align: center; background-color: #f3f3f3; height: 100%; padding-top: 3%; color: rgb(195,195,195); padding-bottom: 10%;">
		 <h5 style="padding-bottom: 2%; padding-top: 2%;">{{$subscriptions[0]->SubscriptionDescription}}</h5>
             <a href="{{url('payWithPayPal')}}?id={{$subscriptions[0]->SubscriptionId}}"><button>Go Premium</button></a>
		 </div>
		 </div>
                </div>
                
                
                <div class="col-sm-4">
                <div style="text-align: center; background-color: rgb(227,83,108); color: white;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);padding:0px;">
		 <h3 style="padding-top:10px;">{{$subscriptions[1]->SubscriptionName}}</h3>
		 <div style="text-align: left; background-color: rgb(235,99,121);">
		 <small style="font-size: 40px; padding-left: 15%;">₱ {{$subscriptions[1]->SubscriptionPrice}}</small>
		 </div>
		 <div style="text-align: center; background-color: #f3f3f3; height: 100%; padding-top: 3%; color: rgb(195,195,195); padding-bottom: 10%;">
		 <h5 style="padding-bottom: 2%; padding-top: 2%;">{{$subscriptions[1]->SubscriptionDescription}}</h5>
            <a href="{{url('payWithPayPal')}}?id={{$subscriptions[1]->SubscriptionId}}"><button>Go Gold</button></a>
		 </div>
		 </div>
                </div>
                
		 
                <div class="col-sm-4">
                <div style="text-align: center;  background-color: rgb(62,198,224); color: white;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);padding:0px;">
		 <h3 style="padding-top:10px;">{{$subscriptions[2]->SubscriptionName}}</h3>
		 <div style="text-align: left;  background-color: rgb(83,207,233);">
		 <small style="font-size: 40px; padding-left: 15%;">₱ {{$subscriptions[2]->SubscriptionPrice}}</small>
		 </div>
		 <div style="text-align: center; background-color: #f3f3f3; height: 100%; padding-top: 3%; color: rgb(195,195,195); padding-bottom: 10%;">
		 <h5 style="padding-bottom: 2%; padding-top: 2%;">{{$subscriptions[2]->SubscriptionDescription}}</h5>
             <a href="{{url('payWithPayPal')}}?id={{$subscriptions[2]->SubscriptionId}}"><button>Go Platiunum</button></a>

		 </div>
		 </div>
                </div>
		 
            </div>
        </div>
                    
                    
                    
                    
                    
                    
                    
                    
                </div>
            </div>
			<!-- start sa footer-->
            <footer class="footer">
                <div class="container">
                    <nav>
                        <ul class="footer-menu">
                            <li>
                                <a href="#">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Company
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Portfolio
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Blog
                                </a>
                            </li>
                        </ul>
                        <p class="copyright text-center">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                            <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                        </p>
                    </nav>
                </div>
            </footer>
			
			<!-- end sa footer-->
        </div>
    </div>
    @include('includes.scripts')
    
</body>


</html>
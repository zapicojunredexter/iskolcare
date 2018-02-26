<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.libs')
    <title>Evaluation</title>
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
				
                    <div>
					    {{print_r($subscriptions)}}
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
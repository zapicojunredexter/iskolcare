<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.libs')
    <title>My Profile</title>
</head>

<body>
    <div class="wrapper" style="background-color:#e6eaeb;">

        @if(Session::get('type')==='Director')
            @include('includes.directorSidebar')
        @elseif(Session::get('type')==='Coordinator')
            @include('includes.coordinatorSidebar')
        @elseif(Session::get('type')==='Registered User')
            @include('includes.regUserSidebar')
        @else
            @include('includes.superAdminSideBar')
        @endif
        <div class="main-panel">
            <?php
                $label = "My Profile";
            ?>
            @if(Session::get('type')!=='Super Admin')
                @include('includes.regUserHeader')
            @else
                @include('includes.superAdminHeader')
            @endif
            <div class="content" style="padding:0px;">
                @if(Session::get('type')==='Director')
                    @include('DirectorProfile')
                @elseif(Session::get('type')!=='Super Admin')
                    @include('RegUserProfile')   
                @endif
            



                <div class="container-fluid">
    
                    <div class="row">
				
                       <!--start sa if admin-->
                        <div class="container">
                        @if(Session::get('type')==="Super Admin")
                        
                            <h1>LOGGED IN AS ADMIN</h1>
             
                            <!--start sa chart-->
                            <h3>TRANSACTION HISTORY</h3>
                            <canvas id="bar-chart" height="100px"></canvas>
                                        <script src="js/Chart.js">
                                        </script>
                                        <script src="js/Chart.bundle.js">
                                        </script>
                                        <script src="js/utils.js">
                                        </script>
                                        <script>

                                            loadBarChar();
    function getMonthString(month){
        var strMonth="";
        switch(month){
            case 1 :
                strMonth="January";
                break;
            case 2 :
                strMonth="February";
                break;
            case 3 :
                strMonth="March";
                break;
            case 4 :
                strMonth="April";
                break;
            case 5 :
                strMonth="May";
                break;
            case 6 :
                strMonth="June";
                break;
            case 7 :
                strMonth="July";
                break;
            case 8 :
                strMonth="August";
                break;
            case 9 :
                strMonth="September";
                break;
            case 10 :
                strMonth="October";
                break;
            case 11 :
                strMonth="November";
                break;
            case 12 :
                strMonth="December";
                break;
        }
        return strMonth;
    }
    function loadBarChar(){
        var dates={!!json_encode($monthsYears)!!};
        console.log(dates);
        
        var transactions={!!json_encode($subscriptionTransctions)!!};
        console.log(transactions);
        
        var myLabels = dates.map((element) => {
            return getMonthString(element.Month) + " " +element.Year; 
        });
        console.log(myLabels);     
        var counters = [];
        //counters.push(21);
        dates.forEach((date,index) => {
            var counter = 0;
            transactions.forEach((transaction,index) => {
                //console.log(Number(transaction.TransactionDate.substr(0,4)));
                if((Number(transaction.TransactionDate.substr(5,2))==Number(date.Month)) && (Number(transaction.TransactionDate.substr(0,4))==Number(date.Year)))
                    counter++;
            });
            counters.push(counter);
        });
        console.log(counters);
        new Chart(document.getElementById('bar-chart'),{
            type: 'line',
            data: {
                labels: myLabels,
                datasets: [
                    {
                        label: "Transactions Done",
                        borderColor: "#3e95cd",
                        data: counters,
                        lineTension: 0,
                        fill:false,
                    },
                ]
            },
            options:{
                title:{
                    display: true,
                    text: 'Transactions Done',
                }
            }
        });
            
	
        
        
        
        
    }
                                        </script>
                           
                            <!--end sa chart-->


                            <table class="table table-striped">
                                <tr style="background-color:#1b593e;color:white;">
                                    <th>University Name</th>
                                    <th>Transaction Date</th>
                                </tr>
                                @foreach($subscriptionTransctions as $transac)
                                <tr>
                                    <td>{{$transac->UniName}}</td>
                                    <td>{{$transac->TransactionDate}}</td>
                                </tr>
                                @endforeach
                            </table>

                        @endif
                        </div>
                        <!--end sa if admin-->
    
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
    
<script src="js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="js/plugins/bootstrap-notify.js"></script>
    <script src="js/demo.js"></script>
    @include('includes.scripts')
    <script type="text/javascript">

        $(document).ready(function() {
                @if(!empty($upcomingActivities))
				@foreach($upcomingActivities as $upcAct)
                    <?php

                        $date1 = new \DateTime(date("Y-m-d"));
                        $date2 = new \DateTime($upcAct->SchedDate);
                        $dif = $date1->diff($date2);
                        $difference = $dif->format("%R%a days");
                        if($difference<3){
                            if($difference === "+0 days"){
                               echo "demo.showNotification('top','left',`Reminder! The $upcAct->ActivityName Activity is today!`);";    
                            }elseif($difference === "+1 days"){
                               echo "demo.showNotification('top','left',`Reminder! The $upcAct->ActivityName Activity will be tomorrow!`);";
                            }else{
                                echo "demo.showNotification('top','left',`Reminder! The $upcAct->ActivityName Activity will be in $difference!`);";
                            }
                        }
                    ?>
                @endforeach
                @endif
                @if(!empty($upcomingInstLevel))
                    @foreach($upcomingInstLevel as $upcAct)
                         <?php

                            $date1 = new \DateTime(date("Y-m-d"));
                            $date2 = new \DateTime($upcAct->SchedDate);
                            $dif = $date1->diff($date2);
                            $difference = $dif->format("%R%a days");
                            if($difference<3){
                                if($difference === "+0 days"){
                                   echo "demo.showNotification('top','left',`Reminder! The $upcAct->ActivityName Activity is today!`);";    
                                }elseif($difference === "+1 days"){
                                   echo "demo.showNotification('top','left',`Reminder! The $upcAct->ActivityName Activity will be tomorrow!`);";
                                }else{
                                    echo "demo.showNotification('top','left',`Reminder! The $upcAct->ActivityName Activity will be in $difference!`);";
                                }
                            }
                        ?>
                    @endforeach
                @endif
            // Javascript method's body can be found in assets/js/demos.js
            /*demo.initDashboardPageCharts();

            demo.showNotification('top','left','haha<a href="{{url('logout')}}">fill up</a>')
            demo.showNotification();*/

        });
    </script>
</body>


</html>
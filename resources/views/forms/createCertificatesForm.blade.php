<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.libs')
    <title>Create Certificates</title>
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
                $label="Create Certificates";
            ?>
            @include('includes.regUserHeader')
            <div class="content">
                <div class="container-fluid">
				
                    <div class="row">
                      
                      
                      <!--start sa create certificate contents-->
                      <div id="data" class="col-sm-12">   
                          <div class="row">
                              <div class="col-sm-12">
                                  <a href="{{url('getActivityPage')}}?id={{$activity->ActivityId}}#tab-participants">
                                  <h3 style="display:inline;">{{$activity->ActivityName}}</h3>
                                  </a>
                                  <br><br>
                              </div>
                                <div class="col-sm-10">
                                    <input class="form-control"type="text" onkeyup="changeFontSize()" placeholder="Size of name" id="size">
                                </div>
                              <div class="col-sm-2">
                                  <button onclick="printCertificates()" class="blue-button">GET PDF</button>
                                
                              </div>
                          </div> 
                          <br>
                          <div style="border:solid black 1px;margin:auto;page-break-after:always;display:flex;justify-content:center;overflow:scroll;">
                            <div style="position:absolute;align-self:center;;z-index:1;" id="name">John Doe</div>
                            <img  style="align-self:center;width:320mm;height:190mm;" src="img/certificates/{{Session::get('type')}}-{{Session::get('accountId')}}-certificate-photo.jpg" >
                          </div>
                      </div>
                      <script>
                          function printCertificates(){
                          var size = document.getElementById('size').value;
                            var w=window.open("printCertificates?actId={{$activityId}}&size="+size+"&for={{$for}}");
                            w.onload=function(){w.print();w.close()};   
                          }
                          function changeFontSize(){  
                            var size = document.getElementById('size').value;
                              if(size<=200)
                              document.getElementById('name').style.fontSize=size+'px';
                          }

                      </script>
                <!-- end sa create certificate contents -->



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

<script src="{{asset('js/jquery.min.js')}}"></script>
<script>

    
   setInterval(function(){
    $.ajax({
		url: "{{url('getUnreadNotifications')}}",
		type: "get", 
        success: function(response) {
          response=JSON.parse(response);
            console.log(response);
            if(response.Message !== undefined){
                window.location.href="{{url('getProfile')}}";
            }else{
                $('#notifitems').html("");
                
                for(var i=0;i<response.length;i++){
                    if(i === 0)
                        $('#notifitems').append("<a class='dropdown-item' href='"+response[i].LinksTo+"&notifId="+response[i].NotificationId+"'>"+response[i].Description+"</a>");
                    else
                        $('#notifitems').append("<hr><a class='dropdown-item' href='"+response[i].LinksTo+"&notifId="+response[i].NotificationId+"'>"+response[i].Description+"</a>");
                }
                if(response.length>0){
                    $('#notif-counter').css('display','block');
                    
                    $('#notif-counter').html(response.length);
                    
                }else{
                    $('#notif-counter').css('display','none');
                    $('#notifitems').append("<li>No new notifications</li>");
                    
                }    
            }  
		},
		error: function(xhr) {
		}
	});

    },10000);



    
    $.ajax({
		url: "{{url('getUnreadNotifications')}}",
		type: "get", 
        success: function(response) {
            response=JSON.parse(response);
            console.log(response);
             $('#notifitems').html("");
            
            for(var i=0;i<response.length;i++){
                if(i === 0)
                    $('#notifitems').append("<a class='dropdown-item' href='"+response[i].LinksTo+"&notifId="+response[i].NotificationId+"'>"+response[i].Description+"</a>");
                else
                    $('#notifitems').append("<hr><a class='dropdown-item' href='"+response[i].LinksTo+"&notifId="+response[i].NotificationId+"'>"+response[i].Description+"</a>");
            }
            if(response.length>0){
                $('#notif-counter').css('display','block');
                
                $('#notif-counter').html(response.length);
                
            }else{
                $('#notif-counter').css('display','none');
                $('#notifitems').append("<li>No new notifications</li>");
                
            }
		},
		error: function(xhr) {
		}
	});
    
</script>
        
<!-- Navbar -->
        
<nav class="navbar navbar-expand-lg " color-on-scroll="500">
        
    <div class=" container-fluid  ">
        
        <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        
            <span class="navbar-toggler-bar burger-lines"></span>
        
            <span class="navbar-toggler-bar burger-lines"></span>
        
            <span class="navbar-toggler-bar burger-lines"></span>
        
        </button>
        
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
        
            <ul class="nav navbar-nav mr-auto">
                @if(!empty($label))
                <li class="nav-item">
                    <b>
                    {{$label}}
                    </b>
                </li>
                @endif
        <!--start sa notifications-->
                            
                <li class="dropdown nav-item">
                    
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">

                        <i class="nc-icon nc-bell-55"></i>

                        <span class="notification" style="display:none;" id="notif-counter"></span>

                        <span class="d-lg-none">Notification</span>

                    </a>
                    <!-- if ibalhine sa right dropdown-menu-right -->
                    <ul class="dropdown-menu" id="notifitems">

                        <li>No new notifications</li>

                    </ul>

                </li>

                <!--end sa notifications-->
                
            </ul>
        
            <ul class="navbar-nav ml-auto">
        
                <!--
        
                <li class="nav-item">
        
                    <input type="text" style="border-radius:50px;border:solid silver 1px;padding:10px;" placeholder="Search ...">
        
                </li>
        
                -->
                <script>
                    function masterSearch(value){
                        if(value!==""){
                            $('#search-results').css('display','block');
                        }else{
                            $('#search-results').css('display','none');    
                        }
                    }
                </script>
                <li class="nav-item">
                    <input type="text" name="" onkeyup="masterSearch(this.value)" class="serch" id="">
                    <div id="search-results" style="display:none;position:absolute;background-color:silver;width:180px;z-index:100;">
                    adsas<br>
                    adsas<br>
                    adsas<br>
                    adsas<br>
                    adsas<br>
                    </div>
                </li>
                <li class="nav-item" style="margin-right:20px;">
                    <a>Logged in as {{Session::get('type')==='Registered User'?'Regular User':Session::get('type')}}</a>
                    
                </li>
                            
                <li class="nav-item">
                
        
                        <ul class="nav navbar-nav mr-auto">


                            <!--
                            <li class="dropdown nav-item">
                                <input type="text" name="" class="serch" placeholder="Search..." id="">
                            </li>
                            -->


                            <li class="dropdown nav-item">
            
                                <a href="#" class="dropdown-toggle nav-link" style="padding:0px;" data-toggle="dropdown">
        
                                    @if(Session::get('type')==='Director')
        
                                        <img src="img/logos/{{Session::get('pic')}}" style="border:solid rgba(0,0,0,0.2) 3px; border-radius: 50%;width:50px;height:50px;">
        
                                    @else
        
                                        <img src="img/dp/{{Session::get('pic')}}" style="border:solid rgba(0,0,0,0.2) 3px; border-radius: 50%;width:50px;height:50px;">
        
                                    @endif
        
                                </a>
        
                                <ul class="dropdown-menu dropdown-menu-right">
        
                                    <li onclick="window.location.href='{{url('getProfile')}}'" class="dropdown-item"><a href="{{url('getProfile')}}">{{Session::get('name')}}'s Profile</a></li>
        
                                    <li class="divider"></li>
        
                                    <li onclick="window.location.href='{{url('logout')}}'" class="dropdown-item"><a href="{{url('logout')}}">Logout</a></li>
        
                                </ul>
        
                            </li>
        
                        </ul>

    
        
                </li>
        
            </ul>
        
        </div>
        
    </div>
        
</nav>
        
<!-- End Navbar -->
                        


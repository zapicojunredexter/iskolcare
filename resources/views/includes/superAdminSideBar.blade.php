
		<!-- start sa sidebar-->
        <div class="sidebar" data-color="green" style="">
            <!--
                 data-image="img/logos/1-university-logo-photo.jpg"
                "img/logos/1-university-logo-photo.jpg"

        data-image="../assets/img/sidebar-5.jpg"

        Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"
$('--').data('image');
        Tip 2: you can also add an image using data-image tag
    -->
            <div class="sidebar-wrapper" style="background-color:#1b593e;">
                <div class="logo" style="align-items:center;justify-content:center;text-align:center;">
                    <!--
					<img src="default-img/logo.png" style="margin-left:25%;width:50%;">
                    -->
					<img src="default-img/mini-logo.png" style="margin-left:autopx;width:30%;">
                </div>
                <ul class="nav">
                    <li class="{{Request::is('getProfile') ? 'nav-item active': ''}}">
                        <a class="nav-link" href="{{url('getProfile')}}">
                            <i class="nc-icon nc-single-02"></i>
                            <p>DASHBOARD</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{url('getSubscribedSchools')}}">
                            <i class="nc-icon nc-istanbul"></i>
                            <p>SUBSCRIBED SCHOOLS</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <script>
    function getUniversityLists(){
        
    $.ajax({
		url: "{{url('getUniversityListsJson')}}",
		type: "get", 
        success: function(response) {
            response=JSON.parse(response);
            console.log('na');
            console.log(response);
             $('#universities-dropdown').html("");
            for(var i=0;i<response.length;i++){
                $('#universities-dropdown').append("<li class='uni-list-dropdown'><div><a href='getUniversityProfile?id="+response[i].UniId+"'>"+response[i].UniName+"</a></div></li>");
                
            }
            
            $('#universities-dropdown').toggle('slide');
		},
		error: function(xhr) {
            alert('error upon connecting to db');
		}
	});
    }
</script>
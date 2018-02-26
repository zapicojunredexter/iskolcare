<!-- start sa tabs-->
<div class="col-md-12">                     
    <div class="row" style="margin-top:20px;margin-bottom:20px;">
        @if(Request::is('getUniversityProfile'))
            <div class="col-md-3" style="border-top-left-radius:7px;border-top-right-radius:7px;border-top:solid silver 1px;border-left:solid silver 1px;border-right:solid silver 1px;padding:10px;text-align:center;">
                <a
                   style="color: black;width:200px;"
                   href="{{url('/getUniversityProfile?')}}id={{$university->UniId}}">About</a>
            
            </div>
        @else
            <div class="col-md-3" style="border-bottom: solid silver 1px;padding:10px;text-align:center;">
				<a
                   style="color: black;width:200px;"
                   href="{{url('/getUniversityProfile?')}}id={{$university->UniId}}">About</a>    
            </div>
        
        @endif

        @if(Request::is('getUniversityAnnouncements'))
            <div class="col-md-3" style="border-top-left-radius:7px;border-top-right-radius:7px;border-top:solid silver 1px;border-left:solid silver 1px;border-right:solid silver 1px;padding:10px;text-align:center;">
				<a
                   style="color: black;width:200px;"
                   href="{{url('/getUniversityAnnouncements?')}}id={{$university->UniId}}">Announcements</a>
            </div>
        @else
            <div class="col-md-3" style="border-bottom: solid silver 1px;padding:10px;text-align:center;">
				<a
                   style="color: black;width:200px;"
                   href="{{url('/getUniversityAnnouncements?')}}id={{$university->UniId}}">Announcements</a>
            </div>
        
        @endif
        
        @if(Request::is('getUniversityProgramsSpecific') || Request::is('getUniversityPrograms'))
            <div class="col-md-3" style="border-top-left-radius:7px;border-top-right-radius:7px;border-top:solid silver 1px;border-left:solid silver 1px;border-right:solid silver 1px;padding:10px;text-align:center;">
                <a
                   style="color: black;width:200px;"
                   href="{{url('/getUniversityPrograms?')}}id={{$university->UniId}}">Programs</a>
            </div>
        @else
            <div class="col-md-3" style="border-bottom: solid silver 1px;padding:10px;text-align:center;">
                <a
                   style="color: black;width:200px;"
                   href="{{url('/getUniversityPrograms?')}}id={{$university->UniId}}">Programs</a>    
            </div>
        @endif

        @if(Request::is('getUniversityProjects'))
            <div class="col-md-3" style="border-top-left-radius:7px;border-top-right-radius:7px;border-top:solid silver 1px;border-left:solid silver 1px;border-right:solid silver 1px;padding:10px;text-align:center;">
                <a
                    style="color: black;width:200px;"
                    href="{{url('/getUniversityProjects?')}}id={{$university->UniId}}">Projects</a>    
            </div>
        @else
            <div class="col-md-3" style="border-bottom: solid silver 1px;padding:10px;text-align:center;">
                <a
                    style="color: black;width:200px;"
                    href="{{url('/getUniversityProjects?')}}id={{$university->UniId}}">Projects</a>    
            </div>

        @endif
    </div>
</div>
                       <!-- end sa tabs-->
                   
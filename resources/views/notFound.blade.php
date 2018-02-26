<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.libs')
    <title>My Profile</title>
</head>

<body>
    @if(Session::get('type')!=='Super Admin')
        @include('includes.regUserHeader')
    @else
        @include('includes.superAdminHeader')
    @endif
		
    <div style="text-align:center;">
        <a href="{{URL::previous()}}">Go Back!</a>
        <h1>{{!empty($message)?$message:'The item you are looking for could not be found'}}</h1>
    </div>
    @include('includes.scripts')
    
</body>


</html>
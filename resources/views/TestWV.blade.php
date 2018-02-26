<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    @include('includes.libs')

</head>
<body>

<div style="padding:10px;">
<form action="{{url('uploadPhotosFromMobile')}}" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    <input type="hidden" name="activityId" value="{{$activityId}}">
    <input type="hidden" name="userType" value="{{$userType}}">
    <input class="btn btn-default"  class="form-control" type="file" name="images" style="width:100%;" required>
    
    <input type="submit" value="UPLOAD" class="blue-button" style="margin-top:40px;width:100%;">
    
</form>
</div>

</body>
</html>
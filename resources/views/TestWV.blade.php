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
    <!--
<div style="padding:10px;">
    <div style="width:100%;min-height:80px;">
        <div style="width:30%;float:left;">
            <b>Activity Name</b>
        </div>
        <div style="width:70%;float:right;">{{$activity->ActivityName}}</div>
    </div>
    <div style="width:100%;min-height:80px;">
        <div style="width:30%;float:left;">
            <b>Activity Description</b>
        </div>
        <div style="width:70%;float:right;">{{$activity->ActivityDescription}}</div>
    </div>
    <div style="width:100%;min-height:80px;">
        <div style="width:30%;float:left;">
            <b>Activity Venue</b>
        </div>
        <div style="width:70%;float:right;">{{$activity->ActivityVenue}}</div>
    </div>
    <div style="width:100%;min-height:80px;">
        <div style="width:30%;float:left;">
            <b>Schedule</b>
        </div>
        <div style="width:70%;float:right;">
            @for($i = 0; $i< sizeof($activity->Schedules); $i++)
                {{date("M jS,Y",strtotime($activity->Schedules[$i]->SchedDate))}}
                <small>{{date("h:i a",strtotime($activity->Schedules[$i]->SchedTime))}} until {{date("h:i a",strtotime($activity->Schedules[$i]->SchedTimeEnd))}}</small>
                ,
            @endfor
        </div>
    </div>

</div>
-->
<form action="{{url('uploadPhotosFromMobile')}}" method="post" enctype="multipart/form-data" style="text-align:center;padding:20px;">
    {{csrf_field()}}
    <img id="myimage" height="200" src="default-img/upload-img.png" onclick="
$('#file-image').trigger('click');">
    <input type="hidden" name="activityId" value="{{$activityId}}">
    <input type="hidden" name="userType" value="{{$userType}}">
    <input style="display:none;" id="file-image" class="btn btn-default" onchange="onFileSelected(event)" class="form-control" type="file" name="images" style="width:100%;" required>
    <!--
    <input type="file" accept="image/*" capture="camera" />
	asd
	<input type='file' style='' accept='image/*;capture=camera' name='upload_file' id='upload_file' data-mini='true' /> 
    zxc
	-->
    <input type="submit" value="UPLOAD" class="blue-button" style="margin-top:40px;width:100%;">
    
</form>
    
<script src="js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script>
    function onFileSelected(event) {
  var selectedFile = event.target.files[0];
  var reader = new FileReader();

  var imgtag = document.getElementById("myimage");
  imgtag.title = selectedFile.name;

  reader.onload = function(event) {
    imgtag.src = event.target.result;
  };

  reader.readAsDataURL(selectedFile);
}
</script>
</body>
</html>
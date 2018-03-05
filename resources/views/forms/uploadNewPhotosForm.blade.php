<!--
<form action="{{url('changeDisplayPic')}}" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    <input type="hidden" name="activityId" value="{{$activity->ActivityId}}">
    <input type="hidden" name="for" value="uploadActivityPhotos">
    <center>
    <input class="btn btn-default" type="file" name="photo">
    </center><br>
    <input type="submit" value="SUBMIT" class="btn btn-success">
</form>

**-->

<div class="modal fade" id="uploadNewPhotosModal" role="dialog">
    <div class="modal-dialog"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                UPLOAD PHOTOS TO ACTIVITY
                <span onclick="$('#uploadNewPhotosModal').modal('hide');" class="close-span">&times;</span>
            </div>
            <div class="modal-body" style="">
                    
            
<form action="{{url('changeDisplayPic')}}" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    <input type="hidden" name="activityId" value="{{$activity->ActivityId}}">
    <input type="hidden" name="for" value="uploadActivityPhotos">
    <center>
    <input class="btn btn-default" type="file" name="images[]" multiple>
    </center><br>
    <input type="submit" value="SUBMIT" class="blue-button" onclick="this.disabled='true';this.form.submit();" style="margin-left:40%;">
</form>

            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>
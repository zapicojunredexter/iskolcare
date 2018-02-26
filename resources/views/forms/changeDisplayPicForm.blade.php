
<div class="modal fade" id="editDisplayPic" role="dialog">
    <div class="modal-dialog"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                CHANGE DISPLAY PICTURE
            </div>
            <div class="modal-body" style="">
                
<form action="{{url('changeDisplayPic')}}" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    <input type="hidden" name="for" value="RegUserDp">
    <center>
    <input type="file" class="btn btn-default" name="photo">
    </center><br>

    <input type="submit" value="SUBMIT" class="blue-button" style="margin-left:40%;">
</form>

            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>
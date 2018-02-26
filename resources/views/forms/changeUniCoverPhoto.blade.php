
<form action="{{url('changeDisplayPic')}}" method="post" enctype="multipart/form-data">
<div class="modal fade" id="editCoverPhotoModal" role="dialog">
    <div class="modal-dialog"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                CHANGE COVER PHOTO
            </div>
            <div class="modal-body" style="">
                {{csrf_field()}}
                <input type="hidden" name="for" value="ChangeUniCp">
                <center>
                    <input type="file" class="btn btn-default" name="photo" required>
                </center><br>
                            
            
                <button class="blue-button" style="margin-left:40%;">SUBMIT</button>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div> 
</form>

<form action="{{url('changeDisplayPic')}}" method="post" enctype="multipart/form-data">
<div class="modal fade" id="editUniLogo" role="dialog">
    <div class="modal-dialog"  role="document">
        <div class="modal-content" style="">
            <div class="modal-header">
                CHANGE UNIVERSITY LOGO
                <span onclick="$('#editUniLogo').modal('hide');" class="close-span">&times;</span>
            </div>
            <div class="modal-body" style="">
                
                {{csrf_field()}}
                <input type="hidden" name="for" value="ChangeUniLogo">
                <center>
                    <input type="file" name="photo" class="btn btn-default" required>
                </center><br>
            
            
                
                <button style="margin-left:40%;" class="blue-button">SUBMIT</button>
                
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div> 
</form>
         
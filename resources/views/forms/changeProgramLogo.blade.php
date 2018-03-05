

<form action="{{url('changeDisplayPic')}}" method="post" enctype="multipart/form-data">
<div class="modal fade" id="changeProgramLogo" role="dialog">
    <div class="modal-dialog"  role="document">
        <div class="modal-content" style="">
            <div class="modal-header">
                CHANGE PROGRAM LOGO
                <span onclick="$('#changeProgramLogo').modal('hide');" class="close-span">&times;</span>

            </div>
            <div class="modal-body" style="">
                
                            
                {{csrf_field()}}
                <input type="hidden" name="programId" value="{{$program->ProgramId}}">
                <input type="hidden" name="for" value="ChangeProgramLogo">
                <center>
                <input class="btn btn-default" type="file" name="photo">
                </center><br>
                <input type="submit" value="SUBMIT" class="blue-button" style="margin-left:40%;">
            </div>
            <div class="modal-footer">
			</div>
        </div>
    </div>
</div> 

</form>
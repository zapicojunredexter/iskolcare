<div class="modal fade" id="changeProjectBannerModal" role="dialog">
    <div class="modal-dialog"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                CHANGE PROJECT BANNER
            </div>
            <div class="modal-body">



            <form action="{{url('changeDisplayPic')}}" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    <input type="hidden" readonly name="projectId" value="{{$project->ProjectId}}" id="projectId">
    <input type="hidden" name="for" value="ChangeProjectBanner">
    <center>
    <input type="file" class="btn btn-default" name="photo" required>
    </center><br>
                
                <button class="blue-button" style="margin-left:40%;">SUBMIT</button>
                </form>
  
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>    

               <!--
<form action="{{url('changeDisplayPic')}}" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
<div id="changeProjectBannerModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('changeProjectBannerModal')">×</span>
                    <h2>CHANGE PROJECT BANNER</h2>
            </div>
            <div class="modal-body">

  <input type="hidden" name="projectId" id="projectId">
    <input type="hidden" name="for" value="ChangeProjectBanner">
    <center>
    <input type="file" class="btn btn-default" name="photo">
    </center><br>
                
                
                
            </div>
            <div class="modal-footer">
                
                <input type="submit" value="SUBMIT" class="btn btn-success">
  
            </div>
        </div>
    </div>
</form>-->
             
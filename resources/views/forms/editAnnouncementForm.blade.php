    
<div class="modal fade" id="editAnnouncementModal" role="dialog">
    <div class="modal-dialog"  role="document" style="top:0px;">
            <div class="modal-content">
                <div class="modal-header">
                    EDIT ANNOUNCEMENT
                </div>
                <div class="modal-body">
                <form method="get" id="editAnnouncementForm" onsubmit="return false;" action="{{url('/editAnnouncement')}}">

                    <input type="hidden" name="annId" readonly id="annId">
                    
                    <div style=" text-align: left; margin-left: 20px;">
					<p style="padding: 0; margin: 0; font-size: 15px; color: black;"><b id="posterName"></b></p>
					<p style="padding: 0; margin: 0; color: black; font-size: 12px;" id="posterDate"></p>
					</div>
                    <div style="margin-left: 20px; margin-top: 10px; margin-right: 20px;">
                    <input type="text" name="postWhat" id="ann-what" class="form-control" placeholder="What">
                    <input type="text" name="postWhen" id="ann-when" class="form-control" placeholder="When">
                    <input type="text" name="postWhere" id="ann-where" class="form-control" placeholder="Where">
                    <textarea onkeyup="checkEditAnnouncement();" name="annDesc" class="form-control" id="annDesc"></textarea><br>
                    </div>
                    <button id="edit-button-submit" class="blue-button" type="button" onclick="this.disabled='true';editAnnouncement();">SUBMIT</button>
                </form>
                </div>
                <div class="modal-footer">
                    &nbsp;
                </div>
            </div>
	   </div>
    </div>
<script>
        function replaceEditAnnouncement(postId,postedBy,postDesc,postDate,postWhat,postWhen,postWhere){
            $('#annId').val(postId);
            $('#posterName').html(postedBy);
            $('#annDesc').html(postDesc.replace(/<br>/g,'\n'));
            $('#posterDate').html(postDate);
            $('#ann-what').val(postWhat);
            $('#ann-where').val(postWhere);
            $('#ann-when').val(postWhen);
            $('#editAnnouncementModal').modal('show');
        }
        function checkEditAnnouncement(){
            var annDesc = $('#annDesc').val();
            if(annDesc.trim()!==""){
                $('#edit-button-submit').prop('disabled',false);
            }else{
                $('#edit-button-submit').prop('disabled',true);
    
            }
        }
   
          function editAnnouncement(){
                 $.ajax({
                    url: "{{url('/editAnnouncement')}}",
		            data: $("#editAnnouncementForm").serialize(),
                    type: "get", 
                    success: function(response) {
                      alert("Successfully edited announcement");
                      location.reload();
                    },
                    error: function(xhr) {
                        alert("Something went wrong!");
                    }
                });
              }
    
      </script>
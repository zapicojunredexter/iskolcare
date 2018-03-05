<div class="modal fade" id="addAnnouncementModal" role="dialog">
    <div class="modal-dialog modal-lg"  role="document">
        <div class="modal-content" style="">
            <div class="modal-header">
                ADD ANNOUNCEMENT
                <span onclick="$('#addAnnouncementModal').modal('hide');" class="close-span">&times;</span>
            
            </div>
            <div class="modal-body" style="">
                <form id="add-new-announcement-form" method="get" onsubmit="return false;">
                    <input type="hidden" name="uniId" value="{{$university->UniId}}" readonly>
                    <!--
                    <input type="text" id="add-announcement" onkeyup="checkAnnouncement();" name="announcement" placeholder="Write Something" style="width: 100%; border: none; padding: 3%;">
                    -->
                        <input name="postWhat" style="background-image: url('default-img/clip.png');background-position: 10px 7px;background-repeat: no-repeat;background-size: 20px;padding: 10px 18px 10px 38px;" type="text" placeholder="What" class="form-control">
                        <input name="postWhen" style="background-image: url('default-img/calends.png');background-position: 10px 7px;background-repeat: no-repeat;background-size: 20px;padding: 10px 18px 10px 38px;" type="text" placeholder="When" class="form-control">
                        <input name="postWhere" style="background-image: url('default-img/loc.png');background-position: 10px 7px;background-repeat: no-repeat;background-size: 20px;padding: 10px 18px 10px 38px;" type="text" placeholder="Where" class="form-control">
                        <textarea id="add-announcement" onkeyup="checkAnnouncement();" name="announcement" placeholder="Write Something" class="form-control"></textarea>
                        <div style="height:40px;padding-left: 3%; background-color: #f1f1f1; border-top: 1px solid rgba(0,0,0,0.1);">
                            <button id="add-announcement-button" onclick="this.disabled='true';addAnnouncement();" type="submit" class="blue-button" style="width:100px;height:100%;border:0px;font-size: 12px;cursor: pointer;float: right;" disabled>POST</button>
                            &nbsp;
                        </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div> 

<script>
    function checkAnnouncement(){
        var text=$('#add-announcement').val();
        if(text.trim()!==""){
            $('#add-announcement-button').prop('disabled',false);
        }else{
            $('#add-announcement-button').prop('disabled',true);
        }
    }
    function addAnnouncement(){
        $.ajax({
            url: "{{url('/addAnnouncement')}}",
            type: "get", 
            data: $("#add-new-announcement-form").serialize(),
            success: function(response) {
                swal("Successfully added new Announcement","","success").then(()=>{
                    location.reload();
                });
            //alert("Successfully added university details");
            //$('#edit-university-modal').modal('hide');
            
            //		  $('#editCoverPhotoModal').modal('show');
            //location.reload();
            },
            error: function(xhr) {
                swal("Something went wrong!","","error").then(()=>{
                    $('#add-announcement-btn').prop('disabled',false);
                });

            }
        });
    }
</script>

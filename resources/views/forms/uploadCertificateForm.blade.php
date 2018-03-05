<div class="modal fade" id="chooseCertificateModal" role="dialog">
    <div class="modal-dialog"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                UPLOAD CERTIFICATE TEMPLATE                
                <span onclick="$('#chooseCertificateModal').modal('hide');" class="close-span">&times;</span>

            </div>
            <div class="modal-body">
                


                <form action="{{url('uploadCertificates')}}" id="uploadCertificateForm" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="for" id="certificate-for" readonly>
                    <input type="hidden" name="id" readonly value="{{$activity->ActivityId}}">
                    <input type="file" name="photo" class="form-control" required>
                    <br>
                    <!-- onclick="this.disabled='true';this.form.submit()" -->
                    <button class="blue-button" style="margin-left:40%;">SUBMIT</button>
                </form>


            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div> 
<script>
    function uploadCertificate(){
        $.ajax({
            url: "{{url('uploadCertificates')}}",
            type: "post", 
		    data: $("#uploadCertificateForm").serialize(),
            success: function(response) {
                /*response=JSON.parse(response);
                if(response.Message === 'Successful Login'){
                            window.location.href="{{url('getProfile')}}";   
                }else{
                    alert(response.Message);
                }*/
            },
            error: function(xhr) {
                console.log('error'+xhr);
                alert('Something went wrong!');
            }
        });                            
    }
                    </script>
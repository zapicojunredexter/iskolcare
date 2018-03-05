<div class="modal fade" id="editReleasedFormModal" role="dialog">
    <div class="modal-dialog"  role="document">
        <div class="modal-content" style="">
            <div class="modal-header">
                Edit Released Form Details
                <span onclick="$('#editReleasedFormModal').modal('hide');" class="close-span">&times;</span>
            </div>
            <div class="modal-body" style="">
                


            <form action="{{url('editReleasedForm')}}" method="get">
                <input type="hidden" name="rfId" id="rfId" readonly>
                <div class="row">
                    <div class="col-sm-4">From</div>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" value="<?php echo date('Y-m-d')?>" name="fromDate" id="fromDate" readonly>
                    </div>
                    <div class="col-sm-4">To</div>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" name="toDate" id="toDate" value="<?php echo date('Y-m-d')?>" min="<?php echo date('Y-m-d')?>">
                    </div>
                    <div class="col-sm-4">Evaluation for</div>
                    <div class="col-sm-8">
                        <select name="for" class="form-control">
                            <option id="initialFor">Student Volunteers</option>
                            <option value="Student Volunteers">Student Volunteers</option>
                            <option value="Faculty Volunteers">Faculty Volunteers</option>
                            <option value="Beneficiaries">Beneficiaries</option>
                            <option value="Leaders">Leaders</option> 
                        </select>
                    </div>
                </div>
                <br>
                <input type="SUBMIT" class="blue-button" style="margin-left:40%;">
            </form>


            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div> 

<div class="modal fade" id="editReleasedFormModal" role="dialog">
    <div class="modal-dialog"  role="document">
        <div class="modal-content" style="">
            <div class="modal-header">
                Edit Released Form Details
            </div>
            <div class="modal-body" style="">
                


            <form action="{{url('editReleasedForm')}}" method="get">
                <input type="hidden" name="rfId" id="rfId" readonly>
                <div class="row">
                    <div class="col-sm-4">From</div>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" name="fromDate" id="fromDate">
                    </div>
                    <div class="col-sm-4">From</div>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" name="toDate" id="toDate">
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
                <input type="SUBMIT" class="blue-button" style="margin-left:40%;">
            </form>


            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div> 

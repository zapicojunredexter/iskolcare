<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Dashboard Template for Bootstrap</title>
        @include('includes.libs')
  </head>

  <body>
     <div id="participateInActivity" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('participateInActivity')">×</span>
                    <h2>Modale Header</h2>
            </div>
            <div class="modal-body">
                  @include('forms.participateForm')
            </div>
            <div class="modal-footer">
                <h3>Modal Footer</h3>
            </div>
        </div>
      </div>
    @include('includes.regUserHeader')
    <div class="container-fluid">
      <div class="row">
        @include('includes.regUserSidebar')
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" style="background-color:orange;">
            @foreach($activities as $activity)
            {{$activity->ActivityId}}-{{$activity->ActivityName}}
                <a onclick="document.getElementById('programId').value={{$activity->ActivityId}};displayModal('participateInActivity');"> become volunteer now</a>
                <br>
                <!--{{print_r($activity)}}<br>-->
          
            @endforeach
          
        </div>
          
      </div>
    </div>

      
      
      
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    @include('includes.scripts')
  </body>
</html>

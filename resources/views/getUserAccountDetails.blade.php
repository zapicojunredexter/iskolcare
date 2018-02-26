<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Dashboard Template for Bootstrap</title>
        @include('includes.libs')
  </head>

  <body>
      <div id="editUniversityModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('editUniversityModal')">×</span>
                    <h2>Modale Header</h2>
            </div>
            <div class="modal-body">
                qwe
            </div>
            <div class="modal-footer">
                <h3>Modal Footer</h3>
            </div>
        </div>
      </div>

      
      
    @include('includes.regUserHeader')
    <div class="container-fluid">
      <div class="row">
          
    @if(Session::get("type")==='Director')
        @include('includes.directorSidebar')  
    @elseif(Session::get("type")==='Coordinator')   
        @include('includes.coordinatorSidebar')
    @endif
     
        

           
         
        
            @include("regUserProfile")
          <!--
        <div style="background: transparent; width: 80%; margin-left: 20%;margin-top:10px;">
        </div>-->
          
          
      </div>
    </div>

      
      
      
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    @include('includes.scripts')
  </body>
</html>

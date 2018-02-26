<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Dashboard Template for Bootstrap</title>
        @include('includes.libs')
  </head>

  <body>
      <div id="manageAnAccountModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal('manageAnAccountModal')">×</span>
                    <h2>Modale Header</h2>
            </div>
            <div class="modal-body">
                qq
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
     
        

          <div style="background: transparent; width: 80%; margin-left: 20%;margin-top:10px;">
              <table class="table">
                  @foreach($accounts as $account)
                    <tr>
                        <td>{{$account->Name}}</td>
                        <td>{{$account->LastName}}</td>
                        <td>{{$account->Gender}}</td>
                        <td>{{$account->ContactNumber}}</td>
                        <td>{{$account->Address}}</td>
                        <td>{{$account->EmailAddress}}</td>
                        <td>{{$account->Birthday}}</td>
                        <td><a href="{{url('getUserAccountDetails')}}?id={{$account->AccountId}}"><button class="btn btn-warning">Do something</button></a></td>
                    </tr>
                  @endforeach
              </table>
          </div>
         <!--
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" style="background-color:silver;s">
        </div>
-->
          
          
      </div>
    </div>

      
      
      
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    @include('includes.scripts')
  </body>
</html>

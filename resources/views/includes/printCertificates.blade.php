<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Print Certificates</title>
      <style>
          .certificate-container{
              /*width:210mm;
              height:297mm;*/
              width:297mm;
              height:210mm;
              background-color: red;
          }
      </style>
  </head>
  <body>
          
      @foreach($volunteers as $volunteer)
        <div style="margin:auto;
             page-break-after:always;display:flex;justify-content:center;">
          <div style="position:absolute;align-self:center;;z-index:1;font-size:{{$fontSize}}px;">{{$volunteer->Name}} {{$volunteer->LastName}}</div>
           <img  style="align-self:center;width:320mm;height:190mm;" src="img/certificates/{{Session::get('type')}}-{{Session::get('accountId')}}-certificate-photo.jpg" >
      </div>
      @endforeach
          
  </body>
</html>

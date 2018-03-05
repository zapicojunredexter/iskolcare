<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.libs')

</head>

<body style="padding:0px;">
    
    <div class="modal fade" id="loadingModal" role="dialog">
        <div class="modal-dialog modal-lg"  role="document">
            <div style="color:white;text-align:center;margin-top:200px;">
            
                <img src="default-img/loading.gif" style="width:100px;">
            </div>
        </div>
    </div>

    <div id ="results-container">
        <div class="col-sm-12" style="text-align:center;">
            <h2><a href="{{url('getActivityPage')}}?id={{$releasedForm->ActivityId}}" style="font-weight:bold;">{{strtoupper($releasedForm->ActivityName)}}</a></h2>        
        </div>
        <div class="col-sm-12" style="text-align:center;">
            <h3>{{$releasedForm->EvaluationFormName}}</h3>
        </div>
        @include('includes.evaluationToolResults')                  
    </div>
    @include('includes.scripts')
    <script>
        //window.print();
       $('#loadingModal').modal('show');
        //$('#loadingModal').modal('hide');
        setTimeout(()=>{
            $('#loadingModal').modal('hide');      
        },3000);
        setTimeout(()=>{
                window.print();
            },3500);
        setTimeout(()=>{
            window.close();
        },4000);
    </script>
</body>

</html>
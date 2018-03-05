
<script src="js/Chart.js">
</script>
<script src="js/Chart.bundle.js">
</script>
<script src="js/utils.js">
</script>
<div class="row">
    <?php
        $counter = 1;
    ?>
    @foreach($releasedForm->Questions as $question)
    <div class="col-sm-12" style="border-bottom:solid silver 1px; padding:20px;">
        <div class="row">
            <div class="col-sm-12">
                <h4 style="font-weight:bold"><?php echo $counter++;?>. {{$question->Question}}</h4>
            </div>
        @if($question->QuestionType === "Open")
            <div class="col-sm-12" style="{{Request::is('getResults')?'overflow-y:scroll;height:200px;':''}}">
                <table class="table table-striped">
                @foreach($question->Answers as $answer)
                    <tr>
                        <td style="padding:0px;">{{$answer->Answer}}</td>
                    </tr>
                @endforeach
                </table>
            </div>
        @elseif($question->QuestionType === "Checkbox")
            @foreach($question->Choices as $choice)            
            <div class="col-sm-12">{{$choice->ChoiceDescription}} ({{$choice->Tally}})</div>
            @endforeach
            
            <div class="col-sm-12">
                <div style="width:100%;margin-left:auto;margin-right:auto;">
                    <canvas id="chart-area-{{$question->QuestionId}}" height="70px"/>
                </div>
            </div>
        @else
            @foreach($question->Choices as $choice)
            <div class="col-sm-12">{{$choice->ChoiceDescription}} ({{$choice->Tally}})</div>
            @endforeach
            <div class="col-sm-12">
                <div style="width:300px;margin-left:auto;margin-right:auto;">
                    <canvas id="chart-area-{{$question->QuestionId}}" />
                </div>
            </div>
        @endif
            
            
        </div>
    </div>
    @endforeach
</div>


<script>
    
    function createChart(id,dataSet,titles){
        var config = {
        type: 'pie',
        data: {
            datasets: [{
                data: dataSet,
                backgroundColor: [
                    window.chartColors.yellow,
                    window.chartColors.green,
                    window.chartColors.blue,
                    window.chartColors.red,
                    window.chartColors.orange,
                ],
                label: 'Dataset 1'
            }],
            labels: titles
        },
        options: {
            responsive: true
        }
    };
        var ctx = document.getElementById(id).getContext("2d");
        window.myPie = new Chart(ctx, config);
    
    }
         
    
    function createBarGraph(id,dataSet,titles){
        var config = {
            type: 'horizontalBar',
            data: {
                labels: titles,
                datasets:[{
                        label: "Tally",
                        backgroundColor: "#3e95cd",
                        data: tally,     
                }], 
                options:{
                    scales: {
                        xAxes:[{
                            display: false,
                            categorySpacing:0,
                        }],
                        yAxes:[{
                            display: false,
                            /*
                            type:'linear',
                            position:'left',
                            id:'y-axis-1',
                            */
                        }],
                    },
                    title:{
                        display: false,
                        text: 'Answers Tally',
                    },
                },            
            },
        };                 
    
        var ctx = document.getElementById(id).getContext("2d");
        window.myPie = new Chart(ctx, config);
    
    }
/*
function createBarGraph(id,dataSet,titles){
        var config = {
            type: 'horizontalBar',
            data: {
                labels: titles,
                datasets:[{
                        label: "Tally",
                        backgroundColor: "#3e95cd",
                        data: tally,     
                }], 
                options:{
                    scales: {
                        xAxes:[{
                            categorySpacing:0,
                        }],
                        yAxes:[{
                            barPercentage:0.5,
                        }],
                    },
                    title:{
                        display: true,
                        text: 'Answers Tally',
                    },
                },            
            },
        };                 
    
        var ctx = document.getElementById(id).getContext("2d");
        window.myPie = new Chart(ctx, config);
    
    }

*/
@foreach($json["Questions"] as $question)
    @if($question["QuestionType"] === "Radio")
        var tally=[];
        var title=[];
        @foreach($question["Choices"] as $answer)
            tally.push({{$answer["Tally"]}});
            title.push('{{$answer["ChoiceDescription"]}}');
        @endforeach
        createChart('chart-area-{{$question["QuestionId"]}}',tally,title);
        
    @endif
    
@endforeach
@foreach($json["Questions"] as $question)
    @if($question["QuestionType"] === "Checkbox")
        var tally=[];
        var title=[];
        @foreach($question["Choices"] as $answer)
            tally.push({{$answer["Tally"]}});
            title.push('{{$answer["ChoiceDescription"]}}');
        @endforeach
        console.log("tallyu");
        console.log(tally);
        console.log("title");
        console.log(title);
        console.log('{{$question["Question"]}}');
        createBarGraph('chart-area-{{$question["QuestionId"]}}',tally,title);
    @endif
    
@endforeach  

    

  
    </script>
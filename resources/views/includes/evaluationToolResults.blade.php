<div class="row" style="padding:100px;">
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
            <div class="col-sm-12" style="height:300px;overflow-y:scroll;">
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
            <div class="col-sm-12">
                {{$choice->ChoiceDescription}} ({{$choice->Tally}})
            </div>
            <div class="col-sm-12">
                <div class="progress">
                    <?php
                    $rate = 0;
                    if($releasedForm->totalResponses !== 0)
                        $rate=$choice->Tally/$releasedForm->totalResponses * 100;
                    ?>
                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $rate;?>%"><span class="sr-only">80% Complete (danger)</span></div>
                </div>
            </div>
            @endforeach
             
        @else
            @foreach($question->Choices as $choice)
            <div class="col-sm-12">{{$choice->ChoiceDescription}} ({{$choice->Tally}})</div>
            @endforeach
        @endif

            <div class="col-sm-12">
                <div style="width:300px;margin-left:auto;margin-right:auto;">
                    <canvas id="chart-area-{{$question->QuestionId}}" />
                </div>
            </div>
            
        </div>
    </div>
    @endforeach
</div>


    <!--<div id="canvas-holder" style="width:40%">
        <canvas id="chart-area" />
    </div>-->
<script src="js/Chart.js">
</script>
<script src="js/Chart.bundle.js">
</script>
<script src="js/utils.js">
</script>

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

@foreach($json["Questions"] as $question)
    @if($question["QuestionType"] === "Radio")
        var tally=[];
        var title=[];
        @foreach($question["Choices"] as $answer)
            tally.push({{$answer["Tally"]}});
            title.push('{{$answer["ChoiceDescription"]}}');
        @endforeach
        console.log(tally);
        console.log(title);
        console.log('{{$question["Question"]}}');
        createChart('chart-area-{{$question["QuestionId"]}}',tally,title);
    @endif
    
@endforeach
   

    

  
    </script>
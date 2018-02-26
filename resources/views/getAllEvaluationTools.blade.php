<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.libs')
    <title>Evaluation</title>
</head>

<body>
    @include('forms.editEvaluationToolForm')
    @include('forms.addEvaluationToolForm')
    <div class="wrapper" style="background-color:#e6eaeb;">

        @if(Session::get('type')==='Director')
            @include('includes.directorSidebar')
        @elseif(Session::get('type')==='Coordinator')
            @include('includes.coordinatorSidebar')
        @else
            @include('includes.regUserSidebar')
        @endif
        <div class="main-panel">
            <?php
                $label="Evaluation";
            ?>
            @include('includes.regUserHeader')
            <div class="content">
                <div class="container-fluid">
				
                    <div>
					
					<!-- start sa evaluation tools table-->
                    <button style="float:right;" onclick="$('#addEvaluationToolModal ').modal('show');" class="blue-button">
                        + Add Evaluation Tool
                    </button>
                    <br>    
                    <table class="table table-striped">
                        <tr style="background: #1b593e;color: white;">
                            <th>TOOL NAME</th>
                            <th>TOOL DESCRIPTION</th>
                            <th>ASSOCIATED PROGRAM</th>
                            <th></th>
                        </tr>
                        @foreach($evaluationTools as $evaluationTool)
                        <tr>
                            <td>
                                <a href="{{url('getEvaluationTool')}}?id={{$evaluationTool->EvaluationFormId}}">
                                {{$evaluationTool->EvaluationFormName}}
                                </a>
                            </td>
                            <td>
                                {{$evaluationTool->EvaluationFormDescription}}
                            </td>
                            <td>
                            </td>
                            <td>
                                <a href="#" onclick="
                                                document.getElementById('formId').value={{$evaluationTool->EvaluationFormId}};
                                                document.getElementById('formName').value='{{$evaluationTool->EvaluationFormName}}';
                                                document.getElementById('formDesc').value='{{$evaluationTool->EvaluationFormDescription}}';
                                                $('#editEvaluationToolModal ').modal('show');">
                                    <img data-toggle="tooltip" title="Edit Evaluation Tool" src="default-img/edit.png" style="width:20px;" alt="edit">
                                </a>
                                <a href="#" onclick="deleteEvaluationForm({{$evaluationTool->EvaluationFormId}})">
                                    <img data-toggle="tooltip" title="Delete Evaluation Tool" src="default-img/trash.png" style="width:20px;" alt="delete">
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @foreach($programTools as $programTool)
                        <tr>
                            <td>
                                <a href="{{url('getEvaluationTool')}}?id={{$programTool->EvaluationFormId}}">
                                {{$programTool->EvaluationFormName}}
                                </a>
                            </td>
                            <td>
                                {{$programTool->EvaluationFormDescription}}
                            </td>
                            <td>
                                <a href="{{url('getUniversityProgramsSpecific')}}?id={{$programTool->ProgramId}}">
                                    {{$programTool->ProgramName}}
                                </a>
                            </td>
                            <td>
                                <a href="#" onclick="
                                                document.getElementById('formId').value={{$programTool->EvaluationFormId}};
                                                document.getElementById('formName').value='{{$programTool->EvaluationFormName}}';
                                                document.getElementById('formDesc').value='{{$programTool->EvaluationFormDescription}}';
                                                $('#editEvaluationToolModal ').modal('show');">
                                    <img data-toggle="tooltip" title="Edit Evaluation Tool" src="default-img/edit.png" style="width:20px;" alt="edit">
                                </a>
                                <a href="#" onclick="deleteEvaluationForm({{$programTool->EvaluationFormId}})">
                                    <img data-toggle="tooltip" title="Delete Evaluation Tool" src="default-img/trash.png" style="width:20px;" alt="delete">
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    <script>
                        function deleteEvaluationForm(id){
                            if(confirm('Are you sure you want to delete Evaluation Form?')){
                                window.location.href="{{url('deleteEvaluationTool')}}"+"?id="+id;
                            }
                        }
                    </script>
                <!--end sa evaluation tools table-->
                    </div>
                </div>
            </div>
			<!-- start sa footer-->
            <footer class="footer">
                <div class="container">
                    <nav>
                        <ul class="footer-menu">
                            <li>
                                <a href="#">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Company
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Portfolio
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Blog
                                </a>
                            </li>
                        </ul>
                        <p class="copyright text-center">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>
                            <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                        </p>
                    </nav>
                </div>
            </footer>
			
			<!-- end sa footer-->
        </div>
    </div>
    @include('includes.scripts')
    
</body>


</html>
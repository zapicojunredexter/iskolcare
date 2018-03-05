    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content={{csrf_token()}}>
    <!--
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/iskolcare.css')}}">
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('css/creative.css')}}">
    <link rel="stylesheet" href="{{asset('css/modal.css')}}">
   -->
    
    <link rel="stylesheet" href="{{asset('css/iskolcare.css')}}">
    <link rel="stylesheet" href="{{asset('css/modal.css')}}">
    <link rel="stylesheet" href="{{asset('css/circle.css')}}">
    <link rel="stylesheet" href="{{asset('css/breadcrumbs.css')}}">
   
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <!--
    <link href="css/light-bootstrap-dashboard.css?v=2.0.1" rel="stylesheet" />
    -->
    <link href="css/my-light.css" rel="stylesheet" />
<style>
/* start sa scroll bar*/
    
/* width */
::-webkit-scrollbar {
    width: 3px;
}

/* Track */
::-webkit-scrollbar-track {
    background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
    background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: #555; 
}
/* end sa scrollbar */
/* wwwww */
    
body, html {
    /*
    height: 100%;
    background-repeat: no-repeat;
    background-image: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));*/
}
/**
 * Profile image component
 */
.profile-header-container{
    margin: 0 auto;
    text-align: center;
}

.profile-header-img {
    padding: 0;
}

.profile-header-img > img.img-circle {

    border: 3px solid #1b593e;
}

.profile-header {
    margin-top: 43px;
}

/**
 * Ranking component
 */
.rank-label-container {
    margin-top: -19px;
    /* z-index: 1000; */
    text-align: center;
}

.label.label-default.rank-label {
    font-size: 10px;    
    background-color: rgb(81, 210, 183);
    background-color: #1b593e;
    padding: 3px 3px;
    border-radius: 27px;
}    
    .ppimg{
        border-radius: 50%;
        height: 50px;
    }
    
    
/* qqqqqqqqqqq */       
    
    
    
/*
.breadcrumb-right-arrow .breadcrumb-item+.breadcrumb-item::before{
    content: ">";
    vertical-align:top;
    font-size:40px;
    line-height:10px;
}
*/  
.serch{
	padding: 10px 18px 10px 38px;
	font-size: 10px;
	border: 2px solid #ccc;
	width: 100%;
	background-color: white;
	/*float: right;*/
	border-radius: 20px;
	box-sizing: border-box;
	background-image: url('default-img/searchicon.png');
	background-position: 10px 7px;
	background-repeat: no-repeat;
}
.uni-list-dropdown div{
    /*background-color:white;
    color:black;
    width: 200px; 
    padding:10px;   */
    padding:10px;
}
.uni-list-dropdown div a{
    /*color:black;*/  
}
.pull-right .dropdown-menu:after{
    left: auto;
    right:13px;
}
.pull-right .dropdown-menu{
    left: auto;
    right:0;
}
.form-control::placeholder{
    color: rgba(0,0,0,0.4);
    opacity: 1;
}
.form-control{
    border: solid silver 1px;
}

textarea{
    border: solid silver 1px;
    height:100px!important;
}
pre{
    color:inherit;
    font-family:inherit;
    white-space:pre-wrap;
    text-indent: 0px;
}
::placeholder{
    color: rgba(0,0,0,0.4);
    opacity: 1;
}
:-ms-input-placeholder{
    color: rgba(0,0,0,0.4);
}
::-ms-input-placeholder{
    color: rgba(0,0,0,0.4);
}
.blue-button: hover{

}
.blue-button:disabled,
.blue-button[disabled]{
    opacity: 0.4;
}
.blue-button{
    background-color:#2196F3;
    padding-top:10px;
    padding-bottom:10px;
    padding-left:20px;
    padding-right:20px;
    cursor:pointer;
    font-size:12px;
    border:solid black 0px;
    color:white;
}

.list-group-item{
    color:white!important;
    background:transparent!important;
    font-size:13px;
    border-radius:0px!important;
    border:solid black 0px;
    padding:20px;
}
.list-group-item:hover{
    background-color:#1a4e38!important;
    transition:0.4s;
}
.list-group-item p{
    margin-left:10px;
    display:inline;
    font-weight:bold;
    font-size:12px;
}
.table-striped td{
    padding:20px!important;
}
a{
    color: inherit;
}
#menu1{
    background-color:#185038!important;
}
#menu2{
    background-color:#185038!important;
}
.plus-arrow-toggle{
    margin-left:10px;
    margin-right:10px;
}
.round-blue-button{
    font-weight:bold;
    border-radius:40px;
    padding-left:30px;
    margin-right:10px;
    padding-right:30px;
    background-color:#2196F3;
    padding-top:10px;
    padding-bottom:10px;
    font-size:12px;
    border:solid black 0px; 
    color:white;
}
.round-blue-button-inactive{
    
    font-weight:bold;
    border-radius:40px;
    padding-left:30px;
    margin-right:10px;
    padding-right:30px;
    padding-top:10px;
    padding-bottom:10px;
    font-size:12px;
    border:solid black 0px;
    color:gray;
}
.round-blue-button-inactive:hover{
    background-color:#2196F3;
    transition:0.4s;
    color:white;
}
    
    /*for google maps */
    .pac-container {
    z-index: 1051 !important;
}
   
</style>

    <link rel="icon" href="default-img/mini-logo.png">
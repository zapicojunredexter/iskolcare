<!-- <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/iskolcare.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/modal.js')}}"></script>
    Core JS Files   -->
<script src="js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="{{asset('js/iskolcare.js')}}"></script>
    <script src="{{asset('js/modal.js')}}"></script>
<script src="js/core/popper.min.js" type="text/javascript"></script>
<script src="js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="js/plugins/bootstrap-switch.js"></script>
<!--  Chartist Plugin  -->
<!--  Notifications Plugin    -->
<script src="js/plugins/bootstrap-notify.js"></script>
<script src="js/sweetalert.min.js"></script>

<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="js/light-bootstrap-dashboard.js?v=2.0.1" type="text/javascript"></script>
<script>
$('#edit-uni-button').on('click',function(event){
	event.stopPropagation();
	$('#edit-university-modal').modal('show');
          
});
console.log(window.location.hash);   
var hashes = window.location.hash;

$(''+hashes+'').trigger('click');

</script>
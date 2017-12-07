$(document).ready(function(){
	
});
function loader($con)
{
	if($con=="signup")
		document.getElementsByClassName("sin_loader")[0].style.visibility="visible";
	else if($con=="resend")
		document.getElementsByClassName("ver_loader")[0].style.visibility="visible";
}
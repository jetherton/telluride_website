$(document).ready(function(){

	//find the checkbox
	$('input[type="checkbox"][value="12"]').parent().remove();
	
	
});

function orgclick()
{
	//figure out the current selection
	var id = $("#orgs").val();
	$("#orgscheck").val(id);
	
	
	
}
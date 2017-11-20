$(document).ready(function() {
	page_num = 0; search_term ='';
	$(document).on("click", "#search_button", function(){	
		page_num = 1; search_term = $("#search_term").val();
		var yourarray = [];			loadAccountDetails(page_num,search_term);	 
    });});

function loadAccountDetails(page_num,search_term){
	$("#results").load("servicefiles/account_details.php", {'page':page_num,'search_term': search_term}, function(){});
}

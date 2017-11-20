 
$(document).ready(function() {

	var page_num = 0; var search_term = $("#search_term").val(); 
	loadAccountDetails(page_num,search_term);	
	$(document).on("click", "ul.navigater li a", function(){
		if ($(this).attr('title') != 'current')
		{ 
			$("#listitems").prepend('<div class="loading-indication"><img src="images/ajax-loader.gif" /> Loading...</div>');
		
			page_num = $(this).attr("title");  	
         
			loadAccountDetails(page_num,'');
		 
		}
		return false; //prevent going to herf link
	});
	
	 
	$(document).on("click", "#en_dis_all", function(){
        if (!$(this).is(':checked')) {
            $( "input[id^='en_dis_']" ).prop('checked', false);
        }
		else{
		  $( "input[id^='en_dis_']" ).prop('checked', true);
		}
    });
	
	$(document).on("click", ".En_Dis", function(){	
		
		var yourarray = [];
		$('input[id^="en_dis_"]:checked').each(function () {
			yourarray.push($(this).val());
		});
		
		var ids = JSON.stringify(yourarray);
        if($(this).val()=='Enable'){
			var flag =	1;		
		}
		else if($(this).val()=='Disable'){
			var flag =	0;		
		}
		else{
			var flag = 10;
		}
		
		$.post('servicefiles/enable_disable_accounts.php',{ids:ids,flag:flag},function(data){
			loadAccountDetails(page_num,'');
			$('#en_dis_all').prop('checked', false);
		},'json');
		
		
    });
	
	/* $(document).on("click", "#search_button", function(){	
		page_num = 1; search_term = $("#search_term").val();
		var yourarray = [];	
		
		loadAccountDetails(page_num,search_term);
		 
    }); */
	
});

function loadAccountDetails(page_num,search_term){
	/* $("#listitems").load("servicefiles/account_details1.php", {'page':page_num,'search_term': search_term}, function(){}); */
	
	$.post('servicefiles/account_details1.php',{page:page_num,search_term:search_term},function(data){
			$('#listitems').html(data['str']);
			$('.nav_right').html(data['pag']);
			$('#en_dis_all').prop('checked', false);
		},'json');
	
}


$(document).ready(function(){
customer_report();

  $(document).on("click", "#submit_button_id",function(){ customer_report();});
});

function customer_report(){

	var id = $("#customer_id").val();
	var month = $("#select_month").val() ;
	var text = $("#select_month option:selected").text();
	$("#summery_report_id").html('');
	

	$("#report_month_id").html("<b> "+text+" </b>");
	$("#loading_gif_id").css('display','block')
	
	$.post('servicefiles/customer_report.php',{id:id,month:month},function(data){
		
		$("#summery_report_id").html(data);
		$("#loading_gif_id").css('display','none')
			
	});
	
	
}	


function htmToExcel(){

	
	var html = $("#summery_report_id").html();
	
	if(html != ''){
	
		$("#downloadHTML").css('display','');
		$("#downloadLink").css('display','none');
	$.post('servicefiles/html_excel.php',{html:html},function(data){
		
		if(data==1){
		
			$("#downloadHTML").css('display','none');
			$("#downloadLink").css('display','');
		
			window.open('phpHtmlExcel.php','_blank');
		
		}
			
		});
	}
	else{
		alert("Please wait... ");
	}
	return false ;
}
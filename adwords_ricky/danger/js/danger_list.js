var func ; var type = 1 ; var flag = 0;
var add = '<a href="#" onclick="return addTask();" style="cursor:pointer;">Add Task </a>';

$(document).ready(function(){
	type = $('#usertype').val(); 
	listTask();
	
});

function listTask(){
	var tasktype = $("#select_type").val();
	common('','List Task','','','');
	$("#summery_report_id").load("list_danger.php", {type:tasktype}, function(){
		if(type==2) common('none',0,'',0,add);		
		else common('none','List Task','','','');
	}); 
}
function common(loading_gif_id,report_month_id,selectTask,summery_report_id,downloadLink){
	//alert(downloadLink);
	if(loading_gif_id != 0) $("#loading_gif_id").css('display',loading_gif_id);
	if(report_month_id != 0) $('#report_month_id').html(report_month_id);
	//if(selectTask != 0) $("#selectTask").css('display',selectTask);
	if(summery_report_id != 0) $('#summery_report_id').html(summery_report_id);
	if(downloadLink != 0) $('#downloadLink').html(downloadLink);
}
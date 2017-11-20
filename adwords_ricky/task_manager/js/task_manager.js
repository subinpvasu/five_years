var func ; var type = 1 ; var flag = 0;
var add = '<a href="#" onclick="return addTask();" style="cursor:pointer;">Add Task </a>';
var list = '<a href="#" onclick="return listTask();" style="cursor:pointer;">List Tasks </a>';
var list = '<a href="#" onclick="return listTask();" style="cursor:pointer;">List Tasks </a>';
var edit = '<a href="#" onclick="return editTask();" style="cursor:pointer;">Edit Task </a>';
var delet = '<a href="#" onclick="return deleteTask();" style="cursor:pointer;">Delete Task </a>';

$(document).ready(function(){
	type = $('#usertype').val(); 
	listTask();
	
});

function listTask(){
	var tasktype = $("#select_type").val();
	common('','List Task','','','');
	$("#summery_report_id").load("list_tasks.php", {type:tasktype}, function(){
		if(type==2) common('none',0,'',0,add);		
		else common('none','List Task','','','');
	}); 
}
function addTask(){
	var id=0;
	common('','Add Task','none','','');
	$("#summery_report_id").load("add_edit_task.php", {id:id}, function(){		
		common('none',0,0,0,list);	
		
	}); 

}
function addEditTask(){

	if(flag==1){alert("Process already in progress"); return false;}
	flag=1;
		
	var taskName = $("#taskName").val();
	var taskDesc = $("#taskDesc").val();
	var taskType = $("#taskType").val();
	//var taskTo = $("#taskTo").val();
	var taskId = $("#taskId").val();
	
		
	var taskTo = 0;
	$.post('servicefiles/add_edit_task.php',{taskName:taskName,taskDesc:taskDesc,taskType:taskType,taskTo:taskTo,taskId:taskId},function(data){
		flag=0;
		if(data['error']==0 && taskId==0){listTask();}
		else if(data['error']==0 && taskId != 0){taskDetails(taskId);}
		else{alert(data['error']);}
			
	},'json');  
	
	return false;
}
function taskDetails(id){

	func = 1;
	//common(loading_gif_id,report_month_id,selectTask,summery_report_id,downloadLink)
	common('','Task Details','none','','');
	$("#summery_report_id").load("task_details.php", {id:id}, function(){
		if(type==2) common('none',0,0,0,"&nbsp; &nbsp; &nbsp;"+list+" &nbsp; &nbsp; &nbsp; "+edit+" &nbsp; &nbsp; &nbsp; "+delet);
		else common('none',0,0,0,list);
	}); 
}
function taskComments(id){
	func=2;
	
	common('','Comments','','','');
	$("#summery_report_id").load("task_comments.php", {id:id}, function(){
		common('none',0,0,0,list)
	}); 
}

function add_comment(id){

 
	var taskComment = $("#taskComment").val();

	$.post('servicefiles/add_task_comment.php',{id:id,taskComment:taskComment},function(data){
		
		if(data['error']==0){if(func==1) taskDetails(id); else taskComments(id); }
		else{alert(data['error']);}
		
			
	},'json');  
	
	return false;
}

function editTask(){
	var id=$("#taskId").val();
	common('','Edit Task','','','');
	$("#summery_report_id").load("add_edit_task.php", {id:id}, function(){
		common('none',0,0,0,list)
	});
}
function deleteTask(id){
	var id=$("#taskId").val();
	var c = confirm("Are you sure to delete the task ?")
	
	if (c == true) {
    
		$.post('servicefiles/delete_task.php',{id:id},function(data){
		
		if(data['error']==0){listTask();}
		else{alert(data['error']);}
			
	},'json');
	
	} 
	
}

function common(loading_gif_id,report_month_id,selectTask,summery_report_id,downloadLink){
	//alert(downloadLink);
	if(loading_gif_id != 0) $("#loading_gif_id").css('display',loading_gif_id);
	if(report_month_id != 0) $('#report_month_id').html(report_month_id);
	//if(selectTask != 0) $("#selectTask").css('display',selectTask);
	if(summery_report_id != 0) $('#summery_report_id').html(summery_report_id);
	if(downloadLink != 0) $('#downloadLink').html(downloadLink);
}
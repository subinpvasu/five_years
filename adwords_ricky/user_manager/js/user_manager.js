
var func ; var flag = 0; var check= false; var checkurl= false;
var add = '<a href="#" onclick="return addUser();" style="cursor:pointer;">Add User </a>';
var list = '<a href="#" onclick="return lists();" style="cursor:pointer;">List User </a>';

$(document).ready(function(){	
	lists();	
});

function lists(){
	common('','List Users','','','');
	$("#summery_report_id").load("list_users.php", {type:0}, function(){
		common('none',0,'',0,add);
	}); 
}
function addUser(){
	var id=0;
	common('','Add User','none','','');
	$("#summery_report_id").load("add_edit_user.php", {id:id}, function(){		
		common('none',0,0,0,list);	
		check = true;
		checkurl = true;
	}); 

}
function addEdit(){

	if(flag==1){alert("Process already in progress"); return false;}
	flag=1;
	var url = "";
	var name = $("#taskName").val();
	var email = $("#userEmail").val();
	var pass = $("#newpass").val();
	var conf = $("#confpass").val();
	var type = $("#ItemType").val();
	
	var check_list = $("#ItemType").val();
	if(type==1 || type==4){url = $("#txtarSpreadSheet").val();}	
        
        console.log(url);
	
	var id = $("#Item_Id").val();
	if(type==3){
	var values= [];
    $('#SelectAccountManagers input:checked').each(function() {
        values.push(this.value); 
    });
	}
	else{
		var values = 0 ;
	}
	 
	
	var taskTo = 0;
	$.post('servicefiles/add_edit_user.php',{name:name,email:email,pass:pass,conf:conf,id:id,type:type,check:check,url:url,values:values,checkurl:checkurl},function(data){
		flag=0;
		if(data['error']==0 ){lists();}
		else{alert(data['error']);}
			
	},'json');  
	
	return false;
}

function edit(id){
	check =false;
	checkurl =false;
	common('','Edit User','','','');
	$("#summery_report_id").load("add_edit_user.php", {id:id}, function(){
		$(".pass").css("display","none");
		common('none',0,0,0,list);
	});
}
function passChangeOk(){

	var checkd = $("#changePass").is(":checked");
    if(checkd) {
		check =true;
        $(".pass").css("display","")
    } else {
		check =false;
        $(".pass").css("display","none")
    }
	

}
function urlChangeOk(){

	var checkd = $("#changeUrl").is(":checked");
    if(checkd) {
		checkurl =true;
        $(".url").css("display","")
    } else {
		checkurl =false;
        $(".url").css("display","none")
    }
	

}
function delet(id){

	var uid=$("#userID").val();
	if(uid==id){
	
		alert("Delete Not Allowed");
		return false;
	}
	
	
	var c = confirm("Are you sure to delete the user ?")
	
	if (c == true) {
		
		$.post('servicefiles/delete_user.php',{id:id},function(data){
		
		if(data['error']==0){lists();}
		else{alert(data['error']);}
			
	},'json');
	
	} 
	return false;
	
}
function SelectAccountManagers(t,operation){
	if(t.value==3){
	
		$("#SelectAccountManagers").css('display',"");
		$(".url").css("display","none"); 
                $(".urlchk").css("display","none");
	}
	else{
		$("#SelectAccountManagers").css('display',"none");
		if(t.value==1 || t.value == 4){
                    if(operation == 'Add') $(".url").css("display",""); 
                    else if(operation == 'Edit') $(".urlchk").css("display","");
//                    $(".urlchk").css("display","");	
                }
		else{
                    $(".url").css("display","none"); 
                    $(".urlchk").css("display","none");	
                }
	}
}

function common(loading_gif_id,report_month_id,selectTask,summery_report_id,downloadLink){

	if(loading_gif_id != 0) $("#loading_gif_id").css('display',loading_gif_id);
	if(report_month_id != 0) $('#report_month_id').html(report_month_id);
	if(summery_report_id != 0) $('#summery_report_id').html(summery_report_id);
	if(downloadLink != 0) $('#downloadLink').html(downloadLink);
}
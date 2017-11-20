
function loginSubmit(){

	var user = $("#contact-name").val();
	var pass = $("#contact-pass").val();
	
	var err = false ;
	
	if(checkEmail(user) && checkPass(pass)){
		
		$.post('servicefiles/login.php',{user:user,pass:pass},function(data){
			
			if(data['msg']==4){ window.location.replace("customers.php"); }
		 
			else if(data['msg']==2 || data['msg']==1 || data['msg']==3){ window.location.replace("reportmanagement/managementReports.php"); }
			
			else {alert(data['msg']);}
		},'json');
		
		
	}
	else{
	
		alert("Please Check Your Username and Password");
		
	}
	
	return false;

}

function checkEmail(user){

	if(user==''){
		return false ;
	}
	else{
		return true ;
	}
}
function checkPass(pass){

	if(pass==''){
		return false ;
	}
	else{
		return true ;
	}
}
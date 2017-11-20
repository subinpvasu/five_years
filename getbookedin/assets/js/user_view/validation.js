/**
 * 
 * @returns true if success
 * 
 * header_menu.php register form validation.
 */
function validation_register()
{
    if($("#firstname").val().length>=2)
    {
    	 if($("#lastname").val().length>=2)
    	    {
        
            if((!isNaN($("#mobile").val()) && $("#mobile").val().length>9 && $("#mobile").val().length<=11)||$("#mobile").val().length==0)
            {
                if(validateEmail($("#email").val()))
                {
                    if(($("#new_password").val()==$("#confirm_password").val()))
                    {
                        if ($("#new_password").val().length >= 8) {
                            
                            if (!$('input[name=preferred_communication_mode]:checked').val() ) {          
                             
                              alert("Please select preferred communication mode.");return false ;
                            }
                            else{
                                var cmode = $('input[name=preferred_communication_mode]:checked').val() ;
                                
                                alert(cmode);
                                       
                                if(cmode==1 || cmode==2 ){
                                    
                                    if($("#mobile").val() < 9) {alert("Please enter a valid mobile number"); return false;}
                                    else return true ;
                                }
                                
                                else return true ;
                            }
                            
                            
                        }else {
                            alert("Password must contain atleast 8 character length.");
                            return false;
                        }

                    }
                    else
                    {
                        alert("New Password and Confirm Password is not matching!");
                        return false;
                    }
                }
                else
                {
                    alert("Please enter a valid Email address!");
                    return false;
                }
            }
            else
            {
                alert("Mobile is not valid!");
                return false;
            }
        
    }
    else
    {
        alert("Enter a valid Last Name!");
        return false;
    }
    }else
    	{
    	 alert("Enter a valid First Name!");
         return false;
    	}
}
/**
 * 
 * @returns true if success
 * header_menu.php login form validation.
 */
function validation_login()
{
    if(validateEmail($("#username").val()))
    {
        if($("#password").val().length>0)
        {
          //  alert("Login successfull!");
            return true;
        }
        else
        {
            alert("Please enter the valid Password!");
            return false;
        }
    }
    else
    {
        alert("Please enter a valid Username!");
        return false;
    }
}

function validation_profile()
{
    
    alert($('input[name=preferred_communication_mode]:checked').val()); return false;
    if($("#firstname_pro").val().length>=2)
    {
    	if($("#lastname_pro").val().length>=2)
        {
        if(!isNaN(parseInt($("#age_pro").val())) && parseInt($("#age_pro").val())<100 && parseInt($("#age_pro").val())>0)
        {
            if((!isNaN($("#mobile_pro").val()) && $("#mobile_pro").val().length>9 && $("#mobile_pro").val().length<=11 )|| ($("#mobile_pro").val()==''))
            {
                
                if (!$('input[name=preferred_communication_mode]:checked').val() ) {          
                             
                    alert("Please select preferred communication mode.");return false ;
                  }
                  else{
                      var cmode = $('input[name=preferred_communication_mode]:checked').val() ;

                      if(cmode==1 || cmode==2 ){

                          if($("#mobile").val() < 9) {alert("Please enter a valid mobile number"); return false;}
                          else return true ;
                      }

                      else return true ;
                      }
            }
            else
            {
                alert("Mobile is not valid!");
                return false;
            }
        }
        else
        {
            alert("Age is not valid!");
            return false;
        }
    }
    else
    {
        alert("Enter a valid Last Name!");
        return false;
    }
    }
    else
    {
        alert("Enter a valid First Name!");
        return false;
    }
}

function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}
/**
 * 
 * login ajax function
 */
$(document).ready(function(){
    $("#login_form").click(function(){
        if(validation_login())
        {
        
            $.ajax({url:$("#baseurl").val()+"/index.php/user/ajaxLogin",
		type:"post",
		 data: {
                         csrfToken: $('#csrftwo').val(),
			 username:$("#username").val(),
			 password:$("#password").val()
		 },
		 success:function(result){
                            if(result==='success')
                            {
                                window.open($("#homepage").val(), '_self', false);
                            }
                            else
                            {
                                $("#error_text_login").html(result);
                            }
			 }
		});
        }
    });
});
/**
 * logout ajax function
 */
$(document).ready(function(){
    $("#logout").click(function(){
          $.ajax({url:$("#baseurl").val()+"/index.php/user/logout",
		type:"post",
		 data: {
                         csrfToken: $('#csrftwo').val()
		 },
		 success:function(result){
                            if(result==='success')
                            {
                                window.open($("#homepage").val(), '_self', false);
                            }
                        }
		});
    });
    
});
<script>

$(document).ready(function(){
	var loginbox;
	var loginmask;
    var tmp='';

	loginbox = document.createElement("div");
	loginmask = document.createElement("div");
	loginbox.id="loginbox";
	loginmask.id="loginmask";


tmp += '<table style="width:100%;margin-top:60px;"><caption>Welcome to BTWDive</caption><tr><td style="text-align:left;">Username</td><td><input type="text" id="username" name="username" value="" class="textbox"/></td></tr>';
tmp += '<tr><td style="text-align:left;">Password</td><td><input type="password" id="password" name="password" class="textbox"/></td></tr>';
tmp += '<tr><td colspan="2" style="text-align:center;"><input type="checkbox" id="remember" name=""  />Remember Me</td></tr>';
tmp += '<tr><td colspan="2" style="text-align:center;"><input type="submit" id="submit" class="btn" value="Login" /></td></tr><table>';







loginbox.innerHTML=tmp;
	document.body.appendChild(loginmask);
	document.body.appendChild(loginbox);

$("#submit").click(function(){

if($("#username").val().length==0)
{
	alert("Please enter the username");
	return false;
}

if($("#password").val().length==0)
{
	alert("Please enter the password");
	return false;
}

	 $.ajax({url: base_url+"index.php/customer/letThemLog/",
		 type:"post",
		 data:{
			 username:$("#username").val(),
		     password:$("#password").val()
			 },
			 success: function(result) {
                switch (parseInt(result)) {
				case 1:
					window.location=base_url+"index.php/customer/sub_index/";
					break;

				default:
					alert("Username and Password not matching.");
					break;
				}
             }

});
});


$(function() {

    if (localStorage.chkbx && localStorage.chkbx != '') {
        $('#remember').attr('checked', 'checked');
        $('#username').val(localStorage.usrname);
        $('#password').val(localStorage.password);
    } else {
        $('#remember').removeAttr('checked');
        $('#username').val('');
        $('#password').val('');
    }

    $('#remember').click(function() {

        if ($('#remember').is(':checked')) {
            // save username and passwordword
            localStorage.usrname = $('#username').val();
            localStorage.password = $('#password').val();
            localStorage.chkbx = $('#remember').val();
        } else {
            localStorage.usrname = '';
            localStorage.password = '';
            localStorage.chkbx = '';
        }
    });
});

});
</script>

<style>
#loginmask
{
    min-width:100%;
	min-height: 100%;
	background-color: black;
	opacity:0.3;
	position:fixed;
	top:0px;
	left:0px;
}
#loginbox
{
	background-color: #CCCCCC;
    color: black;
    height: 230px;
    left: 37%;
    position: fixed;
    text-align: center;
    top: 30%;
    width: 360px;
}

</style>


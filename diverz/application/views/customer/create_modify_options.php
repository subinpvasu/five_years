<script>
function updatePurposeList(sbn)
{
	$.ajax({url:"/btwdive/index.php/customer/updatePurposeList/",
		type:"post",
		data:{
qry:sbn
			},
success:function(result){
	var tbl = '<table id="datum" style="width:100%;text-align:left;">';
	var trl='';
	var smn = result.split("!");
	//smn = smn.slice(0,-1);
	for(var i=1;i<smn.length;i++)
	{
	    var str = smn[i].split("|");
	    
		 trl = trl+'<tr style="cursor:pointer" id="'+i+'"><td style="width:70%;"> '+str[1].trim()+'</td><td>'+str[2]+'</td></tr>';
	}
	tbl = tbl+trl+'</table>';
	$("#resultant").html(tbl);
	$("#resultant tr:even").css("background-color", "#ffffff");
	$("#resultant tr:odd").css("background-color", "#E5E5E5");

	$("tr").click(function(){
        var row_data = [];
$("td",this).each(function(){
	row_data.push($(this).text());
}); 

        $("#numb").val((parseInt(this.rowIndex)+1));
        $("#opti").val(row_data[0]);
        $("#valu").val(row_data[1]);
        $("#addoptions").val((parseInt(this.rowIndex)+1));
        });
}

		});
}
function addOptionsBox()
{
	if($("#opti").val()=='')
	{
exit;
	}
	
	if($("#addoptions").val()!='z' && $("#addoptions").val()==$("#numb").val())
	{
		var ri = $("#addoptions").val();
		ri = parseInt(ri);
$('tr:nth-child('+ri+') td:nth-child(1)').html($("#opti").val());
$('tr:nth-child('+ri+') td:nth-child(2)').html($("#valu").val());
$("#numb").val('');
$("#opti").val('');
$("#valu").val('');
$("#addoptions").val('z');
exit;
	}
	var past = $("#resultant").html();
	past = past.replace('<table id="datum" style="width:100%;text-align:left;">',"");
	past = past.replace("</table>","");
	var chk = 1;
	
	var find = '</tr>';
	var re = new RegExp(find, 'g');

	past = past.replace(re, '</tr>|');
    var tp = '';
    past = '|'+past;
	var row = past.split("|");
	for(var i=1;i<row.length;i++)
	{
	    if(i==$("#numb").val())
	    {
	        tp = tp+'<tr style="cursor:pointer" id="'+$("#numb").val()+'"><td style="width:70%;"> '+$("#opti").val()+'</td><td>'+$("#valu").val()+'</td></tr>';
	        chk++;
	    }
	    
	        tp = tp+row[i];
		
	}
	if(chk==1)
	{
		tp = tp+'<tr style="cursor:pointer" id="'+$("#numb").val()+'"><td style="width:70%;"> '+$("#opti").val()+'</td><td>'+$("#valu").val()+'</td></tr>';
	}

	var temp = '<table id="datum" style="width:100%;text-align:left;">'+tp+'</table>';
	$("#resultant").html(temp);
	
	$("#resultant tr:even").css("background-color", "#ffffff");
	$("#resultant tr:odd").css("background-color", "#E5E5E5");
	$("#numb").val('');
	$("#opti").val('');
	$("#valu").val('');
	
	$("tr").click(function(){
         var row_data = [];
$("td",this).each(function(){
	row_data.push($(this).text());
});
$("#numb").val((parseInt(this.rowIndex)+1));
$("#opti").val(row_data[0]);
$("#valu").val(row_data[1]);
$("#addoptions").val((parseInt(this.rowIndex)+1));

        });
}

$(document).ready(function(){
	
		$("#svbtn").click(function(){
			if($("#resultant").html()=='')
			{
		exit;
			}
		var table_data = [];
	    $('tr').each(function(){
	    var row_data = [];    
	    $('td', this).each(function(){
	        row_data.push($(this).text());   
	    });    
	    table_data.push(row_data);
	});
		$.ajax({url:"/btwdive/index.php/customer/updateDataOption/",
			type:"post",
			data:{
				option:$("#category").val(),
			    rows:table_data
				},
				success:function(result){alert("Updated");
				self.close();
				}
			});
		});
});
$(document).ready(function(){
	$("#svbtnctn").click(function(){
		if($("#resultant").html()=='')
		{
	exit;
		}
	var table_data = [];
    $('tr').each(function(){
    var row_data = [];    
    $('td', this).each(function(){
        row_data.push($(this).text());   
    });    
    table_data.push(row_data);
});
	$.ajax({url:"/btwdive/index.php/customer/updateDataOption/",
		type:"post",
		data:{
			option:$("#category").val(),
		    rows:table_data
			},
			success:function(result){alert("Updated");
			location.reload();
			}
		});
	});
});

function isNumber(n){
	  return (parseFloat(n) == n);
	}


	
	$("document").ready(function(){
	    $("#numb").keyup(function(event){
	        var input = $(this).val();
	        if(!isNumber(input)){
	           
	            $(this).val(input.substring(0, input .length-1));
	        }
	           
	    });
	});
    
   
    

</script>
<style>
body
{
    counter-reset: Serial;           
}


tr td:first-child:before
{
  counter-increment: Serial;      
  content:counter(Serial); 
}
</style>
<div style="width:100%;text-align: center;">
<h2 style="width:100%;text-align: center;" >Form to Set-Up Various items as Variables for the program</h2>
<div style="width:49.8%;float:left;height:400px;">
<b style="display:block;">CATEGORY</b>
<select class="select" onchange="updatePurposeList(this.value)" id="category"><option></option>
<?php 
foreach ($options as $o):
echo '<option value="'.$o->PURPOSE.'">'.$o->PURPOSE.'</option>';
endforeach;
?>
</select>
<div style="width:100%;margin:30px 0px;"><b style="width:20%;float:left;">NO</b><b style="width:50%;float:left">OPTIONS</b><b style="width:25%;float:left">VALUE</b></div>
<div style="width:100%;">
<input type="text" class="textbox" id="numb" style="width:20%;"/>
<input type="text" class="textbox" id="opti" style="width:50%;"/>
<input type="text" class="textbox" id="valu" style="width:25%;"/>
</div>
<div style="margin:30px 0px;"><button class="btn"  style="width:auto;" id="addoptions" value="z" onclick="addOptionsBox()">Add Options&gt;&gt;</button></div>
<button class="btn" id="svbtn">Save</button>
<button class="btn" id="svbtnctn" style="width:auto;">Save &amp; Continue</button>
<button class="btn"  onclick="self.close()">Exit</button>
</div>




<div style="width:49.8%;float:left;height:400px;">
<b style="width:60%;float:left;text-align: left;">OPTIONS</b><b style="width:20%;float:left;text-align: left;">DISPLAY VALUE</b>
<div style="width:80%;float:left;height:350px;background-color: white;color:black;overflow:auto" id="resultant"></div>
</div>
</div>

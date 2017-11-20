<script>
$(document).ready(function(){
	$("#searchfind").click(function(){
document.getElementById("findsearch").style.display='inline-block';
document.getElementById("thatpage").style.display='inline-block';
document.getElementById("thispage").style.display='none';
document.getElementById("findsearch").focus();


		});
});
function loadAJAX()
{
	if (window.XMLHttpRequest){
	  xmlhttp=new XMLHttpRequest();
	  }	else {
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  return xmlhttp;
}
function searchandfind(str)
{
	if(str!=null && str!=''){
		try{
var frm = document.getElementById("from").value;
var to = document.getElementById("to").value;
var diverid=document.getElementById("diverid").value;
			}catch(e){}
	loadAJAX().onreadystatechange=function()
	  {
		  if(xmlhttp.readyState<4)
		  {
			  document.getElementById("balanceout").innerHTML='<img width="100px" height="100px" src="<?php echo base_url() ?>img/loading_gif.gif" style="position:relative;top:0px;left:0px;">';
		  }
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	  document.getElementById("balanceout").innerHTML=xmlhttp.responseText;
	    }
	  };
	  if(document.getElementById("findpdf").value==100)
	  {
		  xmlhttp.open("POST","/btwdive/index.php/customer/ajax_bowaft_search/"+str,true);
	  }
	  else if(document.getElementById("findpdf").value==101)
		  {
		  xmlhttp.open("POST","/btwdive/index.php/customer/ajax_list_invoice_search/"+frm+"/"+to+"/0/40/"+str,true);//----------------------------------
		  }
		else if(document.getElementById("findpdf").value==105)
		  {
		  xmlhttp.open("POST","/btwdive/index.php/customer/ajax_diver_commi_search/"+diverid+"/"+frm+"/"+to+"/0/40/"+str,true);//----------------------------------
		  }  
	  else
	  {
	xmlhttp.open("POST","/btwdive/index.php/customer/ajax_balance_search/"+str,true);
	  }
	xmlhttp.send();
	}
}
function searchandfindpdf()
{
	var str = document.getElementById("balanceout").innerHTML;

	
	  
	    if(str!='')
	    {
	    	if(document.getElementById("findpdf").value==100)
	    	{
	    		$.ajax({url:"/btwdive/index.php/customer/searched_pdf/1",
	    			type:"post",
	    			 data: {
	    				data:str	 
	    			 },
	    	   		 
	    		
	    	  });
	    	}
	    	else if(document.getElementById("findpdf").value==101)
	    	{
	    		$.ajax({url:"/btwdive/index.php/customer/searched_pdf/2",
	    			type:"post",
	    			 data: {
	    				data:str	 
	    			 },
	    	   		 
	    		
	    	  });
	    	}
	    	else
	    	{
	   $.ajax({url:"/btwdive/index.php/customer/searched_pdf/",
			type:"post",
			 data: {
				data:str	 
			 },
	   		 
		
	  });
	    }
	    }
	


	
}
</script>
<div id="options" style="width:100%;text-align:center;">
<div style="width:66%;display: inline-block;background-color: gray;padding-top:5px;">
<img src=<?php echo base_url()."img/back.png"?>  <?php if($current==0 || $current==null){?>title="No Previous Page" <?php }else{?>onclick="javascript:document.getElementById('pageback').submit()" title="Previous Page"  <?php }?>    width="35px"  style="cursor: pointer;padding:0 20px;"/>
<img src=<?php echo base_url()."img/next.png"?>    width="35px"
<?php if((ceil($current/32)+1)!=(ceil(count($total)/32))){ echo 'title="Next Page"';?>
onclick="javascript:document.getElementById('pagenext').submit()"<?php }else{echo 'title="No Next Page"';}?> style="cursor: pointer;padding:0 20px;"/>
<img src=<?php echo base_url()."img/refresh.png"?> title="Refresh Page<?php //echo $current.'|'.$total;?>"      width="35px"  onclick="window.location.reload()" title="refresh" style="cursor: pointer;padding:0 20px;"/>
<img src=<?php echo base_url()."img/print.png"?>   title="Save Current Page" width="35px" onclick="javascript:document.getElementById('pagethis').submit()" style="cursor: pointer;padding:0 20px;" id="thispage"/>
<img src=<?php echo base_url()."img/print.png"?>   title="Save Current Page" width="35px" onclick="searchandfindpdf()" style="cursor: pointer;padding:0 20px;display:none" id="thatpage"/>
<img src=<?php echo base_url()."img/xport.png"?>   title="Save All Pages "   width="35px" onclick="javascript:document.getElementById('pageform').submit()" title="Export Data"  style="cursor: pointer;padding:0 20px;"/>
<img src=<?php echo base_url()."img/find.png"?>    title="Search & Find"     width="35px"  style="cursor: pointer;padding:0 20px;" id="searchfind"/>
<input type="text" name="" class="textbox" placeholder="Search By Name" title="Search By Name" id="findsearch" onkeyup="searchandfind(this.value)" style="bottom:9px;position:relative;display:none"/>
</div>

</div>
<form id="pageform" method="post"><input type="hidden" name="submitted" value="pagepdf"/></form>
<form id="pagethis" method="post"><input type="hidden" name="submitted" value="pagethis"/></form>
<!--<form id="pagethat" method="post"><input type="hidden" name="submitted" value="pagethat"/></form>-->
<form id="pagenext" method="post"><input type="hidden" name="submitted" value="pagenext"/><input type="hidden" name="current" value="<?php echo $current[0];?>"/></form>
<form id="pageback" method="post"><input type="hidden" name="submitted" value="pageback"/><input type="hidden" name="current" value="<?php echo $current[0];?>"/></form>

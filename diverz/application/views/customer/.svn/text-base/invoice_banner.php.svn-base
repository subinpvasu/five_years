<script>

function loadAJAX()
{
	if (window.XMLHttpRequest){
	  xmlhttp=new XMLHttpRequest();
	  }	else {
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  return xmlhttp;
}
function downloadCurrentDoc()
{
	var str = window.frames[0].document.getElementById("current_pdf").value;
	/*
	loadAJAX().onreadystatechange=function()
	  {
		  if(xmlhttp.readyState<4)
		  {
			  //document.getElementById("balanceout").innerHTML='<img width="100px" height="100px" src="<?php echo base_url() ?>img/loading_gif.gif" style="position:relative;top:0px;left:0px;">';
		  }
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	  //document.getElementById("balanceout").innerHTML=xmlhttp.responseText;
	    }
	  };
	xmlhttp.open("POST","/btwdive/index.php/customer/createCurrentDoc/"+str,true);
	xmlhttp.send(); */
	window.open("<?php  echo base_url() ?>index.php/customer/createCurrentDoc/"+str);
}

function displayZoomIn()
{
	var zoom = window.frames[0].document.getElementById("zoom_status").value;
	zoom++;
	if(zoom>=5)
	{
		window.frames[0].document.getElementById("zoom_status").value=5;
		window.frames[0].document.getElementById('zoomer').style.msTransform="scale(5)";
		window.frames[0].document.getElementById("zoomer").style.transform="scale(5)";
	}
	else
	{
		window.frames[0].document.getElementById("zoom_status").value=zoom;
		window.frames[0].document.getElementById('zoomer').style.msTransform="scale("+zoom+")";
		window.frames[0].document.getElementById("zoomer").style.transform="scale("+zoom+")";
	}
	
}
function displayZoomOut()
{
	var zoom = window.frames[0].document.getElementById("zoom_status").value;
	zoom--;
	
	if(zoom<1)
	{
		window.frames[0].document.getElementById("zoom_status").value=1;
		window.frames[0].document.getElementById('zoomer').style.msTransform="scale(1)";
		window.frames[0].document.getElementById('zoomer').style.transform="scale(1)";
	}
	else
	{
		window.frames[0].document.getElementById("zoom_status").value=zoom;
		window.frames[0].document.getElementById('zoomer').style.msTransform="scale("+zoom+")";
		window.frames[0].document.getElementById('zoomer').style.transform="scale("+zoom+")";
	}
	
}
</script>

<div id="options" style="width:100%;text-align:center;">
<div style="width:100%;display: inline-block;background-color: gray;padding-top:5px;">
<img src=<?php echo base_url()."img/zoom_out.png"?> onclick="displayZoomOut()" title="" style="cursor: pointer;padding:0 20px;width:35px;"/>
<img src=<?php echo base_url()."img/zoom_in.png"?> onclick="displayZoomIn()" style="cursor: pointer;padding:0 20px;width:35px;"/>
<img src=<?php echo base_url()."img/refresh.png"?> title="Refresh Page"      width="35px"  onclick="window.location.reload()" title="refresh" style="cursor: pointer;padding:0 20px;"/>

<img src=<?php echo base_url()."img/xport.png"?> title="Save Page as PDF" width="35px" onclick="downloadCurrentDoc()" title="Export Data" style="cursor: pointer;padding:0 20px;"/>


</div>

</div>
<form id="pageform" method="post"><input type="hidden" name="submitted" value="pagepdf"/></form>
<form id="pagethis" method="post"><input type="hidden" name="submitted" value="pagethis"/></form>
<!--<form id="pagethat" method="post"><input type="hidden" name="submitted" value="pagethat"/></form>-->


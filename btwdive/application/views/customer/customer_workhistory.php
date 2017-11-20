<!--
Project     : BTW Dive
Author      : Subin
Title      : Customer Work History
Description : Customer Work history avalable  in this page.
-->
<link rel="stylesheet" href="../../../css/style.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript">
function loadAJAX()
{
	if (window.XMLHttpRequest){
	  xmlhttp=new XMLHttpRequest();
	  }	else {
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  return xmlhttp;
}
$(document).ready(function(){
	$("tr:even").css("background-color", "#ffffff");
	$("tr:odd").css("background-color", "#E5E5E5");
	$("tr:even").css("color", "#000000");
	$("tr:odd").css("color", "#000000");
});
$(document).ready(function() {
    $("tr").click(function(event) {
        if($(this).attr("id")>0){
           document.getElementById("link"+$(this).attr("id")).click();
            }
    });
});
</script>
<?php  foreach ($customers as $customer):?>
<div id="account">
<div class="name"><span>Client Name : <?php echo $customer->firstname;?></span></div>
<div class="vessel"><span>Vessel Name : <?php echo $customer->vesselname;?></span><span>Location : <?php echo $customer->location;?></span><span>Slip #: <?php echo $customer->slip;?></span></div>
<div class="info"><span style="color:white;font-style:italic;text-align: center;width:100%">To Edit/Modify a Payment,Double click on the Row you want to edit</span></div>
<?php endforeach; ?>
<input type="hidden" id="home" value="<?php echo base_url()?>" />
<div style="width:100%;float:left;">
<table><tr style="">
<th style="width:9%;">Work Order No.</th>
<th style="width:8%;">Schedule Date</th>
<th style="width:7%;">Type</th>
<th  style="width:61%;" colspan="2">Work Description</th>
<th style="width:10%;">Status</th></tr></table></div>
<div class="details" style="height:400px;overflow-y:scroll;width:101.5%;"><table style="width:100%;">
<?php

 foreach ($workhistory as $history):
switch($history->st)
{
    case 0:
        $invoice =  'In Progress';
        break;
    case 1:
        $invoice =  'Completed';
        break;
    case 2:
        $invoice =  'Ready for Invoice';
        break;
    case 3:
        $invoice =  'Invoiced';
        break;
    case 4:
        $invoice =  'Voided';
        break;
    case 5:
        $invoice =  'On Hold';
        break;
}


echo '<tr style="cursor:pointer" id="'.$history->workid.'"><td style="width:9%">'.$history->worknumber.'</td>
<td  style="width:8%">'.$history->schedule.'</td>
<td  style="width:7%">';
if($history->type=='A'){echo 'Anode</td><a href="'.base_url ().'index.php/customer/anode_work_order/'.$history->workid.'" target="_blank" id="link'.$history->workid.'"></a><td  style="width:61%" colspan="2">Anode Work</td>';}
if($history->type=='M'){echo 'Mech</td><a href="'.base_url ().'index.php/customer/mechanical_work_order/'.$history->workid.'" target="_blank" id="link'.$history->workid.'"></a><td  style="width:61%" colspan="2">Mechanical Work</td>';}
if($history->type=='C'){
    if($history->description=='')
    {
        $bow = 'BOW';
    }
    else
    {
        $bow = $history->description;
    }
    echo 'Clean</td><a href="'.base_url ().'index.php/customer/cleaning_work_order/'.$history->workid.'" target="_blank" id="link'.$history->workid.'"></a><td  style="width:61%" colspan="2">'.$bow.'</td>';}
echo '
<td  style="width:10%">'.$invoice.'</td>
</tr>';

endforeach;?>
</table>
</div>
<div class="exit"><button onclick="self.close();" class="btn" style="margin-top:0%">Exit</button></div>
</div>
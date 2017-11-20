<!--
Project     : BTW Dive
Author      : Subin
Title      : Outstanding Balance Customers
Description : Display all the outstanding balance customer details.
-->
<script>
function showLog(customer)
{
	$("#"+customer).toggle();
	$.ajax({url: base_url+"index.php/customer/displayLogDetails/",
        type: "post",
        data: {
            who: customer
        },
        success: function(result) {
           $("#"+customer).html(result);
        }
    });
    if($("#"+customer).is(":visible"))
    {
    	$("."+customer).removeClass("rotatenot");
$("."+customer).addClass("rotate");
    }else
    {
    	$("."+customer).removeClass("rotate");
    	$("."+customer).addClass("rotatenot");
    }
}

</script>
<style>
.rotate
{
	-ms-transform: rotate(90deg); /* IE 9 */
    -webkit-transform: rotate(90deg); /* Chrome, Safari, Opera */
    transform: rotate(90deg);
}
.rotatenot
{
	-ms-transform: rotate(0deg); /* IE 9 */
    -webkit-transform: rotate(0deg); /* Chrome, Safari, Opera */
    transform: rotate(0deg);
}
.even
{
	background-color: #D8D8D8;
	color:black;
}
.odd
{
	background-color: #848482;
	color:white;
}
</style>
<div style="min-height: 500px;width: 100%;text-align: center;">
<h2>Customers with Outstanding Balances</h2>
<table style="width:65%;margin:0 auto;">

<tr style="height:40px;background-color: white;color:black">

<th style="text-align:left;">Customer Name</th>
<th style="text-align:left;">Vessel Name</th>
<th style="text-align:center;">Outstanding Balance</th>
</tr>

<?php
$i=0;
$cls = 'even';
if(count($customer)>0){
foreach($customer as $c):
if($i%2==0)
{
    $cls = 'even';
}
else
{
    $cls = 'odd';
}
echo '
    <tr  style="height:20px;cursor:pointer;" onclick="showLog('.$c->CUSTOMER.')" class="'.$cls.'">
    <td style="text-align:left;"><img src="'. base_url().'img/arrowright.png" class="'.$c->CUSTOMER.' rotatenot" style="height: 10px; width: 15px;"/>'.$c->ACCOUNT.'</td>
    <td style="text-align:left;">'.$c->VESSEL.'</td>
    <td style="text-align:center;">'.$c->AMOUNT.'</td>
    </tr>
    <tr class="'.$cls.'"><td colspan="3" id="'.$c->CUSTOMER.'" style="display:none;text-align:left"></td>
    </tr>
    ';
$i++;
endforeach;
}else {
    echo '<tr><td colspan="3" style="text-align:center"><h2>No Logs Found.</h2></td></tr>';
}

?>


</table>
<br/>
<button class="btn" onclick="self.close()">Exit</button>
</div>
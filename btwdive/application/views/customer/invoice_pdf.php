<!--
Project     : BTW Dive
Author      : Subin
Title      : Invoice
Description : HTML of the pdf document
-->
<script>
$(document).ready(function(){
    $(".mastertable").css('margin-top','50px');
    $('.listed').css('height','60px');
    $('.listed').css('margin-left','170px');
    $('.slavetable').css('margin-left','100px');

  	  $(".once").css("border-bottom","transparent");
  	  $(".twice").css("border-top","transparent");
  	  $(".twice").css("margin-top","0px");
  	  $(".boldremove").remove();

});
</script>
<style>
li:nth-child(1):before {
	content: "* "
}

li:nth-child(2):before {
	content: "* "
}

li:nth-child(3):before {
	content: "* "
}

li:nth-child(4):before {
	content: "* "
}

li:nth-child(5):before {
	content: "* "
}

li:nth-child(6):before {
	content: "* "
}

.details>.dialog_details {
	color: black;
}

@page {
	margin-top: 6.5mm;
	margin-left: 0mm;
}

@font-face {
	font-family: 'calibri';
	src: url('<?php echo base_url()?>/fonts/calibri.ttf') format('truetype')
}

tr,td,th {
	border: none;
}
</style>

<?php
$tot = 0;
$part = '';
$z = 0;
$as = 0;
$cs = 0;
$ms = 0;
$ar = 0;
$temp = '';
foreach ( $worked as $w ) :
    $temp = $temp . '<tr style="font-family: sans-serif;font-size: 3mm;">
									<td
										style=" border-right: 1px solid black;  vertical-align: top;"></td>
									<td
										style="text-align: left;  border-right: 1px solid black; vertical-align: top;height:15px;font-family: sans-serif;font-size: 3mm;padding-left: 2mm">
										';
    switch ($w->WO_CLASS) {

        case 'A' :
            if(($z%9)==0)
            {
                $as=0;
            }
            if ($as == 0) {
                if ($w->DISCOUNT > 0) {
                    $temp = $temp . '<div style="width:100%;float:left;white-space:nowrap;margin:1mm 0mm"><b  style="margin-right:14%;font-family: sans-serif;font-size: 3mm;">Zinc/Anode Change and Replacement interval shown in Months</b>' . date ( "m/d/Y", strtotime ($w->SCHEDULE_DATE)) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Discount ' . $w->DISCOUNT . '%</div>';
} else {
$temp = $temp .
                     '<div style="width:100%;float:left;white-space:nowrap;margin:1mm 0mm"><b  style="margin-right:14%;font-family: sans-serif;font-size: 3mm;">Zinc/Anode Change and Replacement interval shown in Months</b>' .
                     date ( "m/d/Y", strtotime ( $w->SCHEDULE_DATE ) ) .
                     '</div>';
}
$as ++;
if ($ar == 0 && $w->WORK_VALUE == 3) {
$temp = $temp . '<p style="display:block;padding-left:250px;height:10px;font-family: sans-serif;font-size: 3mm;">(Zinc Replaced on ' . date (
                    "m/d/Y",
                    strtotime ( $w->SCHEDULE_DATE ) ) . ')</p>';
$ar ++;
}
}
if ($w->WORK_VALUE == 3 ) {

$temp = $temp . '<div style="width:100%;float:left;font-family: sans-serif;font-size: 3mm;margin:1mm 0mm"><b style="width:55%;font-weight:normal;margin-right:5%">' . ucwords (
                strtolower ( $w->WORK_TYPE ) ) . '</b>';
if(!is_null($w->ADFD))
{$diff = abs(strtotime($w->ADFD) - strtotime($w->SCHEDULE_DATE));
    $temp = $temp.'............(Prior Replacement  &nbsp;&nbsp;' . date ( "m/d/Y", strtotime ( $w->ADFD ) ) . ' = ' . abs ( ceil(($diff/(60*60*24))/30)) . ' months)</div>';
}
} else {
$temp = $temp .
 '<div style="width:60;float:left;font-weight:normal;display:inline;text-align:left;position:relative;">' .
 ucwords ( strtolower ( $w->WORK_TYPE ) ) .
 '</div>';
}

break;

case 'C' :
if ($cs == 0) {
if ($w->DISCOUNT > 0) {
$temp = $temp . '<div style="width:100%;float:left;font-family: sans-serif;font-size: 3mm;margin:1mm 0mm"><b style="margin-right:23%;">Hull Clean</b>................. ' . date (
"m/d/Y",
strtotime ( $w->SCHEDULE_DATE ) ) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Discount ' . $w->DISCOUNT . '%</div>';
} else {
$temp = $temp .
 '<div style="width:100%;float:left;font-family: sans-serif;font-size: 3mm;margin:1mm 0mm"><b style="margin-right:23%;">Hull Clean</b>................ ' .
 date ( "m/d/Y", strtotime ( $w->SCHEDULE_DATE ) ) .
 '</div>';
}

}

$d = date_parse_from_format ( "Y-m-d", $w->SCHEDULE_DATE );
if($w->WORK_DESCRIPTION=='')
{
    $wkdn = 'Bow( Aft ) Thruster Hydro Blasting';
}
else
{
    $wkdn = $w->WORK_DESCRIPTION;
}
if ($d ["month"] >= 4 && $d ['month'] <= 10) {
$temp = $temp . "Summer Cleaning Dates(April 1st-Oct 31st):&nbsp;&nbsp;&nbsp;<b>" . ucwords ( strtolower ( $wkdn ) ) . "</b>";
} else {
$temp = $temp . "Winter Cleaning Dates(Nov 1st - March 31st):&nbsp;&nbsp;&nbsp;<b>" . ucwords (
strtolower ( $wkdn ) ) . "</b>";
}

break;
case 'M' :
if ($ms == 0) {
if ($w->DISCOUNT > 0) { // '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        // Discount '.$w->DISCOUNT.'%</div>';
$temp = $temp . '<div style="width:100%;float:left;font-family: sans-serif;font-size: 3mm;margin:1mm 0mm"><b  style="margin-right:23%;">Mechanical Services</b>............ ' . date ( "m/d/Y", strtotime ( $w->SCHEDULE_DATE)) . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Discount ' . $w->DISCOUNT . '%</div>';
} else {
$temp = $temp .
 '<div style="width:100%;float:left;font-family: sans-serif;font-size: 3mm;margin:1mm 0mm"><b  style="margin-right:23%;">Mechanical Services</b>........... ' .
 date ( "m/d/Y", strtotime ( $w->SCHEDULE_DATE )).
 '</div>';
}

}
$temp = $temp . ucwords ( strtolower ( $w->WORK_DESCRIPTION ) );
break;
default :
break;
}

$temp = $temp . '
										</td>

									<td
										style=" border-right: 1px solid black; vertical-align: bottom;">' . $w->LIST_PRICE . '</td>
									<td
										style=" vertical-align: bottom;">' . $w->DISCOUNT_PRICE . '</td>
								</tr>';
$z ++;
$temp = $temp . "|";
$tot += $w->DISCOUNT_PRICE;

/* if ($z % 7 == 0)
{
$temp = $temp . "|";
$part = $part."|".$tot;

} */

endforeach
;

?>

<?php


// echo count($datum);exit;

$total = 0;
$credit = 0;
$outbal = 0;
$baldue = 0;
$detail1 = '';
$detail2 = '';
$detail3 = '';
foreach ( $message as $m ) :

    $detail1 = $m->ddetail1;
    $detail2 = $m->ddetail2;
    $detail3 = $m->ddetail3;

endforeach
;

?>
<input type="hidden" id="zoom_status" value="1" />
<?php
$step = '';
$steps = '';
?>

<?php

$step = $step . '<table
	style="width: 600px; margin: 0px auto; background-color: white; color: black; transform-origin: 18% 4%; -ms-transform-origin: 18% 4%;"
	id="zoomer" class="mastertable">
	<!--top portion of the pdf -->
	<tr>';
foreach ( $company as $c ) :
    $step = $step . '<td style="width: 200px; vertical-align: top; padding-top: 5mm"><span
			style="color: #912424; font-size: 16px; font-family: sans-serif; line-height: 4mm;">' . $c->BUSINESS_NAME . '</span>
			 <span style="font-family: sans-serif;display:block;line-height:3mm;margin-top:1mm;font-size: 15px">' . $c->ADDRESS . '</span>
			<span style="font-family: sans-serif;margin-top:1mm;display:block;line-height:3mm;font-size: 15px">' . $c->CITY . ' ' .
                                     $c->STATE .
                                     ',' .
                                     $c->ZIP_CODE .
                                     '</span>';
endforeach
;


$step = $step . '	</td>
		<td style="width: 280px; text-align: center; vertical-align: top;">
			<table class="slavetable" style="width: 94mm; text-align: center; vertical-align: top;">
				<tr>

					<td style="vertical-align: top; width: 4mm">
    <img
						src="http://btwdivedb.com/diver/img/dagger_pdf.png"
						style="width: 4mm; height: 85px;" /></td>
					<td style="vertical-align: top;"><b
						style="float: left; width: 100%; font-size: 5mm; font-family: calibri;">Below
							The Waterline Diving Service</b> <span>(P)310.918.5631
							</span>


						<table style="width: 100%; text-align: center; margin: 0px auto;">
							<tr>
								<td style=""><img src="http://btwdivedb.com/diver/img/red.bmp"
									style="width: 10mm; height: 7mm;" /></td>
								<td style="text-align: center;"><span style="display:block;">info@btwdive.com</span><span>www.btwdive.com</span></td>
								<td style=""><img src="http://btwdivedb.com/diver/img/blue.jpg"
									style="width: 10mm; height: 7mm;" /></td>
							</tr>
						</table></td>
					<td style="vertical-align: top; width: 4mm"><img
						src="http://btwdivedb.com/diver/img/dagger_pdf.png"
						style="width: 4mm; height: 85px;" /></td>
				</tr>
			</table>




		</td>

	</tr>';

// <!-- just below the top -->

$msg = '';
foreach ( $invoice as $i ) :

    $step = $step . '	<tr>
		<td
			style="height: 135px; padding-left: 14mm; width: 200px; vertical-align: bottom;">
			<!-- customer details. --> <span
			style="margin-top: 17mm; font-family: sans-serif; font-size: 4mm;"><b
				style="font-family: calibri; font-size: 4mm; display: block;">' . $i->FIRST_NAME . "&nbsp;" . $i->LAST_NAME .
                                     '</b>';
    if ($i->BILL_ADDRESS != '') {
        $step = $step . $i->BILL_ADDRESS . '<br />';
    }
    if ($i->BILL_ADDRESS1 != '') {
        $step = $step . $i->BILL_ADDRESS1 . "<br />";
    }
    ?><?php

    $step = $step . $i->BILL_CITY . "," . $i->BILL_STATE . '&nbsp;' . $i->BILL_ZIPCODE;
    $step = $step . '		</span>
		</td>

		<td style="padding-left: 20px;">

			<ul class="listed"
				style="list-style-type: none; width: 140px; margin-left: 50px; background-repeat: no-repeat; height: 50px; margin-top: 3mm; padding-top: 2mm; border: 1px solid #d4d4d4; border-radius: 10px; font-style: italic;">
				<li style="font-size: 3mm; font-family: sans-serif;">Hull Cleaning</li>
				<li style="font-size: 3mm; font-family: sans-serif;">Corrosion
					Control</li>
				<li style="font-size: 3mm; font-family: sans-serif;">Problem
					Recognition</li>
			</ul>

		</td>

	</tr>
	<tr>

		<td colspan="2" style="padding-left: 92mm; vertical-align: top;">
			<table
				style="border-collapse: collapse; text-align: center; font-family: sans-serif; font-size: 3.4mm">
				<tr>
					<td style="width: 29mm;"><span
						style="font-size: 3.4mm; font-family: sans-serif; vertical-align: top; height: 3.4mm">Invoice
							Date</span></td>
					<td style="width: 32mm;"><span
						style="font-size: 3.4mm; font-family: sans-serif; vertical-align: top; height: 3.4mm">Payment
							Enclosed</span></td>
					<td style="width: 29mm;"><span
						style="font-size: 3.4mm; font-family: sans-serif; vertical-align: top; height: 3.4mm">Invoice
							#</span></td>
				</tr>
				<tr>
					<td
						style="border: 1px solid #d4d4d4; border-right: 1px solid black; height: 35px;">' .
                                     date ( "m/d/Y", strtotime ( $i->INVOICE_DATE ) ) .
                                     '</td>
					<td
						style="border: 1px solid #d4d4d4; border-right: 1px solid black; text-align: left;">&nbsp;$</td>
					<td style="border: 1px solid #d4d4d4;">' .
                                     $i->PK_INVOICE .
                                     '
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<!-- main portion-->
	<tr>
		<td colspan="2"
			style="border-bottom: 1px dotted black; color: red; font-size: 3mm">Please
			detach here &amp; return with payment.</td>
	</tr>
	<tr>
		<td colspan="2">
			<table id="print_tbl">
				<tr>
					<td style="text-align: center">
						<div
							style="border: 1px solid #d4d4d4; padding: 5px 5px 5px 150px; height: 60px; background: #F5F5F5; width: 550px; border-radius: 5px; text-align: center;margin-bottom: 3mm">
							<table
								style="border-collapse: collapse; text-align: center; font-family: sans-serif; font-size: 3.2mm;margin-top: 5px;">
								<tr>


									<th
										style="width: 100px; border: 1px solid #d4d4d4; border-right: 1px solid black; border-bottom: none; height: 28px; background-color: white; height: 6mm">Date</th>
									<th
										style="width: 100px; border: 1px solid #d4d4d4; border-right: 1px solid black; border-bottom: none; background-color: white; height: 6mm">Invoice#</th>
									<th
										style="width: 100px; border: 1px solid #d4d4d4; border-right: 1px solid black; border-bottom: none; background-color: white; height: 6mm">Terms</th>
									<th
										style="width: 100px; border: 1px solid #d4d4d4; border-bottom: none; background-color: white; height:6mm">Account#</th>


								</tr>
								<tr>

									<td
										style="width: 100px; border: 1px solid #d4d4d4; border-right: 1px solid black; border-top: none; height: 28px; background-color: white; height: 6mm">' .
                                     date ( "m/d/Y", strtotime ( $i->INVOICE_DATE ) ) .
                                     '</td>
									<td
										style="width: 100px; border: 1px solid #d4d4d4; border-right: 1px solid black; border-top: none; background-color: white; height: 6mm">' .
                                     $i->PK_INVOICE .
                                     '</td>
									<td
										style="width: 100px; border: 1px solid #d4d4d4; border-right: 1px solid black; border-top: none; background-color: white; height:6mm">' .
                                     $i->TERMS .
                                     '</td>
									<td
										style="width: 100px; border: 1px solid #d4d4d4; border-top: none; background-color: white; height: 6mm">' .
                                     $i->ACCOUNT_NO .
                                     '</td>


								</tr>
							</table>
						</div>
						<div
							style="border: 1px solid #d4d4d4; border-radius: 5px; margin-top: 3px; width: 705px;"
							class="dialog_details once">
							<input type="hidden" id="current_pdf"
								value="' .
                                     $i->PK_INVOICE .
                                     '" />
							<table
								style="border-collapse: collapse; text-align: center; width: 100%; font-family: sans-serif; font-size: 3.4mm">

								<tr>
									<th
										style="border-right: 1px solid black; border-bottom: 1px solid black; width: 1%; height: 5mm">#</th>
									<th
										style="border-right: 1px solid black; border-bottom: 1px solid black; width: 75%">Description</th>

									<th
										style="border-right: 1px solid black; border-bottom: 1px solid black; width: 9%;">List
										Price</th>
									<th
										style="border-bottom: 1px solid black; border-bottom: 1px solid black; width: 11%;">Total</th>
								</tr>
								<tr>
									<td
										style="border-right: 1px solid black; border-bottom: 1px solid black;"></td>
									<td
										style="border-right: 1px solid black; border-bottom: 1px solid black; font-size: 3.2mm; ">
										<span
										style="width: 29mm;  display: inline-block; text-align: left; padding-left: 2mm;vertical-align: top;">Location<br />
											<b>';
											if($i->LOCATION=='Select Location')
											{
											    $step = $step. $i->SLIP ;
											}
											else
											{
											    $step = $step.$i->LOCATION . "&nbsp;" . $i->SLIP;
											}

                                     $step = $step.
                                     '</b></span> <span
										style="width: 33mm;  display: inline-block; text-align: left;margin-right:20mm;vertical-align: top;">Vessel
											Name<br /> <b>' .
                                     $i->VESSEL_NAME .
                                     '</b>
									</span> <span style="width:50mm;display: inline-block; text-align: left;vertical-align: top;">Paint
											Condition<br /> <b>';
    if ($i->PAINT_CYCLE != 0) {
        $step = $step . ucwords ( strtolower ( $paint [($i->PAINT_CYCLE) - 1]->OPTIONS ) );
    }

    $step = $step . '</b>
									</span>


									</td><td
										style="border-right: 1px solid black; border-bottom: 1px solid black;"></td>
									<td
										style="border-bottom: 1px solid black; border-bottom: 1px solid black;"></td>
								</tr>';

    $total = $i->NET_AMOUNT_INVOICED;
    $out = $i->OUTSTANDING_BALANCE;
    $out > 0 ? $outbal = $out : $credit = - ($out);
    $baldue = $total + $out;
    $msg = $i->COMMENTS;
endforeach
;
$stepp = '';
if ($z % 9 > 0) {
    $stepp = $stepp . '<tr>
    <td
    style=" border-right: 1px solid black;  vertical-align: top;"></td>
    <td style="text-align: left;  border-right: 1px solid black; vertical-align: top;height:' . (($z % 9) * 10) . 'px;">&nbsp;</td>
    <td
    style=" border-right: 1px solid black; vertical-align: bottom;"></td>
    <td
    style=" vertical-align: bottom;"></td></tr>';
}

$stepm = '';
$steps2 = '';
$steps3 = '';
$steps4 = '';
if ($msg != '') {
$stepm = $stepm . '
    <tr style="font-family: sans-serif;font-size: 3mm;">
    <td
    style=" border-right: 1px solid black;  vertical-align: top;color:white;">_</td>
    <td style="text-align: left;  border-right: 1px solid black; vertical-align: top;padding-left: 2mm">
    <b style="display:block;">Comments Section:</b>
    ' . $msg . '
    </td>
    <td
    style=" border-right: 1px solid black; vertical-align: bottom;"></td>
    <td
    style=" vertical-align: bottom;"></td>
    </tr>
    ';
}

$steps = $steps . '<tr><td colspan="4">
<table style="width:100%;border-collapse: collapse;">
								<tr>

									<td rowspan="3"
										style="padding-left:6mm; width: 71%;text-align: left; border-bottom: 1px solid black; border-right: 1px solid black; border-top: 1px solid black;font-family: sans-serif;font-size: 3.2mm;">
										' . $detail1 .
 '
										</td>
									<td
										style="border-bottom: 1px solid black; text-align: left; padding-left: 10px; border-top: 1px solid black;font-family: sans-serif;font-size: 3mm;">Total</td>
									<td
										style="border-bottom: 1px solid black; border-top: 1px solid black;font-family: sans-serif;font-size: 3mm;font-weight: bold;text-align: center;">';

 $steps2 = $steps2.
 '</td>
								</tr>

								<tr>
									<td
										style="white-space: nowrap; text-align: left; padding-left: 10px;font-family: sans-serif;font-size: 3.2mm;">Credit
										Balance</td>
									<td style="font-family: sans-serif;font-size: 3mm;text-align: center;">' .
 number_format ( abs ( $credit ), 2 ) .
 '</td>
								</tr>

								<tr>
									<td
										style="border-bottom: 1px solid black; white-space: nowrap; text-align: left; padding-left: 10px;font-family: sans-serif;font-size: 3.2mm;">Outstanding
										Balance</td>
									<td style="border-bottom: 1px solid black;font-family: sans-serif;font-size: 3.2mm;text-align: center;">'. number_format(abs($outbal),2).'</td>
								</tr>

								<tr>

									<td rowspan="2" colspan=""
										style="padding-left:6mm;text-align: left; border-bottom: 1px solid black; border-right: 1px solid black;font-family: sans-serif;font-size: 3.2mm;">' .
 $detail2 .
 '</td>
									<td style="text-align: left; padding-left: 10px;font-family: sans-serif;font-size: 3.1mm;font-weight: bold;">Balance Due</td>

									<td style="vertical-align: top;font-family: sans-serif;font-size: 3.2mm;font-weight: bold;text-align: center;">';
$steps4 = $steps4. '</td>
								</tr>

								<tr>

									<td colspan="2" style="border-bottom: 1px solid black;text-align: center;"><p
											style="color: red; font-size: 10px; white-space: nowrap;color: #912424;vertical-align: middle;">We
											Accept Major Credit Cards</p></td>

								</tr>

								<tr>

									<td class="linkedin" colspan=""
										style="padding-left:6mm;text-align: left; border-right: 1px solid black;font-family: sans-serif;font-size: 3.2mm;height: 11mm">' .
 $detail3 .
 '</td>
									<td colspan="2" style="white-space: nowrap; color: #912424;text-align: center;vertical-align: middle;">Thank
										You For Your Business</td>
								</tr>

</table></td></tr>

							</table>
						</div>
					</td>
				</tr>

			</table>
		</td>
	</tr>

</table><b style="page-break-after: always;" class="boldremove"></b>';
/*
 *  number_format ( abs ( $total ), 2 ) . .
 number_format ( abs ( $outbal ), 2 ) .
 .
 number_format ( abs ( $baldue ), 2 ) .
 */
//$amtpart = explode ( "|", $part );
// echo $part;exit;
//$tp = count ( $datum );
//echo $step;
//echo $datum[0];
//for($i = 0; $i < count ( $datum ); $i ++) {
/**
 * $z = 15 set this to two pages.
 */
//echo $temp;
/* if(count($datum)>1){
echo $datum[0];
echo '</table></div><b style="page-break-after: always;"></b><div
							style="border: 1px solid #d4d4d4; border-radius: 5px; margin-top: 3px; width: 705px;"
							class="dialog_details"><table style="border-collapse: collapse; text-align: center; width: 100%; font-family: sans-serif; font-size: 3.4mm">
<tr>
<th
style="border-right: 1px solid black;  width: 1%;color:white; ">_</th>
<th
style="border-right: 1px solid black;  width: 75%"></th>

<th
style="border-right: 1px solid black;  width: 9%;"></th>
<th
style="  width: 11%;"></th>
</tr>';
echo $datum[1];

}
if(count($datum)==1)
{
    echo $datum[0];

} */



//}
$temp = $temp . $stepm;
$datum = explode ( "|", $temp );
echo $step;
$ntp = '';
$stp = '';
$mtp = '';
for($i=0;$i<count($datum);$i++)
{
    if($z<=7){
    $ntp = $ntp .  $datum[$i];

    }
    if($z>7 && $z<=12)
    {
        $stp = $stp . $datum[$i];
    }
    if($z>12)
    {
        if($i<=12)
        {
            if($i<12)
            {
            $mtp = $mtp . $datum[$i];
            }
            if($i==12)
            {
                $mtp = $mtp . $datum[$i]. '</table></div><b style="page-break-after: always;"></b><div
							style="border: 1px solid #d4d4d4; border-radius: 5px; margin-top: 3px; width: 705px;"
							class="dialog_details twice"><table style="border-collapse: collapse; text-align: center; width: 100%; font-family: sans-serif; font-size: 3.4mm">
<tr>
<th
style="border-right: 1px solid black;  width: 1%;color:white; ">_</th>
<th
style="border-right: 1px solid black;  width: 75%"></th>

<th
style="border-right: 1px solid black;  width: 9%;"></th>
<th
style="  width: 11%;"></th>
</tr>';
            }
        }
        else
        {
            $mtp = $mtp .$datum[$i];
        }
    }
}

if($z<=7)
{
echo $ntp;
}
if($z>7 && $z<=12)
{
   echo $stp. '</table></div><b style="page-break-after: always;"></b><div
							style="border: 1px solid #d4d4d4; border-radius: 5px; margin-top: 3px; width: 705px;"
							class="dialog_details twice"><table style="border-collapse: collapse; text-align: center; width: 100%; font-family: sans-serif; font-size: 3.4mm">


   ';
}
if($z>12)
{
    echo $mtp;
}


//echo $stepm;
echo $steps;
echo number_format ( abs ( $total ), 2 );
echo $steps2;

if ($out < 0 && abs ( $out ) > $total) {
    echo number_format ( ( $total + $out ), 2 );
    ;
} else {
    echo number_format ( abs ( $total + $out ), 2 );
}
echo $steps4;
//echo $i."<br/".$z;


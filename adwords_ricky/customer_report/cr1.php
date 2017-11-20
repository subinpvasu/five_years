<?php
include("../header.php");

$id   = $_REQUEST['id'] ;

$array_currency = array('GBP'=>"£" ,'USD'=>'US$','EUR'=>'€','CAD'=>'CA$','MAD'=>"MAD",'NOK'=>'kr','BRL'=>'R$','DKK'=>'kr.','SAR'=>'SAR','AUD'=>'AU$','HKD'=>'HK$','TRY'=>'TRY' );

$account = $main -> getRow("SELECT ad_account_name,ad_account_adword_id,ad_account_currencyCode FROM adword_accounts where ad_account_adword_id='".$id."' ");
$_SESSION['ad_account_adword_id'] = $account->ad_account_adword_id;
$_SESSION['ad_account_name'] = $account->ad_account_name;
$_SESSION['ad_account_currencyCode'] = $array_currency[$account->ad_account_currencyCode];
?>

<div class="report-container">
	<div class="page-header"><h1><?php echo $account->ad_account_name; ?> (<?php echo $account->ad_account_adword_id; ?>)</h1></div>
	<div class="report-div">
		<div class="report-div-one">
			<div class="report-details1">
				<span id="downloadLinkExcel" style="display:line;">
					<!--a href="#" onclick="return htmToExcel()"; style="cursor:pointer;">Excel </a></span -->
					<span class="txtcolor2" id="downloadHTMLExcel" style="display:none;">Downloading.......</span> &nbsp; &nbsp;
				<span id="downloadLinkPdf" style="display:line;">
					<a href="#" onclick="return htmToPdf()"; style="cursor:pointer;">Pdf </a></span>
				<span class="txtcolor2" id="downloadHTMLPdf" style="display:none;">Downloading.......</span>
			</div>		
			<div class="report-details2">
				
					<input type='hidden' name='id' value='<?php echo $id; ?>' id="customer_id" />
					<div><span class="txtcolor2">Select</span> Month :</div>
					<div><select name='type' id="select_month" >
						<?php

							for ($i = 0; $i < 12; $i++) {
								echo "<option value='". date("Y-m", strtotime( date( 'Y-m' )." -$i months"))."' >". date("M-Y", strtotime( date( 'Y-m' )." -$i months"))."</option>";
							}

						?>
					</select></div>
					<div><input type="image" src="../img/go.png" alt="GO" class="submit_button" id="submit_button_id" ></div>
					<div><span class="txtcolor2">Select</span> Quarter :</div>
					<div><select name='type' id="select_month" >
						<?php
							$ar = getGivenNumberOfQuarters();
							for ($i = 5; $i >=0 ; $i--) { 
								echo "<option value='".$ar[$i]['quarter']."' >". $ar[$i]['quarter']."</option>";
							}

						?>
					</select></div>
					<div><input type="image" src="../img/go.png" alt="GO" class="submit_button" id="submit_button_id" ></div>
				
				
			</div>	
		</div>

		<div id="summery_report_id">
		<style> 

td {padding-left:5px;}

.classh1 {
	
	
	background-color: #00d8ff;
	padding: 10px 20px; 
    border-radius : 10px 10px .01em .01em;
    color: #fff;
    font-size: 18px;
    height: 30px;
    width : 95%;
	margin-bottom : 10px;
}

.classb1 {
	
	width : 98.2%;
	/* padding: 10px 20px; */
	background: #F5F5F5;
	height:auto ;
	margin:0px;
}
.classb2{
	width : 95%;
	padding: 10px 20px; 
	border-bottom-left-radius : 10px;
	border-bottom-right-radius : 10px;
	background: #717171;
	height:5px ;
	margin-bottom : 10px;
}
.classb3{
	width:98%;
	background : #222 ;
	border:1px #CCC solid ;
	height : auto;
	margin: 5px auto ;
}
.table1{
	border-collapse  : collapse ;
	border : #333 1px solid ;
	height:auto;
	width:100%;
	
}
.table1 td{
	
	width:15%;
	height:100px;
}
.hone,.htwo,.hthree,.hfour{
	float:left;
	width:100% ;
	text-align : center;
	margin:5px 0px;
}
.hone{
	color:#666;
	
}
.htwo{
	color:#EEE;
	font-weight:bold ;
	font-size : 18px;
	margin-bottom:0px;
}
.hthree{
	
	color:#EEE;
	font-size : 10px;
	margin-top:0px;
}
.hfour{
	
}
.classb4{
	width:30%;
	background:#DDD;
	margin:auto;
	font-size : 10px;
	padding : 2px 5px;
}
.containerdiv{
	display:none;
}
.green_span{
	color:green;
}
.red_span{
	color:red ;
}

.table_head{
	background: #717171;
	color:#FFF ;
	
}
.odd_trs{
	background: #e1e1e1;
}

.classb1 table{
	
	border-collapse : collapse ;
}
</style>
			
			<!-----  New Design  -->
			<div class="containerdiv" id="div1">
				<div class='classh1'></div>
				
				<div class='classb2'></div>			
			</div>
			<b style="page-break-after: always;"></b>
			<div class="containerdiv" id="div2">
				<div class='classh1'> <input type="checkbox" checked="checked"  class="classcb" />Conversion Share</div>
				<div class='classb1' id="conversion_share">&nbsp;</div>
				<div class='classb2'></div>			
			</div>
			<b style="page-break-after: always;"></b>
			<div class="containerdiv" id="div3">
				<div class='classh1'> <input type="checkbox" checked="checked"  class="classcb" /> Ad Label Report </div>
				<div class='classb1' id="ad_label_report">&nbsp;</div>
				<div class='classb2'></div>			
			</div>
			<b style="page-break-after: always;"></b>
			<div class="containerdiv" id="div4">
				<div class='classh1'> <input type="checkbox" checked="checked"  class="classcb" />Wastage Analysis</div>
				<div class='classb1' id="wastage_analysis">&nbsp;</div>
				<div class='classb2'></div>			
			</div>
			<b style="page-break-after: always;"></b>
			<div class="containerdiv" id="div5">
				<div class='classh1'> <input type="checkbox" checked="checked"  class="classcb" />Device Report</div>
				<div class='classb1' id = "device_report">&nbsp;</div>
				<div class='classb2'></div>			
			</div>
			<b style="page-break-after: always;"></b>
			<div class="containerdiv" id="div6">
				<div class='classh1'> <input type="checkbox" checked="checked"  class="classcb" />Keyword Discovery</div>
				<div class='classb1' id="keyword_discovery">&nbsp;</div>
				<div class='classb2'></div>			
			</div>
			<b style="page-break-after: always;"></b>
			<div class="containerdiv" id="div7">
				<div class='classh1'> <input type="checkbox" checked="checked"  class="classcb" />Conversion Booster</div>
				<div class='classb1' id="conversion_booster">&nbsp;</div>
				<div class='classb2'></div>			
			</div>
			<b style="page-break-after: always;"></b>
			<div class="containerdiv" id="div8">
				<div class='classh1'> <input type="checkbox" checked="checked"  class="classcb" />Avg By Day of Week</div>
				<div class='classb1' id="dayofweek">&nbsp;</div>
				<div class='classb2'></div>			
			</div>	
			<b style="page-break-after: always;"></b>
			<div class="containerdiv" id="div9">
				<div class='classh1'> <input type="checkbox" checked="checked"  class="classcb" />Total By Hour of Day</div>
				<div class='classb1' id="hourofday">&nbsp;</div>
				<div class='classb2'></div>			
			</div>						
		</div>
	</div>
</div>
<?php include("../footer.php"); 

function get_quarter($i=0) {
	$y = date('Y');
	$m = date('m');
	if($i > 0) {
		for($x = 0; $x < $i; $x++) {
			if($m <= 3) { $y--; }
			$diff = $m % 3;
			$m = ($diff > 0) ? $m - $diff:$m-3;
			if($m == 0) { $m = 12; }
		}
	}
	switch($m) {
		case $m >= 1 && $m <= 3:
			$start = $y.'-01-01';
			$end = $y.'-03-31';
			$quarter = "Q1-".$y ;
			break;
		case $m >= 4 && $m <= 6:
			$start = $y.'-04-01';
			$end = $y.'-06-30';
			$quarter = "Q2-".$y ;
			break;
		case $m >= 7 && $m <= 9:
			$start = $y.'-07-01';
			$end = $y.'-09-30';
			$quarter = "Q3-".$y ;
			break;
		case $m >= 10 && $m <= 12:
			$start = $y.'-10-01';
			$end = $y.'-12-31';
			$quarter = "Q4-".$y ;
	    	break;
	}
	return array(
		'start' => $start,
		'end' => $end ,
        'quarter'=>$quarter		
	);
}
function getGivenNumberOfQuarters($no=6){
	
	for($i=$no-1; $i >= 0 ; $i--){ $array[]	 = get_quarter($i); }
	
	return $array ;
	
}

?>

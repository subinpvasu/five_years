<?php
include("../header.php");

$id   = $_REQUEST['id'] ;
$main->select($_SESSION['user_db']);


$array_currency = array('GBP'=>"£" ,'USD'=>'US$','EUR'=>'€','CAD'=>'CA$','MAD'=>"MAD",'NOK'=>'kr','BRL'=>'R$','DKK'=>'kr.','SAR'=>'SAR','AUD'=>'AU$','HKD'=>'HK$','TRY'=>'TRY' );

$account = $main -> getRow("SELECT ad_account_name,ad_account_adword_id,ad_account_currencyCode FROM adword_accounts where ad_account_adword_id='".$id."' ");
$_SESSION['ad_account_adword_id'] = $account->ad_account_adword_id;
$_SESSION['ad_account_name'] = $account->ad_account_name;
$_SESSION['ad_account_currencyCode'] = $array_currency[$account->ad_account_currencyCode];
?>
<style> td {padding-left:5px;}</style>
<div class="report-container">
	<div class="page-header"><h1><a href="<?php echo SITE_URL ;?>account_details.php?msg=Search&search_term=<?php echo $account->ad_account_adword_id; ?>" style="text-decoration: none;color:#686868;"><?php echo $account->ad_account_name; ?> (<?php echo $account->ad_account_adword_id; ?>)</a></h1></div>
	<div class="report-div">
		<div class="report-div-one">
			<div class="report-details1">
				<span id="downloadLinkExcel" style="display:line;">
					<a href="#" onclick="return htmToExcel()"; style="cursor:pointer;">Excel </a></span>
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
				
				
			</div>	
		</div>

		<div>
		
			<div style="width:50%;margin:50px auto; display:none;" id="loading_gif_id"><img src="../img/loadingnew.gif" /></div>

			<div id="summery_report_id" ></div>
			<div style="width:50%;margin:50px auto; display:none;" id="loading_gif_id2"><img src="../img/loadingnew.gif" /></div>
		</div>
	</div>
</div>
<?php include("../footer.php"); ?>

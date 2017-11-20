<?php
include("header.php");

$array_currency = array('GBP' => "£", 'USD' => 'US$', 'EUR' => '€', 'CAD' => 'CA$', 'MAD' => "MAD", 'NOK' => 'kr', 'BRL' => 'R$', 'DKK' => 'kr.', 'SAR' => 'SAR', 'AUD' => 'AU$', 'HKD' => 'HK$', 'TRY' => 'TRY');


?>
<div class="report-container">
	<div class="page-header"><h1>BUDGET ORDER</h1></div>
	<!--div class="nav_left">&nbsp;</div>
	<div class="nav_right" style="text-align:right;padding-left:1%;width:58%" > </div-->
	<div class="report-div">
		<div class="account-details-div">
			<style>
.headerSortUp
	{
background-image: url("./images/downn.png");
		 background-position: center top;
    background-repeat: no-repeat;
    background-size: 20px auto;

cursor: pointer;
    }
.headerSortDown
	{
background-image: url("./images/up.png");
		 	 background-position: center top;
    background-repeat: no-repeat;
    background-size: 20px auto;
cursor: pointer;
	}
</style>
			<div id="listhead">
			  <table width="100%" height="100%" border="1" class="tablesorter">
                              <thead>
				<tr>				 
				  
				  <th width="15%" align="center">Account</th>
				  <th width="15%" align="center">Billing Account</th>
				  <th width="15%" align="center">Billing Customer</th>
				  <th width="15%" align="center">Purchase Order </th>
				  <th width="10%" align="center">Budget</th>
				  <th width="10%" align="center">% Spent</th>
				  <th width="10%" align="center">Start Date</th>
				  <th width="10%" align="center">End Date</th>
				  
				</tr>
                              </thead>
                              <tbody>
			 
				<?php $reports = $main->getBudgetOrderReport($_SESSION['ad_mcc_id'],$_SESSION['user_id'],$_SESSION['user_type']); ?>
				
				<?php foreach($reports as $result){ ?>
			 
				<tr>	
				
					<td width="15%" align="center"><?php echo $result['ad_account_name'] ; ?><br /><?php echo $result['ad_account_id'] ; ?> </td>
					<td width="15%" align="center"><?php echo $result['ad_billing_account_name'] ; ?><br /><?php echo $result['ad_billing_account_id'] ; ?></td>
					<td width="15%" align="center"><?php echo $result['ad_account_company'] ; ?><br /><?php echo $result['ad_primary_billing_id'] ; ?></td>
					<td width="15%" align="center"><?php echo $result['ad_budget_order_name'] ; ?><br /><?php echo $result['ad_po_number'] ; ?>
				<?php if($result['ad_budget_order_status'] == 0 ) {?> <span style="vertical-align:super; color:#FF6600;">Expired</span> <?php } ?>
					</td>
					<td width="10%" align="center"><?php if($result['ad_spending_limit']<>0){echo $result['ad_spending_limit'];} else{echo "Unlimited"; } ?> </td>
					<td width="10%" align="center"><?php if($result['spent']<>0){echo $result['spent'];} else{echo "--"; } ?> </td>
					<td width="10%" align="center"><?php echo date('d-m-Y',strtotime($result['ad_start_time'])) ; ?></td>
					<td width="10%" align="center"><?php echo date('d-m-Y',strtotime($result['ad_end_time'])) ; ?></td>
				  
				</tr>
			    <?php } ?>
                              </tbody>
				</table>
			</div>
		</div>
		<!--div class="nav_left">&nbsp;</div>
		<div class="nav_right" style="text-align:right;padding-left:1%;width:58%" >&nbsp;</div-->
	</div>
</div>
<?php include("footer.php"); ?>
<script type="text/javascript" src="./js/latest.js"></script>
<script type="text/javascript" src="./js/tablesorter.js"></script>
<style>
.headerSortUp
	{
background-image: url("./images/downn.png");
		 background-position: center top;
    background-repeat: no-repeat;
    background-size: 20px 10px;
border-top:2px solid #fc1f91 !important;
cursor: pointer;
    }
.headerSortDown
	{
background-image: url("./images/up.png");
		 	 background-position: center bottom;
    background-repeat: no-repeat;
    background-size: 20px 10px;
cursor: pointer;
		border-bottom:2px solid #fc1f91 !important;
	}
</style>
<script>
$(document).ready(function() {//,[2,0]
    // call the tablesorter plugin
    $("table").tablesorter({
        // sort on the first column and third column, order asc
        sortList: [[0,0]]
   	
    
    });



});

</script>
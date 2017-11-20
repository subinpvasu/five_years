<?php
include("header.php");
?>
<div class="report-container">
	<div class="page-header"><h1>Account Details</h1></div>
	<div class="nav_left">
		<ul class="navigater">

		  <li>Select All <input type="checkbox"  name='en_dis_all' id='en_dis_all' ></li>
		  <li><button type="submit" value="Enable" class="En_Dis">Enable</button></li>
		  <li><button type="submit" value="Disable" class="En_Dis">Disable</button></li>
		<?php if($_SESSION['prospect_account']<>1) { ?>  <li><button type="submit" value="Archive" class="En_Dis">Archive</button></li> <?php } ?>
		  </ul>
	</div>
	<div class="nav_right" style="text-align:right;padding-left:1%;width:58%" > 
	</div>
	<div class="report-div">
		<div class="account-details-div">
			<div id="listhead">
			  <table width="100%" height="100%" border="1">
				<tr>				 
				  <th width="10%" align="center">&nbsp;</th>
				  <th width="10%" align="center">Adwords ID</th>
				  <th width="20%" align="left">&nbsp;Name</th>
				  <th width="30%" align="left">&nbsp;Login Details</th>
				  <th width="10%" align="center">&nbsp;Status</th>
				  <th width="10%" align="center"><?php echo ANALYSIS; ?></th>
				  <th width="10%" align="center"><?php echo MONTHLY_REPORT; ?></th>
				</tr>
			  </table>
			</div>
			<div id="listitems">

			</div>
		</div>
		<div class="nav_left">
			<ul class="navigater">

			  <li>Select All <input type="checkbox"  name='en_dis_all' id='en_dis_all' ></li>
			  <li><button type="submit" value="Enable" class="En_Dis">Enable</button></li>
			  <li><button type="submit" value="Disable" class="En_Dis">Disable</button></li>
			  <?php if($_SESSION['prospect_account']<>1) {?>  <li><button type="submit" value="Archive" class="En_Dis">Archive</button></li> <?php } ?>
			  </ul>
		</div>
		<div class="nav_right" style="text-align:right;padding-left:1%;width:58%" > 
		</div>
	</div>
</div>
<?php include("footer.php"); ?>

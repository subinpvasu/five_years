<?php
include("header.php");
?>
<div class="report-container">
	<div class="page-header"><h1>ADWORD ACCOUNTS</h1></div>
	<div class="nav_left"><?php if($_SESSION['user_type']==2) { ?>
		<ul class="navigater">

		  <li>Select All <input type="checkbox"  name='en_dis_all' id='en_dis_all' ></li>
		  <li><button type="submit" value="Enable" class="En_Dis">Make it to Main Db</button></li>
		  
		  </ul>
	<?php } ?>
	</div>
	<div class="nav_right" style="text-align:right;padding-left:1%;width:58%" > 
	</div>
	<div class="report-div">
		<div class="account-details-div">
			<div id="listhead">
			  <table width="100%" height="100%" border="1">
				<tr>				 
				  <?php if($_SESSION['user_type']==2) { ?><th width="10%" align="center">Select</th><?php } ?>
				  <th width="20%" align="center">MCC ID</th>
				  <th width="20%" align="left">&nbsp;Name</th>
				  <th width="30%" align="left">&nbsp;Company</th>
				  <th width="10%" align="center">&nbsp;</th>
				  <th width="10%" align="center">&nbsp;</th>
				  
				</tr>
			  </table>
			</div>
			<div id="listitems">

			</div>
		</div>
		<div class="nav_left">
			<?php if($_SESSION['user_type']==2) { ?><ul class="navigater">

			  <li>Select All <input type="checkbox"  name='en_dis_all' id='en_dis_all' ></li>
			  <li><button type="submit" value="Enable" class="En_Dis">Make it to Main Db</button></li>
			  
			</ul><?php } ?>
		</div>
		<div class="nav_right" style="text-align:right;padding-left:1%;width:58%" > 
		</div>
	</div>
</div>
<?php include("footer.php"); ?>

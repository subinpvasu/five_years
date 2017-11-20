<?php
include("../header.php");
?>
<div class="report-container">
	<div class="page-header"><h1>Task Manager <input type='hidden' name='usertype' value='<?php echo $_SESSION['user_type']; ?>' id="usertype" /></h1></div>
	<!--div class="nav_left">
		<ul class="navigater">

		  <li>Select All <input type="checkbox"  name='en_dis_all' id='en_dis_all' ></li>
		  <li><button type="submit" value="Enable" class="En_Dis">Enable</button></li>
		  <li><button type="submit" value="Disable" class="En_Dis">Disable</button></li>
		  </ul>
	</div>
	<div class="nav_right" style="text-align:right;padding-left:1%;width:58%" > 
	</div-->
	<div class="report-div">
		<div class="ap_left">
			<span class="txtcolor2" id="report_month_id">&nbsp;<b>List Task</b></span> &nbsp; 

			<span id="downloadLink" style="display:line;"></span>

		</div>
		<div style="width:50%;margin:50px auto; " id="loading_gif_id">
			<img src="../img/loadingnew.gif" />
			</div>
			<div id="summery_report_id" >
			</div>
	
		<!--div class="nav_left">
			<ul class="navigater">

			  <li>Select All <input type="checkbox"  name='en_dis_all' id='en_dis_all' ></li>
			  <li><button type="submit" value="Enable" class="En_Dis">Enable</button></li>
			  <li><button type="submit" value="Disable" class="En_Dis">Disable</button></li>
			  </ul>
		</div>
		<div class="nav_right" style="text-align:right;padding-left:1%;width:58%" > 
		</div-->
	</div>
</div>
<?php include("../footer.php"); ?>

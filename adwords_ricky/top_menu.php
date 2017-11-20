<?php $link = "http://google.hostpush.co.uk/"; $link = "http://".$_SERVER['SERVER_NAME']."/" ; ?>
<div class="second_one">

<ul>

<li><img src="<?php echo $link ; ?>img/logout_li.png" style="margin-top:1px;vertical-align: middle;"><a href="<?php echo $link ; ?>logout.php">Logout</a></li>

<?php if($_SESSION['user_type']==2){ ?>
<li><img src="<?php echo $link ; ?>img/new_blue.png" style="margin-top:1px;vertical-align: middle;"><a href="<?php echo $link ; ?>user_manager/user_manager.php">User&nbsp;Manager</a></li>
<?php } ?>
<li><img src="<?php echo $link ; ?>img/report_li.png" style="margin-top:1px;vertical-align: middle;"><a href="<?php echo $link ; ?>reportmanagement/managementReports.php">Manage&nbsp;Reports</a></li>
<li><img src="<?php echo $link ; ?>img/details_li.png" style="margin-top:1px;vertical-align: middle;"><a href="<?php echo $link ; ?>/task_manager/task_manager.php">Task&nbsp; Manager</a></li>
<?php if($_SESSION['user_type']<>3){ ?>
<li><img src="<?php echo $link ; ?>img/home_li.png" style="margin-top:1px;vertical-align: middle;"><a href="<?php echo $link ; ?>account_details.php">Account&nbsp;Details</a></li>

<?php } ?>

</ul>


</div>
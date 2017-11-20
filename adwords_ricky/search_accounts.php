



<div class="first_one">

<?php if($_SESSION['user_type']<>3){ ?>
  <div style="
    float: left;
"><input type="text" class="ext textbox" placeholder="Search accounts" id="search_term" value="<?php echo $_REQUEST['search_term']; ?>"></div>
<div style="
    float: left;
"><img src="<?php echo SITE_URL ;?>img/search_img.png" onclick="goToChangeReports()" id="srchBtn" style="cursor:pointer;"></div>
<?php } ?>

</div>

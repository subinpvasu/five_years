<!--
<html>
    <head>
        <meta charset="UTF-8">
        <title>BTW Dive</title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta name="author" content="@toddmotto">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <link href="<?php echo base_url(); ?>css/diver_style.css" rel="stylesheet">
        <script type="text/javascript">
            function viewWOdetails(woid)
            {
                window.open("<?php echo site_url('/customer/view_wo_details/') ?>" + '/' + woid,'_self',false);

                //	alert(wonum);
            }
$(document).ready(function(){
	$("#printer").click(function(){
//alert("Ready to  Print.");
		var chkId=0;
$(":hidden.tmp").each(function(){
//	alert($(this).val());

	 chkId = chkId +"^"+ $(this).val();
});
//chkId =  chkId.slice(0,-1);
if(chkId.length>1)
{
window.open("<?php echo base_url()?>index.php/customer/printDocumentTitle/"+chkId);
}
		});
});


   </script>
   <style>
</head>

    <body>

        <div class="wrapper">

            <div id="main" style="padding:50px 0 0 0;">

                <form id="respo-form" method="post">
                  <div id="headerbtns">
                        <table width="100%">
                            <td width="40%">
                            <button name="home"  onclick="window.location = '<?php echo base_url(); ?>index.php/customer/diver_home/'" type="button" id="homebtn">Home</button>
                            </td>
                            <td width="20%" style="background-color:#000000;"></td>
                            <td width="40%">
                            <button name="log_out"   onclick="window.location = '<?php echo base_url(); ?>index.php/customer/diver_logout/'" type="button" id="Log_out">Log Out</button>
                            </td>
                        </table>
                    </div>
                    <div>
                        &nbsp;
                    </div>
                    <h2 align="center">Incomplete Work Orders


                    </h2>
                    <div>
                        &nbsp;
                    </div>
                    <div  id="displayCWO">
                        <table width="100%" bgcolor="1">
                            <tr width="100%">
                                <th class="tblhead">Type</th>
                                <th class="tblhead">Work Order #</th>
                                <th class="tblhead">Name</th>
                                <th class="tblhead">Boat Name</th>
                                <th class="tblhead">Location</th>
                            </tr>
                            <?php
                            if (is_array($results)) {
                                foreach ($results as $data) {
                                    ?>
	       <input type="hidden" class="tmp" value="<?php echo $data->PKWORKORDER; ?>"/>
                                    <tr onclick="viewWOdetails('<?php echo $data->PKWORKORDER; ?>')" class="tblRowDisplay" >
                                        <td><?php echo $data->W; ?></td>
                                        <td><?php echo $data->R; ?></td>
                                        <td><?php echo $data->F . " " . $data->L; ?></td>
                                        <td><?php echo $data->V; ?></td>
                                        <td><?php echo $data->O . " " . $data->SL; ?></td>
                                    </tr>
                                    <?php
                                }
                            }else{
                                echo '<tr><td colspan="5" style="text-align:center;">No Work Orders Found.</td></tr>';
                            }


            ?>
           </table>
            </div>
            <div id="pagLink" style="text-align: center;width: 100%;"><?php echo $links; ?></div>
             <div>
                 &nbsp;
			</div>
				<button class="btn" type="button" id="printer" name="s"  >Print Work Orders</button>
				</form>
	</div>



</div>

<div style="bottom: 0px;  width: 100%; text-align: center;font-weight: bold;">

BTW
		Dive &copy; 2014</div>
</body>
</html>
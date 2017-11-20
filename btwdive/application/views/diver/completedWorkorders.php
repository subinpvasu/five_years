<!--
Project     : BTW Dive
Author      : Subin
Title      : Completed work orders.
Description : Completed work orders will be listed according to the custyomers logged in.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BTW Dive</title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta name="author" content="@toddmotto">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>jquery/calender.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/calender.css" />

        <link href="<?php echo base_url(); ?>css/diver_style.css" rel="stylesheet">
        <script type="text/javascript">
            function updateList()
            {
                $("#displayCWO").html('<img width="100px" height="100px" src="<?php echo base_url() ?>img/loading_gif.gif" style="position:relative;top:0px;left:175px;">');
                $.ajax({url: "<?php echo base_url();?>index.php/customer/diver_view_cwo_date/",
                    type: "post",
                    data: {
                        s_date: $("#search_datea").val(),
                        e_date: $("#search_dateb").val()
                    },
                    success: function(result) {
                        //alert("hai");
                        $("#displayCWO").html(result);
                        $("#pagLink").hide();
                        $("#update_total_amount").click();

                    }
                });

            }
            /**
             *
             * @param {type} woid
             * @returns {undefined}
             */
            function viewWOdetails(woid)
            {
                // alert(woid);
                window.open("<?php echo site_url('/customer/view_wo_details/') ?>" + '/' + woid,'_self',false);

                //	alert(wonum);
            }
        </script>
        <script>

            $(function() {
                $("#search_datea").datepicker();
                $("#search_dateb").datepicker();
     //   $("#search_date").datepicker("option", "dateFormat", "yy-mm-dd");
            });
$(document).ready(function(){
	$("#update_total_amount").click(function(){

		$.ajax({url: "/btwdive/index.php/customer/total_commission_by_date/",
            type: "post",
            data: {
                s_date: $("#search_datea").val(),
                e_date: $("#search_dateb").val()
            },
            success: function(result) {
                //alert("hai");
               $("#totcom").html(result);

            }
        });

		});
});
            $(document).ready(function(){
            	updateList();
                });
        </script>

        <style>
@media all and (max-width: 480px) {
	body {
		font-family: sans-serif; font-weight : normal; font-size : 80%;
		background-color: black;
color:white;
		background-image: url('../img/body_bg.jpg');
		font-weight: normal;
		font-size: 80%;
	}
	#tblCompWO th.tblhead
{
	font-size: 90%;
	white-space:nowrap;
	line-height: 30px;

}
#tblCompWO th.tblhead:nth-child(2)
{

	font-size:80%;
	white-space: normal;
}

#displayCWO td,th
{
	font-size: 90%;

}
	#displayCWO th.tblhead:nth-child(4)
	{
	display: none;
	}
	#displayCWO td:nth-child(4)
{
	display:none;
}
#displayCWO td:nth-child(1)
{
	width:1%;
}
.dates
{
font-size: 90%;
}
#respo-form
{
	padding:0px;
}

}

@media all and (min-width: 481px) {
	body {
		font-family: sans-serif; font-weight : normal; font-size : 80%;
		background-color: black;
		line-height:20px;

		background-image: url('../img/body_bg.jpg');
		font-weight: normal;

	}
}

@media screen and (min-width: 1024px) {
	body {
		font-family: sans-serif;
		font-weight: normal;
line-height:20px;
		background-color: black;

		background-image: url('../img/body_bg.jpg');
	}
}
        </style>
    </head>

    <body>
        <?php
         $tcomm=0;
        if (is_array($total_comm)) {
           //   echo "0";
            foreach ($total_comm as $data) {
             //   echo "0";
                $tcomm= $tcomm+$data->C_AMT;
            }

        }
        ?>
        <div class="wrapper">
<input type="hidden" id="update_total_amount" />
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
                    <h2 align="center">Completed Work Orders


                    </h2>
                    <div>
                        &nbsp;
                    </div>
                    <div class="dates" style="width:100%">

                        Search By Date <input type="text" name="search_datea" id="search_datea" value="<?php
$k = date('m/d/Y', strtotime('last Sunday', strtotime(date('m/d/Y'))));
$date = $k;
$newdate = strtotime('-6 day', strtotime($date));
$newdate = date('m/d/Y', $newdate);
echo $newdate;
?>" style="width:30%;" onchange="updateList()"> -
                        <input type="text" name="search_dateb" id="search_dateb" style="width:30%;" value="<?php echo date('m/d/Y', strtotime('last Sunday', strtotime(date('m/d/Y')))); ?>" onchange="updateList()">
                    </div>
 <div>
                        &nbsp;
                    </div>
                        <div style="width:100%;text-align: center;">
                            <b>Total Commission :<b id="totcom" style=""><?php echo  number_format($tcomm,2); ?></b></b>
                        </div>
                        <div>
                            &nbsp;
                        </div>
                        <div id="tblCompWO">

                            <table id="t1" width="100%" bgcolor="1">

                            </table>
                        </div>
                        <div id="displayCWO">
                            <table id="t2" width="100%" bgcolor="1">
<?php
if (is_array($results)) {
    foreach ($results as $data) {
        ?>
                                        <tr onclick="viewWOdetails('<?php echo $data->PKWORKORDER; ?>')" class="tblRowDisplay" width="100%" >
                                            <td style="width:10%;table-layout: fixed;text-align: center;"><?php echo $data->W; ?></td>
                                            <td style="width:19%;table-layout: fixed;text-align: center;"><?php echo $data->R; ?></td>
                                            <td style="width:18%;table-layout: fixed;text-align: center;"><?php echo $data->F . " " . $data->L; ?></td>
                                            <td style="width:18%;table-layout: fixed;text-align: center;"><?php echo $data->V; ?></td>
                                            <td style="width:20%;table-layout: fixed;text-align: center;"><?php echo $data->O . " " . $data->SL; ?></td>
                                            <td style="width:15%;table-layout: fixed;text-align: right;"><?php echo $data->C_AMT; ?></td>
                                        </tr>
        <?php
    }
}
?>
                            </table>
                        </div>
                        <div id="pagLink"><?php echo $links; ?></div>
                        <div>
                            &nbsp;
                        </div>
                    </div>


                    <div style="bottom: 0px; position: absolute; width: 93%; text-align: center;font-weight: bold;">BTW
                        Dive © 2014</div>
                    </body>
                    </html>
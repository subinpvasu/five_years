<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BTW Dive</title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
        <meta name="author" content="@toddmotto">
        <link href="<?php echo base_url(); ?>css/diver_style.css" rel="stylesheet">

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
	#respo-form
	{
font-size: 90%;
}
.schedule
	{
	font-size: 60%;
	}

#displayCWO td:nth-child(1)
{
	width:1%;
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
 </style>  </head>

    <body>
        <input type="hidden" id="diverid" value="<?php echo $diverid ?>" />
        <input type="hidden" value="<?php echo date("Y-m-d"); ?>" id="datelast"/>

        <div class="wrapper">

            <div id="main" style="padding:50px 0 0 0;">
                <?php
                $comm_amt = 0;
                foreach ($commission_amt as $comm) :
                    $comm_amt += $comm->C_AMT;
                endforeach;
                ?>
                <form id="respo-form" method="post">
                    <div id="headerbtns">
                        <table width="100%">
                        <tr>
                            <td width="40%">
                                <button name="home"  onclick="window.location = '<?php echo base_url(); ?>index.php/customer/diver_home/'" type="button" id="homebtn">Home</button>
                            </td>
                            <td width="20%" style="background-color:#000000;"></td>
                            <td width="40%">
                                <button name="log_out"   onclick="window.location = '<?php echo base_url(); ?>index.php/customer/diver_logout/'" type="button" id="Log_out">Log Out</button>
                            </td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        &nbsp;
                    </div>
                    <h2 align="center">Cleaning Services
                    </h2>
                    <div>
                        &nbsp;
                    </div>


                    <?php
                    foreach ($customers as $customer) :
                        ?>
                        <div>
                            Client: <?php echo $customer->F . '&nbsp;' . $customer->L; ?>

                        </div>
                        <div>
                            Vessel Name : <?php echo $customer->V; ?>&nbsp;&nbsp;Location : <?php echo $customer->O; ?>&nbsp;&nbsp;Slip #: <?php echo $customer->S; ?>
                        </div>

                        <div>
                            Work Order # : <?php echo $customer->W; ?>

                        </div>

                        <?php
                    endforeach;
                    ?>
                    <div>
                        <table width="100%">
                            <tr width="100%">
                                <th class="tblhead">Type</th>
                                <th class="tblhead">Description</th>
                                <th class="tblhead">Cost</th>
                            </tr>
                            <?php
                            foreach ($cleanings as $c) :
                                if ($c->WORK_VALUE > 0) {
                                    ?>
                                    <tr class="tblRowDisplay" >
                                        <td><?php echo $c->WORK_TYPE; ?></td>
                                        <td><?php echo $c->WORK_DESCRIPTION; ?></td>
                                        <td><?php echo $c->DISCOUNT_PRICE; ?></td>
                                    </tr>
        <?php
        $dates = $c->SCHEDULE_DATE;
        $comments = $c->COMMENTS;
        $wostatus = $c->WO_STATUS;
    }

endforeach;
?>
                        </table>
                    </div>
                            <?php
                            if ($wostatus != 0) {
                                ?>
                        <div>
                            <label>
                                <span style="text-align:right">Commission :<?php echo $comm_amt; ?></span>
                            </label>
                        </div>
    <?php
}
?>

                    <div>
                        <label>
                            <span>Comments</span>
                            <textarea  class="txtareaComments" tabindex="15" style="height:100px;" readonly><?php echo $comments; ?></textarea>
                        </label>
                    </div>
                   <div style="margin:25px 0">
				<label>
					<span  class="schedule" style="text-decoration:underline;">Schedule Date : <?php echo $dates; ?></span>
                            <input type="hidden" value="<?php echo $dates; ?>" id="scheduledate"/>
                        </label>
                    </div>
<?php
if ($wostatus == 0) {
    ?>
                        <div>
                            <button name="s" onclick="window.location = '<?php echo base_url(); ?>index.php/customer/clean_compWO/<?php echo $pkwork; ?>'" type="button" id="ic_wo">Next</button>
                        </div>
                        <div>
			<button name="s" onclick="window.location='<?php echo base_url();?>index.php/customer/diver_incompleted_wo/'" type="button" id="ic_wo">Back</button>
			</div>
                        <?php
                    }
                    else
                    {

                    ?>
                        <div>
                        <button name="s" onclick="window.location='<?php echo base_url();?>index.php/customer/diver_completed_wo/'" type="button" id="ic_wo">Back</button>
                        </div>
                    <?php }
                    ?>
                    <div>
                        &nbsp;
                    </div>
                </form>
                <!-- /Form -->
            </div>






        <div style="bottom: 0px;  width: 93%; text-align: center;font-weight: bold;">BTW Dive &copy; 2014</div>
            </div>
    </body>
</html>
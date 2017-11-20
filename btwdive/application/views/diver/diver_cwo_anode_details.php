<!--
Project     : BTW Dive
Author      : Subin
Title      : Add anode whle cleaning
Description : Add/update anode work order while cleaning.
-->
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>BTW Dive</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<meta name="author" content="@toddmotto">
	<link href="<?php echo base_url();?>css/diver_style.css" rel="stylesheet">
   <script type="text/javascript">





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
/* #displayCWO td,th
{
	font-size: 90%;

} */
	/* #displayCWO th.tblhead:nth-child(4)
	{
	display: none;
	}
	#displayCWO td:nth-child(4)
{
	display:none;
} */
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
        </style>

</head>

<body>
	<input type="hidden" id="diverid" value="<?php echo $diverid?>" />
                        <input type="hidden" value="<?php echo date("Y-m-d");?>" id="datelast"/>
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
                            <td width="40%">
                            <button name="home"  onclick="window.location = '<?php echo base_url(); ?>index.php/customer/diver_home/'" type="button" id="homebtn">Home</button>
                            </td>
                            <td width="20%" style="background-color:#000000;"></td>
                            <td width="40%">
                            <button name="log_out"   onclick="window.location = '<?php echo base_url(); ?>index.php/customer/diver_logout/'" type="button" id="Log_out">Log Out</button>
                            </td>
                        </table>
                    </div>
                   <h2 align="center">Anode Work

		  </h2>
                    <div>
                        &nbsp;
                    </div>
			<?php
			foreach ( $customers as $customer ) :
			?>
			<div>
			Client: <?php  echo $customer->F.'&nbsp;'.$customer->L; ?>

			</div>
			<div>
            Vessel Name : <?php echo $customer->V;?>&nbsp;&nbsp;Location : <?php echo $customer->O;?>&nbsp;&nbsp;Slip #: <?php echo $customer->S;?>
            </div>

			<div>
			Work Order # : <?php  echo $customer->W; ?>

			</div>

			<?php
			endforeach;
			?>
			   <div>
		   <table width="100%" bgcolor="1">
           <tr width="100%">
           <th class="tblhead">Anodes on Boat</th>
           <th class="tblhead">Change Anode</th>
           </tr>
           <?php
           foreach ( $cleanings as $c ) :
                if($c->VALUE>0){
           ?>
           <tr class="tblRowDisplay" >
           <td><?php echo  $c->WORK_TYPE; ?></td>
           <?php
           switch ($c->VALUE)
    {
        case 1:
            echo '<td>Inspect Anode</td>';
            break;
        case 2:
            echo '<td>Change If Needed</td>';
            break;
        case 3:
            echo '<td>Change Anode</td>';
            break;
        default:
            echo '<td></td>';
    }
    ?>

           </tr>
            <?php
            $dates = $c->SCHEDULE_DATE;
            $comments = $c->COMMENTS;
            $wostatus=$c->WO_STATUS;
          //  echo $wostatus;
                }
            endforeach;

            ?>
           </table>

                           </div>

                        <?php
                        if($wostatus!=0)
                        {
                            ?>
                        <div>
				<label>
					<span style="text-align:right">Commission :<?php echo $comm_amt;?></span>
				</label>
			</div>
                        <?php
                        }
                        ?>
			<div>
				<label>
					<span>Comments/Quality Control</span>
					<textarea  class="txtareaComments" tabindex="15" style="height:100px;" readonly><?php echo $comments;?></textarea>
				</label>
			</div>
			<div style="margin:25px 0">
				<label>
					<span style="text-decoration:underline;">Schedule Date : <?php echo $dates;?></span>
                                        <input type="hidden" value="<?php echo $dates;?>" id="scheduledate"/>

				</label>
			</div>
			<?php
                        if($wostatus==0)
                        {
                            ?>
                         <div>
			<button name="s" onclick="window.location='<?php echo base_url();?>index.php/customer/anode_compWO/<?php echo $pkwork;?>'" type="button" id="ic_wo">Next</button>
			</div>
			<div>
			<button name="s" onclick="window.location='<?php echo base_url();?>index.php/customer/diver_incompleted_wo/'" type="button" id="ic_wo">Back</button>
			</div>
                    <?php
                        }else
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

<div style="bottom: 0px; position: absolute; width: 93%; text-align: center;font-weight: bold;">BTW
		Dive © 2014</div>
                    </div>


</body>
</html>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>BTW Dive</title>
	<meta charset="UTF-8">
        <title>BTW Dive</title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta name="author" content="@toddmotto">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>jquery/calender.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/calender.css" />

        <link href="<?php echo base_url(); ?>css/diver_style.css" rel="stylesheet">


        <script type="text/javascript">
        $(document).ready(function(){
$("#lastdate").datepicker();
            });
            function loadAJAX()
{
	if (window.XMLHttpRequest){
	  xmlhttp=new XMLHttpRequest();
	  }	else {
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  return xmlhttp;
}


            function update_comments(str)
    {
        var r = confirm("Are you sure you want to Complete this Work Order..?");
        var msg = 10;

	if(r){
		loadAJAX().onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
			      //searchDistribution(xmlhttp.responseText);
		      if(xmlhttp.responseText=='Y')
		      {



		      }
		    }
		  };
		  if($("#msgsms").val()=="b")
		  {
 msg =20;

		  }
		

		//xmlhttp.open("POST","/btwdive/index.php/customer/completeWorkOrder/"+str,true);
		//xmlhttp.send();
			paint_cycle_status = $("input[name=paint_cycle]:checked").val();
                 $.ajax({url: "<?php echo base_url();?>index.php/customer/update_diver_comments/1",
                type: "post",
                data: {
                    newcomments:  $("#comment").val(),
                    oldcomments:  $("#oldsms").val(),
					pk_vessel : $("#pk_vessel").val(),
					paint_cycle : paint_cycle_status,
                    lastdate:$("#lastdate").val(),
                    pk_wo:$("#pk_wo").val(),
                    sts:msg

                },
                success: function(result) {
            //
        alert("Work Order Completed");
   window.open('<?php echo base_url();?>index.php/customer/diver_incompleted_wo/','_self',false);
//alert("updated");



                }
            });

            }

     //  var a=$("#comment").val();
      // alert(a);



    }
            function messageChanged()
            {
document.getElementById("msgsms").value="b";
            }
            </script>
</head>

<body>
    <?php
	foreach ( $cleanings as $c ) :

            $dates = $c->SCHEDULE_DATE;
            $comments = $c->COMMENTS;
            $wostatus=$c->WO_STATUS;
            endforeach;
            ?>
			<?php echo $paint_cycle[0]->PAINT_CYCLE; ?>
	<div class="wrapper">
	<input type="hidden" id="msgsms" value="a"/>
            <input type="hidden" id="pk_wo" value="<?php echo $pkwork; ?>" >
			<input type="hidden" id="pk_vessel" value="<?php echo $cleanings[0]->PK_VESSEL; ?>" >
		<div id="main" style="padding:50px 0 0 0;">

		<!-- Form -->
		<form id="respo-form" >
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
			<div>
            <h4 style="width:50%;float:left;display:inline-block;margin-top:10px;">Work Order Completed On : </h4><input style="width:48%;float:left;" type="text" id="lastdate" value="<?php echo date("m/d/Y");?>"/>
            </div>
			<div>
                                &nbsp;
                            </div>
					<div style="width:100%;float:left;display:inline-block;margin-top:10px;">
				<h4 style="width:50%;float:left;"> Paint Cycle : </h4><input name="paint_cycle" value="1" type="radio" <?php if($paint_cycle[0]->PAINT_CYCLE == 1) echo 'checked="checked"'?>>EXCELLENT 
				<input name="paint_cycle" value="2" type="radio" <?php if($paint_cycle[0]->PAINT_CYCLE == 2) echo 'checked="checked"'?>> GOOD
				<input name="paint_cycle" value="3" type="radio" <?php if($paint_cycle[0]->PAINT_CYCLE == 3) echo 'checked="checked"'?>>FAIR 
				<input name="paint_cycle" value="4" type="radio" <?php if($paint_cycle[0]->PAINT_CYCLE == 4) echo 'checked="checked"'?>>POOR 
            </div>
                            <div>
                                &nbsp;
                            </div>
					
			<h2>Comments

		  </h2><div>
                                &nbsp;
                            </div>
            <div>

					<textarea onchange="messageChanged()"  tabindex="15" id="comment" name="comments" ><?php echo $comments;?></textarea>
					<input type="hidden" id="oldsms" value="<?php echo $comments;?>"/>

			</div>

			<div>

                            <button name="s" onclick="update_comments(<?php echo $pkwork;?>)"  type="button" id="btn_sbt">Submit</button>
			</div>
			<div>
                            <button name="s"  onclick="window.location='<?php echo base_url();?>index.php/customer/diver_cleantype_cwo/<?php echo $pkwork;?>'" type="button" >Back</button>


                        </div>

		</form>
		<!-- /Form -->

		</div>



<div style="bottom: 0px;  width: 93%; text-align: center;font-weight: bold;">BTW
		Dive &copy; 2014</div>
            </div>
</body>
</html>
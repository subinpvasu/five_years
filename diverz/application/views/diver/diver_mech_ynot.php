<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>BTW Dive</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<meta name="author" content="@toddmotto">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<link href="<?php echo base_url();?>css/diver_style.css" rel="stylesheet">


        <script type="text/javascript">
            function update_comments()
    {
            	var today = new Date();
            	var dd = today.getDate();
            	var mm = today.getMonth()+1; //January is 0!
            	var yyyy = today.getFullYear();

            	if(dd<10) {
            	    dd='0'+dd
            	}

            	if(mm<10) {
            	    mm='0'+mm
            	}

            	today = mm+'/'+dd+'/'+yyyy;
     //  var a=$("#comment").val();
      // alert(a);
		paint_cycle_status = $("input[name=paint_cycle]:checked").val();
        $.ajax({url: "<?php echo base_url();?>index.php/customer/update_diver_comments/",
                type: "post",
                data: {
               	 newcomments:  $("#comment").val(),
                 oldcomments:$("#oldsms").val(),
				 pk_vessel : $("#pk_vessel").val(),
				paint_cycle : paint_cycle_status,
                 lastdate:today,
                 pk_wo:$("#pk_wo").val(),
                 sts:0
                },
                success: function(result) {
                	alert("Comments Updated.");
                    window.open('<?php echo base_url();?>index.php/customer/diver_incompleted_wo/','_self',false);
//alert("updated");



                }
            });



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
	<div class="wrapper">
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
					<div style="width:100%;float:left;display:inline-block;margin-top:10px;">
				<h4 style="width:50%;float:left;"> Paint Cycle : </h4><input name="paint_cycle" value="1" type="radio" <?php if($paint_cycle[0]->PAINT_CYCLE == 1) echo 'checked="checked"'?>>EXCELLENT 
				<input name="paint_cycle" value="2" type="radio" <?php if($paint_cycle[0]->PAINT_CYCLE == 2) echo 'checked="checked"'?>> GOOD
				<input name="paint_cycle" value="3" type="radio" <?php if($paint_cycle[0]->PAINT_CYCLE == 3) echo 'checked="checked"'?>>FAIR 
				<input name="paint_cycle" value="4" type="radio" <?php if($paint_cycle[0]->PAINT_CYCLE == 4) echo 'checked="checked"'?>>POOR 
            </div>
                            <div>
                                &nbsp;
                            </div>
					
			<h2>Why not?

		  </h2>
			<div>
            &nbsp;
            </div>
            <div>

					<textarea  tabindex="15" id="comment" name="comments" ><?php echo $comments;?></textarea>
					<input type="hidden" id="oldsms" value="<?php echo $comments;?>"/>

			</div>

			<div>

                            <button name="s" onclick="update_comments()"  type="button" id="btn_sbt">Submit</button>
			</div>
         <div>
                            <button name="s"  onclick="window.location='<?php echo base_url();?>index.php/customer/mech_compWO/<?php echo $pkwork;?>'" type="button" >Back</button>


                        </div>
		</form>
		<!-- /Form -->

		</div>



<div style="bottom: 0px;  width: 93%; text-align: center;font-weight: bold;">BTW
		Dive &copy; 2014</div>	</div>
</body>
</html>
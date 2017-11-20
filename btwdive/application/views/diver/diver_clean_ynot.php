<!--
Project     : BTW Dive
Author      : Subin
Title      : Add comments to cleaning work order before completion.
Description : Add comments to cleaning work order before completion.
-->
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
     //  var a=$("#comment").val();
      // alert(a);
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
        $.ajax({url: "<?php echo base_url();?>index.php/customer/update_diver_comments/",
                type: "post",
                data: {
                    newcomments:  $("#comment").val(),
                    oldcomments:'',
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
            $woclass = $c->WO_CLASS;
            endforeach;
            ?>
	<div class="wrapper">
            <input type="hidden" id="pk_wo" value="<?php echo $pkwork; ?>" >

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
			<h2>Why not?

		  </h2>
			<div>
            &nbsp;
            </div>
            <div>

					<textarea  tabindex="15" id="comment" name="comments" ><?php echo $comments;?></textarea>

			</div>

			<div>

                            <button name="s" onclick="update_comments()"  type="button" id="btn_sbt">Submit</button>
			</div>
			<?php if($woclass=='C'){ ?>
         <div>
                            <button name="s"  onclick="window.location='<?php echo base_url();?>index.php/customer/clean_compWO/<?php echo $pkwork;?>'" type="button" >Back</button>


                        </div><?php }else{?>
                         <div>
                            <button name="s"  onclick="window.location='<?php echo base_url();?>index.php/customer/anode_compWO/<?php echo $pkwork;?>'" type="button" >Back</button>


                        </div>
                        <?php }?>
		</form>
		<!-- /Form -->

		</div>



<div style="bottom: 0px; position: absolute; width: 93%; text-align: center;font-weight: bold;">BTW
		Dive © 2014</div>	</div>
</body>
</html>
<!--
Project     : BTW Dive
Author      : Subin
Title      : List anodes
Description : All anodesincluded in the  work orde rwill be listed.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BTW Dive</title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta name="author" content="@toddmotto">
        <link href="<?php echo base_url(); ?>css/diver_style.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript">
            function completeWorkOrder(str,sbn)
            {
                flag = false;

                $(":checkbox").each(function(){
if(!($(this).prop("checked")))
    {
flag = true;
	}

                    });

                //Checking check box is checked
                if (flag===false)
                {
                    if(sbn==1)
                    {
                    	window.open('<?php echo base_url(); ?>index.php/customer/diver_anode_cwo_comments/' + str, '_self', false);
                    }else
                    {
                    window.open('<?php echo base_url(); ?>index.php/customer/diver_anode_cwo3/' + str, '_self', false);
                    }

                }
                else
                {
                    alert("To complete this work order, all anodes should be replaced");
                }//alert(str);
            }
        </script>
    </head>

    <body>

        <div class="wrapper">

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
                        <h2>Which Zincs were changed?

                        </h2>
                        <div>
                            &nbsp;
                        </div>

                        <div>
                            &nbsp;
                        </div>
                        <div>
                            <table>
                                <?php
                                $workparts = '';
                                $comments = '';
                                $dates = '';
                                $diverz = '';
                                $used = '';
                                $workpartsand = '';
                                $kount = 1;
                                foreach ($anodes as $anode) :
                                    ?>
                                    <tr>
                                        <td><?php echo $anode->WORK_TYPE; ?> </td>


                                        <?php
                                        $anode->VALUE == 3 ? print
                                                                '<td style="background-color:#262626;text-align: center;width: 40px"><input type="checkbox" class="chkbx" name="' . $anode->P . '" checked id="change' . $anode->P . '" value="3" /></td>' : print
                                                                '<td style="background-color:#262626;text-align: center;width: 40px"><input type="checkbox" class="chkbx"  name="' . $anode->P . '"  id="change' . $anode->P . '" value="3" /></td>';
                                        ?>
                                    </tr>        <?php
                                endforeach;
                                ?>
                            </table>
                        </div>
                        <div>
                            &nbsp;
                        </div>

                        <div>
                            &nbsp;
                        </div>
<?php if(count($totalanodes)==count($anodes)){?>
<div>
                            <button name="s" onclick="completeWorkOrder(<?php echo $pkwork; ?>,1)"  type="button" id="btn_next">Next</button>

                        </div>
<?php }else{?>

                        <div>
                            <button name="s" onclick="completeWorkOrder(<?php echo $pkwork; ?>,0)"  type="button" id="btn_next">Next</button>

                        </div>
                        <?php }?>
                        <div>
                            <button name="s"  onclick="window.location='<?php echo base_url();?>index.php/customer/view_wo_details/<?php echo $pkwork;?>'" type="button" >Back</button>


                        </div>

                </form>
                <!-- /Form -->

            </div>
            <div style="bottom: 0px; position: absolute; width: 93%; text-align: center;font-weight: bold;">BTW
        Dive © 2014</div>
        </div>




</body>
</html>
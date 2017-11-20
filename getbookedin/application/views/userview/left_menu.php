<div class="container"> 
    <!--service start-->
    <div class="row">
        <!--left menu-->
        <div class="col-lg-3 col-md-4 col-sm-4">
            <div class="hs_service">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <style type="text/css">
                            span {
                                font-weight: bold;
                                font-size: 12px;
                            }
                        </style>
                        <?php
                            foreach ($available_adminusers as $aduser):
                            if ($aduser['id'] == $subdomain['id_admin']) {
                                ?>

                                <h4 class="hs_heading"> <?php echo "Admin Selected"; ?> </h4>
                                <h4> <?php echo $adminuser_header['header_caption']; ?> </h4>
                                <p><i class="fa fa-envelope"></i> &nbsp; <?php echo $aduser['email']; ?> <br>
                                    <i class="fa fa-phone-square"></i> &nbsp; <?php if (strlen($aduser['mobile_number']) > 0) {
                            echo $aduser['mobile_number'];
                        } else {
                            echo $aduser['phone_number'];
                        }
                        ?> <br>
                                    <i class="fa fa-indent"></i> &nbsp; <?php echo $aduser['address']; ?> <br>
                                    &nbsp;&nbsp;<?php echo $aduser['city'] . ", " . $aduser['state'] . "-" . $aduser['zip_code']; ?>
                                </p>
                                <p><i class="fa fa-globe"></i> &nbsp;
                                    <a href="http://<?php echo $aduser['subdomain']['subdomain_name'] . '.getbookedin.uk'; ?>" target="_blank">
        <?php echo $aduser['subdomain']['subdomain_name'] . '.getbookedin.uk'; ?>  </a>
                                </p>
    <?php }
endforeach;
?>

                        <p>
                            <input type="button" class="btn btn-primary" value="Waiting List" name="waitinglist" id="getwaitinglist" data-toggle="modal" data-target="#waitinglistModal">
                        </p>

                    </div>
                </div>
            </div>
        </div>

        <div id="waitinglistModal" class="modal fade" role="dialog" style="backgroun">
            <div class="modal-dialog"  style="width:99%; margin:5px auto;" >

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Waiting Lists</h4>
                    </div>


                    <div class="modal-body">

                        <div>

                               <?php $waitingList = $waiting_list[0];
                                                              
                               if($waitingList ->wait_period_type_id_fk ==1) {
                                   
                                   $type = "Days";
                               }
                               else{
                                   
                                   $type = "Date Range";
                               }
                               ?> 
                            
                            
                            
                            <?php if(count($waiting_list)<1) {?><p> No waiting list found </p><?php }  
                            
                             else {  ?> <p><?php echo $type ;  ?> added to waiting list</p>
                            
                            <p><?php echo $waitingList ->date_value ;  ?></p><?php } ?>

                        </div>

                        <div class="bg-warning" style="font-weight: bold;color:brown;" id="error_text_login"></div>

                        <div class="modal-footer">
                            <?php if(count($waiting_list)>0) {?>
                            <input type="button" class="btn btn-primary" value="Change" name="change_waiting_list" id="change_waiting_list">
                            <input type="button" class="btn btn-primary" value="Cancel" name="cancel_waiting_list" id="cancel_waiting_list">
                            <?php }else{ ?>
                            <input type="button" class="btn btn-primary" value="Add" name="add_waiting_list" id="add_waiting_list">
                            <?php } ?>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--left menu end-->
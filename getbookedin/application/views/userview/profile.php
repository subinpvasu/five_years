<!--right menu--> 

<div class="col-lg-9 col-md-8 col-sm-8">
    <div class="hs_service">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <h4>Update Profile</h4>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-8 col-md-10 col-sm-12">

                <?php
                if (isset($message)) {
                    ?>
                    <h4><?php echo $message; ?></h4>

                    <?php
                }
                $firstname = set_value('firstname') == false ? $user[0]->first_name : set_value('firstname');
                $lastname = set_value('lastname') == false ? $user[0]->last_name : set_value('lastname');
                $age = set_value('age') == false ? $user[0]->age : set_value('age');
                $gender = set_value('gender') == false ? $user[0]->gender : set_value('gender');
                $mobile = set_value('mobile') == false ? $user[0]->mobile_number : set_value('mobile');
                $preferred_communication_mode = set_value('preferred_communication_mode') == false ? $user[0]->preferred_communication_mode : set_value('preferred_communication_mode');
                ?>
                <form action="<?php echo $this->config->item('base_url'); ?>/index.php/user/profile" method="post" onsubmit="return validation_profile()">

                    <div>

                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="csrftwo" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
                        <?php echo form_label('First Name', 'firstname'); ?>
                        <?php echo form_input('firstname', $firstname, ' id="firstname_pro" class="form-control"'); ?>
                    </div>

                    <div>
                        <?php echo form_label('Last Name', 'lastname'); ?>
                        <?php echo form_input('lastname', $lastname, ' id="lastname_pro" class="form-control"'); ?>
                    </div>

                    <div>
                        <?php echo form_label('Age', 'age'); ?>
                        <?php echo form_input('age', $age, ' id="age_pro" class="form-control"'); ?>
                    </div>
                    <div>
                        <?php
                        $options = array(
                            'female' => 'Female',
                            'male' => 'Male',
                            'other' => 'Don&apos;t want to disclose',
                        );
                        ?>

                        <?php echo form_label('Gender', 'gender'); ?>
                        <?php echo form_dropdown('gender', $options, $gender, 'class="form-control"'); ?>
                    </div>
                    <div>
                        <?php echo form_label('Mobile', 'mobile'); ?>
                        <?php echo form_input('mobile', $mobile, ' id="mobile_pro" class="form-control"'); ?>
                    </div>


                    <div>
                        <label for="preferred_communication_mode">Preferred communication mode</label> <br />
                        Email <input type="radio" value="0" name="preferred_communication_mode" id ="prefered_communication_mode_email" <?php if($preferred_communication_mode == 0) {?> checked="checked" <?php } ?> />
                        &nbsp; &nbsp; SMS <input type="radio" value="1" name="preferred_communication_mode" id ="prefered_communication_mode_sms" <?php if($preferred_communication_mode == 1) {?> checked="checked" <?php } ?>   />
                        &nbsp; &nbsp; Both <input type="radio" value="2" name="preferred_communication_mode" id ="prefered_communication_mode_both"  <?php if($preferred_communication_mode == 2) {?> checked="checked" <?php } ?> /><br />
                    </div>


                    <div style="margin-top: 30px;">
                        <?php echo form_submit('update', 'Update Profile', 'class="btn btn-primary"'); ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--right menu end--> 
</div>
</div>
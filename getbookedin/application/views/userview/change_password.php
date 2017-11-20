   <!--right menu--> 
      
    <div class="col-lg-9 col-md-8 col-sm-8">
      <div class="hs_service">
        <div class="row">
          <div class="col-lg-8 col-md-8 col-sm-8">
            <h4>Change Password</h4>
          </div>
         
        </div>
        <div class="row">
          <div class="col-lg-8 col-md-10 col-sm-12">
          
           <?php
          if(isset($message))
          {
              ?>
               <h4><?php echo $message;?></h4>
              <?php 
          }               ?>
          
          <h5 style="color:red;"> <?php echo validation_errors(); ?></h5>
          
          <form action="<?php echo $this->config->item('base_url'); ?>/index.php/user/change_password" method="post" onsubmit="return validation_profile()">
        
    <div>
    
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="csrftwo" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
        <?php echo form_label('Current Password', 'old_password'); ?>
        <?php echo form_password('old_password','',  'class="form-control"'); ?>
    </div>
    <div>
        <?php echo form_label('New Password', 'new_password'); ?>
        <?php echo form_password('new_password','',  ' class="form-control"'); ?>
    </div>
    
     <div>
        <?php echo form_label('Confirm Passowrd', 'confirm_password'); ?>
        <?php echo form_password('confirm_password', '', ' class="form-control"'); ?>
    </div>
    
  
    <div style="margin-top: 30px;">
        <?php echo form_submit('update', 'Update Password', 'class="btn btn-primary"'); ?>
    </div>
</form>
          
          
          
          
          </div>
        </div>
      </div>
    </div>
      <!--right menu end--> 
</div>
</div>

<div class="container">

    <style type="text/css">
        h2 {
            font-weight: 100;
            margin-bottom: 30px;
            border-bottom: solid thin #c8c8c8;
            padding-bottom: 20px;
        }
        .get_but {
            background-color: #00ac7a;
            color: #eeeeee;
            font-size: 15px;
            font-weight: 800;
            padding: 15px 10px;
        }
        .get_but:hover {
            color: #E6E6E6;
        }
        .app_box {
            text-align: center;
            margin: 10px ;
        }
        p {
            font-size: 16px;
            line-height: 17pt;
        }
    </style>
  
 <div class="row">
     <div class="col-lg-12 col-lg-12 col-lg-12">
         <h2><?php echo $adminuser_header['header_caption']; ?></h2>
     </div>

     <div class="col-lg-7 col-lg-7 col-lg-7">
         <p> <?php echo $adminuser_header['description']; ?></p>
     </div>

     <div class="col-lg-5 col-lg-5 col-lg-5">
         <div class="app_box">
             <p>&nbsp;</p>
             <a class="get_but" href="" data-toggle="modal" data-target="#loginModal">Book Now</a>
         </div>
     </div>
 </div>

    <!--service start-->
 <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="hs_service">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <h4>Step 1</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <p> Register to book your appointments </p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="hs_service">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <h4>Step 2</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <p> Verify your e-mail and/or Mobile no. to get reminder notifications.
                        (if it is not in your inbox, check your junk/spam folder). </p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-4">
        <div class="hs_service">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <h4>Step 3</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <p> Book your appointment for a convenient time, </p>
                </div>
            </div>
        </div>
    </div>
</div>
    <!--service end-->

  <div class="hs_margin_40"></div>

  <div class="clearfix"></div>

  <div class="hs_margin_60"></div>
</div>
</body>
</html>
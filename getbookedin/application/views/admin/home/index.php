<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- favicon links -->
    <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
    <link rel="icon" type="image/ico" href="favicon.ico" />
    <!--Google web fonts-->
    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>

    <!-- main css -->
    <link rel="stylesheet" href="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/css/main.css" media="screen"/>
    <link rel="stylesheet" id="theme-color" type="text/css" href="#"/>

    <!--page title-->
    <title>GetBookedin</title>
    <style type="text/css">
        p {
            font-size: 15px;
            line-height: 24px;
        }
        #hs_header nav {
            border: none;
        }
        .booking {
        background-image: url("<?php echo $this->config->item('base_url'); ?>/assets/adminhome/images/booking.png");
            background-position: -522px 10px;
            background-repeat: no-repeat;
            height: 382px;

        }
        body {
            font-family: "Square Market",Helvetica,Arial,sans-serif;
        }
        h4 {
            font-size: 28px;
            font-weight: 100;
            margin-bottom: 35px;;
        }
        .caption_logo {
            font-size: 28px;
            font-weight: 100;
            color: #ffffff;
        }
        .get_but {
            background-color: #00ac7a;
            color: #EEEEEE;
            font-size: 15px;
            font-weight: 800;
            padding: 15px 10px;
        }
        .get_but:hover {
            color: #ffffff;
        }
        .feature {
            text-align: center;
            background-color: #f8f8f8;
        }
        .feature:hover h4,
        .feature:hover b {
            color: #00ac7a;
        }
        .calendar {
            background-image: url("<?php echo $this->config->item('base_url'); ?>/assets/adminhome/images/calendar.png");
            height: 702px;
            background-repeat: no-repeat;
            background-position: center center;
        }
        .hs_slider_title {
            font-size: 50px;
            font-weight: 100;
        }
        .lead {
            font-size: 25px;
            font-weight: 100;
            text-shadow: none;
        }
    </style>

</head>
<body>
<!--Pre loader start-->
<div id="preloader">
    <div id="status"><img src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/images/loader.gif" id="preloader_image" width="36" height="36" alt="loading image"/></div>
</div>
<!--pre loader end-->

<!--header start-->
<header id="hs_header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 clearfix">
                <div class="col-lg-2 col-md-2 col-sm-12">
                    <div id="hs_logo" > <a href="<?php echo $base_url; ?>/index.php/admin"> <p class="caption_logo">GetBookedIn</p>
<!--                            <img src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/logo.png" alt=""> -->
                        </a> </div>
                    <!-- #logo -->
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4">
<!--                                        <div class="hs_social">-->
<!--                                            <ul>-->
<!--                                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>-->
<!--                                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>-->
<!--                                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>-->
<!--                                                <li><a href="#" id="hs_search"><i class="fa fa-search"></i></a></li>-->
<!--                                            </ul>-->
<!--                                        </div>-->
<!--                                        <div class="hs_search_box">-->
<!--                                            <form class="form-inline" role="form">-->
<!--                                                <div class="form-group has-success has-feedback">-->
<!--                                                    <input type="text" class="form-control" id="inputSuccess4" placeholder="Search">-->
<!--                                                    <span class="glyphicon glyphicon-search form-control-feedback"></span> </div>-->
<!--                                            </form>-->
<!--                                        </div>-->

                    <!-- #logo -->
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <button type="button" class="hs_nav_toggle navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">Menu<i class="fa fa-bars"></i></button>
                    <nav>
                        <ul class="hs_menu collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<!--                            <li><a class="active">Home</a>-->
<!--                                <ul>-->
<!--                                    <li><a href="index1.html">home 1</a></li>-->
<!--                                    <li><a href="one-page.html">One Page</a></li>-->
<!--                                </ul>-->
<!--                            </li>-->
                            <li><a href="<?php echo $base_url; ?>/index.php/admin" >Home</a></li>
                            <li><a href="<?php echo $base_url; ?>/index.php/admin/login" >login</a></li>
                            <li><a href="<?php echo $base_url; ?>/index.php/admin/registration" >Register</a></li>
                            <li><a href="#">&nbsp;</a></li>
                            <li><a href="#">&nbsp;</a></li>
<!--                            <li><a>services</a>-->
<!--                                <ul>-->
<!--                                    <li><a href="services.html">Pediatric Clinic</a></li>-->
<!--                                    <li><a href="services.html">Dental Clinic</a></li>-->
<!--                                    <li><a href="services.html">General Surgery</a></li>-->
<!--                                    <li><a href="services.html">Physiotherapy</a></li>-->
<!--                                    <li><a href="services.html">Pregnancy Care</a></li>-->
<!--                                </ul>-->
<!--                            </li>-->
<!--                            <li><a>pages</a>-->
<!--                                <ul>-->
<!--                                    <li><a>Blog</a>-->
<!--                                        <ul>-->
<!--                                            <li><a href="blog-categories.html">Blog Categories</a></li>-->
<!--                                            <li><a href="blog-single-post.html">Blog Single Post</a></li>-->
<!--                                            <li><a href="blog-single-post-leftsidebar.html">Blog Leftsidebar</a></li>-->
<!--                                            <li><a href="blog-single-post-rightsidebar.html">Blog Rightsidebar</a></li>-->
<!--                                        </ul>-->
<!--                                    </li>-->
<!--                                    <li><a>services</a>-->
<!--                                        <ul>-->
<!--                                            <li><a href="services-two-column.html">services Two Column</a></li>-->
<!--                                            <li><a href="services.html">services Three Column</a></li>-->
<!--                                            <li><a href="services-four-column.html">services Four Column</a></li>-->
<!--                                        </ul>-->
<!--                                    </li>-->
<!--                                    <li><a>profile</a>-->
<!--                                        <ul>-->
<!--                                            <li><a href="profile-single.html">profile single</a></li>-->
<!--                                        </ul>-->
<!--                                    </li>-->
<!--                                    <li><a href="elements.html">Elements</a></li>-->
<!--                                    <li><a href="typography.html">Typography</a></li>-->
<!--                                    <li><a href="columns.html">columns</a></li>-->
<!--                                    <li><a href="icon.html">icon</a></li>-->
<!--                                </ul>-->
<!--                            </li>-->
<!--                            <li><a href="profile.html">our profile</a></li>-->
<!--                            <li><a href="blog-categories.html">our blog</a></li>-->
<!--                            <li><a href="contact.html">Contact</a></li>-->
                        </ul>
                    </nav>
                </div>

            </div>
            <!-- .col-md-12 -->
        </div>
        <!-- .row -->
    </div>
    <!-- .container -->

</header>
<!--header end-->
<!--slider start-->
<div id="carousel-example-generic" class="carousel slide carousel-fade" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <div class="item active"> <img class="animated fadeInDown" src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/images/slider/slider1.jpg" alt="...">
            <div class="carousel-caption">
                <h1 class="hs_slider_title animated bounceInDown">TAKE APPOINTMENTS ANYTIME.</h1>
                <p class="lead animated pulse">IT's Easy, IT's Secure, IT'S Fast.</p>
<!--                <a href="#hs_meat_doc" class="btn btn-default hs_slider_button animated fadeInLeftBig">More Info</a> <a href="#" class="btn btn-success animated fadeInRightBig">Download</a> -->
            </div>
        </div>
        <div class="item"> <img class="animated fadeInDown" src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/images/slider/slider2.jpg" alt="...">
            <div class="carousel-caption">
                <h1 class="hs_slider_title animated bounceInDown">Customers can book online 24/7.</h1>
                <p class="lead animated pulse">customers can always access your availability and book their appointment online.</p>
<!--                <a href="#hs_appointment_form_link" class="btn btn-default hs_slider_button animated fadeInLeftBig">More Info</a> <a href="#" class="btn btn-success animated fadeInRightBig">Download</a> -->
            </div>
        </div>
    </div>
</div>
<!--layer slider ends-->

<!--slider end-->

<div class="container">
    <!--service start-->
    <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-5">
            <div class="hs_service">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="booking"></div>

<!--                        <img class="booking" src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/booking.png">-->
<!--                        <p>Quisque vitae interdum ipsum. Nulla eget mper nulla. </p>-->
<!--                        <p>Quisque vitae interdum ipsum.</p>-->
<!--                        <p>Nulla eget mper nulla. Proin lacinia urna quis tortor </p>-->
<!--                        <p>Quisque vitae interdum ipsum. Nulla eget mper nulla. Proin lacinia </p>-->
<!--                        <p>Quisque vitae interdum ipsum. Nulla eget mper nulla.  </p>-->
<!--                        <p>Quisque vitae interdum ipsum.</p>-->
<!--                        <p>Nulla eget mper nulla. Proin lacinia urna quis tortor </p>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-7">
            <div class="hs_service">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <h4>Appointment booking</h4>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4" style="text-align:center;"> </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <p>The ability to manage and fill your appointment book is critical to your business. With us, customers new and old can book an appointment with you whenever they want.
                            No more lost customer opportunities because of missed phone calls or emails. Your clients can also cancel or reschedule, all on their own.
                            Rest of all, allowing customers to book their own appointments allows you to cost-effectively grow your customer base.</p>
                            <p>Your clients can also cancel or reschedule, all on their own.
                            est of all, allowing customers to book their own appointments allows you to cost-effectively grow your customer base. </p>
                        <br><br>
                        <a href="<?php echo $base_url; ?>/index.php/admin/login" class="get_but">Get start Now</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--service end-->
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="feature">
                <div class="row">
                    <div class="col-lg-1 col-md-1 col-sm-1"></div>
                    <div class="col-lg-10 col-md-10 col-sm-10">
                        <h4>Flexible, customizable, and keeps you ahead of<br> schedule.</h4>

                        <p>Adjust your availability, confirm appointments, and customize your account as your business grows. From calendar syncing to you Google calendar it makes more easier.</p>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-1"></div>
                </div>
            </div>



            <div class="feature">
            <div class="row">
<!--                <div class="col-lg-1 col-md-1 col-sm-1"></div>-->
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div style="text-align: left;">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <p><b>Works with your calendar</b></p>
                                <p>All appointment scheduling syncs with your Google Calendar automatically, so your availability is always up to date. Out and about? See your schedule at a glance from any device.</p>

                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <p><b>Know when you’re booked</b></p>
                                <p>Receive notifications via email or text. When you confirm appointments, your schedule automatically fills up—like a calendar that pencils it all in for you.</p>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">

                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">

                            </div>
                        </div>
                    </div>
                    <div class="calendar"></div>
<!--                    <img src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/calendar.png" />-->
                </div>
<!--                <div class="col-lg-1 col-md-1 col-sm-1"></div>-->
            </div>
            </div>
        </div>
    </div>

<!--    <div class="row">-->
        <!--what we do start-->
<!--        <div class="col-lg-6 col-md-7 col-sm-12">-->
<!--            <h4 class="hs_heading">What we do</h4>-->
<!--            <div class="hs_tab">-->
<!--                <ul id="myTab" class="nav nav-tabs">-->
<!--                    <li class="active"><a href="#services1" data-toggle="tab">services # 1</a></li>-->
<!--                    <li><a href="#services2" data-toggle="tab">services # 2</a></li>-->
<!--                    <li><a href="#services3" data-toggle="tab">services # 3</a></li>-->
<!--                </ul>-->
<!--                <div id="myTabContent" class="tab-content">-->
<!--                    <div class="tab-pane fade in active" id="services1">-->
<!--                        <div class="row">-->
<!--                            <div class="col-lg-12 col-md-12 col-sm-12">-->
<!--                                <div class="col-lg-6 col-md-6 col-sm-6"> <img width="228" height="252" src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/service/1.jpg" alt="" /> </div>-->
<!--                                <div class="col-lg-6 col-md-6 col-sm-6">-->
<!--                                    <h4 class="hs_theme_color">Morbi id pulvinar enim. Vestibulum sed .</h4>-->
<!--                                    <div class="hs_margin_30"></div>-->
<!--                                    <p>Cras velit ligula, sodaleut enim quis, venenatis feugiat ante. lus facilisis nisl. Praesent aliquet</p>-->
<!--                                    <p>sollicitudin leo, eu oare nibh sodales et. Vestibulum blandit,eu oare nibh sodales et. </p>-->
<!--                                    <div class="hs_margin_30"></div>-->
<!--                                    <a href="blog-single-post-rightsidebar.html" class="btn btn-default">Read More</a> </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="tab-pane fade" id="services2">-->
<!--                        <div class="row">-->
<!--                            <div class="col-lg-12 col-md-12 col-sm-12">-->
<!--                                <div class="col-lg-6 col-md-6 col-sm-6">-->
<!--                                    <h4 class="hs_theme_color">Morbi id pulvinar enim. Vestibulum sed .</h4>-->
<!--                                    <div class="hs_margin_30"></div>-->
<!--                                    <p>Cras velit ligula, sodaleut enim quis, venenatis feugiat ante. lus facilisis nisl. Praesent aliquet</p>-->
<!--                                    <p>sollicitudin leo, eu oare nibh sodales et. Vestibulum blandit,eu oare nibh sodales et. </p>-->
<!--                                    <div class="hs_margin_30"></div>-->
<!--                                    <a href="blog-single-post-rightsidebar.html" class="btn btn-default">Read More</a> </div>-->
<!--                                <div class="col-lg-6 col-md-6 col-sm-6"> <img width="228" height="252" src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/service/1.jpg" alt="" /> </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="tab-pane fade" id="services3">-->
<!--                        <div class="row">-->
<!--                            <div class="col-lg-12 col-md-12 col-sm-12"> <img width="515" height="252" src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/service/2.jpg" alt="" />-->
<!--                                <h4 class="hs_theme_color">Morbi id pulvinar enim. Vestibulum sed .</h4>-->
<!--                                <p>Cras velit ligula, sodaleut enim quis, venenatis feugiat ante. lus facilisis nisl. Praesent aliquet</p>-->
<!--                                <p>sollicitudin leo, eu oare nibh sodales et. Vestibulum blandit, </p>-->
<!--                                <a href="blog-single-post-rightsidebar.html" class="btn btn-default">Read More</a> </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
        <!--what we do end-->
        <!--Book an Appointment start-->
<!--        <div class="col-lg-6 col-md-5 col-sm-12">-->
<!--            <h4 class="hs_heading" id="hs_appointment_form_link">Book an Appointment</h4>-->
<!--            <div class="hs_appointment_form_div"> <img src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/bg/appointment_form.jpg" width="512" height="365" alt=""/>-->
<!--                <div class="hs_appointment_form">-->
<!--                    <form method="post">-->
<!--                        <div class="row">-->
<!--                            <div class="col-lg-6 col-md-7 col-sm-6">-->
<!--                                <div class="form-group">-->
<!--                                    <select class="form-control" id="slider_select_dep" name="select_dep">-->
<!--                                        <option>Select Department</option>-->
<!--                                        <option value="Department 1">Department 1</option>-->
<!--                                        <option value="Department 2">Department 2</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                                <div class="form-group">-->
<!--                                    <input type="text" class="form-control" id="slider_fname" name="fname" placeholder="full Name  ( required )" required>-->
<!--                                </div>-->
<!--                                <div class="form-group">-->
<!--                                    <input type="text" id="slider_phone" name="phone" class="form-control"  placeholder="Phone (required)" required>-->
<!--                                </div>-->
<!--                                <div class="form-group">-->
<!--                                    <input type="email" id="slider_email" name="email" class="form-control"  placeholder="Email (required)" required>-->
<!--                                </div>-->
<!--                                <div class="form-group">-->
<!--                                    <input type="date" id="slider_date" name="date" class="form-control">-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="row">-->
<!--                            <div class="col-lg-3 col-md-4 col-sm-3">-->
<!--                                <button type="button" id="slider_book_apo" class="btn btn-default">Submit</button>-->
<!--                            </div>-->
<!--                            <div class="col-lg-8 col-md-8 col-sm-8">-->
<!--                                <p>Aenean facilisis sodales est nec gravida. Morbi vitae purus non est facilisis.</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <p id="appointment_err"></p>-->
<!--                    </form>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
        <!--Book an Appointment end-->
<!--    </div>-->

    <!--Up Coming Events start-->
<!--    <div class="row">-->
<!--        <div class="col-lg-12 col-md-12 col-sm-12">-->
<!--            <h4 class="hs_heading">Up Coming Events</h4>-->
<!--            <div class="up_coming_events">-->
<!--                <div id="up_coming_events_slider" class="owl-carousel owl-theme">-->
<!--                    <div class="up_coming_events_slider_item">-->
<!--                        <div class="row">-->
<!--                            <div class="col-lg-12 col-md-12 col-sm-12">-->
<!--                                <div class="hs_event_date">-->
<!--                                    <h3>14</h3>-->
<!--                                    <p>Feb</p>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="hs_event_div">-->
<!--                            <div class="row">-->
<!--                                <div class="col-lg-12 col-md-12 col-sm-12">-->
<!--                                    <div class="col-lg-6 col-md-5 col-sm-6"> <img src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/event/up_comming_event1.jpg" alt="" /> </div>-->
<!--                                    <div class="col-lg-6 col-md-7 col-sm-12">-->
<!--                                        <h4>Pelln sque vitae dolor non.</h4>-->
<!--                                        <p>Cras sodaleut ligula, velit enim quis, neatis feugiat ante. Ut arcu nulla.Cras velit ligula, sodaleut enim quis, venenatis feugiat ante. lus facilisis nisl. </p>-->
<!--                                        <a href="blog-single-post-rightsidebar.html" class="btn btn-default pull-right">Read More</a> </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="up_coming_events_slider_item">-->
<!--                        <div class="row">-->
<!--                            <div class="col-lg-12">-->
<!--                                <div class="hs_event_date">-->
<!--                                    <h3>23</h3>-->
<!--                                    <p>Feb</p>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="hs_event_div">-->
<!--                            <div class="row">-->
<!--                                <div class="col-lg-12 col-md-12 col-sm-12">-->
<!--                                    <div class="col-lg-6 col-md-5 col-sm-6"> <img src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/event/up_comming_event2.jpg" alt="" /> </div>-->
<!--                                    <div class="col-lg-6 col-md-7 col-sm-12">-->
<!--                                        <h4>Pelln sque vitae dolor non.</h4>-->
<!--                                        <p>Cras sodaleut ligula, velit enim quis, neatis feugiat ante. Ut arcu nulla.Cras velit ligula, sodaleut enim quis, venenatis feugiat ante. lus facilisis nisl. </p>-->
<!--                                        <a href="blog-single-post-rightsidebar.html" class="btn btn-default pull-right">Read More</a> </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="up_coming_events_slider_item">-->
<!--                        <div class="row">-->
<!--                            <div class="col-lg-12 col-md-12 col-sm-12">-->
<!--                                <div class="hs_event_date">-->
<!--                                    <h3>24</h3>-->
<!--                                    <p>Feb</p>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="hs_event_div">-->
<!--                            <div class="row">-->
<!--                                <div class="col-lg-12 col-md-12 col-sm-12">-->
<!--                                    <div class="col-lg-6 col-md-5 col-sm-6"> <img src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/event/up_comming_event3.jpg" alt="" /> </div>-->
<!--                                    <div class="col-lg-6 col-md-7 col-sm-12">-->
<!--                                        <h4>Pelln sque vitae dolor non.</h4>-->
<!--                                        <p>Cras sodaleut ligula, velit enim quis, neatis feugiat ante. Ut arcu nulla.Cras velit ligula, sodaleut enim quis, venenatis feugiat ante. lus facilisis nisl. </p>-->
<!--                                        <a href="blog-single-post-rightsidebar.html" class="btn btn-default pull-right">Read More</a> </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="up_coming_events_slider_item">-->
<!--                        <div class="row">-->
<!--                            <div class="col-lg-12 col-md-12 col-sm-12">-->
<!--                                <div class="hs_event_date">-->
<!--                                    <h3>14</h3>-->
<!--                                    <p>Feb</p>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="hs_event_div">-->
<!--                            <div class="row">-->
<!--                                <div class="col-lg-12 col-md-12 col-sm-12">-->
<!--                                    <div class="col-lg-6 col-md-5 col-sm-6"> <img src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/event/up_comming_event1.jpg" alt="" /> </div>-->
<!--                                    <div class="col-lg-6 col-md-7 col-sm-12">-->
<!--                                        <h4>Pelln sque vitae dolor non.</h4>-->
<!--                                        <p>Cras sodaleut ligula, velit enim quis, neatis feugiat ante. Ut arcu nulla.Cras velit ligula, sodaleut enim quis, venenatis feugiat ante. lus facilisis nisl. </p>-->
<!--                                        <a href="blog-single-post-rightsidebar.html" class="btn btn-default pull-right">Read More</a> </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="customNavigation text-right"> <a class="btn_prev prev"><i class="fa fa-chevron-left"></i></a> <a class="btn_next next"><i class="fa fa-chevron-right"></i></a> </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <!--Up Coming Events end-->
    <div class="hs_margin_40"></div>

    <!--Our Doctor Team start-->
<!--    <div class="row">-->
<!--        <div class="col-lg-12 col-md-12 col-sm-12">-->
<!--            <h4 class="hs_heading" id="hs_meat_doc">Our Doctor Team</h4>-->
<!--            <div class="our_doctor_team">-->
<!--                <div id="our_doctor_team_slider" class="owl-carousel owl-theme">-->
<!--                    <div class="our_doctor_team_slider_item"> <img src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/team/team_member1.png" alt="" />-->
<!--                        <div class="hs_team_member_detail">-->
<!--                            <h3>Dr Johnathan Treat</h3>-->
<!--                            <p>Quisque vitae interdum ipsum. Nulla eget mpernulla. Proin lacinia urna </p>-->
<!--                            <a href="profile-single.html" class="btn btn-default">Read More</a> </div>-->
<!--                    </div>-->
<!--                    <div class="our_doctor_team_slider_item"> <img src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/team/team_member2.png" alt="" />-->
<!--                        <div class="hs_team_member_detail">-->
<!--                            <h3>Dr. Edwin Spindrift</h3>-->
<!--                            <p>Quisque vitae interdum ipsum. Nulla eget mpernulla. Proin lacinia urna </p>-->
<!--                            <a href="profile-single.html" class="btn btn-default">Read More</a> </div>-->
<!--                    </div>-->
<!--                    <div class="our_doctor_team_slider_item"> <img src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/team/team_member3.png" alt="" />-->
<!--                        <div class="hs_team_member_detail">-->
<!--                            <h3>Dr Johnathan Treat</h3>-->
<!--                            <p>Quisque vitae interdum ipsum. Nulla eget mpernulla. Proin lacinia urna </p>-->
<!--                            <a href="profile-single.html" class="btn btn-default">Read More</a> </div>-->
<!--                    </div>-->
<!--                    <div class="our_doctor_team_slider_item"> <img src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/team/team_member1.png" alt="" />-->
<!--                        <div class="hs_team_member_detail">-->
<!--                            <h3>Dr. Edwin Spindrift</h3>-->
<!--                            <p>Quisque vitae interdum ipsum. Nulla eget mpernulla. Proin lacinia urna </p>-->
<!--                            <a href="profile-single.html" class="btn btn-default">Read More</a> </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="customNavigation text-right"> <a class="btn_prev prev"><i class="fa fa-chevron-left"></i></a> <a class="btn_next next"><i class="fa fa-chevron-right"></i></a> </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <!--Our Doctor Team end-->
    <div class="clearfix"></div>

    <!--Meet Our Partners start-->
<!--    <div class="row">-->
<!--        <div class="col-lg-12 col-md-12 col-sm-12">-->
<!--            <h4 class="hs_heading">Meet Our Partners</h4>-->
<!--            <div class="our_partners">-->
<!--                <div id="our_partners_slider" class="owl-carousel owl-theme">-->
<!--                    <div class="our_partners_slider_item"> <img src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/partner/partner1.png" alt="" width="142" height="40"  /> </div>-->
<!--                    <div class="our_partners_slider_item"> <img src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/partner/partner2.png" alt="" width="142" height="40"  /> </div>-->
<!--                    <div class="our_partners_slider_item"> <img src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/partner/partner3.png" alt="" width="142" height="40"  /> </div>-->
<!--                    <div class="our_partners_slider_item"> <img src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/partner/partner4.png" alt="" width="142" height="40"  /> </div>-->
<!--                    <div class="our_partners_slider_item"> <img src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/partner/partner1.png" alt="" width="142" height="40"  /> </div>-->
<!--                </div>-->
<!--                <div class="customNavigation text-right"> <a class="btn_prev prev"><i class="fa fa-chevron-left"></i></a> <a class="btn_next next"><i class="fa fa-chevron-right"></i></a> </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <!--Meet Our Partners end-->
    <div class="hs_margin_60"></div>
</div>
<!--<footer id="hs_footer">-->
<!--    <div class="container">-->
<!--        <div class="hs_footer_content">-->
<!--            <div class="row">-->
<!--                <div class="col-lg-12">-->
<!--                    <div class="hs_footer_menu">-->
<!--                        <ul>-->
<!--                            <li><a href="index-2.html">Home</a></li>-->
<!--                            <li><a href="about.html">About</a></li>-->
<!--                            <li><a href="services.html">Services</a></li>-->
<!--                            <li><a href="blog-categories.html">Blog</a></li>-->
<!--                            <li><a href="profile.html">Our profile</a></li>-->
<!--                            <li><a href="contact.html">Contact</a></li>-->
<!--                        </ul>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="row">-->
<!--                <div class="col-lg-12 col-md-12 col-sm-12">-->
<!--                    <div class="row">-->
<!--                        <div class="hs_footer_about_us">-->
<!--                            <div class="col-lg-3 col-md-4 col-sm-12 col-md-12 col-sm-12">-->
<!--                                <h4 class="hs_heading">About Us</h4>-->
<!--                                <a href="index-2.html"><img src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/logo.png" alt="logo" width="180" height="41" /></a> </div>-->
<!--                            <div class="col-lg-9 col-md-8 col-sm-12 hs_about_us">-->
<!--                                <div class="hs_margin_60"></div>-->
<!--                                <p>Aenean facilisis sodales est neciMorbi vitapurus on Est facilisisro convallis commodo velante, tiam ltricies lputate.Aenean facilisis sodales est neciMorbi vitapurus on Est facilisisro convallis commodo velante, tiam ltricies lputate. </p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="row">-->
<!--                        <div class="col-lg-4 col-md-3 col-sm-12">-->
<!--                            <h4 class="hs_heading">Get in touch !</h4>-->
<!--                            <div class="hs_contact_detail">-->
<!--                                <p><i class="fa fa-map-marker"></i> 13/2 Elizabeth Street Melbourne VIC 3000, Australia</p>-->
<!--                                <p><i class="fa fa-mobile-phone"></i> +61 3 8376 6284</p>-->
<!--                                <div class="clearfix"></div>-->
<!--                                <div class="hs_social">-->
<!--                                    <ul>-->
<!--                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>-->
<!--                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>-->
<!--                                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>-->
<!--                                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>-->
<!--                                    </ul>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-lg-8 col-md-9 col-sm-12">-->
<!--                            <h4 class="hs_heading">About Us</h4>-->
<!--                            <div class="row">-->
<!--                                <a href="index-2.html"><img src="--><?php //echo $this->config->item('base_url'); ?><!--/assets/adminhome/images/logo.png" alt="logo" width="180" height="41" /></a>-->
<!--                                <p style="margin-top: 20px;">Aenean facilisis sodales est neciMorbi vitapurus on Est facilisisro convallis commodo velante, tiam ltricies lputate.Aenean facilisis sodales est neciMorbi vitapurus on Est facilisisro convallis commodo velante, tiam ltricies lputate. </p>-->

                                <!--                        <div class="col-lg-12 col-md-12 col-sm-12 hs_twitter_widget">-->
                                <!---->
                                <!---->
                                <!--                            <ul>-->
                                <!--                                <li>  <div class="hs_margin_60 hs_about_us"></div>-->
                                <!--                                     </li>-->
                                <!--                            </ul>-->
                                <!--                        </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-lg-8 col-md-9 col-sm-12">-->
<!--                            <h4 class="hs_heading">Useful Links</h4>-->
<!--                            <div class="clearfix"></div>-->
<!--                            <div class="hs_footer_link">-->
<!--                                <ul>-->
<!--                                    <li><a href="services.html">Pediatric Clinic</a></li>-->
<!--                                    <li><a href="services.html">Dental Clinic</a></li>-->
<!--                                    <li><a href="services.html">General Surgery</a></li>-->
<!--                                    <li><a href="services.html">Physiotherapy</a></li>-->
<!--                                    <li><a href="services.html">Ltricies lputate</a></li>-->
<!--                                </ul>-->
<!--                            </div>-->
<!--                            <div class="hs_footer_link">-->
<!--                                <ul>-->
<!--                                    <li><a href="blog-categories.html">Blog Categories</a></li>-->
<!--                                    <li><a href="services-two-column.html">services Two Column</a></li>-->
<!--                                    <li><a href="blog-single-post.html">Blog Single Post</a></li>-->
<!--                                    <li><a href="services.html">services Three Column</a></li>-->
<!--                                    <li><a href="blog-single-post-leftsidebar.html">Blog Leftsidebar</a></li>-->
<!--                                </ul>-->
<!--                            </div>-->
<!--                            <div class="hs_footer_link">-->
<!--                                <ul>-->
<!--                                    <li><a href="blog-single-post-rightsidebar.html">Blog Rightsidebar</a></li>-->
<!--                                    <li><a href="typography.html">Typography</a></li>-->
<!--                                    <li><a href="elements.html">Elements</a></li>-->
<!--                                    <li><a href="columns.html">columns</a></li>-->
<!--                                    <li><a href="icon.html">icon</a></li>-->
<!--                                </ul>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</footer>-->
<div class="hs_copyright"></div>
<!--main js file start-->
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/js/owl.carousel.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/js/jquery.bxslider.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/js/jquery.mixitup.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/js/smoothscroll.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/js/single-0.1.0.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>/assets/adminhome/js/custom.js"></script>
<!--main js file end-->
</body>

</html>
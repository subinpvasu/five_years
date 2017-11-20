<?php	 	

$themename  = "Vulcan";
$shortname  = "vulcan";

$display_options = array("pages","posts");
$categories_list = get_categories('hide_empty=0');

$categories = array();
foreach ($categories_list as $catlist) {
	$categories[$catlist->cat_ID] = $catlist->cat_name;
}

$listpages = array();
$pagelist = get_pages();
foreach ($pagelist as $plist ) {
  $listpages[$plist->ID] = $plist->post_title;
}

$num_options = array("3","4","5","6","7","8","9","10");
 
/* Get Cufon fonts into a drop-down list */
$cufonts = array();
if(is_dir(TEMPLATEPATH . "/js/fonts/")) {
	if($open_dirs = opendir(TEMPLATEPATH . "/js/fonts")) {
		while(($cufontfonts = readdir($open_dirs)) !== false) {
			if(stristr($cufontfonts, ".js") !== false) {
				$cufonts[] = $cufontfonts;
			}
		}
	}
}
$cufonts_dropdown = $cufonts;

/* Get Stylesheets into a drop-down list */
$styles = array();
if(is_dir(TEMPLATEPATH . "/css/styles/")) {
	if($open_dirs = opendir(TEMPLATEPATH . "/css/styles/")) {
		while(($style = readdir($open_dirs)) !== false) {
			if(stristr($style, ".css") !== false) {
				$styles[] = $style;
			}
		}
	}
}
$style_dropdown = $styles;

$bgoptions = array("clean","dot","line");

$options = array (
  array(	"type" => "open"),
  array(	"name" => "General Settings",
		    "type" => "heading"),
  array(  "name" => "Custom Logo Image URL",
        "desc" => "Use this if you want to change Logo Image, recommended 134x46 pixel",
        "id" => $shortname."_logo",
        "std" => "",
        "type" => "text"),
  array(	"name" => "Color Scheme",
  					"desc" => "Choose a color scheme, Default is white.",
  					"id" => $shortname."_style",
      			"std" => "",
      			"type" => "select",
      			"options" => $styles),
  array(	"name" => "Cufon Fonts",
  					"desc" => "Please select fonts below as your default Cufon font for Text Heading Replacement.",
  					"id" => $shortname."_cufon_fonts",
      			"std" => "",
      			"type" => "select",
      			"options" => $cufonts_dropdown),      			
  array(  "name" => "Excluded pages from menu.",
        			"desc" => "The Selected pages will will not show up in the menu.<br /> If you exclude a page with sub pages both will be excluded from the menu. ",
        			"id" => $shortname."_excludeinclude_pages",
        			"std" => "",
        			"desc" => "Please select the pages that you want to exclude from  navigation.",
        			"type" => "checkbox_multiple",
        			"options" => $listpages),
  array(	"name" => "About page",
          "desc" => "Please select your About page.",
            "id" => $shortname."_about_pid",
            "std" => "",
            "type" => "select",
            "options" => $listpages),
  array(	"name" => "Services page",
          "desc" => "Please select your Services page.",
            "id" => $shortname."_services_pid",
            "std" => "",
            "type" => "select",
            "options" => $listpages),
  array(	"name" => "Contact page",
          "desc" => "Please select your Contact page.",
            "id" => $shortname."_contact_pid",
            "std" => "",
            "type" => "select",
            "options" => $listpages),
  array(	"name" => "Testimonial Category",
          "desc" => "Please select your Testimonial category.",
            "id" => $shortname."_testimonial_cid",
            "std" => "",
            "type" => "select",
            "options" => $categories),    
  array(	"name" => "Client Category",
          "desc" => "Please select your category for Client .",
            "id" => $shortname."_client_cid",
            "std" => "",
            "type" => "select",
            "options" => $categories),
  array(	"name" => "Team Category",
          "desc" => "Please select your category for Team/Staff.",
            "id" => $shortname."_team_cid",
            "std" => "",
            "type" => "select",
            "options" => $categories),       
  array(	"name" => "Display Team / Staff List",
          "desc" => "pleae check this option if you want to add Team Category (Staff List) in about page.",
            "id" => $shortname."_enable_team",
            "std" => "",
            "type" => "checkbox"),  
  array(	"name" => "Slideshow speed",
          "desc" => "Enter Your slideshow speed milliseconds, eg. 6000",
            "id" => $shortname."_slideshowspeed",
            "std" => "",
            "type" => "text"),           
  array(	"name" => "Google Analytics",
          "desc" => "Enter Your google analytics code here.",
            "id" => $shortname."_ga_code",
            "std" => "",
            "type" => "textarea"),               
  array(	"name" => "404 Page Message",
          "desc" => "Enter Your Message for 404 pages (Not Found).",
            "id" => $shortname."_404_text",
            "std" => "",
            "type" => "textarea"),                                              
  array(	"name" => "Footer Logo",
          "desc" => "Enter Your image logo url for footer here, recommended size 132x48 pixel.",
            "id" => $shortname."_footer_logo",
            "std" => "",
            "type" => "text"),                                  
  array(	"name" => "Footer text ",
          "desc" => "Enter Your Website Copyright Here.",
            "id" => $shortname."_footer_text",
            "std" => "",
            "type" => "textarea"),                  
  array(	"type" => "close"),
  array(	"type" => "open"),
  array(	"name" => "Homepage Setting",
					"type" => "heading"), 
	array(	"name" => "Your Site Slogan",
			"desc" => "Enter your <strong>Site Slogan</strong> here (will be displayed below slideshow)",
            "id" => $shortname."_site_slogan",
			     "std" => "",            
            "type" => "textarea"), 
	array(	"name" => "Get in Touch Link",
			"desc" => "please enter the url destinaton for Get in Touch button.",
            "id" => $shortname."_getintouch_btn",
            "type" => "text"),                      
  array(	"name" => "Homepage Box Section #1",
					"type" => "heading"),			                        	
	array(	"name" => "Title",
			"desc" => "Title for Homepage Box #1.",
            "id" => $shortname."_homebox_title1",
            "type" => "text"),
	array(	"name" => "Description",
			"desc" => "Description for Homepage Box #1",
            "id" => $shortname."_homebox_desc1",
            "type" => "textarea"),
	array(	"name" => "Image Url",
			"desc" => "Image for Homepage Section #1, image will dynamically resize to fit the box size.",
            "id" => $shortname."_homebox_image1",
            "type" => "text"),  
	array(	"name" => "Destination Url",
			"desc" => "please enter the url destinaton from homepage box #1 will be linked to.",
            "id" => $shortname."_homebox_desturl1",
            "type" => "text"),                                      
  array(	"name" => "Homepage Box Section #2",
					"type" => "heading"),			                        	
	array(	"name" => "Title",
			"desc" => "Title.",
            "id" => $shortname."_homebox_title2",
            "type" => "text"),
	array(	"name" => "Description",
			"desc" => "Description for Homepage Box #2.",
            "id" => $shortname."_homebox_desc2",
            "type" => "textarea"),
	array(	"name" => "Image Url",
			"desc" => "Image for Homepage Section #2, image will dynamically resize to fit the box size.",
            "id" => $shortname."_homebox_image2",
            "type" => "text"),               
	array(	"name" => "Destination Url",
			"desc" => "please enter the url destinaton from homepage box #2 will be linked to.",
            "id" => $shortname."_homebox_desturl2",
            "type" => "text"),                                
  array(	"name" => "Homepage Box Section #3",
					"type" => "heading"),			                        	
	array(	"name" => "Title",
			"desc" => "Title for Homepage Box #3.",
            "id" => $shortname."_homebox_title3",
            "type" => "text"),
	array(	"name" => "Description",
			"desc" => "Description for Homepage Box #3.",
            "id" => $shortname."_homebox_desc3",
            "type" => "textarea"),
	array(	"name" => "Image Url",
			"desc" => "Image for Homepage Section #3, image will dynamically resize to fit the box size.",
            "id" => $shortname."_homebox_image3",
            "type" => "text"),    
	array(	"name" => "Destination Url",
			"desc" => "please enter the url destinaton from homepage box #3 will be linked to.",
            "id" => $shortname."_homebox_desturl3",
            "type" => "text"),                                  
  array(	"name" => "Welcome Title & Short Site Description",
					"type" => "heading"),	                    
	array(	"name" => "Welcome Title",
			"desc" => "Enter Your Welcome title here.",
            "id" => $shortname."_welcome_title",
            "type" => "text"),            
	array(	"name" => "Website Description, will be displayed below 3 columns box",
			"desc" => "Enter your <strong>Site Description</strong> here",
			     "std" => "",
            "id" => $shortname."_site_desc",
            "type" => "textarea"),                     
  array(	"type" => "close"),
  array(	"type" => "open"),
  array(	"name" => "Blog Settings",
			"type" => "heading"),			
  array(	"name" => "Blog Category ID",
          "desc" => "Please select the categories that you want to displayed in blog page",
            "id" => $shortname."_blog_cats_include",
            "std" => "",
        			"type" => "checkbox_multiple",
        			"options" => $categories),
	array(	"name" => "Number of posts to display in Blog Page",
			"desc" => "Select the number of post to display in Blog Page.",
			"id" => $shortname."_blog_num",
			"std" => "",
			"type" => "text"),
	array(	"name" => "Number of Words",
			"desc" => "Enter the number of words for Blog Excerpt.",
            "id" => $shortname."_blogtext",
            "type" => "text"),
	array(	"name" => "Read More text",
			"desc" => "Enter the text for read more (eg : Read More, Continue Reading).",
            "id" => $shortname."_readmoretext",
            "type" => "text"),
  array(	"name" => "Disable Author Box in single post?",
    "desc" => "check this option if you want to disable Author Box in Single Post",
    "id" => $shortname."_disable_authorbox",
    "std" => "false",
    "type" => "checkbox"),                              
  array(	"type" => "close"),
    array(	"type" => "open"),
   array(	"name" => "Portfolio Settings",
			"type" => "heading"),
	array(	"name" => "Portfolio Page Heading",
			"desc" => "Enter the text Heading for Portfolio page.",
            "id" => $shortname."_porto_heading",
            "type" => "text"),              
	array(	"name" => "Portfolio Page Description",
			"desc" => "Will be displayed in Portfolio page content.",
            "id" => $shortname."_porto_text",
            "std" => "",
            "type" => "textarea"),
	array(	"name" => "Number of Words",
			"desc" => "Enter the number of words for Portfolio Post Excerpt.",
            "id" => $shortname."_portfoliotext",
            "type" => "text"),                
	array(	"name" => "Number of posts per page to display in Portfolio Page",
			"desc" => "Fill the number of post to display in Portfolio Page alternative.",
			"id" => $shortname."_porto_num",
			"std" => "",
			"type" => "text"),    
  array(	"name" => "Display Portfolio items as two columns?",
          "desc" => "please check this option if you want to display your portfolio itesm in two columns.",
            "id" => $shortname."_portfolio_2col",
            "std" => "",
            "type" => "checkbox"),  			
    array(	"type" => "close"),  
    array(	"type" => "open"),
	array(	"name" => "Contact Information Settings",
			"type" => "heading"),
	array(	"name" => "Address",
			"desc" => "Please enter your office address here.",
			"id" => $shortname."_info_address",
			"type" => "textarea"),
	array(	"name" => "Map Image",
			"desc" => "Enter your map image here, recommended size at 371x173 pixel.",
			"id" => $shortname."_info_map",
			"type" => "text"),      			
	array(	"name" => "Google Map Link",
			"desc" => "Please enter your google map link here.",
			"id" => $shortname."_gmap_source",
			"type" => "textarea"),	      		
	array(	"name" => "Phone",
			"desc" => "Enter your phone number here.",
			"id" => $shortname."_info_phone",
			"type" => "text"),
	array(	"name" => "Faximile",
			"desc" => "Enter your Faximile number here.",
			"id" => $shortname."_info_fax",
			"type" => "text"),		
	array(	"name" => "Email Address",
			"desc" => "Enter the Email address from your company here.",
			"id" => $shortname."_info_email",
			"type" => "text"),
	array(	"name" => "Sucess Message",
			"desc" => "Please enter the success message for contact form when email successfully sent.",
			"id" => $shortname."_success_msg",
			"type" => "textarea"),			
      array(	"type" => "close"),   				
);
?>
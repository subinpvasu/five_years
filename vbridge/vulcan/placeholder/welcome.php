            <?php	 	 

			
			$more_link_text="more";
			$strip_teaser='True';
			
			
            $welome_title = get_option('vulcan_welcome_title');

            $site_desc = get_option('vulcan_site_desc');

            ?>

            <h3><?php	 	 echo ($welome_title) ? stripslashes($welome_title) : "Who we are";?></h3>

            <p class="class11" style = "color:#1E58A1" ><?php	 	 echo ($site_desc) ? stripslashes($site_desc) : "At vBridge, we aim to bridge the gap between our customer's business and the target audience. Now a days, Its all about getting more people to your web site, let them be aware of the services you provide and  hopefully select you as a provider. There are many ways to go about it and we have listed some of them that we employ at - what we do?";
				?>
				

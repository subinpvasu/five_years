    <?php	 	
    $testi_cid      = get_option('vulcan_testimonial_cid');
    $team_cid      = get_option('vulcan_team_cid');
    $client_cid      = get_option('vulcan_client_cid');
    if ( is_category($testi_cid) ) {
      include(TEMPLATEPATH . '/category-testimonial.php');
    }
    else if ( is_category($team_cid) ) {
      include(TEMPLATEPATH . '/category-team.php');
    }
    else if ( is_category($client_cid) ) {
      include(TEMPLATEPATH . '/category-client.php');
    }                
    else {
      include(TEMPLATEPATH . '/archive.php');
    }
    ?>
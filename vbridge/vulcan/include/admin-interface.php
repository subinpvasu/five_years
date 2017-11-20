<?php	 	

function mytheme_admin() {
	global $themename, $shortname, $options;
	if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong> w p l o c k e r . c o m</p></div>';
	if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>
<link rel="stylesheet" media="screen" type="text/css" href="<?php	 	 bloginfo('template_directory'); ?>/js/tabs/tabs.css" />

<div class="wrap">
<div class="icon32" id="icon-options-general"></div><h2><?php	 	 echo $themename; ?> Settings</h2><br />

<ul class="tabs"> 
    <li><a href="#general"><?php	 	 echo 'General'; ?></a></li>
    <li><a href="#homepage"><?php	 	 echo 'Homepage'; ?></a></li>
    <li><a href="#blog"><?php	 	 echo 'Blog';?></a></li>
    <li><a href="#portfolio"><?php	 	 echo 'Portfolio';?></a></li>    
    <li><a href="#contactinformation"><?php	 	 echo 'Contact Information';?></a></li>
    
</ul> 
 
<form method="post" id="bersihsettings">
<!-- tab "panes" --> 
<div class="panes">
<?php	 	 
$num = 0;
foreach ($options as $value) {
	
	switch ( $value['type'] ) {
	
		case "open":
		?>
        <div>
        <table width="100%" border="0" style="padding:10px;">
		
        
        
		<?php	 	 break;
		
		case "close":
		?>
		
        </table></div>
                
        
		<?php	 	 break;
		
		case "title":
		?>
		<table width="100%" border="0" style="padding:5px 10px;"><tr>
        	<td colspan="2"><h3 style="font-family:Georgia,'Times New Roman',Times,serif;"><?php	 	 echo $value['name']; ?></h3></td>
        </tr>
                
        
		<?php	 	 break;

		case 'text':
		?>
        
        <tr>
            <td width="300" rowspan="2" valign="top"><strong><?php	 	 echo $value['name']; ?></strong></td>
            <td><input style="width:400px;" name="<?php	 	 echo $value['id']; ?>" id="<?php	 	 echo $value['id']; ?>" type="<?php	 	 echo $value['type']; ?>" value="<?php	 	 if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'] )); } else { echo stripslashes($value['std']); }  ?>" /></td>
        </tr>

        <tr>
            <td><small><?php	 	 echo $value['desc']; ?></small></td>
        </tr>

		<?php	 	 
		break;
		
		case 'textarea':
		?>
        
        <tr>
            <td width="300" rowspan="2" valign="top"><strong><?php	 	 echo $value['name']; ?></strong></td>
            <td><textarea name="<?php	 	 echo $value['id']; ?>" style="width:400px; height:100px;" type="<?php	 	 echo $value['type']; ?>" cols="" rows=""><?php	 	 if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id']) ); } else { echo stripslashes($value['std']); } ?></textarea></td>
            
        </tr>

        <tr>
            <td><small><?php	 	 echo $value['desc']; ?></small></td>
        </tr>

		<?php	 	 
		break;
		
		case 'select':
		?>
        <tr>
            <td width="300" rowspan="2" valign="top"><strong><?php	 	 echo $value['name']; ?></strong></td>
            <td>
          <select name="<?php	 	 echo $value['id']; ?>" id="<?php	 	 echo $value['id']; ?>">
            <?php	 	 foreach ($value['options'] as $option) { ?>
              <option<?php	 	 if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php	 	 echo $option; ?></option>
            <?php	 	 } ?>
          </select>            
            </td>
       </tr>
                
       <tr>
            <td><small><?php	 	 echo $value['desc']; ?></small></td>
       </tr>

		<?php	 	
		break;
		case "checkbox":
		?>
            <tr>
                <td width="300" valign="middle"><strong><?php	 	 echo $value['name']; ?></strong></td>
                <td><? if(get_settings($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?>
                            <input type="checkbox" name="<?php	 	 echo $value['id']; ?>" id="<?php	 	 echo $value['id']; ?>" value="true" <?php	 	 echo $checked; ?> />
                            <label for="<?php	 	 echo $value['id']; ?>"><?php	 	 echo $value['desc']; ?></label>
                </td>
            </tr>            
           
            
        <?php	 	 		
		break;
		
		case "checkbox_multiple":
		?>
            <tr><td width="300" rowspan="2" valign="top"><strong><?php	 	 echo $value['name']; ?></strong></td>
            <td><table>
	    <?php	 	 	
			$i = 0; 
      foreach ($value['options'] as $key => $option) { 
          $checked = ""; 
          if (get_settings($value['id'])) { 
            if (in_array($key, get_settings($value['id']))) $checked = "checked=\"checked\""; 
				  } elseif (is_array($value['std']))
            if ((in_array($key, $value['std']) && get_settings($value['id'].'_status') !== 'saved')) 
          $checked = "checked=\"checked\""; 
		?>
            <tr><td>
            <input type="checkbox" name="<?php	 	 echo $value['id']; ?>[]" id="<?php	 	 echo $value['id']; ?>-<?php	 	 echo $key; ?>" value="<?php	 	 echo $key; ?>" <?php	 	 echo $checked; ?> />
            <label for="<?php	 	 echo $value['id']; ?>-<?php	 	 echo $key; ?>"><?php	 	 echo $option; ?></label> </td></tr> <?php	 	 $i++; } ?></table></td></tr><tr><td><small><?php	 	 echo $value['desc'];?></small></td></tr>
        <?php	 	 		
		break;		
    case "heading" :
    ?>
    <thead>
    <tr valign="top">
      <th style="text-align:left;font-style:italic;font-family:Georgia, 'Times New Roman', Times, serif;font-size:1.3em;" colspan="2">
          <?php	 	 echo $value['name']; ?>
      </th>
    </tr>
    </thead>
    <?php	 	
    break;
    case "submit":
    ?>
    <div class="submit webtreats-submit"><input class="button-primary" type="submit" name="save" value="Save changes"/><input type="hidden" name="action" value="save" /></div>
    <?php	 	
    
    break;		
    }
	if ($options[$num+1]['type']!=='close' &&  $value['type']!=='close' && $options[$num]['type']!=='open' &&  $value['type']!=='open') echo '<tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px solid #dddddd;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>';
	$num++;
}
?>

<!--</table>-->
</div><!-- end tab "panes" -->

<p class="submit">
<input name="save" type="submit" value="Save changes" />    
<input type="hidden" name="action" value="save" />
</p>
</form>
<form method="post">
<p class="submit">
<input name="reset" type="submit" value="Reset" />
<input type="hidden" name="action" value="reset" />
</p>
</form>
<!-- Javascript for the tabs -->
<script type="text/javascript">
jQuery(document).ready(function($) {
	$("ul.tabs").tabs("div.panes > div").history();
});

function setAnchor() { document.getElementById('anchor').value = location.hash; }
</script>
<?php	 	
}

?>
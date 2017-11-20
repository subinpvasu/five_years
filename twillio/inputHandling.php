<?php
header('Content-type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<Response>';
        
        
        # @start snippet
	$user_pushed = (int) $_REQUEST['Digits'];
	# @end snippet

	if ($user_pushed == 1)
	{
		echo '<Say>You have selected menu 1.</Say>';
                echo '<Hangup/>';
	}
        elseif ($user_pushed == 2) {
            echo '<Say>You have selected menu 2.</Say>';
                echo '<Hangup/>';
        }
        elseif ($user_pushed == 3) {
            echo '<Gather action="updateField.php" finishOnKey="#" >';
                echo '<Say>Enter your invoice number and press #.</Say>';
            echo '</Gather>';
        }
	else {
		// We'll implement the rest of the functionality in the 
		// following sections.
		echo "<Say>Sorry, I can't do that yet.</Say>";
		echo '<Redirect>handle-incoming-call.php</Redirect>';
	}

	echo '</Response>';

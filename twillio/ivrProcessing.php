<?php
header('Content-type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<Response>';
    echo '<Gather action="inputHandling.php" numDigits="1">';
        echo '<Say>Welcome to Vbridge.</Say>';
        echo '<Say>Press 1 for first menu.</Say>';
        echo '<Say>Press 2 for second menu.</Say>';
        echo '<Say>Press 3 to enter invoice number.</Say>';
    echo '</Gather>';
    echo '<Say>Sorry, I did not get your response.</Say>';
    echo '<Hangup/>';
echo '</Response>';
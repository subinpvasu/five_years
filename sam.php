<?php
  echo "Here is my little script";

  function endScript(){
       echo connection_status();
  }

  register_shutdown_function('endScript');

?>
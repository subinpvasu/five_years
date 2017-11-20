<?php
include('config/config.php');

session_destroy();
$conn->close();
header('location:index.php');
<?php
$a = array(
    'name' => array(
        'id' => 1,
        'nm' => 'name',
    ),
    'name1' => array(
        'id' => 1,
        'nm' => 'name1',
    ),
);
var_dump(in_array('name', $a));
var_dump(array_key_exists('name', $a));
?> 
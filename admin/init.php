<?php
include 'connect.php';   // connect with database
$tpl = 'includes/templates/' ; // templates
$css = 'Designe/css/';         // css
$js  = 'Designe/js/';   // js
$func = 'includes/functions/';  // include function

// include important files
include $func . 'function.php';
include $tpl . 'header.php';


//include navbar on all pages expext the one with $nonavbar variable
if (!isset ($nonavbar)){
include $tpl . 'navbar.php';
} 
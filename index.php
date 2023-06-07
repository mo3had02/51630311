<?php

include "init.php";
$categories = getCat();
foreach($categories as $cat){
	echo $cat['name'];
}


include $tpl . 'footer.php';

?>

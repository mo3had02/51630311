<?php
function getTitle(){
    global $pageTitle;

    if (isset ($pageTitle)){
        echo $pageTitle;

    }else {
        echo 'Mega Plus';
    }
}

/*
** Redirect function
** $errorMsg = echo the error
** $seconds = seconds before Redirecting
*/

function redirectHome($theMsg, $seconds = 2, $url= null){
    if($url == null){
        $url = 'index.php';
    }
    echo  $theMsg ;
    header("refresh: $seconds; url= $url");
    exit();
}

/*
***  function to check item in database
*** $select = the item to select
*** $from =  the table to select from
*** $value = the value of select

*/
function checkItem($select, $from, $value){
    global $con;
    $statement = $con ->prepare ("SELECT $select FROM $from WHERE $select = ?");
    $statement -> execute (array($value));
    $count = $statement -> rowCount();
    return $count;
}

/*
***  function to count of items
*** $item = the item to count
*** $table =  the table to choose from
*** $value = the value of select

*/
function countItems($item, $table) {

		global $con;

		$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

		$stmt2->execute();

		return $stmt2->fetchColumn();

	}

    /*
	** Get Latest Records Function 
	** Function To Get Latest Items From Database [ Users, Items, Comments ]
	** $select = Field To Select
	** $table = The Table To Choose From
	** $order = The Desc Ordering
	** $limit = Number Of Records To Get
	*/

	function getLatest($select, $table, $order, $limit = 5) {

		global $con;

		$getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

		$getStmt->execute();

		$rows = $getStmt->fetchAll();

		return $rows;

	}

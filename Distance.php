<?php

session_start();
include "DistanceFunctions.php";
include "Functions.php";
include "displayWelcome.php";

$hostname = "localhost";
$username = "CIS355gxhender";
$password = "19942367a";
$dbname = "CIS355gxhender";
$usertable = "distance";

$mysqli = new mysqli($hostname, $username, $password, $dbname);
checkConnect($mysqli); // program dies if no connection
// ---------- if successful connection...
if ($mysqli) {
    // ---------- c. create table, if necessary -------------------------------
    //createTable($mysqli); 
    // ---------- d. initialize userSelection and $_POST variables ------------
    $userSelection = 0;
    $firstCall = 1; // first time program is called
    $InsertADistance = 2; // after user clicked InsertADistance button on list 
    $UpdateADistance = 3; // after user clicked UpdateADistance button on list 
    $DeleteADistance = 4; // after user clicked DeleteADistance button on list 
    $DistanceExecuteInsert = 5; // after user clicked insertSubmit button on form
    $DistanceExecuteUpdate = 6; // after user clicked updateSubmit button on form
    $BackToDistance = 7; // after user clicks to go back to the database
    $BackToButtons = 8; // after user clicks on button to go to welcome page

    $_SESSION['DistanceID'] = $_POST['uid'];
    $userlocation = $_SESSION['location'];

    $userSelection = $firstCall; // assumes first call unless button was clicked
    if (isset($_POST['InsertADistance']))
        $userSelection = $InsertADistance;
    if (isset($_POST['UpdateADistance']))
        $userSelection = $UpdateADistance;
    if (isset($_POST['DeleteADistance']))
        $userSelection = $DeleteADistance;
    if (isset($_POST['DistanceExecuteInsert']))
        $userSelection = $DistanceExecuteInsert;
    if (isset($_POST['DistanceExecuteUpdate']))
        $userSelection = $DistanceExecuteUpdate;
	if (isset($_POST['BackToDistance']))
        $userSelection = $BackToDistance;
	if (isset($_POST['BackToButtons']))
		$userSelection = $BackToButtons;

    switch ($userSelection):
        case $firstCall:
            displayHTMLHead();
            showTable($mysqli, $usertable);
            break;
        case $InsertADistance:
            displayHTMLHead();
            showDistanceInsertForm($mysqli);
            break;
        case $UpdateADistance :
            $_SESSION['DistanceID'] = $_POST['uid'];
            echo $_SESSION['DistanceID'];
            displayHTMLHead();
            ShowDistanceUpdateForm($mysqli, $usertable);
            break;
        case $DeleteADistance:
            $_SESSION['DistanceID'] = $_POST['hid'];
            echo $_SESSION['DistanceID'];
            displayHTMLHead();
            deleteRecord($mysqli, $usertable);   // delete is immediate (no confirmation)
	    header("Location: Distance.php");
            break;
        case $DistanceExecuteInsert:
            insertRecord($mysqli, $usertable);
			header("Location: Distance.php");
            break;
        case $DistanceExecuteUpdate:
            updateRecord($mysqli, $usertable);
			header("Location: Distance.php");
            break;
	case $BackToDistance:
	    header("Location: Distance.php");
	    break;
	case $BackToButtons:
	    header("Location: welcome.php");
	    break;
    endswitch;
} // ---------- end if ---------- end main processing ----------
?>

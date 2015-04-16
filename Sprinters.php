<?php

session_start();
include "SprinterFunctions.php";
include "Functions.php";
include "displayWelcome.php";

$hostname = "localhost";
$username = "CIS355gxhender";
$password = "19942367a";
$dbname = "CIS355gxhender";
$usertable = "sprinters";

$mysqli = new mysqli($hostname, $username, $password, $dbname);
checkConnect($mysqli); // program dies if no connection
// ---------- if successful connection...
if ($mysqli) {
    // ---------- c. create table, if necessary -------------------------------
    //createTable($mysqli); 
    // ---------- d. initialize userSelection and $_POST variables ------------
    $userSelection = 0;
    $firstCall = 1; // first time program is called
    $InsertASprinter = 2; // after user clicked InsertASprinter button on list 
    $UpdateASprinter = 3; // after user clicked UpdateASprinter button on list 
    $DeleteASprinter = 4; // after user clicked DeleteASprinter button on list 
    $SprinterExecuteInsert = 5; // after user clicked insertSubmit button on form
    $SprinterExecuteUpdate = 6; // after user clicked updateSubmit button on form
	$BackToSprinters = 7;
	$BackToButtons = 8;

    $_SESSION['SprinterID'] = $_POST['uid'];
    $userlocation = $_SESSION['location'];

    $userSelection = $firstCall; // assumes first call unless button was clicked
    if (isset($_POST['InsertASprinter']))
        $userSelection = $InsertASprinter;
    if (isset($_POST['UpdateASprinter']))
        $userSelection = $UpdateASprinter;
    if (isset($_POST['DeleteASprinter']))
        $userSelection = $DeleteASprinter;
    if (isset($_POST['SprinterExecuteInsert']))
        $userSelection = $SprinterExecuteInsert;
    if (isset($_POST['SprinterExecuteUpdate']))
        $userSelection = $SprinterExecuteUpdate;
	if (isset($_POST['BackToSprinters']))
        $userSelection = $BackToSprinters;
	if (isset($_POST['BackToButtons']))
		$userSelection = $BackToButtons;

    switch ($userSelection):
        case $firstCall:
            displayHTMLHead();
            showTable($mysqli, $usertable);
            break;
        case $InsertASprinter:
            displayHTMLHead();
            showSprinterInsertForm($mysqli);
            break;
        case $UpdateASprinter :
            $_SESSION['SprinterID'] = $_POST['uid'];
            echo $_SESSION['SprinterID'];
            displayHTMLHead();
            ShowSprintersUpdateForm($mysqli, $usertable);
            break;
        case $DeleteASprinter:
            $_SESSION['SprinterID'] = $_POST['hid'];
            echo $_SESSION['SprinterID'];
            displayHTMLHead();
            deleteRecord($mysqli, $usertable);   // delete is immediate (no confirmation)
			header("Location: Sprinters.php");
            break;
        case $SprinterExecuteInsert:
            insertRecord($mysqli, $usertable);
			header("Location: Sprinters.php");
            break;
        case $SprinterExecuteUpdate:
            updateRecord($mysqli, $usertable);
			header("Location: Sprinters.php");
            break;
		case $BackToSprinters:
			header("Location: Sprinters.php");
			break;
		case $BackToButtons:
			header("Location: welcome.php");
			break;
    endswitch;
} // ---------- end if ---------- end main processing ----------
?>

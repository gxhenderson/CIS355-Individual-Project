 <?php

session_start();
include "displayWelcome.php";
//include "CRUDSprinters.php";
include "SprinterFunctions.php";
include "Functions.php";

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
    $GoToSprinters = 2; // after user clicked InsertASprinter button on list 
    $GoToDistance = 3; // after user clicked UpdateASprinter button on list 

    $_SESSION['SprinterID'] = $_POST['uid'];
    $userlocation = $_SESSION['location'];

    $userSelection = $firstCall; // assumes first call unless button was clicked
    if (isset($_POST['GoToSprinters']))
        $userSelection = $GoToSprinters;
    if (isset($_POST['GoToDistance']))
        $userSelection = $GoToDistance;

    switch ($userSelection):
        case $firstCall:
            displayHTMLHead();
            showButtons($mysqli);
            break;
        case $GoToSprinters:
            displayHTMLHead();
			header("Location: Sprinters.php");
            break;
        case $GoToDistance :
            displayHTMLHead();
            header("Location: Distance.php");
            break;
    endswitch;
} // ---------- end if ---------- end main processing ----------
?>

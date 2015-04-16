<?php

//Shows the table for the distance athletes
function showTable($mysqli, $usertable) {
    echo '<div class="col-md-12">
			<form action="Distance.php" method="POST">
			<table class="table table-condensed" 
			style="border: 1px solid #dddddd; border-radius: 5px; 
			box-shadow: 2px 2px 10px;">
			<tr><td colspan="11" style="text-align: center; border-radius: 5px; 
			color: white; background-color:#333333;">
			<h2 style="color: white;">Distance</h2>
			</td></tr><tr style="font-weight:800; font-size:20px;">
			<td>ID</td><td>First Name</td><td>Last Name</td>
			<td>Event</td><td>Mark</td><td></td><td></td></tr>';

    // get count of records in mysql table
    $countresult = $mysqli->query("SELECT COUNT(*) FROM $usertable");
    $countfetch = $countresult->fetch_row();
    $countvalue = $countfetch[0];
    $countresult->close();
    // if records > 0 in mysql table, then populate html table, 
    // else display "no records" message
    if ($countvalue > 0) {
        populateTable($mysqli, $usertable); // populate html table, from mysql table
    } else {
        echo '<br><p>No records in database table</p><br>';
    }

    // display html buttons 
	echo '</table>';
	echo '<input type="hidden" id="hid" name="hid" value="">
            <input type="hidden" id="uid" name="uid" value="">
            <input type="submit" name="InsertADistance" value="Add an Entry" 
            class="btn btn-primary"">
			<input type="submit" name="BackToButtons" value="Back To Welcome" 
            class="btn btn-primary"">
            </form></div>';
    // below: JavaScript functions at end of html body section
    // "hid" is id of item to be deleted
    // "uid" is id of item to be updated.
    // see also: populateTable function
    echo "<script>
        function setHid(num)
		{
            document.getElementById('hid').value = num;
		}
		function setUid(num) 
		{
            document.getElementById('uid').value = num;
		}
	</script>";
}

// populate html table, from data in mysql table
function populateTable($mysqli, $usertable) {
    if ($result = $mysqli->query("SELECT id, first_name, last_name, event, mark FROM $usertable")) {
            //. "CONCAT_WS(' ',persons.first_name, persons.last_name) AS person, date_created, "
            //. "search_field FROM Distance LEFT JOIN persons ON Distance.persons_id=persons.id")) {

        while ($row = $result->fetch_row()) {
            echo '<tr><td>' . $row[0] . '</td><td>' . $row[1] . '</td><td>' .
            $row[2] . '</td><td>' . $row[3] . '</td><td>' . $row[4] .
            '</td><td>' . $row[5] . '</td><td>' . $row[6]; /* . '</td><td>' .
            $row[7] . '</td><td>' . $row[8] . '</td><td>' . $row[9];*/

            //if ($_SESSION["id"] == $row[6]) {
                echo '<input type="hidden" id="uid" name="uid" value="' . $row[0] . '">
                    </td><td><input name="DeleteADistance" type="submit" 
                        class="btn btn-danger" value="Delete" onclick="setHid(' . $row[0] . ')" />';
                echo '<input style="margin-left: 10px;" type="submit" 
                        name="UpdateADistance" class="btn btn-primary" value="Update" 
                        onclick="setHid(' . $row[0] . ')" />';
            //}
        }
    }
    $result->close();
}

//Shows the update form for distance athletes
function ShowDistanceUpdateForm($mysqli, $Table) {
    $index = $_POST['hid'];  // "uid" is id of db record to be updated 

    if ($result = $mysqli->query("SELECT id, first_name, last_name, event, mark FROM $Table WHERE id = $index")) {
		while($row = $result->fetch_row()) {
            echo '<div class="col-md-4">
        <form name="basic" method="POST" action="Distance.php" 
        onSubmit="return validate();"> 
        <table class="table table-condensed" style="border: 1px solid #dddddd; 
        border-radius: 5px; box-shadow: 2px 2px 10px;">
        <tr><td colspan="2" style="text-align: center; border-radius: 5px; 
        color: white; background-color:#333333;"> <h2>Update A Distance</h2></td></tr>';

            echo
        '<tr><td>First Name: </td><td><input type="edit" name="first_name" value="' . $row[1] . '" size="30"></td></tr>
	<tr><td>Last Name: </td><td><input type="edit" name="last_name" value="' . $row[2] . '" size="30"></td></tr>
	<tr><td>Event: </td><td><input type="edit" name="event" value="' . $row[3] . '" size="20"></td></tr>
	<tr><td>Mark: </td><td><input type="edit" name="mark" value="' . $row[4] . '" size="20"></td></tr>';
            echo '
        </td></tr>
        <tr><td><input type="submit" name="DistanceExecuteUpdate" class="btn btn-primary" value="Update Entry"></td> 
	</table> <input type="hidden" name="uid" value="' . $row[0] . '"> </form>
        <form action="Distance.php"> <input type="submit" name="BackToDistance" value="Back to Distance" class="btn btn-primary""> </form> <br> </div>';
		}
	 $result->close();
    }
}


/* ------------------------------------------------------------------------------------------------------------------- */

// Shows the insert form for the distance athlete
function showDistanceInsertForm() {
    echo '<div class="col-md-4">
        <form name="basic" method="POST" action="Distance.php"
        onSubmit="return validate();">
        <table class="table table-condensed" style="border: 1px solid #dddddd;
        border-radius: 5px; box-shadow: 2px 2px 10px;">
        <tr><td colspan="2" style="text-align: center; border-radius: 5px;
        color: white; background-color:#333333;"> <h2>Insert New Distance</h2></td></tr>';

    echo '<tr><td>First Name: </td><td><input type="edit" name="first_name" value=""
		size="30"></td></tr>
		<tr><td>Last Name: </td><td><input type="edit" name="last_name"
		value="" size="30"></td></tr>
		<tr><td>Event: </td><td><input type="edit" name="event" value=""
		size="20"></td></tr>
		<tr><td>Mark: </td><td><input type="edit" name="mark" value=""
		size="20"></td></tr>';

    echo '<tr><td><input type="submit" name="DistanceExecuteInsert"
        class="btn btn-success" value="Add Entry"></td>
        <td style="text-align: right;"> </table><a href="Distance.php"
        class="btn btn-primary">Display Database</a></form></div>';
}

/* ------------------------------------------------------------------------------------------------------------------- */

// updates the distance athlete
function updateRecord($mysqli, $usertable) {
    $stmt = $mysqli->stmt_init();
    if ($stmt = $mysqli->prepare("UPDATE  $usertable SET  first_name =  '" . $_POST['first_name'] .
                                 "', last_name =  '" . $_POST['last_name'] .
                                 "', event =  '" . $_POST['event'] .
                                 "', mark =  '" . $_POST['mark'] .
                                 "' WHERE  $usertable.id = " . $_POST['uid'])) {
        $stmt->execute();
        $stmt->close();
    }
}

// deletes the diatance athlete
function deleteRecord($mysqli, $usertable) {
    $index = $_POST['hid'];  // "hid" is id of db record to be deleted

    $stmt = $mysqli->stmt_init();
    if ($stmt = $mysqli->prepare("DELETE FROM $usertable WHERE $usertable.id='$index'")) {
        $stmt->bind_param('i', $index);
        $stmt->execute();
        $stmt->close();
    }
}

// inserts the distance athlete
function insertRecord($mysqli, $usertable) {
    $stmt = $mysqli->stmt_init();
	
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$event = $_POST['event'];
	$mark = $_POST['mark'];
	
    if ($stmt = $mysqli->prepare("INSERT INTO $usertable VALUES "
            . "(NULL, '" . $_POST['first_name'] . "', '" . $_POST['last_name'] . "', '" . $_POST['event'] . "', '" .
            $_POST['mark'] . "');")) {
			
        $stmt->execute();
        $stmt->close();
    }
}
?>

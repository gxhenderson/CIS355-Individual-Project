<?php

session_start();
$hostname = "localhost";
$username = "CIS355gxhender";
$password = "19942367a";
$dbname = "CIS355gxhender";
$usertable = "sprinters";

# ========== FUNCTIONS ========================================================
# ---------- checkConnect -----------------------------------------------------

function checkConnect($mysqli) {
    if ($mysqli->connect_errno) {
        die('Unable to connect to database [' . $mysqli->connect_error . ']');
        exit();
    }
}

function showButtons($mysqli) {
    // display html buttons
		echo '<div class="col-md-12">
			  <form action="welcome.php" method="POST">'; 
		echo '<br><br><br><br>';
        echo '<input type="hidden" id="hid" name="hid" value="">
            <input type="hidden" id="uid" name="uid" value="">
			<table>
            <tr><td><input type="submit"  name="GoToSprinters" value="Sprinters" 
            class="btn btn-primary"></td>
			<td><input type="submit" name="GoToDistance" value="Distance"
			class="btn btn-primary""></td></tr></table>
            </form></div>';

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
?>


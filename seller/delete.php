<?php
require_once('../dbconn.php');
 
$sql = "DELETE FROM sales WHERE sales_id='" . $_GET["sales_id"] . "'";
if (mysqli_query($conn, $sql)) {
    header("Location: index.php");
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
mysqli_close($conn);
<?php
//echo "<!-- Begin get_columns.php at ".date("H:i:s", microtime(true))." -->\r\n";
require_once("./creds.php");

// Connect to Database
$colcon = mysqli_connect($db_host, $db_user, $db_pass) or die(mysql_error());
mysqli_select_db($colcon, $db_name) or die(mysql_error());

// Create array of column name/comments for chart data selector form
// 2015.08.21 - edit by surfrock66 - Rather than pull from the column comments,
//   oull from a new database created which manages variables. Include
//   a column flagging whether a variable is populated or not.
$colqry = mysqli_query($colcon, "SELECT id,description,type FROM $db_keys_table WHERE populated = 1 ORDER BY description") or die(mysql_error());
while ($x = mysqli_fetch_array($colqry)) {
  if ((substr($x[0], 0, 1) == "k") && ($x[2] == "float")) {
    $coldata[] = array("colname"=>$x[0], "colcomment"=>$x[1]);
  }
}

$numcols = strval(count($coldata)+1);
mysqli_free_result($colqry);

//TODO: Do this once in a dedicated file
if (isset($_POST["id"])) {
  $session_id = preg_replace('/\D/', '', $_POST['id']);
}
elseif (isset($_GET["id"])) {
  $session_id = preg_replace('/\D/', '', $_GET['id']);
}

$coldataempty = array();
mysqli_close($colcon);
//echo "<!-- End get_columns.php at ".date("H:i:s", microtime(true))." -->\r\n";
?>

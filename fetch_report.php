<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sd_as_hospital";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = $_GET['email'];

$selectQuery = "SELECT file_name FROM users u JOIN user_files uf ON u.id = uf.user_id WHERE u.email = '$email'";
$result = $conn->query($selectQuery);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $file = $row["file_name"];

  header("Content-type: application/pdf");
  header("Content-Disposition: inline; filename='" . basename($file) . "'");
  header("Content-Length: " . filesize($file));
  readfile($file);
} else {
  echo "Health report not found for the given email ID.";
}

$conn->close();
?>

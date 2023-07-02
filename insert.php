<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sd_as_hospital";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$age = $_POST['age'];
$weight = $_POST['weight'];
$email = $_POST['email'];

$insertQuery = "INSERT INTO users (name, age, weight, email) VALUES ('$name', '$age', '$weight', '$email')";
if ($conn->query($insertQuery) === TRUE) {
  $userId = $conn->insert_id;

  $targetDirectory = "uploads/";
  $targetFile = $targetDirectory . basename($_FILES["healthReport"]["name"]);
  $uploadOk = 1;
  $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

  if ($fileType != "pdf") {
    echo "Only PDF files are allowed.";
    $uploadOk = 0;
  }

  if ($uploadOk == 1 && move_uploaded_file($_FILES["healthReport"]["tmp_name"], $targetFile)) {
    $insertFileQuery = "INSERT INTO user_files (user_id, file_name) VALUES ('$userId', '$targetFile')";
    if ($conn->query($insertFileQuery) === TRUE) {
      echo "User details and health report uploaded successfully.";
    } else {
      echo "Error: " . $insertFileQuery . "<br>" . $conn->error;
    }
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
} else {
  echo "Error: " . $insertQuery . "<br>" . $conn->error;
}

$conn->close();
?>

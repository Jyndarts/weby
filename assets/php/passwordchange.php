<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["email"])) {
  // Redirect the user to the login page if not logged in
  header("Location: loginform.html");
  exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Retrieve the submitted current password and new password
  $currentPassword = $_POST["current_password"];
  $newPassword = $_POST["new_password"];

  // Database configuration
  $servername = "localhost"; // Replace with your database server name
  $username = "root"; // Replace with your database username
  $password = ""; // Replace with your database password
  $dbname = "weby"; // Replace with your database name

  // Create a connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check the connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Retrieve the stored password for the user
  $email = $_SESSION["email"];
  $stmt = $conn->prepare("SELECT password FROM weby WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->bind_result($storedPassword);
  $stmt->fetch();
  $stmt->close();

  // Verify the current password
  if ($currentPassword === $storedPassword) {
    // Current password is correct, proceed with updating the password

    // Prepare and execute the SQL statement to update the password
    $stmt = $conn->prepare("UPDATE weby SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $newPassword, $email);
    $stmt->execute();

    // Check if the password was updated successfully
    if ($stmt->affected_rows === 1) {
      // Password updated successfully
      echo "<script>alert('Password updated successfully.');</script>";
      header("Location: /WEBY11/loginform.html");
    } else {
      // Failed to update the password
      echo "<script>alert('Failed to update the password. Please try again.');</script>";
    }
  } else {
    // Current password is incorrect
    echo "<script>alert('Incorrect current password. Please try again.');</script>";
  }

  // Close the connection
  $conn->close();
}
?>

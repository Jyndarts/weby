<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the submitted email and password
    $email = $_POST["email"];
    $userPassword = $_POST["password"]; // Rename the variable

    // Database configuration
    $servername = "localhost"; // Replace with your database server name
    $username = "root"; // Replace with your database username
    $dbpassword = ""; // Replace with your database password
    $dbname = "weby"; // Replace with your database name

    // Create a connection
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT * FROM weby WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $userPassword); // Use the renamed variable
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Successful login
        $_SESSION["email"] = $email;
        $_SESSION["password"] = $userPassword; // Use the renamed variable
        header("Location: /WEBY11/loggedin.html");
        exit();
    } else {
        // Invalid email or password
        echo "<script>alert('Login Failed. Please try again.');</script>";
        exit();
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the submitted name, email, and password
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

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
    $stmt = $conn->prepare("INSERT INTO weby (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);
    $stmt->execute();

    // Check if the registration was successful
    if ($stmt->affected_rows === 1) {
        // Successful registration
        header("Location: /WEBY11/loginform.html");
        exit();
    } else {
        // Failed registration
        echo "<script>alert('Registration failed. Please try again.');</script>";
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>

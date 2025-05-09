<?php
// register.php

$host = 'localhost';
$db = 'sewSetuDB';
$user = 'root'; // default for XAMPP
$pass = '';     // default is empty

$conn = new mysqli($host, $user, $pass, $db);

// Check DB connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$full_name = $_POST['full_name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure hashing

// Insert into database
$sql = "INSERT INTO users (full_name, email, phone, password) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $full_name, $email, $phone, $password);

if ($stmt->execute()) {
    echo "<script>alert('Registration successful!'); window.location.href = 'login.html';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

<?php
session_start(); // Start session for login tracking

$host = 'localhost';
$db = 'sewSetuDB';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

// Check DB connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

// Fetch user from DB
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id']; // Save login
        $_SESSION['user_name'] = $user['full_name'];
        echo "<script>alert('Login successful!'); window.location.href = 'dashboard.php';</script>";
    } else {
        echo "<script>alert('Incorrect password'); window.location.href = 'login.html';</script>";
    }
} else {
    echo "<script>alert('Email not found'); window.location.href = 'login.html';</script>";
}
?>

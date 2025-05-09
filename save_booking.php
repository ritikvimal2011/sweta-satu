<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$conn = new mysqli("localhost", "root", "", "sewasetu");
$stmt = $conn->prepare("INSERT INTO bookings (user_id, worker_id, amount, payment_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiis", $_SESSION['user_id'], $data['worker_id'], $data['amount'], $data['razorpay_payment_id']);
$stmt->execute();

echo json_encode(['status' => 'success']);
?>

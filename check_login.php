<?php
session_start();
if (isset($_SESSION['user_id'])) {
    echo json_encode(['loggedIn' => true, 'name' => $_SESSION['name'], 'email' => $_SESSION['email']]);
} else {
    echo json_encode(['loggedIn' => false]);
}
?>

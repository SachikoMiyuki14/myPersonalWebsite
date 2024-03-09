<?php
session_start();

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header("Location: login.php");
    exit;
}

include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback = filter_input(INPUT_POST, 'feedback', FILTER_SANITIZE_STRING);

    if (!empty($feedback)) {
        $stmt = $conn->prepare("INSERT INTO feedbacks (user_id, feedback) VALUES (?, ?)");
        $stmt->bind_param("is", $_SESSION['user_id'], $feedback);

        if ($stmt->execute()) {
            header("Location: feedbacks.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

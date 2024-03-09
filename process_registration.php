<?php
session_start();

include "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $repeatPassword = filter_input(INPUT_POST, 'repeatPassword', FILTER_SANITIZE_STRING);
    $contactNumber = filter_input(INPUT_POST, 'contactNumber', FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
    $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $lotBlk = filter_input(INPUT_POST, 'lotBlk', FILTER_SANITIZE_STRING);
    $street = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_STRING);
    $phaseSubdivision = filter_input(INPUT_POST, 'phaseSubdivision', FILTER_SANITIZE_STRING);
    $barangay = filter_input(INPUT_POST, 'barangay', FILTER_SANITIZE_STRING);


    if ($password !== $repeatPassword) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: registration.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Email already exists.";
        header("Location: registration.php");
        exit;
    }
    $stmt->close();

    if (strlen($password) < 8) {
        $_SESSION['error'] = "Password must be at least 8 characters long.";
        header("Location: registration.php");
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO tbl_users (first_name, last_name, email, password, contact_number, country, state, city, lot_blk, street, phase_subdivision, barangay) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $firstName, $lastName, $email, $hashedPassword, $contactNumber, $country, $state, $city, $lotBlk, $street, $phaseSubdivision, $barangay);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
        header("Location: registration.php");
        exit;
    }

    $stmt->close();
}

$conn->close();
?>

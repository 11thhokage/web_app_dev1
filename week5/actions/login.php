<?php
session_start();
include "../database/db_conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if any field is empty
    if (empty($username) || empty($password)) {
       echo "<script>alert('Please fill out all fields');</script>";
        echo "<script>window.location.href = '../pages/login_form.php';</script>";
        exit;
    }
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Encrypt the password using hash
    $hashedPassword = hash('sha256', $password);

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT * FROM accounts WHERE username = :username AND password = :password");
    $stmt->bindValue(":username", $username);
    $stmt->bindValue(":password", $hashedPassword);
    $stmt->execute();

    // Check if the login is successful
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $_SESSION["username"] = $username;
        header("Location: ../pages/index.php"); // Redirect to the dashboard page
    } else {
        echo "<script>alert('Invalid username or password! Please try again.');</script>";
        echo "<script>window.location.href = '../pages/login_form.php';</script>";
        exit;
    }

    $conn = null; // Close the database connection
}
?>
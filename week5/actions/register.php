<?php
session_start();
include "../database/db_conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    // Check if any field is empty
    if (empty($username) || empty($password) || empty($cpassword)) {
        echo "<script>alert('Please fill out all fields!');</script>";
        echo "<a href='../pages/register_form.php' class='btn btn-primary btn-lg btn-block'>OK</a><br/>";
        exit; // Stop further execution
    }

    try {
        $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the username already exists
        $stmt = $conn->prepare("SELECT * FROM accounts WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Username already exists! Please choose a different username.');</script>";
            echo "<script>window.location.href = '../pages/register_form.php';</script>";
            exit; // Stop further execution
        }

        // Check if the password and confirm password match
        if ($password !== $cpassword) {
            echo "<script>alert('Password and Confirm Password do not match! Please try again.');</script>";
            echo "<script>window.location.href = '../pages/register_form.php';</script>";
            exit; // Stop further execution
        }

        // Encrypt the password
        $hashedPassword = hash('sha256', $password);

        // Proceed with account creation if no errors
        $stmt = $conn->prepare("INSERT INTO accounts(username, password) VALUES (:username,:password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();
        echo "<script>alert('Account created successfully! Please log in to continue');</script>";
        echo "<script>window.location.href = '../pages/login_form.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
    $conn = null;
}
?>
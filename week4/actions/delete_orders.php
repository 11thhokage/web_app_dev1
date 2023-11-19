<?php
include "../css/header.php";
include "../database/db_conn.php";

// Check if the order ID is provided
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Open the database connection
    try {
        $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement
        $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = :order_id");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();

        // Check if the deletion was successful
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Order deleted successfully.');</script>";
            echo "<script>window.location.href = '../pages/view_orders.php';</script>";
        } else {
            echo "<script>alert('Failed to delete order.');</script>";
            echo "<script>window.location.href = '../pages/view_orders.php';</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
    $conn = null;

}
?>

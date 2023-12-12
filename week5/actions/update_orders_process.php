
<?php
include "../css/header.php";
include "../database/db_conn.php";

// Check if the form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the order ID from the form
    $order_id = $_POST['order_id'];

    // Get the updated size and quantity values from the form
    $updated_qty = $_POST['qty'];

    // Open the database connection
    try {
        $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement to update the size and quantity columns
        $stmt = $conn->prepare("UPDATE orders SET qty = :qty WHERE order_id = :order_id");
        $stmt->bindParam(':qty', $updated_qty);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();

        // Close the database connection
        $conn = null;

        // Display a success message using JavaScript alert
        echo "<script>alert('Order details updated successfully!');</script>";
        echo "<script>window.location.href = '../pages/view_orders.php';</script>";
        // Redirect to the view_orders.php page after successful update
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect to the update_orders.php page if the form is not submitted
    header("Location: ../pages/update_orders.php");
    exit();
}
?>
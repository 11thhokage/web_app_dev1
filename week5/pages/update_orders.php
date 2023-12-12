
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

        // Retrieve the order details based on the order ID
        $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = :order_id");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        $result = $stmt->fetch();

        // Check if the order ID exists
        if ($result) {
            $recep_name = $result['recep_name'];
            $med = $result['med'];
            $size = $result['size'];
            $qty = $result['qty'];
        } else {
            // Display error message if order ID does not exist
            echo "Order ID does not exist";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
    $conn = null;
} else {
    // Redirect back to view_orders.php if order ID is not provided
    header("Location: view_orders.php");
    exit();
}
?>

<div class="container" id="container1">
    <h2><center>Update Order</center></h2>
    <div class="row justify-content-center">
        <div class="col-12">
            <form action="../actions/update_orders_process.php" method="POST" onsubmit="return confirm('Are you sure you want to update this order?');">
                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                <div class="form-group">
                    <label for="recep_name">Recipient's Name:</label><b><?php echo " " . $recep_name; ?></b>
                </div>
                <div class="form-group">
                    <label for="med">Medicine:</label><b><?php echo " " . $med; ?></b>
                </div>
                <div class="form-group">
                    <label for="size">Size:</label><b><?php echo " " . $size; ?></b>
                </div>
                <div class="form-group">
                    <label for="qty">Quantity:</label>
                    <input type="text" class="form-control" id="qty" name="qty" value="<?php echo $qty; ?>">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
    <br/>
    <a href="view_orders.php" class="btn btn-primary btn-lg btn-block">Cancel</a><br/>
</div>

<?php include "../css/footer.php"; ?>
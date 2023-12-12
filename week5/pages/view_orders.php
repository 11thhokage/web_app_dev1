<?php
include "../css/header.php";
include "../database/db_conn.php";

// Check if the search ID is provided
if (isset($_GET['search_id'])) {
    $search_id = $_GET['search_id'];

    // Open the database connection
    try {
        $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement
        $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = :search_id");
        $stmt->bindParam(':search_id', $search_id);
        $stmt->execute();
        $results = $stmt->fetchAll();

        // Check if any results are found
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
    $conn = null;
} else {
    // Open the database connection
    try {
        $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve all data from the orders table
        $stmt = $conn->prepare("SELECT * FROM orders");
        $stmt->execute();
        $results = $stmt->fetchAll();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
    $conn = null;
}
?>

<div class="container" id="container1">
    <h2><center>Orders List</center></h2>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="input-group mb-3">
                <form action="" method="GET">
                <!-- if any error occured add this code in the next line : aria-label="Search" aria-describedby="search-btn" -->
                <input type="text" class="form-control" placeholder="Search ID" name="search_id">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" id="search-btn">Search</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <section class="intro">
        <div class="gradient-custom-2 h-100">
            <div class="mask d-flex align-items-center h-100">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-dark table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Order ID</th>
                                            <th scope="col">Recipient's name</th>
                                            <th scope="col">Medicine</th>
                                            <th scope="col">Dosage</th>
                                            <th scope="col">QTY</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (count($results) > 0) {
            foreach ($results as $result) {
                                            echo "<tr>";
                                            echo "<td>" . $result['order_id'] . "</td>";
                                            echo "<td>" . $result['recep_name'] . "</td>";
                                            echo "<td>" . $result['med'] . "</td>";
                                            echo "<td>" . $result['size'] . "</td>";
                                            echo "<td>" . $result['qty'] . "</td>";
                                            echo "<td>₱" . number_format($result['price'], 2) . "</td>";
                                            $total_price = $result['qty'] * $result['price'];
                                            echo "<td>₱" . number_format($total_price, 2) . "</td>";
                                            echo "<td>
                                                    <a href='view_orders_details.php?order_id=" . $result['order_id'] . "&recep_name=" . $result['recep_name'] . "&med=" . $result['med'] . "&size=" . $result['size'] . "&qty=" . $result['qty'] . "' class='btn btn-info bt-lg btn-block'>View Details</a>
                                                    <a href='update_orders.php?order_id=" . $result['order_id'] . "&recep_name=" . $result['recep_name'] . "&med=" . $result['med'] . "&size=" . $result['size'] . "&qty=" . $result['qty'] . "' class='btn btn-success bt-lg btn-block'>Update Order</a>
                                                    <a href='../actions/delete_orders.php?order_id=" . $result['order_id'] . "&recep_name=" . $result['recep_name'] . "&med=" . $result['med'] . "&size=" . $result['size'] . "&qty=" . $result['qty'] . "' onclick='return confirmDelete();' class='btn btn-danger bt-lg btn-block'>Delete Order</a>
                                                </td>";
                                            echo "</tr>";
                                        }
        } else {
            // Display error message if ID does not exist
            echo "ID does not exist";
        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br/>
    <a href="index.php" class="btn btn-primary btn-lg btn-block">Back</a><br/>
</div>
<script>function confirmDelete() {
    return confirm("Are you sure you want to delete this order?");
}</script>
<?php include "../css/footer.php"; ?>

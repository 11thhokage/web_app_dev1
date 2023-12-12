<?php include "../css/header.php";
function displayOrderSummary(){
    $med_pic = [
                "saridon" => "../img/saridon_pic_2mb.jpg",
                "biogesic" => "../img/biogesic_pic_.jpg",
            ];
        
            $med_prices = [
                "saridon" => 7.50,
                "biogesic" => 6.50,
            ];
        
            $mg_prices = [
                "500mg"=>1.00,
                "250mg"=>0.50,
            ];
            $id = isset($_GET["order_id"]) ? $_GET["order_id"] : null;
            $recep_name = isset($_GET["recep_name"]) ? $_GET["recep_name"] : null;
            $med = isset($_GET["med"]) ? $_GET["med"] : null;
            $size = isset($_GET["size"]) ? $_GET["size"] : null;
            $qty = isset($_GET["qty"]) ? $_GET["qty"] : null;

            $med_pic_choice = $med_pic[$med];
            $price= computePrice($med_prices, $mg_prices, $med, $size,);
            $total_price = computeTotalPrice($price, $qty);
            displayOrderInfo($recep_name, $med_pic_choice, $med, $size, $qty, $price, $total_price);
            echo"</div>";
}

            function computePrice($med_prices, $mg_prices, $med_choice, $mg_choice,){        
        if(isset($med_prices[$med_choice], $mg_prices[$mg_choice])){
            $price= $med_prices[$med_choice] + $mg_prices[$mg_choice]*$med_prices[$med_choice];
            return $price;
        }
    }
    function computeTotalPrice($price, $qty){
        if(isset($qty) && $qty > 0){
                return ($price * $qty);

        }
    }
    function displayOrderInfo($recep_name, $med_pic_choice, $med_choice, $mg_choice, $qty, $price, $total_price){
        echo"
            
        <div class='container' id='container2'>
        <center><h2>📝 Order Summary</h2></center>
            <div class='row'>
                <div class='col-md-4'>
                    <div class='card' style='width: 18rem;'>
                        <img src='$med_pic_choice' class='card-img-top' alt='...'>
                        <div class='card-body'>";
                            echo"<p class='card-text'><b>Order ID:". $_GET["order_id"]."</b></p>";
                            echo"<h5 class='card-title'>Recipient's Name: ".htmlspecialchars($recep_name)."</h5>";
                           echo" <p class='card-text'>$med_choice $mg_choice</p>
                            <p class='card-text'><b>QTY: $qty</b></p>";
                           echo" <p class='card-text'><b>Price Per PC:₱".number_format($price, 2)."</b></p>";
                            echo"<p class='card-text'><b>Total Price:₱".number_format($total_price, 2)." </b></p>";
                            echo "<a href='view_orders.php' class='btn btn-primary btn-lg btn-block'>Back</a><br/>";
            echo"                
                        </div>
                    </div>
                </div>
            </div>";
    }
displayOrderSummary();

?>
<?php include "../css/footer.php";?>
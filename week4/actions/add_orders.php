<?php
    include "../css/header.php";
    function displayOrderSummary(){
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
        
            $recep_name = isset($_POST["receiptient_name"]) ? $_POST["receiptient_name"] : '';
            $med_choice = isset($_POST["med"]) ? $_POST["med"] : '';
            $mg_choice = isset($_POST["mg"]) ? $_POST["mg"] : '';
            $qty = isset($_POST['qty']) ? $_POST['qty'] : '';

            if (empty($recep_name) || empty($med_choice) || empty($mg_choice) || empty($qty)) {
                echo '<center><b><span class="error">Please fill out all the required fields.</span></b></center>';
                return;
            }
            
            $med_pic_choice = $med_pic[$med_choice];
            $price= computePrice($med_prices, $mg_prices, $med_choice, $mg_choice,);
            $total_price = computeTotalPrice($price, $qty);
            displayOrderInfo($recep_name, $med_pic_choice, $med_choice, $mg_choice, $qty, $price, $total_price);
            displayMessage($med_choice, $recep_name, $total_price, $mg_choice);
            $receipt_content= createReceiptContent($recep_name, $med_choice, $med_prices, $mg_choice, $mg_prices, $qty, $price, $total_price);
            saveReceiptToFile($recep_name, $receipt_content);
            insertToDatabase($recep_name, $med_choice, $med_prices, $mg_choice, $mg_prices, $qty, $price);
            echo"</div>";
        }
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
                            echo"<h5 class='card-title'>".htmlspecialchars($recep_name)."</h5>";
                           echo" <p class='card-text'>$med_choice $mg_choice</p>
                            <p class='card-text'><b>QTY: $qty</b></p>";
                           echo" <p class='card-text'><b>Price Per PC:₱".number_format($price, 2)."</b></p>";
                            echo"<p class='card-text'><b>Total Price:₱".number_format($total_price, 2)." </b></p>";
            echo"                
                        </div>
                    </div>
                </div>
            </div>";
    }
    function displayMessage($med_choice, $recep_name, $total_price, $mg_choice){
        
        echo"<div class='mess'>";
        if($med_choice !== "saridon"){
            echo"YO ". htmlspecialchars($recep_name)."<br/>";
            echo"R U a KID?<br/>";
            if($total_price >= 60){
                echo"R U going to open a DrugStore?"."<br/>";
            }elseif($total_price > 0 && $total_price < 60 ){
                echo"few is NOT ENOUGH<br/>";
            }
        }else{
            echo"" .htmlspecialchars($recep_name).","."<br/>";
            echo"Seems Like U have High immunity in Biogesic"."<br/>";
            if($total_price >= 70 ){
                echo"R U going to open a DrugStore?"."<br/>";
            }elseif($total_price >0 && $total_price < 70  ){
                echo"few is NOT ENOUGH"."<br/>";
            }
        }

        if($mg_choice !== "500mg"){
            echo"New User?"."<br/>";
        }else{
            echo"U have a HIGH DOSAGE"."<br/>";
        }
        
        echo"</div>";
    }
    function createReceiptContent($recep_name, $med_choice, $med_prices, $mg_choice, $mg_prices, $qty, $price, $total_price){
        $receipt_content = "Order Summary\n";
        $receipt_content .= "-----------------\n";
        $receipt_content .= "Receiptient's Name: " . $recep_name . "\n";
        $receipt_content .= "Medicine: " . $med_choice . "\n";
        $receipt_content .= "MG: " . $mg_choice . "\n";
        $receipt_content .= "Quantity: " . $qty . "\n";
        $receipt_content .= "Price per Piece: ₱" . number_format($price, 2) . "\n";
        $receipt_content .= "Total Price: ₱" . number_format($total_price, 2) . "\n";
        $receipt_content .= "\n";
        $receipt_content .= "Thank You";
    return $receipt_content;
    }

    function saveReceiptToFile($recep_name, $receipt_content) {
        $filename = "transaction/" . $recep_name ."_order_Summary". ".txt";
        $file = fopen($filename, "w") or die("unable to open File");

        fwrite($file, $receipt_content);
        
        fclose($file);

        echo"<center><b>Receipt created Sucessfully, saved in transaction as ". $recep_name."_order_Summary". ".txt</b></center>" ;
    }
        displayOrderSummary();
    function insertToDatabase($recep_name, $med_choice, $med_prices, $mg_choice, $mg_prices, $qty, $price){
            include "../database/db_conn.php";

            try{
                $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);

                 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                 $stmt = $conn->prepare("INSERT INTO orders(recep_name, med, size, qty, price) VALUES (:recep_name,:med, :size, :qty, :price)");

                 $stmt->bindParam(':recep_name', $recep_name);
                 $stmt->bindParam(':med', $med_choice);
                 $stmt->bindParam(':size', $mg_choice);
                 $stmt->bindParam(':qty', $qty);
                 $stmt->bindParam(':price', $price);

                 $stmt->execute();
                 echo "<script>alert('Order details inserted into the database successfully!');</script>";
                 echo "<a href='../pages/index.php' class='btn btn-primary btn-lg btn-block'>OK</a><br/>";
            }
            catch(PDOException $e){
                 echo "Error: " . $e->getMessage();
            }
    }
    
    $conn=null;

    include "../css/footer.php";
?>
<!doctype html>
<html lang="en">
  <head>
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Checkout Form</title>
  </head>
  <style>
    #container1{
        border: 2px solid black;
    }
    #container1 : form {
        
        display: flex;
        justify-content: center;
        align-items: center
    }
    #container2{
        border: 2px solid black;
    }
    .row , .mess {
        display: flex;
        justify-content: center;
        align-items: center
    }
  </style>
  <body>
    
    <div class="container" id="container1">
    <center><h2 class="mb-3">Order Form</h2></center>
      <form class="needs-validation" novalidate method="POST" action="">
        <div class="row">
          <div class="col-md-9 mb-3">
            <input type="text" class="form-control" name="receiptient_name"id="receiptient_name" placeholder="Receiptient's name" value="" required>
          </div>
          <div class="col-md-9 mb-3">
           <select name="med" id="med">
            <option value="saridon">Saridon</option>
            <option value="biogesic">Biogesic</option>
           </select>
          </div>
          <div class="col-md-9 mb-3">
            <input type="radio" name="mg" id="mg" value="500mg">
            <label for="500mg">500MG</label>
            <input type="radio" name="mg" value="250mg">
            <label for="250mg">250MG</label>
          </div>
          <div class="col-md-9 mb-3">
            <label for="quantity">Quantity</label>
            <input type="number" name="qty">
          </div>
        </div>
        <hr class="mb-4">
        <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button><br/>
      </form>
    </div>
    <?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    

    $med_pic = [
        "saridon" => "img/saridon_pic_2mb.jpg",
        "biogesic" => "img/biogesic_pic_.jpg",
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

    // Calculates the initial total price by adding the selected medicine type's price to the selected size's price 
    $price = 0;
$total_price = 0;

if(isset($med_prices[$med_choice], $mg_prices[$mg_choice])){
    $price= $med_prices[$med_choice] + $mg_prices[$mg_choice]*$med_prices[$med_choice];
    if (isset($qty) && $qty > 0) {
        $total_price = $price*$qty;
    }
}
   

    $med_pic_choice = $med_pic[$med_choice];
    echo "";
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

    
    echo"<center><a href='index.php' class='btn btn-primary'>New Transaction</a></center><br/>";
    echo"</div>";


}
// htmlspecialchars & number_format is not working
// for each
?>

  </body>
</html>


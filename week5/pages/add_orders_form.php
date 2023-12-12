<?php
    include "../css/header.php";
?>
    
    <div class="container" id="container1">
    <center><h2 class="mb-3">Order Form</h2></center>
      <form class="needs-validation" novalidate method="POST" action="../actions/add_orders.php">
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
            <a href="../pages/index.php" class="btn btn-primary btn-lg btn-block">Cancel</a><br/>
      </form>
</div>
    


<?php
    include "../css/footer.php";
    ?>




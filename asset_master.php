<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("location: login.html");
    exit;
}

include "connection.php";

if(isset($_POST['submit'])){
    $asset_type = $_POST["asset_type"];
    $asset_sn = $_POST["asset_sn"];
    $asset_model = $_POST["asset_model"];
    $asset_description = $_POST["asset_description"];
    $asset_accessories = $_POST["asset_accessories"];
    $asset_warranty = $_POST["asset_warranty"];
    $acquisition_date = $_POST["acquisition_date"];
    $acquisition_cost = $_POST["acquisition_cost"];
    $accumulated_dec = $_POST["accumulated_dec"];
    $net_book_value = $_POST["net_book_value"];
    $license = $_POST["license"];
    $asset_status = $_POST["asset_status"];
    
    $q = "INSERT INTO `asset` 
          (`asset_type`, `asset_sn`, `asset_model`, `asset_description`, `asset_accessories`, 
          `asset_warranty`, `acquisition_date`, `acquisition_cost`, `accumulated_dec`, 
          `net_book_value`, `license`, `asset_status`) 
          VALUES 
          ('$asset_type', '$asset_sn', '$asset_model', '$asset_description', '$asset_accessories', 
          '$asset_warranty', '$acquisition_date', '$acquisition_cost', '$accumulated_dec', 
          '$net_book_value', '$license', '$asset_status')";

    $result = $conn->query($q);

    if ($result) {
        echo " ";
    } else {
        echo "Error: " . $q . "<br>" . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>It Asset Management</title>
      <link rel="stylesheet" href="style.css">
      <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
   <body>
   <?php $IPATH = $_SERVER["DOCUMENT_ROOT"]."/asset/";
       include($IPATH."headernav.html") 
    ?>

<div class="card-container2">
<div class="col-lg-6 m-auto" >
            <form method="post" action="">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h1 class="text-white text-center">ADD ASSET INFO</h1>
                    </div>

                    <label for="asset_type">Asset Type:</label>
                    <select class="drop-list" name="asset_type" id="asset_type">
                     <option>Moniter</option>
                     <option>Laptop</option>
                     <option>Mouse</option>
                     <option>Printer</option>
                     <option>GPU</option>
                     <option>Tablet</option>
                    </select>

                    <label>Asset Serial No.:</label>
                    <input type="text" name="asset_sn" class="form-control">

                    <label>Asset Model:</label>
                    <input type="text" name="asset_model" class="form-control">

                    <label>Asset Description:</label>
                    <input type="text" name="asset_description" class="form-control">

                    <label>Asset Accessories:</label>
                    <input type="text" name="asset_accessories" class="form-control">

                    <label>Asset Warranty:</label>
                    <input type="text" name="asset_warranty" class="form-control">

                    <label>Acquisition Date:</label>
                    <input type="date" name="acquisition_date" class="form-control">

                    <label>Acquisition Cost:</label>
                    <input type="int" name="acquisition_cost" class="form-control">

                    <label>Accumulated Description:</label>
                    <input type="text" name="accumulated_dec" class="form-control">

                    <label>Net Book Value:</label>
                    <input type="int" name="net_book_value" class="form-control">

                    <label>License:</label>
                    <input type="text" name="license" class="form-control">

                    <label for="asset_status">Asset Status:</label>
                    <select name="asset_status" id="asset_status">
                     <option>Active</option>
                     <option selected>In-Stock</option>
                     <option>Repair</option>
                     <option>Scrap</option>
                    </select>


                    <button class="btn btn-success" type="submit" name="submit">Submit</button>
                    <a class="btn btn-info" href="adminindex.php">Cancel</a>
                </div>
            </form>
    </div>        
</div>
    
</body>
</html>
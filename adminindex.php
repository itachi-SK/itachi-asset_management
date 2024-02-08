<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("location: login.html");
    exit;
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
   <!-- Asset Table -->
<br>
   <div id="assetTable">
    <div class="container my-4">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Serial No.</th>
                <th>Model</th>
                <th>Description</th>
                <th>Accessories</th> 
                <th>Warranty</th>
                <th>Acquisition Date</th>
                <th>Acquisition Cost</th>
                <th>Accumulated Dec.</th>
                <th>Net Book Value</th>
                <th>License</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "connection.php";
            $sql = "SELECT * FROM asset";
            $result = $conn->query($sql);

            if (!$result) {
                die("Invalid query!");
            }

            while ($row = $result->fetch_assoc()) {
                echo "
                <tr>
                    <td>{$row['id']}</td>
                    <td>{$row['asset_type']}</td>
                    <td>{$row['asset_sn']}</td>
                    <td>{$row['asset_model']}</td>
                    <td>{$row['asset_description']}</td>
                    <td>{$row['asset_accessories']}</td>
                    <td>{$row['asset_warranty']}</td>
                    <td>{$row['acquisition_date']}</td>
                    <td>{$row['acquisition_cost']}</td>
                    <td>{$row['accumulated_dec']}</td>
                    <td>{$row['net_book_value']}</td>
                    <td>{$row['license']}</td>
                    <td>{$row['asset_status']}</td>
                    <td>
                    <a class='btn btn-success' href='edit_asset.php?id={$row['id']}'>Edit</a>
                    <br>
                    <br>
                    <a class='btn btn-danger' onClick=\" javascript:return confirm('Are You Sure to Delete, This Can Not be Undo'); \" href='delete_asset.php?id={$row['id']}'>Delete</a>
                    </td>
                </tr>
                ";
            }            
            ?>
        </tbody>
    </table>
        </div>
     </div>
   </div> 

</body>

</html>
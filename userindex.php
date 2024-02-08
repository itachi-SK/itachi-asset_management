<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("location: login.html");
    exit;
}

include "connection.php";
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
    <?php
    $IPATH = $_SERVER["DOCUMENT_ROOT"]."/asset/";
    include($IPATH."usernav.html") 
    ?>

    <div class="heading h1-head">
        <h1>Allocated Assets</h1>
    </div>
    
    <!-- Reallocation Table -->
    <div id="reallocationTable">
        <div class="container my-4">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Allocation Date:</th>
                        <th>Reason For Allocation:</th>
                        <th>Asset Name:</th>
                        <th>Serial No.</th>
                        <th>Model</th>
                        <th>Accessories</th> 
                        <th>Warranty</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "connection.php";
                    $username = $_SESSION["username"];
                    $sql = "SELECT * FROM allocated_asset WHERE username = '$username'";
                    $result = $conn->query($sql);

                    if (!$result) {
                        die("Invalid query!");
                    }

                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>{$row['id']}</td>
                            <td>{$row['allocation_date']}</td>
                            <td>{$row['reason_asset']}</td>
                            <td>{$row['asset_type']}</td>
                            <td>{$row['asset_sn']}</td>
                            <td>{$row['asset_model']}</td>
                            <td>{$row['asset_accessories']}</td>
                            <td>{$row['asset_warranty']}</td>
                        </tr>
                        ";
                    }            
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

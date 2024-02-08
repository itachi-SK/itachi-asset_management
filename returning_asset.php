<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("location: login.html");
    exit;
}

include "connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $returnnigAssetId = $_GET["id"];

    // Fetch data from returning_asset table
    $selectSql = "SELECT * FROM returnnig_asset WHERE id = $returnnigAssetId";
    $result = $conn->query($selectSql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Delete from allocated_asset table
        $deleteSql = "DELETE FROM allocated_asset WHERE id = $returnnigAssetId";
        $deleteResult = $conn->query($deleteSql);

        if ($deleteResult) {
            // Update asset status in the asset table to 'In-Stock'
            $updateAssetSql = "UPDATE asset SET asset_status = 'In-Stock' WHERE asset_sn = '{$row['asset_sn']}'";
            $updateAssetResult = $conn->query($updateAssetSql);

            if ($updateAssetResult) {
                echo " ";
            } else {
                echo "Error updating asset status: " . $conn->error;
            }
        } else {
            echo "Error deleting allocation: " . $conn->error;
        }
    } else {
        echo "Invalid allocated asset ID.";
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
    <?php
    $IPATH = $_SERVER["DOCUMENT_ROOT"]."/asset/";
    include($IPATH."headernav.html") 
    ?>

    <div class="heading h1-head">
        <h1>Returning Assets</h1>
    </div>

    <!-- Returning Asset Table -->
    <div id="returningAssetTable">
        <div class="container my-4">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Employee Name:</th>
                        <th>Designation:</th>
                        <th>Employee Email:</th>
                        <th>Employee Phone:</th>
                        <th>Site Name:</th>
                        <th>Allocation Date:</th>
                        <th>Reason For Allocation:</th>
                        <th>Asset Name:</th>
                        <th>Serial No.</th>
                        <th>Model</th>
                        <th>Accessories</th> 
                        <th>Reason For Return</th>
                        <th>Feedback</th>
                        <th>Return Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM returnnig_asset";
                    $result = $conn->query($sql);

                    if (!$result) {
                        die("Invalid query!");
                    }

                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>{$row['id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['emp_name']}</td>
                            <td>{$row['emp_designation']}</td>
                            <td>{$row['emp_email']}</td>
                            <td>{$row['emp_phone']}</td>
                            <td>{$row['site_name']}</td>
                            <td>{$row['allocation_date']}</td>
                            <td>{$row['reason_asset']}</td>
                            <td>{$row['asset_type']}</td>
                            <td>{$row['asset_sn']}</td>
                            <td>{$row['asset_model']}</td>
                            <td>{$row['asset_accessories']}</td>
                            <td>{$row['reason_return']}</td>
                            <td>{$row['feedback']}</td>
                            <td>{$row['return_date']}</td>
                            <td>
                                <a class='btn btn-success' onClick=\"return confirm('Are you sure the asset was returned?')\" href='returning_asset.php?id={$row['id']}'>Accept</a>
                            </td>
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
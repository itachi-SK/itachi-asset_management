<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("location: login.html");
    exit;
}

include "connection.php"; // Include the database connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeId = $_POST["employee_id"];
    $assetId = $_POST["asset_id"];
    $allocationDate = $_POST["allocation_date"];
    $reasonAsset = $_POST["reason_asset"];

    // Fetch employee details
    $employeeSql = "SELECT emp_name, emp_designation, emp_email, emp_phone, site_name FROM employee WHERE id = $employeeId";
    $employeeResult = $conn->query($employeeSql);
    $employeeRow = $employeeResult->fetch_assoc();

    // Fetch asset details
    $assetSql = "SELECT asset_type, asset_sn, asset_model, asset_accessories, asset_warranty FROM asset WHERE id = $assetId";
    $assetResult = $conn->query($assetSql);
    $assetRow = $assetResult->fetch_assoc();

    // Insert data into allocated_asset table
    $insertSql = "INSERT INTO allocated_asset (emp_name, emp_designation, emp_email, emp_phone, site_name, allocation_date, reason_asset, asset_type, asset_sn, asset_model, asset_accessories, asset_warranty)
                  VALUES ('{$employeeRow['emp_name']}', '{$employeeRow['emp_designation']}', '{$employeeRow['emp_email']}', '{$employeeRow['emp_phone']}', '{$employeeRow['site_name']}', '$allocationDate', '$reasonAsset', '{$assetRow['asset_type']}', '{$assetRow['asset_sn']}', '{$assetRow['asset_model']}', '{$assetRow['asset_accessories']}', '{$assetRow['asset_warranty']}')";

    $insertResult = $conn->query($insertSql);

    if ($insertResult) {
        // Update asset status in the asset table to 'Active'
        $updateAssetSql = "UPDATE asset SET asset_status = 'Active' WHERE id = $assetId";
        $updateAssetResult = $conn->query($updateAssetSql);

    } 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asset Reallocation Form</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
    <?php $IPATH = $_SERVER["DOCUMENT_ROOT"] . "/asset/";
    include($IPATH . "headernav.html") ?>

    <div id="reallocateTableContainer" class="card-container1">
        <div class="col-lg-6 m-auto">
            <form method="POST" action="">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h1 class="text-white text-center">Reallocation Form</h1>
                    </div>
                    <label for="employee_id">Select Employee:</label>
                    <select name="employee_id">
                        <?php
                        // Fetch and display employees from the database
                        $employeeSql = "SELECT id, emp_name FROM employee";
                        $employeeResult = $conn->query($employeeSql);

                        while ($employeeRow = $employeeResult->fetch_assoc()) {
                            $selected = ($employeeRow['id'] == $employeeId) ? 'selected' : '';
                            echo "<option value='" . $employeeRow['id'] . "' $selected>" . $employeeRow['emp_name'] . "</option>";
                        }
                        ?>
                    </select>

                    <br>

                    <label for="asset_id">Select Asset:</label>
                    <select name="asset_id">
                        <?php
                        // Fetch and display unallocated assets from the database
                        $assetSql = "SELECT id, asset_type FROM asset WHERE asset_status = 'In-Stock'";
                        $assetResult = $conn->query($assetSql);

                        while ($assetRow = $assetResult->fetch_assoc()) {
                            $selected = ($assetRow['id'] == $assetId) ? 'selected' : '';
                            echo "<option value='" . $assetRow['id'] . "' $selected>" . $assetRow['asset_type'] . "</option>";
                        }
                        ?>
                    </select>

                    <br>

                    <label for="allocation_date">Allocation Date:</label>
                    <input type="date" id="allocation_date" name="allocation_date" value="<?php echo $allocationDate; ?>" required>

                    <br>

                    <label for="reason_asset">Reason for Asset Allocation:</label>
                    <select name="reason_asset" id="reason_asset" class="form-control">
                        <?php
                        $reasons = ['New Joinee', 'Upgrade', 'Requested'];
                        foreach ($reasons as $reason) {
                            $selected = ($reason == $reasonAsset) ? 'selected' : '';
                            echo "<option $selected>$reason</option>";
                        }
                        ?>
                    </select>

                    <br>
                    <br>
                    <input type="submit" value="Allocate Asset">
                </div>
            </form>
        </div>
    </div>
</body>

</html>

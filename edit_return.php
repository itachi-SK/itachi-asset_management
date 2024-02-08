<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("location: login.html");
    exit;
}

include "connection.php"; // Include the database connection

// Fetch data based on the id parameter in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM allocated_asset WHERE id = '$id'";
    $result = $conn->query($sql);

    // Check if the result is not empty
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Extract data from the fetched row
        $username = $row['username'];
        $emp_name = $row['emp_name'];
        $emp_designation = $row['emp_designation'];
        $emp_email = $row['emp_email'];
        $emp_phone = $row['emp_phone'];
        $site_name = $row['site_name'];
        $allocation_date = $row['allocation_date'];
        $reason_asset = $row['reason_asset'];
        $asset_type = $row['asset_type'];
        $asset_sn = $row['asset_sn'];
        $asset_model = $row['asset_model'];
        $asset_accessories = $row['asset_accessories'];
    } else {
        // Handle error if no data found for the given id
        echo "Error: No data found for the specified ID.";
        exit;
    }
} else {
    // Handle error if id parameter is not set in the URL
    echo "Error: ID parameter is missing in the URL.";
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the submitted form
    $return_date = $_POST["return_date"];
    $reason_return = $_POST["reason_return"];
    $feedback = $_POST["feedback"];

    // Insert data into the returning_asset table
    $insertSql = "INSERT INTO returnnig_asset (id, username, emp_name, emp_designation, emp_email, emp_phone, site_name, allocation_date, reason_asset, asset_type, asset_sn, asset_model, asset_accessories, reason_return, feedback, return_date) 
    VALUES ('$id', '$username', '$emp_name', '$emp_designation', '$emp_email', '$emp_phone', '$site_name', '$allocation_date', '$reason_asset', '$asset_type', '$asset_sn', '$asset_model', '$asset_accessories', '$reason_return', '$feedback', '$return_date')";

    if ($conn->query($insertSql) === TRUE) {
        // Redirect to the return_asset.php page after successful submission
        header("location: return_asset.php");
        exit;
    } else {
        echo "Error: " . $insertSql . "<br>" . $conn->error;
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
       include($IPATH."usernav.html") 
    ?>

    <!-- Edit Table -->

   <div id="editTableContainer" class="card-container2">
        <div class="col-lg-6 m-auto">
            <form method="post" action=" ">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h1 class="text-white text-center">Return Asset</h1>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $id; ?>" class="form-control">

                    <label>Username:</label>
                    <input type="text" name="username" value="<?php echo $username; ?>" class="form-control" readonly>

                    <label>Employee Name:</label>
                    <input type="text" name="emp_name" value="<?php echo $emp_name; ?>" class="form-control" readonly>

                    <label>Employee Designation:</label>
                    <input type="text" name="emp_designation" value="<?php echo $emp_designation; ?>" class="form-control" readonly>

                    <label>Email:</label>
                    <input type="text" name="emp_email" value="<?php echo $emp_email; ?>" class="form-control" readonly>

                    <label>Phone No.:</label>
                    <input type="text" name="emp_phone" value="<?php echo $emp_phone; ?>" class="form-control" readonly>

                    <label>Site Name:</label>
                    <input type="text" name="site_name" value="<?php echo $site_name; ?>" class="form-control" readonly>
                    
                    <label>Allocated Date:</label>
                    <input type="text" name="allocation_date" value="<?php echo $allocation_date; ?>" class="form-control" readonly>

                    <label>Reason For Allocation:</label>
                    <input type="text" name="reason_asset" value="<?php echo $reason_asset; ?>" class="form-control" readonly>

                    <label>Asset Name:</label>
                    <input type="text" name="asset_type" value="<?php echo $asset_type; ?>" class="form-control" readonly>

                    <label>Asset Serial No.:</label>
                    <input type="text" name="asset_sn" value="<?php echo $asset_sn; ?>" class="form-control" readonly>

                    <label>Asset Model:</label>
                    <input type="text" name="asset_model" value="<?php echo $asset_model; ?>" class="form-control" readonly>

                    <label>Asset Accessories:</label>
                    <input type="text" name="asset_accessories" value="<?php echo $asset_accessories; ?>" class="form-control" readonly>
                    
                    <label for="reason_return">Reason For Return:</label>
                    <select name="reason_return" id="reason_return" class="form-control">
                     <option>Upgrade</option>
                     <option>Issue</option>
                     <option>Resignation</option>
                     <option>No need</option>
                    </select>

                    <label>Feedback:</label>
                    <input type="text" name="feedback" class="form-control">

                    <label>Returing Date:</label>
                    <input type="date" name="return_date"  class="form-control">                    

                    <button class="btn btn-success" type="submit" name="submit">Submit</button>
                    <a class="btn btn-info" href="return_asset.php">Cancel</a>
                
                </div>
            </form>
        </div>
    </div>
</body>

</html>   
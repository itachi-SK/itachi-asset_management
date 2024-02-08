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
<br>
<div id="assetTable">
            <div class="container my-4">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Designation</th>
                <th>Site Name</th> 
                <th>Username</th>
                <th>Password</th>
                <th>User Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "connection.php";
            $sql = "SELECT * FROM employee";
            $result = $conn->query($sql);

            if (!$result) {
                die("Invalid query!");
            }

            while ($row = $result->fetch_assoc()) {
                echo "
                <tr>
                    <td>{$row['id']}</td>
                    <td>{$row['emp_name']}</td>
                    <td>{$row['emp_email']}</td>
                    <td>{$row['emp_phone']}</td>
                    <td>{$row['emp_designation']}</td>
                    <td>{$row['site_name']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['password']}</td>
                    <td>{$row['usertype']}</td>
                    <td>{$row['emp_status']}</td>
                    <td>
                        <a class='btn btn-success' href='edit_emp.php?id={$row['id']}'>Edit</a>
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
<center><a class="btn-blue" href="add_emp.php">Add Employee</a></center>
</body>

</html>
<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("location: login.html");
    exit;
}

?>

<?php
include "connection.php";

$id = "";
$emp_name = "";
$emp_email = "";
$emp_phone = "";
$emp_designation = "";
$site_name = "";
$username = "";
$password = "";
$usertype = "";
$emp_status = "";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    if (!isset($_GET['id'])) {
        header("location: emp.php");
        exit;
    }
    $id = $_GET['id'];
    $sql = "SELECT * FROM employee WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: emp.php");
        exit;
    }

    $emp_name = $row["emp_name"];
    $emp_email = $row["emp_email"];
    $emp_phone = $row["emp_phone"];
    $emp_designation = $row["emp_designation"];
    $site_name = $row["site_name"];
    $username = $row["username"];
    $password = $row["password"];
    $usertype = $row["usertype"];
    $emp_status = $row["emp_status"];
} else {
    $id = $_POST["id"];
    $emp_name = $_POST["emp_name"];
    $emp_email = $_POST["emp_email"];
    $emp_phone = $_POST["emp_phone"];
    $emp_designation = $_POST["emp_designation"];
    $site_name = $_POST["site_name"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $usertype = $_POST["usertype"];
    $emp_status = $_POST["emp_status"];

    $sql = "UPDATE employee SET 
            emp_name='$emp_name',
            emp_email='$emp_email',
            emp_phone='$emp_phone',
            emp_designation='$emp_designation',
            site_name='$site_name',
            username='$username',
            password='$password',
            usertype='$usertype',
            emp_status='$emp_status'
            WHERE id='$id'";
    $result = $conn->query($sql);
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

    <!-- Edit Table -->

   <div id="editTableContainer" class="card-container">
        <div class="col-lg-6 m-auto">
            <form method="post" action=" ">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h1 class="text-white text-center">Update Employee INFO</h1>
                    </div>

                    <input type="hidden" name="id" value="<?php echo $id; ?>" class="form-control">

                    <label>Name:</label>
                    <input type="text" name="emp_name" value="<?php echo $emp_name; ?>" class="form-control">

                    <label>Email ID:</label>
                    <input type="text" name="emp_email" value="<?php echo $emp_email; ?>" class="form-control">

                    <label>Phone:</label>
                    <input type="int" name="emp_phone" value="<?php echo $emp_phone; ?>" class="form-control">

                    <label>Designation:</label>
                    <input type="text" name="emp_designation" value="<?php echo $emp_designation; ?>" class="form-control">
                    
                    <label for="site_name">Site Name:</label>
                    <select name="site_name" id="site_name" value="<?php echo $site_name; ?>" class="form-control">
                     <option>Quesscorp</option>
                     <option>ITC Limited</option>
                     <option>CCCL - Kallur</option>
                     <option>TCS</option>
                     <option>UAIL - TIKIRI</option>
                     <option>TSL - Coke Oven</option>
                    </select>

                    <label>Username:</label>
                    <input type="text" name="username" value="<?php echo $username; ?>" class="form-control">

                    <label>Password:</label>
                    <input type="text" name="password" value="<?php echo $password; ?>" class="form-control">

                    <label for="usertype">User Type:</label>                    
                    <select name="usertype" id="usertype" value="<?php echo $usertype; ?>" class="form-control">
                     <option>Admin</option>
                     <option selected>User</option>
                    </select>

                    <label for="emp_status">Status:</label>
                    <select name="emp_status" id="emp_status" value="<?php echo $emp_status; ?>" class="form-control">
                     <option>Inactive</option>
                     <option selected>Active</option>
                    </select>

                    <button class="btn btn-success" type="submit" name="submit">Submit</button>
                    <a class="btn btn-info" href="emp.php">Cancel</a>
                
                </div>
            </form>
        </div>
    </div>
</body>

</html>   
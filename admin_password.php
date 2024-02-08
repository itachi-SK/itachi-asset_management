<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("location: login.html");
    exit;
}

include "connection.php";

function validatePassword($password) {
    // Define the password pattern using regex
    $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,16}$/";
    
    // Check if the password matches the pattern
    return preg_match($pattern, $password);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldPassword = $_POST["old_password"];
    $newPassword = $_POST["new_password"];
    $confirmNewPassword = $_POST["confirm_new_password"];

    // Get the current user's stored password from the database
    $username = $_SESSION["username"];
    $query = "SELECT password FROM employee WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $currentPassword = $row["password"];

    // Check if the old password matches the stored password
    if ($oldPassword == $currentPassword) {
        // Check if the new password matches the confirm new password
        if ($newPassword == $confirmNewPassword) {
            // Check if the new password meets the specified conditions
            if (validatePassword($newPassword)) {
                // Update the password in the database
                $updateQuery = "UPDATE employee SET password = '$newPassword' WHERE username = '$username'";
                mysqli_query($conn, $updateQuery);
                echo "<script>alert('Password changed successfully!');</script>";
            } else {
                echo "<script>alert('New password must have at least one lowercase letter, one uppercase letter, one number, and be 8 to 16 characters long.');</script>";
            }
        } else {
            echo "<script>alert('New password and confirm new password do not match.');</script>";
        }
    } else {
        echo "<script>alert('Incorrect old password.');</script>";
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

    <div id="changepasswordContainer" class="card-container1">
    <div class="col-lg-6 m-auto">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="card">
        <div class="card-header bg-warning">
            <h1 class="text-white text-center">Change Password</h1>
        </div>
        <label for="old_password">Old Password:</label>
        <input type="password" name="old_password" required>

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>

        <label for="confirm_new_password">Confirm New Password:</label>
        <input type="password" name="confirm_new_password" required>
        <br>
        <br>
        <button  class="btn btn-success" type="submit">Change Password</button>
    </div>
    </form>
    </div>
</div>
</body>

</html>
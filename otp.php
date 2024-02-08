<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userEnteredOTP = $_POST["otp"];
    $storedOTP = $_SESSION["otp"];

    if ($userEnteredOTP == $storedOTP) {
        // OTP is correct, proceed to determine user type and redirect
        $username = $_SESSION["username"];

        $host = "localhost";
        $user = "root";
        $password = "";
        $db = "it_asset_ticket";

        $data = mysqli_connect($host, $user, $password, $db);

        if ($data === false) {
            die("Connection error");
        }

        $sql = "SELECT usertype FROM employee WHERE username='" . $username . "'";
        $result = mysqli_query($data, $sql);
        $row = mysqli_fetch_array($result);

        if ($row) {
            if ($row["usertype"] == "Admin") {
                // Redirect to adminindex.php for Admin
                header("location: adminindex.php");
                exit();
            } elseif ($row["usertype"] == "User") {
                // Redirect to userindex.php for User
                header("location: userindex.php");
                exit();
            }
        } else {
            echo "<script>alert('User not found.');</script>";
        }
    } else {
        echo "<script>alert('Incorrect OTP. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="otp-page">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>OTP Verification</title>
</head>
<body class="otp">
    <div class="login-container">
        <div class="form-wrapper"> 
            <form method="post" action="otp.php">
            <h1>Verification <i class='bx bx-shield'></i></h1>
            <div class="form-group">
                <input type="text" name="otp" placeholder="Enter OTP" required><i class='bx bxs-lock'></i>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Verify OTP</button>
            </div>
            </form>
        </div>
    </div>
</body>
</html>

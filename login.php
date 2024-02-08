<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$host = "localhost";
$user = "root";
$password = "";
$db = "it_asset_ticket";

session_start();

$data = mysqli_connect($host, $user, $password, $db);

if ($data === false) {
    die("Connection error");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM employee WHERE username='" . $username . "' AND password='" . $password . "'";
    $result = mysqli_query($data, $sql);
    $row = mysqli_fetch_array($result);

    if ($row) {
        // Generate OTP
        $otp = mt_rand(100000, 999999);

        // Store OTP and username in the session
        $_SESSION["otp"] = $otp;
        $_SESSION["username"] = $username;

        // Send OTP to the user's email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'skkumar02pubg@gmail.com';
            $mail->Password = 'oopw zpzn snfh bvtl';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('skkumar02pubg@gmail.com', 'Asset Management');
            $mail->addAddress($row['emp_email'], $row['emp_name']);
            $mail->isHTML(true);
            $mail->Subject = 'OTP Verification';
            $mail->Body = 'Your OTP is: ' . $otp;

            $mail->send();

            echo 'OTP sent successfully.';

            // Redirect to OTP verification page
            header("location: otp.php");
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    } else {
        echo "<script>alert('Username or password incorrect.');</script>";
    }
}
?>

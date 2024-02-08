<?php
session_start();

// Include PHPMailer autoloader
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION["username"])) {
    header("location: login.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    include "connection.php";
    
    $emp_name = $_POST["emp_name"];
    $emp_email = $_POST["emp_email"];
    $emp_phone = $_POST["emp_phone"];
    $emp_designation = $_POST["emp_designation"];
    $site_name = $_POST["site_name"];
    
    // Generate random username
    $username = generateRandomString(6);
    
    // Generate random password
    $password = generateRandomPassword();
    
    $usertype = $_POST["usertype"];
    $emp_status = $_POST["emp_status"];
    
    $q = "INSERT INTO `employee` 
          (`emp_name`, `emp_email`, `emp_phone`, `emp_designation`, `site_name`, 
          `username`, `password`, `usertype`, `emp_status`) 
          VALUES 
          ('$emp_name', '$emp_email', '$emp_phone', '$emp_designation', '$site_name', 
          '$username', '$password', '$usertype', '$emp_status')";
          
    if ($conn->query($q) === TRUE) {
        // Send email containing username and password
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'skkumar02pubg@gmail.com'; // SMTP username
            $mail->Password = 'oopw zpzn snfh bvtl'; // SMTP password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('skkumar02pubg@gmail.com', 'Asset Management');
            $mail->addAddress($emp_email, $emp_name); // Add a recipient

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Asset Management login details';
            $mail->Body    = 'Username: ' . $username . '<br>Password: ' . $password;

            $mail->send();
            echo 'Email message has been sent successfully!';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        // Redirect to the employee list page
        header("location: add_emp.php");
        exit;
    } else {
        echo "Error: " . $q . "<br>" . $conn->error;
    }
}

function generateRandomString($length) {
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function generateRandomPassword() {
    $password = '';
    $password .= chr(rand(97, 122)); // lowercase letter
    $password .= chr(rand(65, 90));  // uppercase letter
    $password .= chr(rand(48, 57));  // number
    $password .= chr(rand(33, 38));  // special character !@#$&
    $password .= chr(rand(42, 42));  // special character * (optional)
    $password .= chr(rand(0, 9));    // additional number (optional)
    $password .= chr(rand(97, 122)); // additional lowercase letter (optional)
    $password .= chr(rand(65, 90));  // additional uppercase letter (optional)
    return str_shuffle($password);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>It Asset Management - Add Employee</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
    <?php
    $IPATH = $_SERVER["DOCUMENT_ROOT"] . "/asset/";
    include($IPATH . "headernav.html")
    ?>

    <!-- Add Employee Form -->
    <div class="card-container">
<div class="col-lg-6 m-auto" >
            <form method="post" action="">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h1 class="text-white text-center">ADD ASSET INFO</h1>
                    </div>
                
                <label for="emp_name">Employee Name:</label>
                <input type="text" class="form-control" id="emp_name" name="emp_name" required>
    
                <label for="emp_email">Employee Email:</label>
                <input type="email" class="form-control" id="emp_email" name="emp_email" required>
            
                <label for="emp_phone">Employee Phone:</label>
                <input type="text" class="form-control" id="emp_phone" name="emp_phone" required>

                <label for="emp_designation">Employee Designation:</label>
                <select class="form-control" id="emp_designation" name="emp_designation" required>
                    <option>Chief Architect</option>
                    <option>Intern Software Developer</option>
                    <option>Junior Software Developer</option>
                    <option>Principal Software Engineer</option>
                    <option>Project Manager</option>
                    <option>Senior Software Engineer/Senior Software Developer</option>
                    <option>Software Architect</option>
                    <option>Software Developer</option>
                    <option>Software Engineer</option>
                    <option>Team Lead</option>
                </select>

            
                <label for="site_name">Site Name:</label>
                <select class="form-control" id="site_name" name="site_name" required>
                    <option>Quesscorp</option>
                    <option>Wipro</option>
                    <option>TATA Water</option>
                    <option>TATA Power</option>
                </select>
            
                <label for="usertype">User Type:</label>
                <select class="form-control" id="usertype" name="usertype" required>
                    <option>Admin</option>
                    <option>User</option>
                </select>
    
                <label for="emp_status">Employee Status:</label>
                <select class="form-control" id="emp_status" name="emp_status" required>
                    <option>Active</option>
                    <option>Inactive</option>
                </select>
            <br>
            <br>
                <button class="btn btn-success" type="submit" name="submit">Submit</button>
                <a class="btn btn-info" href="emp.php">Cancel</a>
            </div>
            </form>
    </div>        
</div>
    
</body>
</html>
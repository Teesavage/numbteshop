<?php

$name = $_POST["name"];
$contact = $_POST["phone"];
$email = $_POST["email"];
$size = filter_input(INPUT_POST, "size", FILTER_VALIDATE_INT);
$message = $_POST["message"];


$host = "localhost";
$dbname = "numbteshop";
$username = "root";
$password = "";
        
$conn = mysqli_connect(hostname: $host,
                       username: $username,
                       password: $password,
                       database: $dbname);
        
if (mysqli_connect_errno()) {
    die("Connection error: " . mysqli_connect_error());
}           
        
$sql = "INSERT INTO numbteorder (name, contact, email, size, message)
        VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_stmt_init($conn);

if ( ! mysqli_stmt_prepare($stmt, $sql)) {
 
    die(mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "sssis",
                       $name,
                       $contact,
                       $email,
                       $size,
                       $message);

mysqli_stmt_execute($stmt);




require "mailer-vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = "ssl";
$mail->Port = 465;

$mail->Username = "numbteshop@gmail.com";
$mail->Password = "hiddenpassword";

$mail->setFrom($email, $name);
$mail->addAddress("numbte@gmail.com");
$mail->addReplyTo($email, $name);
$mail->isHTML(true);


$mail->Subject = "New Shoe5 Order From Numbteshop";
$mail->Body = "$message.\n"."Size \n $size.\n"."$contact.";


$mail->send();



echo  '<script>
alert("Order Placed Successfully! Please proceed to make payment.")
window.location.href = "paymentpage.html";
</script>';


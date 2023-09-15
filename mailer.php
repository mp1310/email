<?php
require 'vendor/autoload.php'; // Include PHPMailer autoload file

// Establish a database connection (Update with your database credentials)
$host = "localhost";
$username = "root";
$password = "";
$database = "mailer";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = $_POST["to"];
    $cc = $_POST["cc"];
    $bcc = $_POST["bcc"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    
    // Handle file upload (if provided)
    $file_path = "";
    if ($_FILES["file"]["error"] == 0) {
        $file_name = $_FILES["file"]["name"];
        $file_temp = $_FILES["file"]["tmp_name"];
        $file_path = "uploads/" . $file_name; // Upload files to a directory named "uploads"
        move_uploaded_file($file_temp, $file_path);
    }

    // Insert data into the database
    $sql = "INSERT INTO email_form (to_email, cc_email, bcc_email, subject, message, file_path)
            VALUES ('$to', '$cc', '$bcc', '$subject', '$message', '$file_path')";

    if ($conn->query($sql) === TRUE) {
        // Send email using PHPMailer
        $mail = new PHPMailer\PHPMailer\PHPMailer();

        // SMTP Configuration (Update with your SMTP settings)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';        // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'mallup232@gmail.com'; // SMTP username
        $mail->Password = 'egng ywrg lcbz wowq'; // SMTP password

        $mail->Port = 587; // SMTP port (usually 587 for TLS)

        // Email Content
        $mail->setFrom('mallup232@gmail.com', 'Mallu'); // Sender's email and name
        $mail->addAddress($to); // Recipient's email
        $mail->addCC($cc); // CC email
        $mail->addBCC($bcc); // BCC email
        $mail->Subject = $subject; // Email subject
        $mail->Body = $message; // Email message
        $mail->addAttachment($file_path); // Attach the uploaded file

        // Send the email
        if ($mail->send()) {
            echo "Email data stored and sent successfully!";
        } else {
            echo "Error sending email: " . $mail->ErrorInfo;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

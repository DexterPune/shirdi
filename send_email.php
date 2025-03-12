<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader or include PHPMailer manually
// require 'vendor/autoload.php'; // Use this if you installed via Composer
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = filter_var(trim($_POST['phone']), FILTER_SANITIZE_STRING);
    $cab_location = filter_var(trim($_POST['cab_location']), FILTER_SANITIZE_STRING);
    $days = filter_var(trim($_POST['days']), FILTER_SANITIZE_NUMBER_INT);
    $pick_up_point = filter_var(trim($_POST['pick_up_point']), FILTER_SANITIZE_STRING);
    $cabs = filter_var(trim($_POST['cabs']), FILTER_SANITIZE_STRING);
    $date = filter_var(trim($_POST['date']), FILTER_SANITIZE_STRING);
    $message = filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'shirdisaibabatravels.com@gmail.com';               // SMTP username
        $mail->Password   = 'qrca xtey rbst wyfl';                  // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to
        // bnkt fkuq kikg uqkq
        // Recipients
        $mail->setFrom('shirdisaibabatravels.com@gmail.com', 'Your Company');

        // Admin email
        $mail->addAddress('shirdisaibabatravels.com@gmail.com', 'Recipient Name'); // Add a recipient

$mail->addEmbeddedImage('img/logo/logo2.png', 'myimg_cid');

        // Content for the admin email
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body    = "<html><body>
            <img src='https://yourwebsite.com/path/to/logo.png' alt='Logo' style='width:150px;'><br>
            <h2>Enquiry</h2>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Cab Location:</strong> $cab_location</p>
            <p><strong>Number of Days:</strong> $days</p>
            <p><strong>Pick Up Point:</strong> $pick_up_point</p>
            <p><strong>Selected Cabs:</strong> $cabs</p>
            <p><strong>Date of Journey:</strong> $date</p>
            <p><strong>Message:</strong> $message</p>
        </body></html>";

        $mail->send();

        // Auto-reply email
        $mail->clearAddresses(); // Clear addresses to reuse the instance
        $mail->addAddress($email, $name); // Add the user's email address
        $mail->Subject = 'Thank You for Your Message';
        $mail->Body    = "<html><body>
            <h2>Thank You for Your Enquiry</h2>
            <p>Dear $name,</p>
            <p>Thank you for contacting us. We have received your message and will get back to you shortly.</p>
            <p>Best regards,<br>Your Company</p>
            <img src='cid:myimg_cid' alt='Logo' style='width:150px;'><br>

        </body></html>";

        $mail->send();
        echo 'success';
    } catch (Exception $e) {
        echo 'error';
    }
}
?>

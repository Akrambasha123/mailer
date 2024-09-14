<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Automatically loads PHPMailer and its dependencies

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    $emails = explode(',', $_POST['emails_hidden']);
    $resume = $_FILES['resume'];

    // File validation
    if ($resume['error'] === UPLOAD_ERR_OK) {
        $resumeTmpName = $resume['tmp_name'];
        $resumeName = $resume['name'];
    } else {
        die("Error uploading the resume.");
    }

    $mail = new PHPMailer(true);


    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = ''; // SMTP username
        $mail->Password   = '';    // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender
        $mail->setFrom('', 'A Akram Basha');

        // Add each recipient email
        foreach ($emails as $email) {
            $mail->addAddress(trim($email));
        }

        // Attach resume
        $mail->addAttachment($resumeTmpName, $resumeName);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = '
        <p>A AKRAM BASHA</p>
        <p>Kuppam, 517-425, Andhrapradesh | 8096105834 | a.akrambasha123@gmail.com</p>
        <p>Sep 11, 2024</p>
        <p>Dear Hiring Manager,</p>
        <p>I am writing to express my interest in a challenging role within your esteemed organization. As a recent graduate of Computer Science and Engineering from Kuppam Engineering College, I am eager to leverage my skills and contribute to the growth and success of your team.</p>
        <p>During my tenure at Digital Kuppam, I have honed my abilities as a Fullstack Developer, working on various web projects where I developed and implemented both front-end and back-end solutions. Utilizing technologies such as HTML, CSS, Laravel, and PHP, I successfully enhanced user experiences and significantly boosted website performance. This experience has provided me with a solid foundation in web development and a keen understanding of how to create efficient, user-friendly solutions.</p>
        <p>I am particularly drawn to your organization due to its reputation for innovation and commitment to staying ahead of emerging trends in technology. I am confident that my technical skills, coupled with my enthusiasm for continuous learning, will make a valuable addition to your team. I am eager to bring my background in fullstack development to your organization and contribute to projects that drive growth and innovation.</p>
        <p>Thank you for considering my application. I look forward to the opportunity to discuss how my skills and experiences align with the needs of your team. I am excited about the prospect of contributing to your organization and am confident in my ability to deliver results that align with your standards of excellence.</p>
        <p>Sincerely,<br>A. AKRAM BASHA</p>
    ';
    

        // Send email
        $mail->send();
        echo 'Email has been sent to all recipients successfully.';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

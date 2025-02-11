<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    
    // Process uploaded file
    if (isset($_FILES["pdf"]) && $_FILES["pdf"]["error"] == 0) {
        $pdfPath = $_FILES["pdf"]["tmp_name"];
        $pdfName = "Signature_Form.pdf";

        // Email details
        $to = "info@eecinc.ca"; // Change to recipient email
        $subject = "Signature Form Submission";
        $message = "Hello,\n\nPlease find attached the signed form from $name.\n\nRegards,\n$name";

        // Email headers for file attachment
        $boundary = md5(time());
        $headers = "From: $email\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

        // Email body with attachment
        $body = "--$boundary\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
        $body .= $message . "\r\n\r\n";
        $body .= "--$boundary\r\n";
        $body .= "Content-Type: application/pdf; name=\"$pdfName\"\r\n";
        $body .= "Content-Disposition: attachment; filename=\"$pdfName\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= chunk_split(base64_encode(file_get_contents($pdfPath))) . "\r\n";
        $body .= "--$boundary--";

        // Send email
        if (mail($to, $subject, $body, $headers)) {
            echo "Email sent successfully.";
        } else {
            echo "Email failed to send.";
        }
    } else {
        echo "Error processing file.";
    }
} else {
    echo "Invalid request.";
}
?>

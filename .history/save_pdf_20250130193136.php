<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $name = preg_replace("/[^a-zA-Z0-9]/", "_", $data["name"]); 
    $email = $data["email"];
    $pdfBase64 = $data["pdfBase64"];

    $pdfData = base64_decode($pdfBase64);
    $filePath = "saved_forms/" . $name . "_" . time() . ".pdf";

    if (!file_exists("saved_forms")) {
        mkdir("saved_forms", 0777, true);
    }

    file_put_contents($filePath, $pdfData);
    echo "PDF saved successfully as " . $filePath;
}
?>

<?php
if (isset($_GET['file']) && !empty($_GET['file'])) {
    $file = basename($_GET['file']); // Get the file name securely
    if (file_exists($file)) {
        if (isset($_POST['download'])) {
            $final_image = 'Processed_' . time() . '.jpg';
            if (rename($file, $final_image)) {
                header("Content-Description: File Transfer");
                header("Content-Type: application/octet-stream");
                header("Content-Disposition: attachment; filename=$final_image");
                header("Content-Length: " . filesize($final_image));
                readfile($final_image);
                unlink($final_image); // Delete the file after download
                exit;
            } else {
                echo "Failed to save the compressed image.";
            }
        }
    } else {
        echo "File not found!";
    }
} else {
    echo "Invalid request!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device, initial-scale=1.0">
    <title>Download</title>
    <link rel="icon" type="image" href=".images/download.png">
    
    <!--bootstarp links-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <!--bootstrap links-->
    <link rel="stylesheet" href="tool_styles.css">
    <!--Font links-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Uchen&display=swap" rel="stylesheet">
    <!--Font links-->
</head>    
<body style="background-color: #ffe4e1;">
    <!--navbar-->
    <div id="navbar-placeholder"></div>
    <script>
        document.getElementById("navbar-placeholder").innerHTML = 
            fetch("Navbar.html")
            .then(response => response.text())
            .then(data => document.getElementById("navbar-placeholder").innerHTML = data);
    </Script>
    
    <!--navbar ends-->
   
    <div class="container" style="margin-top: 80px;">
        <p class="text" style="font-family:'Uchen',serif; text-align:center; color:#b72458; padding-top: 10px; font-size: 30px; "><b>Processing Done</b></p>
        <form method="post">
            <button type="submit" name="download" class="btn btn-primary" id="custom-btn"><img src="./images/download.png" style="height:40px; width=40px"> Download</button>
        </form>
    </div>
</body>
</html>
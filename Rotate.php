<?php
if (isset($_POST['submit'])) {
    if (isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])) {
        $info = getimagesize($_FILES['image']['tmp_name']);
        if (isset($info['mime'])) {
            if ($info['mime'] == "image/jpeg") {
                $img = imagecreatefromjpeg($_FILES['image']['tmp_name']);
            } elseif ($info['mime'] == "image/png") {
                $img = imagecreatefrompng($_FILES['image']['tmp_name']);
            } else {
                echo "Only select JPG or PNG image.";
                exit;
            }

            // Get the user-provided rotation angle
            $angle = isset($_POST['angle']) ? $_POST['angle'] : 0;

            // Rotate the image if angle is provided
            if ($angle != 0) {
                $img = imagerotate($img, $angle, 0);
            }

            // Save the rotated image temporarily in a unique filename
            $temp_image = 'rotated_' . time() . '.jpg';
            imagejpeg($img, $temp_image, 90);
            imagedestroy($img);

            // Redirect to the download page with the temporary image name
            header("Location: download.php?file=$temp_image");
            exit;
        } else {
            echo "Invalid image file.";
        }
    } else {
        echo "No file uploaded or invalid file path.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device, initial-scale=1.0">
    <title>Rotate Image</title>
    <link rel="icon" type="image" href="./images/rotate.png">
    
    <!-- Bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <!-- Bootstrap links -->
    <link rel="stylesheet" href="tool_styles.css">
    <!-- Font links -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Uchen&display=swap" rel="stylesheet">
    <!-- Font links -->
</head>    
<body style="background-color: #ffe4e1;">
    <!-- Navbar -->
    <div id="navbar-placeholder"></div>
    <script>
        document.getElementById("navbar-placeholder").innerHTML = 
            fetch("navbar.html")
            .then(response => response.text())
            .then(data => document.getElementById("navbar-placeholder").innerHTML = data);
    </script>
    
    <!-- Navbar ends -->
    <h1 style="text-align: center; color: #b72458;padding-top: 30px; font-size:50px; font-family: 'Uchen', serif;"><b>Rotate Image</b></h1>
    <p style="text-align:center; color:#b72458; padding-top: 10px; font-size: 25px;">Rotate your <b><u>JPG or PNG</u></b> images!</p>
    <!-- Upload Section -->
    <div class="container">
        <div class="wrapper">
            <div class="image">
                <img src="./images/Upload.png" alt="">
            </div>
            <div class="content">
                <div class="icon">
                    <i class="fas fa-cloud-upload-alt"></i>
                </div>
                <div class="text" style="padding-top: 80px;">
                    No file chosen, yet!
                </div>
            </div>
            <div id="cancel-btn">
                <i class="fas fa-times"></i>
            </div>
            <div class="file-name">
                File name here
            </div>
        </div>

        <button onclick="defaultBtnActive()" id="custom-btn">Choose a file</button>
        
        <form method="post" enctype="multipart/form-data">
            <input id="default-btn" type="file" name="image" hidden>
            
            <!-- Input for rotation angle -->
            <div class="form-group row" style="padding-top: 20px;">
                <div class="col-sm-12">
                    <label for="angle" style="text-align:center; color:#b72458; font-size: 15px;">Rotation Angle : </label>
                    <input type="number" class="form-control" id="angle" name="angle" placeholder="Enter rotation angle">
                </div>
            </div>

            <button type="submit" name="submit" id="custom-btn" style="margin-top: 20px;">Rotate</button>
        </form>
    </div>
    
    <script>
        const wrapper = document.querySelector(".wrapper");
        const fileName = document.querySelector(".file-name");
        const defaultBtn = document.querySelector("#default-btn");
        const customBtn = document.querySelector("#custom-btn");
        const cancelBtn = document.querySelector("#cancel-btn i");
        const img = document.querySelector("img");
        let regExp = /[0-9a-zA-Z\^\&\'\@\{\}\[\]\,\$\=\!\-\#\(\)\.\%\+\~\_ ]+$/;

        function defaultBtnActive(){
            defaultBtn.click();
        }

        defaultBtn.addEventListener("change", function(){
            const file = this.files[0];
            if(file){
                const reader = new FileReader();
                reader.onload = function(){
                    const result = reader.result;
                    img.src = result;
                    wrapper.classList.add("active");
                }
                cancelBtn.addEventListener("click", function(){
                    img.src = "";
                    wrapper.classList.remove("active");
                })
                reader.readAsDataURL(file);
            }
            if(this.value){
                let valueStore = this.value.match(regExp);
                fileName.textContent = valueStore;
            }
        });
    </script>
    <!-- Upload ends -->
</body>
</html>

<?php
$message = "";
$messageColor = "";

// 1. The Guard Check
if (isset($_POST['upload_btn'])) {
   
  
    //   2.    We grab the file through  $_FILES   using the name="" attribute from the HTML input
    $file = $_FILES['profile_pic'];

    // 3. Break down the file's information into variables

    $fileName = $file['name'];       // E.g., "my_photo.jpg"
    $tmpLocation = $file['tmp_name'];// The temporary waiting room on the server
    $fileSize = $file['size'];       // File size in bytes
    $fileError = $file['error'];     // 0 means no errors

    // 4. Extract the file extension (jpg, png, etc.) and make it lowercase
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // 5. The Security Checks
    if ($fileExt != "jpg") {
       
        $message = "Error: Only JPG files are allowed.";
        $messageColor = "red";
       
    } elseif ($fileSize > 5000000) { // 5,000,000 bytes = 5MB
       
        $message = "Error: File is too large. Must be under 5MB.";
        $messageColor = "red";
       
    } elseif ($fileError != 0) {
       
        $message = "Error: The file is corrupted or failed to upload.";
        $messageColor = "red";
       
    } else {
       
        // 6. Generate a random new name so users don't overwrite each other's files!
        $newFileName = uniqid() . ".jpg";
       
        // 7. Define the final destination folder and filename
        $destination = "uploads/" . $newFileName;

        // 8. Move the file from the temporary waiting room to the final folder

        if (move_uploaded_file($tmpLocation, $destination)) {
            $message = "Success! File uploaded as: " . $newFileName;
            $messageColor = "green";
        } else {
            $message = "Error: Could not save file. Did you create the 'uploads' folder?";
            $messageColor = "red";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Photo Upload</title>
    <style>
        body { font-family: sans-serif; padding: 40px; }
        .upload-box { border: 2px dashed #aaa; padding: 20px; width: 350px; background: #fafafa; }
        input[type="file"] { margin: 15px 0; }
        button { padding: 8px 15px; background: #28a745; color: white; border: none; cursor: pointer; }
        .alert { font-weight: bold; }
    </style>
</head>
<body>

    <div class="upload-box">
        <h2>Upload Profile Picture</h2>
       
        <!-- Display output message -->
        <?php if ($message != ""): ?>
            <p class="alert" style="color: <?php echo $messageColor; ?>;">
                <?php echo $message; ?>
            </p>
        <?php endif; ?>

        <!-- THE FORM -->
        <!-- CRUCIAL: enctype="multipart/form-data" is required for files! -->
        <form method="POST" action="" enctype="multipart/form-data">
           
            <label>Select a JPG image (Max 5MB):</label>
            <!-- name="profile_pic" is what $_FILES looks for -->
            <input type="file" name="profile_pic" required>
           
            <button type="submit" name="upload_btn">Upload Photo</button>
        </form>
    </div>

</body>
</html>
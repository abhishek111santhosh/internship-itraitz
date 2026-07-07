<?php
// ==========================================
// STUDENT LAB: EMPLOYEE DATA & STREAM I/O
// ==========================================
$feedbackMsg = "";
$feedbackType = "";

// When the user clicks the submit button
if (isset($_POST['submit_btn'])) {
    
    // Grab text inputs and clean them up
    $fullName = trim($_POST['full_name']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $address  = trim($_POST['address']);
    
    // Grab the uploaded resume file
    $file      = $_FILES['resume'];
    $fileName  = $file['name'];
    $tmpFolder = $file['tmp_name'];
    $fileSize  = $file['size'];
    $fileError = $file['error'];
    
    // Get the file extension in lowercase
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    // Simple validation checks
    if ($ext != "pdf" && $ext != "doc" && $ext != "docx") {
        $feedbackMsg = "Oops! Please upload only PDF, DOC, or DOCX files.";
        $feedbackType = "error";
    } elseif ($fileSize > 5000000) {
        $feedbackMsg = "File is too big! Please keep it under 5MB.";
        $feedbackType = "error";
    } elseif ($fileError != 0) {
        $feedbackMsg = "Something went wrong while uploading the file. Try again!";
        $feedbackType = "error";
    } else {
        // Create the uploads folder if we haven't made it yet
        $folderPath = "uploads/resumes/";
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        
        // Make a unique name so files don't overwrite each other
        $savedFileName = uniqid("resume_") . "." . $ext;
        $fullPath      = $folderPath . $savedFileName;
        
        // Move file from temporary memory to our folder
        if (move_uploaded_file($tmpFolder, $fullPath)) {
            
            // --- STREAM WRITING (Connecting to sample.txt / CSV logic) ---
            $dbFile = "employee_records.csv";
            
            // Check if we need to write column titles first
            $writeHeaders = !file_exists($dbFile) || filesize($dbFile) == 0;
            
            // Open stream in Append mode ('a')
            $fp = fopen($dbFile, "a");
            
            if ($fp) {
                if ($writeHeaders) {
                    fputcsv($fp, ["Name", "Email", "Phone", "Address", "Resume File", "Timestamp"]);
                }
                
                // Save the employee data row
                $newRow = [$fullName, $email, $phone, $address, $savedFileName, date("Y-m-d H:i:s")];
                fputcsv($fp, $newRow);
                
                // Always close the stream!
                fclose($fp);
                
                $feedbackMsg = "Awesome! Employee saved to database and resume stored safely.";
                $feedbackType = "success";
            } else {
                $feedbackMsg = "Could not open the CSV file to save data.";
                $feedbackType = "error";
            }
            
        } else {
            $feedbackMsg = "Failed to save the file to the hard drive.";
            $feedbackType = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Details - Hand Drawn UI</title>
    <style>
        /* =========================================================
           THE "HAND-DRAWN SKETCH" CSS THEME
           ========================================================= */
        
        /* 1. Lined notebook paper background for the whole page */
        body {
            font-family: 'Courier New', Courier, 'Comic Sans MS', cursive, monospace;
            background-color: #fcfbf7;
            background-image: linear-gradient(#e1e8ed 1px, transparent 1px);
            background-size: 100% 28px; /* Spacing between notebook lines */
            color: #2b2b2b;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 30px;
        }

        /* 2. Paper card with slightly "wonky/organic" sketch borders */
        .paper-card {
            background: #ffffff;
            padding: 35px 40px;
            width: 100%;
            max-width: 460px;
            
            /* This asymmetrical border-radius creates the hand-drawn ink look! */
            border: 3px solid #2b2b2b;
            border-radius: 255px 15px 225px 15px/15px 225px 15px 255px;
            
            /* Soft drop shadow like a physical sheet of paper sitting on a desk */
            box-shadow: 6px 8px 0px rgba(43, 43, 43, 0.15);
            position: relative;
        }

        /* 3. Titled header with an underline sketch style */
        h2 {
            text-align: center;
            font-size: 1.8em;
            margin-top: 0;
            margin-bottom: 25px;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px dashed #888;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            font-size: 1em;
            color: #333;
        }

        /* 4. Inputs styled like boxes drawn with a pen */
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 10px 12px;
            background: #fffdfa;
            border: 2px solid #444;
            /* Tilted sketch border effect for input boxes */
            border-radius: 10px 250px 10px 250px/250px 10px 250px 10px;
            box-sizing: border-box;
            font-family: inherit;
            font-size: 1em;
            color: #222;
            transition: all 0.2s ease;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #0056b3;
            background: #ffffff;
            box-shadow: 2px 2px 0px rgba(0, 86, 179, 0.2);
        }

        textarea {
            resize: vertical;
            height: 85px;
        }

        /* 5. Dashed file drop area */
        .file-box {
            border: 2px dashed #666;
            padding: 12px;
            background: #f9f8f3;
            border-radius: 8px;
            text-align: center;
        }

        /* 6. Hand-drawn sketch button */
        button {
            width: 100%;
            padding: 12px;
            background-color: #2b2b2b;
            color: #ffffff;
            border: 2px solid #2b2b2b;
            border-radius: 15px 225px 15px 255px/255px 15px 225px 15px;
            font-family: inherit;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 3px 4px 0px rgba(0, 0, 0, 0.3);
            transition: transform 0.1s, box-shadow 0.1s;
        }

        button:hover {
            background-color: #444;
            transform: translate(-2px, -2px);
            box-shadow: 5px 6px 0px rgba(0, 0, 0, 0.3);
        }

        button:active {
            transform: translate(1px, 1px);
            box-shadow: 1px 1px 0px rgba(0, 0, 0, 0.3);
        }

        /* Feedback notifications */
        .alert {
            padding: 10px 15px;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
            border: 2px solid;
            border-radius: 10px;
        }
        .alert.error {
            background-color: #ffe6e6;
            border-color: #cc0000;
            color: #990000;
        }
        .alert.success {
            background-color: #e6ffe6;
            border-color: #008000;
            color: #006600;
        }
    </style>
</head>
<body>

    <div class="paper-card">
        <h2>Employee Details</h2>
        
        <?php if ($feedbackMsg != ""): ?>
            <div class="alert <?php echo $feedbackType; ?>">
                <?php echo $feedbackMsg; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            
            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="full_name" required placeholder="Type name here...">
            </div>

            <div class="form-group">
                <label>Email Address:</label>
                <input type="email" name="email" required placeholder="name@example.com">
            </div>

            <div class="form-group">
                <label>Phone Number:</label>
                <input type="tel" name="phone" required placeholder="10-digit mobile number">
            </div>

            <div class="form-group">
                <label>Residential Address:</label>
                <textarea name="address" required placeholder="Write street address, city, and zip..."></textarea>
            </div>

            <div class="form-group">
                <label>Attach Resume (PDF / DOC / DOCX):</label>
                <div class="file-box">
                    <input type="file" name="resume" required accept=".pdf,.doc,.docx">
                </div>
            </div>

            <button type="submit" name="submit_btn">Save Employee Record</button>
            
        </form>
    </div>

</body>
</html>
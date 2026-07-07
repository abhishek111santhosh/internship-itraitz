<?php
// 1. Set your timezone so the log timestamps reflect your local time
date_default_timezone_set('UTC'); // Example: 'America/New_York' or 'Europe/London'

// 2. Format the current date and time (Year-Month-Day Hour:Minute:Second)
// PHP_EOL adds a cross-platform newline character at the end of the string
$timestamp = "Visit recorded at: " . date("Y-m-d H:i:s") . PHP_EOL;

// 3. The file path where logs will be stored
$logFile = 'log.txt';

// 4. Write to the file using FILE_APPEND and LOCK_EX
// LOCK_EX prevents race conditions if two users visit at the exact same millisecond
file_put_contents($logFile, $timestamp, FILE_APPEND | LOCK_EX);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Visitor Log - Active</title>
    <style>
        body { font-family: sans-serif; padding: 2rem; line-height: 1.5; }
        .success-box { padding: 1rem; border-left: 4px solid #28a745; background: #f8f9fa; }
    </style>
</head>
<body>
    <h1>Welcome to the Site!</h1>
    <div class="success-box">
        <p><strong>Your visit has been logged.</strong></p>
        <p>Entry added: <code><?php echo htmlspecialchars(trim($timestamp)); ?></code></p>
    </div>
    <p><a href="view-log.php">View all visitor logs &rarr;</a></p>
</body>
</html>
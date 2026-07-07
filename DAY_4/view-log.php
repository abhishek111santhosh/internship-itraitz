<?php
$logFile = 'log.txt';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Visitor Logs</title>
    <style>
        body { font-family: sans-serif; padding: 2rem; line-height: 1.5; }
        .log-container { background: #1e1e1e; color: #00ff00; padding: 1.5rem; border-radius: 6px; overflow-x: auto; font-family: monospace; }
        .no-logs { padding: 1rem; border-left: 4px solid #ffc107; background: #fff3cd; }
    </style>
</head>
<body>
    <h1>Visitor Log History</h1>
    
    <?php
    // Check if the log file actually exists before trying to read it
    if (file_exists($logFile) && filesize($logFile) > 0) {
        
        // Read the entire file into a string
        $rawLogs = file_get_contents($logFile);
        
        echo "<div class='log-container'>";
        // htmlspecialchars prevents XSS attacks if logs contained user-submitted data
        // <pre> preserves the line breaks (PHP_EOL) from the text file
        echo "<pre>" . htmlspecialchars($rawLogs) . "</pre>";
        echo "</div>";
        
    } else {
        echo "<div class='no-logs'>No visitor logs found yet. Visit <a href='visitor-log.php'>visitor-log.php</a> to generate the first entry!</div>";
    }
    ?>
    
    <p style="margin-top: 1.5rem;"><a href="visitor-log.php">&larr; Go back and log another visit</a></p>
</body>
</html>

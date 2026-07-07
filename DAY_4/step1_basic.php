<?php
// ==========================================
// LEVEL 3: SENIOR DATA PROCESSOR (CSV STREAMS)
// ==========================================

$sourceFile = "employees_old.csv";
$targetFile = "employees_upgraded.csv";

// 1. Create a dummy CSV file to practice with
$initialData = "ID,Name,Department,Salary\n" .
               "101,Alice Smith,Engineering,75000\n" .
               "102,Bob Jones,Marketing,50000\n" .
               "103,Charlie Brown,Engineering,82000\n" .
               "104,Diana Prince,Executive,120000\n";

file_put_contents($sourceFile, $initialData);
echo "<h3>Senior Dev Task: Processing Employee Salaries</h3>";
echo "<p>Reading from <code>$sourceFile</code>, applying a 10% raise, and streaming to <code>$targetFile</code>...</p>";

// 2. Open BOTH streams simultaneously!
// We read from the source ($handleIn) and write to the target ($handleOut)
$handleIn = fopen($sourceFile, "r");
$handleOut = fopen($targetFile, "w");

if ($handleIn && $handleOut) {
    $rowNumber = 0;
    
    // fgetcsv() is a specialized version of fread() that parses comma-separated lines into an array
    while (($row = fgetcsv($handleIn)) !== false) {
        
        // If this is the Header row (Row 0), just write it to the new file untouched
        if ($rowNumber === 0) {
            fputcsv($handleOut, $row);
        } else {
            // Extract data from the row array
            $id = $row[0];
            $name = $row[1];
            $dept = $row[2];
            $oldSalary = (int)$row[3];
            
            // Apply a 10% raise!
            $newSalary = $oldSalary * 1.10;
            
            // Update the array with the new salary
            $row[3] = $newSalary;
            
            // Stream the upgraded array directly into the new file!
            fputcsv($handleOut, $row);
        }
        $rowNumber++;
    }
    
    // ALWAYS close both channels when done
    fclose($handleIn);
    fclose($handleOut);
    
    echo "<p style='color:green; font-weight:bold;'>Data pipeline complete! Processed " . ($rowNumber - 1) . " employees.</p>";
} else {
    echo "<p style='color:red;'>Error opening stream channels.</p>";
}

// 3. Display the final upgraded CSV file contents
echo "<h4>Contents of Updated File ($targetFile):</h4>";
echo "<table border='1' cellpadding='8' style='border-collapse:collapse; text-align:left;'>";

// Open the new file to read and display on screen
$displayHandle = fopen($targetFile, "r");
while (($row = fgetcsv($displayHandle)) !== false) {
    echo "<tr>";
    foreach ($row as $cell) {
        echo "<td>" . htmlspecialchars($cell) . "</td>";
    }
    echo "</tr>";
}
fclose($displayHandle);

echo "</table>";
?>
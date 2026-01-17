<?php
require_once 'db.php';

// SQL to add the new column
$sql = "ALTER TABLE bookings ADD COLUMN year_of_study VARCHAR(20) NOT NULL AFTER student_id";

if ($conn->query($sql) === TRUE) {
    echo "Table 'bookings' updated successfully. Added 'year_of_study' column.";
} else {
    // Check if error is because column already exists
    if (strpos($conn->error, "Duplicate column name") !== false) {
        echo "Column 'year_of_study' already exists.";
    } else {
        echo "Error updating table: " . $conn->error;
    }
}

$conn->close();
?>

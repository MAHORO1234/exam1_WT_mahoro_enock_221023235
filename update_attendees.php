<?php
// Include the database connection file
include('database_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind parameters with appropriate data types
    $stmt = $connection->prepare("UPDATE attendees SET user_id = ?, class_id = ? WHERE attendee_id = ?");
    $stmt->bind_param("ssi", $user_id, $class_id, $attendee_id);

    // Set parameters from POST data with validation (optional)
    $user_id = htmlspecialchars($_POST['user_id']); // Prevent XSS
    $class_id = htmlspecialchars($_POST['class_id']); // Prevent XSS
    $attendee_id = intval($_POST['attendee_id']); // Ensure integer for attendee_id

    // Execute prepared statement with error handling
    if ($stmt->execute()) {
        echo "Attendee information updated successfully!";
    } else {
        echo "Error updating attendee information: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch existing data for the attendee to pre-fill the form
if(isset($_GET['attendee_id'])) {
    $attendee_id = intval($_GET['attendee_id']);
    $sql = "SELECT * FROM attendees WHERE attendee_id = $attendee_id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc(); // Fetch the data for the attendee
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Attendee Information</title>
</head>
<body>
    <h2>Update Attendee Information</h2>
    <!-- HTML Form for updating attendee information -->
    <form method="post">
        <label for="user_id">User ID:</label>
        <input type="text" id="user_id" name="user_id" value="<?php echo $row['user_id']; ?>" required><br><br>
        <label for="class_id">Class ID:</label>
        <input type="text" id="class_id" name="class_id" value="<?php echo $row['class_id']; ?>" required><br><br>
        <!-- Hidden input field to store the attendee_id -->
        <input type="hidden" name="attendee_id" value="<?php echo $attendee_id; ?>">
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

<?php
// Close the database connection
$connection->close();
?>

<?php
// Include the database connection file
include('database_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind parameters with appropriate data types
    $stmt = $connection->prepare("UPDATE enrollments SET user_id = ?, class_id = ?, enrollment_date = ? WHERE enrollment_id = ?");
    $stmt->bind_param("iisi", $user_id, $class_id, $enrollment_date, $enrollment_id);

    // Set parameters from POST data with validation (optional)
    $user_id = intval($_POST['user_id']); // Ensure integer for user_id
    $class_id = intval($_POST['class_id']); // Ensure integer for class_id
    $enrollment_date = htmlspecialchars($_POST['enrollment_date']); // Prevent XSS
    $enrollment_id = intval($_POST['enrollment_id']); // Ensure integer for enrollment_id

    // Execute prepared statement with error handling
    if ($stmt->execute()) {
        echo "Enrollment information updated successfully!";
    } else {
        echo "Error updating enrollment information: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch existing data for the enrollment to pre-fill the form
if(isset($_GET['enrollment_id'])) {
    $enrollment_id = intval($_GET['enrollment_id']);
    $sql = "SELECT * FROM enrollments WHERE enrollment_id = $enrollment_id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc(); // Fetch the data for the enrollment
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Enrollment Information</title>
</head>
<body>
    <h2>Update Enrollment Information</h2>
    <!-- HTML Form for updating enrollment information -->
    <form method="post">
        <label for="user_id">User ID:</label>
        <input type="text" id="user_id" name="user_id" value="<?php echo $row['user_id']; ?>" required><br><br>
        <label for="class_id">Class ID:</label>
        <input type="text" id="class_id" name="class_id" value="<?php echo $row['class_id']; ?>" required><br><br>
        <label for="enrollment_date">Enrollment Date:</label>
        <input type="date" id="enrollment_date" name="enrollment_date" value="<?php echo $row['enrollment_date']; ?>" required><br><br>
        <!-- Hidden input field to store the enrollment_id -->
        <input type="hidden" name="enrollment_id" value="<?php echo $enrollment_id; ?>">
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

<?php
// Close the database connection
$connection->close();
?>

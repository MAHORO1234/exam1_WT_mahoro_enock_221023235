<?php
// Include the database connection file
include('database_connection.php');

// Initialize $row variable
$row = array();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind parameters with appropriate data types
    $stmt = $connection->prepare("UPDATE messages SET sender_id = ?, receiver_id = ?, message_text = ?, send_date = ? WHERE message_id = ?");
    $stmt->bind_param("iissi", $sender_id, $receiver_id, $message_text, $send_date, $message_id);

    // Set parameters from POST data with validation (optional)
    $sender_id = intval($_POST['sender_id']); // Ensure integer for sender_id
    $receiver_id = intval($_POST['receiver_id']); // Ensure integer for receiver_id
    $message_text = htmlspecialchars($_POST['message_text']); // Prevent XSS
    $send_date = htmlspecialchars($_POST['send_date']); // Prevent XSS
    $message_id = intval($_POST['message_id']); // Ensure integer for message_id

    // Execute prepared statement with error handling
    if ($stmt->execute()) {
        echo "Message information updated successfully!";
    } else {
        echo "Error updating message information: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch existing data for the message to pre-fill the form
if(isset($_GET['message_id'])) {
    $message_id = intval($_GET['message_id']);
    $sql = "SELECT * FROM messages WHERE message_id = $message_id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc(); // Fetch the data for the message
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Message</title>
</head>
<body>
    <h2>Update Message</h2>
    <!-- HTML Form for updating message -->
    <form method="post">
        <label for="sender_id">Sender ID:</label>
        <input type="text" id="sender_id" name="sender_id" value="<?php echo isset($row['sender_id']) ? $row['sender_id'] : ''; ?>" required><br><br>
        <label for="receiver_id">Receiver ID:</label>
        <input type="text" id="receiver_id" name="receiver_id" value="<?php echo isset($row['receiver_id']) ? $row['receiver_id'] : ''; ?>" required><br><br>
        <label for="message_text">Message Text:</label>
        <textarea id="message_text" name="message_text" rows="4" cols="50" required><?php echo isset($row['message_text']) ? $row['message_text'] : ''; ?></textarea><br><br>
        <label for="send_date">Send Date:</label>
        <input type="datetime-local" id="send_date" name="send_date" value="<?php echo isset($row['send_date']) ? date('Y-m-d\TH:i:s', strtotime($row['send_date'])) : ''; ?>" required><br><br>
        <!-- Hidden input field to store the message_id -->
        <input type="hidden" name="message_id" value="<?php echo isset($message_id) ? $message_id : ''; ?>">
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

<?php
// Close the database connection
$connection->close();
?>

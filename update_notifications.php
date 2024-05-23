<?php
// Include database connection
include('database_connection.php');
// Check if notification_id is set in the request
if(isset($_REQUEST['notification_id'])) {
    // Get notification_id from the request
    $notification_id = $_REQUEST['notification_id'];
    
    // Prepare and execute SQL query to select notifications data by notification_id
    $stmt = $connection->prepare("SELECT * FROM notifications WHERE notification_id=?");
    $stmt->bind_param("i", $notification_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if notifications data is found
    if($result->num_rows > 0) {
        // Fetch notifications data
        $row = $result->fetch_assoc();
        $notification_id = $row['notification_id']; // Store notification_id
        $user_id = $row['user_id']; // Store 'user_id'
        $message = $row['message']; // Store 'message'
        $notification_date = $row['notification_date']; // Store 'notification_date'
        $is_read = $row['is_read']; // Store 'is_read'
        
    } else {
        echo "notifications not found.";
    }
}
?>

<html>
<head>
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update notifications form -->
    <form method="POST">
        <label for="notification_id">notification_id:</label>
        <!-- Display notification_id from database -->
        <input type="number" name="notification_id" value="<?php echo isset($notification_id) ? $notification_id : ''; ?>">
        <br><br>
        <label for="user_id">user_id:</label>
        <!-- Display user_id from database -->
        <input type="number" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
        <br><br> 

        <label for="message">message:</label>
        <!-- Display message from database -->
        <input type="text" name="message" value="<?php echo isset($message) ? $message : ''; ?>">
        <br><br>

        <label for="notification_date">notification_date:</label>
        <!-- Display notification_date from database -->
        <input type="date" name="notification_date" value="<?php echo isset($notification_date) ? $notification_date : ''; ?>">
        <br><br>

        <label for="is_read">is_read:</label>
        <!-- Display is_read from database -->
        <input type="date" name="is_read" value="<?php echo isset($is_read) ? $is_read : ''; ?>">
        <br><br>


        <!-- Submit button to update notifications -->
        <input type="submit" name="up" value="Update" onclick="return confirmUpdate();">
    </form>
</body>
</html>

<?php
// Check if update button is clicked
if(isset($_POST['up'])) {
    // Retrieve updated values from reviews form
    
    $is_read = $_POST['is_read'];
    $notification_date = $_POST['notification_date'];
    $message = $_POST['message'];
    $user_id = $_POST['user_id'];
    $notification_id = $_POST['notification_id'];
     
    
    // Update the reviews in the database
    // Update the reviews in the database
// Update the reviews in the database
$stmt = $connection->prepare("UPDATE notifications SET is_read=?, notification_date=?, message=?, user_id=? WHERE notification_id=?");
$stmt->bind_param("ssssi", $is_read, $notification_date, $message, $user_id, $notification_id);
$stmt->execute();


    
    // Redirect to reviews.php
    header('Location: notifications.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>



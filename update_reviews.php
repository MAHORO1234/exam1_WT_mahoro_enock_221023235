<?php
// Include database connection
include('database_connection.php');
// Check if review_id is set in the request
if(isset($_REQUEST['review_id'])) {
    // Get review_id from the request
    $review_id = $_REQUEST['review_id'];
    
    // Prepare and execute SQL query to select reviews data by review_id
    $stmt = $connection->prepare("SELECT * FROM reviews WHERE review_id=?");
    $stmt->bind_param("i", $review_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if reviews data is found
    if($result->num_rows > 0) {
        // Fetch reviews data
        $row = $result->fetch_assoc();
        $review_id = $row['review_id']; // Store review_id
        $user_id = $row['user_id']; // Store 'user_id'
        $class_id = $row['class_id']; // Store 'class_id'
        $rating = $row['rating']; // Store 'rating'
        $comment = $row['comment']; // Store 'comment'
        $review_date = $row['review_date']; // Store 'review_date'

    } else {
        echo "reviews not found.";
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
    <!-- Update reviews form -->
    <form method="POST">
        <label for="class_id">class_id:</label>
        <!-- Display class_id from database -->
        <input type="number" name="class_id" value="<?php echo isset($class_id) ? $class_id : ''; ?>">
        <br><br>
        <label for="user_id">user_id:</label>
        <!-- Display user_id from database -->
        <input type="number" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
        <br><br> 

        <label for="rating">rating:</label>
        <!-- Display rating from database -->
        <input type="text" name="rating" value="<?php echo isset($rating) ? $rating : ''; ?>">
        <br><br>

        <label for="comment">comment:</label>
        <!-- Display comment from database -->
        <input type="date" name="comment" value="<?php echo isset($comment) ? $comment : ''; ?>">
        <br><br>

        <label for="review_date">review_date:</label>
        <!-- Display review_date from database -->
        <input type="date" name="review_date" value="<?php echo isset($review_date) ? $review_date : ''; ?>">
        <br><br>

        <!-- Hidden input field to store review_id -->
        <input type="hidden" name="review_id" value="<?php echo isset($review_id) ? $review_id : ''; ?>">
        <!-- Submit button to update reviews -->
        <input type="submit" name="up" value="Update" onclick="return confirmUpdate();">
    </form>
</body>
</html>

<?php
// Check if update button is clicked
if(isset($_POST['up'])) {
    // Retrieve updated values from reviews form
    $review_date = $_POST['review_date'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];
    $user_id = $_POST['user_id'];
    $class_id = $_POST['class_id'];
    $review_id = $_POST['review_id']; 
    
    // Update the reviews in the database
    $stmt = $connection->prepare("UPDATE reviews SET review_date=?, comment=?, rating=?, class_id=?, class_id=? WHERE review_id=?");
    $stmt->bind_param("sssssi", $review_date, $comment, $rating, $user_id, $class_id, $review_id);
    $stmt->execute();
    
    // Redirect to reviews.php
    header('Location: reviews.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>



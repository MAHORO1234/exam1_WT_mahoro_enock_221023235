<?php
// Include database connection
include('database_connection.php');
// Check if class_id is set in the request
if(isset($_REQUEST['class_id'])) {
    // Get class_id from the request
    $class_id = $_REQUEST['class_id'];
    
    // Prepare and execute SQL query to select classes data by class_id
    $stmt = $connection->prepare("SELECT * FROM classes WHERE class_id=?");
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if classes data is found
    if($result->num_rows > 0) {
        // Fetch classes data
        $row = $result->fetch_assoc();
        $class_id = $row['class_id']; // Store class_id
        $instructor_id = $row['instructor_id']; // Store 'instructor_id'
        $title = $row['title']; // Store 'title'
        $description = $row['description']; // Store 'description'
        $start_time = $row['start_time']; // Store 'start_time'
        $end_time = $row['end_time']; // Store 'end_time'

    } else {
        echo "classes not found.";
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
    <!-- Update classes form -->
    <form method="POST">
        <label for="class_id">class_id:</label>
        <!-- Display class_id from database -->
        <input type="number" name="class_id" value="<?php echo isset($class_id) ? $class_id : ''; ?>">
        <br><br>
        <label for="instructor_id">instructor_id:</label>
        <!-- Display instructor_id from database -->
        <input type="number" name="instructor_id" value="<?php echo isset($instructor_id) ? $instructor_id : ''; ?>">
        <br><br> 

        <label for="title">title:</label>
        <!-- Display title from database -->
        <input type="text" name="title" value="<?php echo isset($title) ? $title : ''; ?>">
        <br><br>

        <label for="description">description:</label>
        <!-- Display description from database -->
        <input type="date" name="description" value="<?php echo isset($description) ? $description : ''; ?>">
        <br><br>

        <label for="start_time">start_time:</label>
        <!-- Display start_time from database -->
        <input type="date" name="start_time" value="<?php echo isset($start_time) ? $start_time : ''; ?>">
        <br><br>


        <label for="end_time">end_time:</label>
        <!-- Display end_time from database -->
        <input type="date" name="end_time" value="<?php echo isset($end_time) ? $end_time : ''; ?>">
        <br><br>

        <!-- Submit button to update classes -->
        <input type="submit" name="up" value="Update" onclick="return confirmUpdate();">
    </form>
</body>
</html>

<?php
// Check if update button is clicked
if(isset($_POST['up'])) {
    // Retrieve updated values from reviews form
    $end_time = $_POST['end_time'];
    $start_time = $_POST['start_time'];
    $description = $_POST['description'];
    $title = $_POST['title'];
    $instructor_id = $_POST['instructor_id'];
    $class_id = $_POST['class_id'];
     
    
    // Update the reviews in the database
    // Update the reviews in the database
$stmt = $connection->prepare("UPDATE classes SET end_time=?, start_time=?, description=?, title=?, instructor_id=? WHERE class_id=?");
$stmt->bind_param("sssssi", $end_time, $start_time, $description, $title, $instructor_id, $class_id);
$stmt->execute();

    
    // Redirect to reviews.php
    header('Location: classes.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>



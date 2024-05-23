<?php
// Include database connection
include('database_connection.php');
// Check if resource_id is set in the request
if(isset($_REQUEST['resource_id'])) {
    // Get resource_id from the request
    $resource_id = $_REQUEST['resource_id'];
    
    // Prepare and execute SQL query to select resources data by resource_id
    $stmt = $connection->prepare("SELECT * FROM resources WHERE resource_id=?");
    $stmt->bind_param("i", $resource_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if resources data is found
    if($result->num_rows > 0) {
        // Fetch resources data
        $row = $result->fetch_assoc();
        $resource_id = $row['resource_id']; // Store resource_id
        $class_id = $row['class_id']; // Store 'class_id'
        $title = $row['title']; // Store 'title'
        $description = $row['description']; // Store 'description'
        $file_url = $row['file_url']; // Store 'file_url'
        
    } else {
        echo "resources not found.";
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
    <!-- Update resources form -->
    <form method="POST">
        <label for="resource_id">resource_id:</label>
        <!-- Display resource_id from database -->
        <input type="number" name="resource_id" value="<?php echo isset($resource_id) ? $resource_id : ''; ?>">
        <br><br>
        <label for="class_id">class_id:</label>
        <!-- Display class_id from database -->
        <input type="number" name="class_id" value="<?php echo isset($class_id) ? $class_id : ''; ?>">
        <br><br> 

        <label for="title">title:</label>
        <!-- Display title from database -->
        <input type="text" name="title" value="<?php echo isset($title) ? $title : ''; ?>">
        <br><br>

        <label for="description">description:</label>
        <!-- Display description from database -->
        <input type="date" name="description" value="<?php echo isset($description) ? $description : ''; ?>">
        <br><br>

        <label for="file_url">file_url:</label>
        <!-- Display file_url from database -->
        <input type="date" name="file_url" value="<?php echo isset($file_url) ? $file_url : ''; ?>">
        <br><br>


        <!-- Submit button to update resources -->
        <input type="submit" name="up" value="Update" onclick="return confirmUpdate();">
    </form>
</body>
</html>

<?php
// Check if update button is clicked
if(isset($_POST['up'])) {
    // Retrieve updated values from reviews form
    
    $file_url = $_POST['file_url'];
    $description = $_POST['description'];
    $title = $_POST['title'];
    $class_id = $_POST['class_id'];
    $resource_id = $_POST['resource_id'];
     
    
    // Update the reviews in the database
    // Update the reviews in the database
$stmt = $connection->prepare("UPDATE resources SET  file_url=?, description=?, title=?, class_id=? WHERE resource_id=?");
$stmt->bind_param("ssssi",  $file_url, $description, $title, $class_id, $resource_id);
$stmt->execute();

    
    // Redirect to reviews.php
    header('Location: resources.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>



<?php
// Include database connection
include('database_connection.php');
// Check if instructor_id is set in the request
if(isset($_REQUEST['instructor_id'])) {
    // Get instructor_id from the request
    $instructor_id = $_REQUEST['instructor_id'];
    
    // Prepare and execute SQL query to select instructors data by instructor_id
    $stmt = $connection->prepare("SELECT * FROM instructors WHERE instructor_id=?");
    $stmt->bind_param("i", $instructor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if instructors data is found
    if($result->num_rows > 0) {
        // Fetch instructors data
        $row = $result->fetch_assoc();
        $instructor_id = $row['instructor_id']; // Store instructor_id
        $user_id = $row['user_id']; // Store 'user_id'
        $full_name = $row['full_name']; // Store 'full_name'
        $bio = $row['bio']; // Store 'bio'
        $specialization = $row['specialization']; // Store 'specialization'

    } else {
        echo "instructors not found.";
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
    <!-- Update instructors form -->
    <form method="POST">
        <label for="instructor_id">instructor_id:</label>
        <!-- Display instructor_id from database -->
        <input type="number" name="instructor_id" value="<?php echo isset($instructor_id) ? $instructor_id : ''; ?>">
        <br><br>
        <label for="user_id">user_id:</label>
        <!-- Display user_id from database -->
        <input type="number" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
        <br><br> 

        <label for="full_name">full_name:</label>
        <!-- Display full_name from database -->
        <input type="full_name" name="full_name" value="<?php echo isset($full_name) ? $full_name : ''; ?>">
        <br><br>

        <label for="bio">bio:</label>
        <!-- Display bio from database -->
        <input type="date" name="bio" value="<?php echo isset($bio) ? $bio : ''; ?>">
        <br><br>

        <label for="specialization">specialization:</label>
        <!-- Display specialization from database -->
        <input type="date" name="specialization" value="<?php echo isset($specialization) ? $specialization : ''; ?>">
        <br><br>

        <!-- Submit button to update instructors -->
        <input type="submit" name="up" value="Update" onclick="return confirmUpdate();">
    </form>
</body>
</html>

<?php
// Check if update button is clicked
if(isset($_POST['up'])) {
    // Retrieve updated values from reviews form
    
    $specialization = $_POST['specialization'];
    $bio = $_POST['bio'];
    $full_name = $_POST['full_name'];
    $user_id = $_POST['user_id'];
    $instructor_id = $_POST['instructor_id'];
     
    
    // Update the reviews in the database
    // Update the reviews in the database
$stmt = $connection->prepare("UPDATE instructors SET specialization=?, bio=?, full_name=?, user_id=? WHERE instructor_id=?");
$stmt->bind_param("ssssi", $specialization, $bio, $full_name, $user_id, $instructor_id);
$stmt->execute();

    
    // Redirect to reviews.php
    header('Location: instructors.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>



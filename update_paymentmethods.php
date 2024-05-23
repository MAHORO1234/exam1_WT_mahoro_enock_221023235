<?php
// Include database connection
include('database_connection.php');
// Check if payment_method_id is set in the request
if(isset($_REQUEST['payment_method_id'])) {
    // Get payment_method_id from the request
    $payment_method_id = $_REQUEST['payment_method_id'];
    
    // Prepare and execute SQL query to select paymentmethods data by payment_method_id
    $stmt = $connection->prepare("SELECT * FROM paymentmethods WHERE payment_method_id=?");
    $stmt->bind_param("i", $payment_method_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if paymentmethods data is found
    if($result->num_rows > 0) {
        // Fetch paymentmethods data
        $row = $result->fetch_assoc();
        $payment_method_id = $row['payment_method_id']; // Store payment_method_id
        $user_id = $row['user_id']; // Store 'user_id'
        $method_type = $row['method_type']; // Store 'method_type'
        $card_number = $row['card_number']; // Store 'card_number'
        $expiry_date = $row['expiry_date']; // Store 'expiry_date'
        $cvv = $row['cvv']; // Store 'cvv'

    } else {
        echo "paymentmethods not found.";
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
    <!-- Update paymentmethods form -->
    <form method="POST">
        <label for="payment_method_id">payment_method_id:</label>
        <!-- Display payment_method_id from database -->
        <input type="number" name="payment_method_id" value="<?php echo isset($payment_method_id) ? $payment_method_id : ''; ?>">
        <br><br>
        <label for="user_id">user_id:</label>
        <!-- Display user_id from database -->
        <input type="number" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
        <br><br> 

        <label for="method_type">method_type:</label>
        <!-- Display method_type from database -->
        <input type="text" name="method_type" value="<?php echo isset($method_type) ? $method_type : ''; ?>">
        <br><br>

        <label for="card_number">card_number:</label>
        <!-- Display card_number from database -->
        <input type="number" name="card_number" value="<?php echo isset($card_number) ? $card_number : ''; ?>">
        <br><br>

        <label for="expiry_date">expiry_date:</label>
        <!-- Display expiry_date from database -->
        <input type="date" name="expiry_date" value="<?php echo isset($expiry_date) ? $expiry_date : ''; ?>">
        <br><br>


        <label for="cvv">cvv:</label>
        <!-- Display cvv from database -->
        <input type="date" name="cvv" value="<?php echo isset($cvv) ? $cvv : ''; ?>">
        <br><br>

        <!-- Submit button to update paymentmethods -->
        <input type="submit" name="up" value="Update" onclick="return confirmUpdate();">
    </form>
</body>
</html>

<?php
// Check if update button is clicked
if(isset($_POST['up'])) {
    // Retrieve updated values from reviews form
    $cvv = $_POST['cvv'];
    $expiry_date = $_POST['expiry_date'];
    $card_number = $_POST['card_number'];
    $method_type = $_POST['method_type'];
    $user_id = $_POST['user_id'];
    $payment_method_id = $_POST['payment_method_id'];
     
    
    // Update the reviews in the database
    // Update the reviews in the database
$stmt = $connection->prepare("UPDATE paymentmethods SET cvv=?, expiry_date=?, card_number=?, method_type=?, user_id=? WHERE payment_method_id=?");
$stmt->bind_param("sssssi", $cvv, $expiry_date, $card_number, $method_type, $user_id, $payment_method_id);
$stmt->execute();

    
    // Redirect to reviews.php
    header('Location: paymentmethods.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>



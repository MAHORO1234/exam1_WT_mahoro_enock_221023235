<?php
// Include database connection file
include('database_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $telephone = $_POST['telephone'];
    $password = $_POST['password']; // Add password field

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute SQL query to insert user into the database
    $stmt = $connection->prepare("INSERT INTO `user` (`firstname`, `lastname`, `email`, `username`, `telephone`, `password`) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $firstname, $lastname, $email, $username, $telephone, $hashedPassword);
    $stmt->execute();

    // Check if user is successfully inserted
    if ($stmt->affected_rows > 0) {
        echo "User registered successfully.";
    } else {
        echo "Error registering user.";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$connection->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
    <center>
        <!-- Registration Form -->
        <h2>User Registration Form</h2>
        <form action="register.php" method="post">
            <label>First Name:</label><br>
            <input type="text" name="firstname" required><br>
            <label>Last Name:</label><br>
            <input type="text" name="lastname" required><br>
            <label>Email:</label><br>
            <input type="email" name="email" required><br>
            <label>Username:</label><br>
            <input type="text" name="username" required><br>
            <label>Telephone:</label><br>
            <input type="tel" name="telephone"><br>
            <label>Password:</label><br> <!-- Add password field -->
            <input type="password" name="password" required><br><br> <!-- Add password field -->
            <input type="submit" value="Register">
            
            <p><a href="login.php">back to login</a></p>
        </form>
    </center>
</body>
</html>

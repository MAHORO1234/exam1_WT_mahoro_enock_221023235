<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>notifications Page</title>
  <style>
    /* CSS styles for the page */
    /* Normal link */
    a {
      padding: 10px;
      color: white;
      background-color:black;
      text-decoration: none;
      margin-right: 15px;
    }

    /* Visited link */
    a:visited {
      color: beige;
    }

    /* Unvisited link */
    a:link {
      color: beige;
    }

    /* Hover effect */
    a:hover {
      background-color: beige;
    }

    /* Active link */
    a:active {
      background-color: burlywood;
    }

    /* Extend margin left for search button */
    button.btn {
      margin-left: 15px;
      margin-top: 4px;
    }

    input.form-control {
      margin-left: 500px;
      padding: 8px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    /* Header style */
    header {
      background-color: beige;
      padding: 10px;
      text-align: center;
    }
    .dropdown {
    position: relative;
    display: inline;
    margin-right: 10px;

  }
  .dropdown-contents {
    display: none;
    position: absolute;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    left: 0; /* Aligning dropdown contents to the left */
  }
  .dropdown:hover .dropdown-contents {
    display: block;
  }
  .dropdown-contents a {
    color: white;
    padding: 12px 32px;
    text-decoration: none;
    display: block;
  }
  </style>
  </head>

  <header>

<body style="background-image: url('./image/carpool.jpg'); background-repeat: no-repeat; background-size: cover;">
  <header>
    <h1>notifications</h1>
  </header>
  <form class="d-flex" role="search" action="search.php">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  <ul style="list-style-type: none; padding: 0;">
    <li style="display: inline; margin-right: 10px;">
    
    <li class="dropdown" style="display: inline; margin-right: 10px;">
      <a href="#" style="padding: 10px; color: white; background-color: skyblue; text-decoration: none; margin-right: 15px;">Settings</a>
      <div class="dropdown-contents">
        <!-- Links inside the dropdown menu -->
        <a href="login.html">Login</a>
        <a href="register.html">Register</a>
        <a href="logout.php">Logout</a>
      </div>
    </li><br><br>
    
    
    
  </ul>
  </header>

  <section>
    <h1>notifications Form</h1>
    <form method="post">
      <label for="notification_id">notification_id:</label>
      <input type="number" notification_id="notification_id" name="id"><br><br>
      <label for="user_id">user_id:</label>
      <input type="text" id="user_id" name="user_id" required><br><br>
      <label for="message">message :</label>
      <input type="text" id="message" name="message" required><br><br>
      <label for="notification_date">notification_date:</label>
      <input type="text" id="notification_date" name="notification_date" required><br><br>

      <label for="is_read">is_read:</label>
      <input type="text" id="is_read" name="is_read" required><br><br>

      <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('database_connection.php');

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters with appropriate data types
        $stmt = $connection->prepare("INSERT INTO notifications (notification_id, user_id, message, notification_date, is_read) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $notification_id, $user_id, $message, $notification_date, $is_read);

        // Set parameters from POST data with validation (optional)
        $notification_id = intval($_POST['notification_id']); // Ensure integer for notification_id
        $user_id = htmlspecialchars($_POST['user_id']); // Prevent XSS
        $message = htmlspecialchars($_POST['message']); // Prevent XSS
        $notification_date = htmlspecialchars($_POST['notification_date']); // Prevent XSS
        $is_read = date('Y-m-d H:i:s'); // Current date and time

        // Execute prepared statement with error handling
        if ($stmt->execute()) {
            echo "New record has been added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $connection->close();
    ?>

    <?php
    include('database_connection.php');
    // SQL query to fetch data from notifications table
    $sql = "SELECT * FROM notifications";
    $result = $connection->query($sql);
    ?>
    <center><h2>Table of notifications</h2></center>
    <table border="5">
      <tr>
        <th>notification_id</th>
        <th>user_id</th>
        <th>message</th>
        <th>notification_date</th>
        <th>is_read </th>
        <th>Delete</th>
        <th>Update</th>
      </tr>
      <?php
      // Check if there are any notifications
      if ($result->num_rows > 0) {
          // Output data for each row
          while ($row = $result->fetch_assoc()) {
              $notification_id = $row['notification_id']; // Fetch the notification_id
              echo "<tr>
                  <td>" . $row['notification_id'] . "</td>
                  <td>" . $row['user_id'] . "</td>
                  <td>" . $row['message'] . "</td>
                  <td>" . $row['notification_date'] . "</td>
                  <td>" . $row['is_read'] . "</td>
                  <td><a style='padding:4px' href='delete_notifications.php?notification_id=$notification_id'>Delete</a></td>
                  <td><a style='padding:4px' href='update_notifications.php?notification_id=$notification_id'>Update</a></td>
              </tr>";
          }
      } else {
          echo "<tr><td colspan='7'>No data found</td></tr>";
      }
      // Close the database connection
      $connection->close();
      ?>
    </table>
  </section>

  <footer>
    <center>
      <b><h2>UR CBE BIT &copy; 2024 Designed by: @MAHORO ENOCK</h2></b>
    </center>
  </footer>
  <script>
    function toggleDropdown() {
      document.querySelector(".dropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.dropdown a')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }
  </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reviews Page</title>
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

  <body style="background-image: url('./image/carpool.jpg'); background-repeat: no-repeat; background-size: cover;">
  <header>
    <h1>Reviews</h1>
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
    <h1>Reviews Form</h1>
    <form method="post">
      <label for="review_id">Review ID:</label>
      <input type="number" name="review_id" required><br><br>
      <label for="class_id">Class ID :</label>
      <input type="text" name="class_id" required><br><br>
      <label for="user_id">User ID:</label>
      <input type="text" name="user_id" required><br><br>
      <label for="rating">Rating:</label>
      <input type="text" name="rating" required><br><br>

      <label for="comment">Comment:</label>
      <input type="text" name="comment" required><br><br>

      <label for="review_date">Review Date:</label>
      <input type="text" name="review_date" required><br><br>

      <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('database_connection.php');

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters with appropriate data types
        $stmt = $connection->prepare("INSERT INTO reviews (review_id, class_id, user_id, rating, comment, review_date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $review_id, $class_id, $user_id, $rating, $comment, $review_date);

        // Set parameters from POST data with validation (optional)
        $review_id = intval($_POST['review_id']); // Ensure integer for review_id
        $class_id = htmlspecialchars($_POST['class_id']); // Prevent XSS
        $user_id = htmlspecialchars($_POST['user_id']); // Prevent XSS
        $rating = htmlspecialchars($_POST['rating']); // Prevent XSS
        $comment = htmlspecialchars($_POST['comment']); // Prevent XSS
        $review_date = htmlspecialchars($_POST['review_date']); // Prevent XSS

        // Execute prepared statement with error handling
        if ($stmt->execute()) {
            echo "New record has been added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    // Close the database connection
    $connection->close();
    ?>

    <?php
    include('database_connection.php');
    // SQL query to fetch data from attendees table
    $sql = "SELECT * FROM reviews";
    $result = $connection->query($sql);
    ?>
    <center><h2>Table of Reviews</h2></center>
    <table border="5">
      <tr>
        <th>Review ID</th>
        <th>Class ID</th>
        <th>User ID</th>
        <th>Rating</th>
        <th>Comment</th>
        <th>Review Date</th>
        <th>Delete</th>
        <th>Update</th>
      </tr>
      <?php
      // Check if there are any reviews
      if ($result->num_rows > 0) {
          // Output data for each row
          while ($row = $result->fetch_assoc()) {
              $review_id = $row['review_id']; // Fetch the review_id
              echo "<tr>
                  <td>" . $row['review_id'] . "</td>
                  <td>" . $row['class_id'] . "</td>
                  <td>" . $row['user_id'] . "</td>
                  <td>" . $row['rating'] . "</td>
                  <td>" . $row['comment'] . "</td>
                  <td>" . $row['review_date'] . "</td>
                  <td><a style='padding:4px' href='delete_reviews.php?review_id=$review_id'>Delete</a></td>
                  <td><a style='padding:4px' href='update_reviews.php?review_id=$review_id'>Update</a></td>
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

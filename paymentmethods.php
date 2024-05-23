<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>paymentmethods Page</title>
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
    <h1>paymentmethods</h1>
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
    <h1>paymentmethods Form</h1>
    <form method="post">
      <label for="payment_method_id">payment_method_id:</labinstructor_idel>
      <input type="number" payment_method_id="payment_method_id" name="payment_method_id"><br><br>
      <label for="user_id">user_id:</label>
      <input type="text" id="user_id" name="user_id" required><br><br>
      <label for="method_type">method_type:</label>
      <input type="text" id="method_type" name="method_type" required><br><br>

      <label for="card_number">card_number:</label>
      <input type="number" id="card_number" name="card_number" required><br><br>
      
      <label for="expiry_date">expiry_date:</label>
      <input type="text" id="expiry_date" name="expiry_date" required><br><br>
      <label for="cvv">cvv:</label>
      <input type="text" id="cvv" name="cvv" required><br><br>
      
      
      <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('database_connection.php');

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind parameters with appropriate data types
        $stmt = $connection->prepare("INSERT INTO paymentmethods (payment_method_id, user_id, method_type,card_number,expiry_date,cvv) VALUES (?, ?, ?,?,?,?)");
        $stmt->bind_param("isssss", $payment_method_id, $user_id, $method_type,$card_number,$expiry_date,$cvv);

        // Set parameters from POST data with validation (optional)
        $payment_method_id = intval($_POST['payment_method_id']); // Ensure integer for payment_method_id
        $user_id = htmlspecialchars($_POST['user_id']); // Prevent XSS
        $method_type = htmlspecialchars($_POST['method_type']); // Prevent XSS
        $card_number = htmlspecialchars($_POST['card_number']); // Prevent XSS
        $expiry_date = htmlspecialchars($_POST['expiry_date']); // Prevent XSS
        $cvv = htmlspecialchars($_POST['cvv']); // Prevent XSS

        

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
    // SQL query to fetch data from paymentmethods table
    $sql = "SELECT * FROM paymentmethods";
    $result = $connection->query($sql);
    ?>
    <center><h2>Table of paymentmethods</h2></center>
    <table border="5">
      <tr>
        <th>payment_method_id</th>
        <th>user_id</th>
        <th>method_type</th>
        <th>card_number</th>
        <th>expiry_date</th>
        <th>cvv</th>
        <th>Delete</th>
        <th>Update</th>
        
      </tr>
      <?php
      // Check if there are any paymentmethods
      if ($result->num_rows > 0) {
          // Output data for each row
          while ($row = $result->fetch_assoc()) {
              $payment_method_id = $row['payment_method_id']; // Fetch the payment_method_id
              echo "<tr>
                  <td>" . $row['payment_method_id'] . "</td>
                  <td>" . $row['user_id'] . "</td>
                  <td>" . $row['method_type'] . "</td>
                  <td>" . $row['card_number'] . "</td>
                  <td>" . $row['expiry_date'] . "</td>
                  <td>" . $row['cvv'] . "</td>
                  
                  <td><a style='padding:4px' href='delete_paymentmethods.php?payment_method_id=$payment_method_id'>Delete</a></td>
                  <td><a style='padding:4px' href='update_paymentmethods.php?payment_method_id=$payment_method_id'>Update</a></td>
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

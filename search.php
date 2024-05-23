<?php
include('database_connection.php');

// Check if the query parameter is set
if (isset($_GET['query'])) {
    // Sanitize input to prevent SQL injection
    $searchTerm = $connection->real_escape_string($_GET['query']);

    // Queries for different tables
    $queries = [
        'attendees' => "SELECT attendee_id FROM attendees WHERE attendee_id LIKE '%$searchTerm%'",
        'instructors' => "SELECT instructor_id FROM instructors WHERE instructor_id LIKE '%$searchTerm%'",
        'classes' => "SELECT title FROM classes WHERE title LIKE '%$searchTerm%'",
        'enrollments' => "SELECT enrollment_date FROM enrollments WHERE enrollment_date LIKE '%$searchTerm%'",
        'masseges' => "SELECT receiver_id FROM receivers WHERE receiver_id LIKE '%$searchTerm%'",
        'notifications' => "SELECT is_read FROM notifications WHERE is_read LIKE '%$searchTerm%'",
        'paymentmethods' => "SELECT card_number FROM paymentmethods WHERE card_number LIKE '%$searchTerm%'",
        'resources' => "SELECT description FROM resources WHERE description LIKE '%$searchTerm%'",
        'reviews' => "SELECT Rating FROM reviews WHERE Rating LIKE '%$searchTerm%'",
    ];

    // Output search results
    echo "<h2><u>Search Results:</u></h2>";

    foreach ($queries as $table => $sql) {
        $result = $connection->query($sql);
        echo "<h3>Table of $table:</h3>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . $row[array_keys($row)[0]] . "</p>"; // Dynamic field extraction from result
            }
        } else {
            echo "<p>No results found in $table matching the search term: '$searchTerm'</p>";
        }
    }

    // Close the connection
    $connection->close();
} else {
    echo "<p>No search term was provided.</p>";
}
?>



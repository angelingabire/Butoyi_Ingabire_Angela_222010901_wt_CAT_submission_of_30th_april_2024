<?php
// Check if the 'query' GET parameter is set
if (isset($_GET['query']) && !empty($_GET['query'])) {
    // Connection details
    include('database_connection.php');


    // Sanitize input to prevent SQL injection
    $searchTerm = $connection->real_escape_string($_GET['query']);

    // Queries for different tables
    $queries = [
        'account' => "SELECT account_number FROM account WHERE account_number LIKE '%$searchTerm%'",
        'branch' => "SELECT branch_name FROM branch WHERE branch_name LIKE '%$searchTerm%'",
        'customer' => "SELECT Customer_id FROM customer WHERE Customer_id LIKE '%$searchTerm%'",
        'employee' => "SELECT employee_name FROM employee WHERE employee_name LIKE '%$searchTerm%'",
        'transaction' => "SELECT transaction_type FROM transaction WHERE transaction_type LIKE '%$searchTerm%'",
        
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

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get search name and filter color from form inputs
    $search_name = isset($_POST['search_name']) ? trim($_POST['search_name']) : '';
    $filter_color = isset($_POST['filter_color']) ? trim($_POST['filter_color']) : '';

    // Sanitize inputs
    $search_name = htmlspecialchars($search_name);
    $filter_color = htmlspecialchars($filter_color);

    // Database connection credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "GuessWho_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Base SQL query
    $sql = "SELECT message, color, recipient FROM Messages_tbl WHERE 1=1";
    $params = [];
    $types = "";

    // Add recipient condition if search_name is provided
    if (!empty($search_name)) {
        $sql .= " AND recipient LIKE ?";
        $params[] = "%" . $search_name . "%"; // Use LIKE for partial matching
        $types .= "s";
    }

    // Add color filter condition if filter_color is provided
    if (!empty($filter_color)) {
        $sql .= " AND color = ?";
        $params[] = $filter_color;
        $types .= "s";
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    // Bind parameters dynamically if any
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    // Execute the query
    if (!$stmt->execute()) {
        die("Query execution failed: " . $stmt->error);
    }

    // Get the result
    $result = $stmt->get_result();

    // Display the messages
    if ($result->num_rows > 0) {
        echo "<h2>Messages:</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<div style='background-color: " . htmlspecialchars($row['color']) . "; padding: 10px; margin: 5px 0;'>
                    <p><strong>To:</strong> " . htmlspecialchars($row['recipient']) . "</p>
                    <p>" . htmlspecialchars($row['message']) . "</p>
                  </div>";
        }
    } else {
        echo "<p>No messages found matching your criteria.</p>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
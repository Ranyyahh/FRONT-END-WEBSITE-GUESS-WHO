<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap" rel="stylesheet">

    <title>Home</title>
</head>
<body>
    <section id="home">
        <div class="upper">
            <header>
                <div class="logo" style="display: flex; align-items: center;">
                    <div id="imglogo" style="margin-right: 10px;">
                        <img src="site_logo.png" alt="Logo">
                        <img src="QCU_Logo_2019.png" alt="Logo">
                        <img src="ccs_logo.png" alt="Logo">
                    </div>
                    <div>
                        <h1 style="margin: 0;"><span>Guess</span> | Who</h1>
                        <p style="margin: 0;">SBIT1C</p>
                    </div>
                </div>                
                <nav>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="submit.html">Messages</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </nav>
                <div class="socmed_icons">   
                    <i class="fa fa-bars"></i>
                </div>
            </header>
            <div class="container">
                <center>
                    <div class="intro">
                        <h4>WELCOME!</h4>
                        <br>
                        <div class="typewriter">
                            <h5>THIS IS A PLACE WHERE YOU CAN SHARE YOUR UNSAID THOUGHTS</h5>
                            <br>
                            <div class="filter-options">
                            <form action="search.php" method="POST">
                            <input type="text" name="search_name" placeholder="Enter your name">
                            <select name="filter_color">
                            <option value="">Select color filter</option>
                            <option value="cornflowerblue">Red</option>
                            <option value="palevioletred">Orange</option>
                            <option value="coral">Yellow</option>
                            <option value="green">Green</option>
                            <option value="blue">Blue</option>
                            <option value="indigo">Indigo</option>
                            <option value="black">Black</option>
      
                            </select>
                                <button type="submit">Search</button>
                                </form>

                        </div>
                    
<!-- CODE FOR SEARCH  -->

<div id="messages">
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



</div>

<!-- CODE FOR SUBMIT YOUR MESSAGE -->

</div>
    <br>
    <div class="messagescontainer">
    <h2>Messages:</h2>
    <div class="message-grid">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";    
        $dbname = "GuessWho_db";
    
        $con = new mysqli($servername, $username, $password, $dbname);
    
        if ($con->connect_error) {
            echo "Connection failed: " . $con->connect_error;
        }
    
        $sql = "SELECT message, recipient, color, submitted_at FROM Messages_tbl ORDER BY submitted_at DESC";
        $result = $con->query($sql);
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $bgColor = $row['color'] ? $row['color'] : 'pink'; 
    
                echo "<div style='height:100px; width:200px; border: 2px solid black; background-color: $bgColor; box-sizing: border-box; margin: 10px 0;'>";
                echo "<p><strong>To: </strong>" . htmlspecialchars($row['recipient']) . "</p>";
                echo "<p><strong>Message: </strong> " . htmlspecialchars($row['message']) . "</p>";
                echo "<p><em><strong>Submitted at: </strong>" . htmlspecialchars($row['submitted_at']) . "</em></p>";
                echo "</div>";
            }
        } else {
            echo "<p>No messages found.</p>";
        }
        ?>
    </div>
</div>
                        <br><br>
                        <br><br>
                        <div id="about">
                            <p>From Quezon City University<br> Web Development</p>
                        </div>
                        </div>
                    </div>
                </center>
        </div>
    </section>
</body>
</html>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "GuessWho_db";

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    echo "Connection failed: " . $con->connect_error;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = ($_POST['message']);
    $recipient = ($_POST['recipient']);
    $color = ($_POST['color']);

    $sql = "INSERT INTO Messages_tbl (message, recipient, color, submitted_at) VALUES ('$message', '$recipient', '$color', NOW())";

    if ($con->query($sql) === TRUE) {
        echo "<script type='text/javascript'>
        alert('Message submitted successfully!');
        window.location.href = 'index.php';
      </script>";
      exit();
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

$sql = "SELECT message, recipient, color, submitted_at FROM Messages_tbl ORDER BY submitted_at DESC";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bgColor = $row['color'] ? $row['color'] : 'pink'; 

        // Start the message div with background color
        echo "<div style='height:100px; width:200px; border: 2px solid black; background-color: $bgColor; box-sizing: border-box; margin: 10px 0;'>";

        // Envelope icon
        echo "<div class='icon-container'><i class='fas fa-envelope'></i> To:</div>";
        
        // Recipient name
        echo "<div class='box-title'>" . htmlspecialchars($row['recipient']) . "</div>";

        // Message
        echo "<p><strong>Message: </strong> " . htmlspecialchars($row['message']) . "</p>";

        // Message submission time
        echo "<p><em><strong>Submitted at: </strong>" . htmlspecialchars($row['submitted_at']) . "</em></p>";

        // Like and Share buttons
        echo "<div class='message-buttons'>
                <button class='like-button'><i class='fas fa-thumbs-up'></i> Like</button>
                <button class='share-button'><i class='fas fa-share-alt'></i> Share</button>
              </div>";

        // Close the message div
        echo "</div>";
    }
} else {
    echo "<p>No messages found.</p>";
}
?>

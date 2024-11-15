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
                                <input type="text" placeholder="Search...">
                                <select>
                                    <option>By Name</option>
                                    <option>By Mood/Feelings</option>
                                </select>
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
    
                echo "<div style='height:100px; width:500px; border: 2px solid black; background-color: $bgColor; box-sizing: border-box; margin: 10px 0;'>";
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

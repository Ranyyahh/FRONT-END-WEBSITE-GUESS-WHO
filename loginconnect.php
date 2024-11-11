<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $username = $_POST["username"];
    $password = $_POST["password"];

    
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "unsent";

  
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       
        $query = "SELECT * FROM users WHERE Username = :username AND PASSWORD = :password";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
          
            $_SESSION['username'] = $username;
            header("Location: http://localhost/WEBSITE/index.html#");
            exit();
        } else {
           
            echo '<script>alert("Incorrect username or password.");</script>';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
       
        $conn = null;
    }
} else {
    
    echo "Invalid request method!";
}
?>
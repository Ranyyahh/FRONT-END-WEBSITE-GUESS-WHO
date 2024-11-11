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

        
        $checkQuery = "SELECT * FROM users WHERE Username = :username";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bindParam(":username", $username);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {  
            echo '<script>alert("Username already taken. Please choose another one.");</script>';
        } else {
            $query = "INSERT INTO users (Username, Password) VALUES (:username, :password)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password", $password);

            if ($stmt->execute()) {
                $_SESSION['username'] = $username;
                header("Location: http://localhost/WEBSITE/index.html#");
                exit();
            } else {
                echo '<script>alert("Error in registration. Please try again.");</script>';
            }
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

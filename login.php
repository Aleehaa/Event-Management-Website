<?php
// Database connection configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eventify";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize loginMessage
$loginMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (!empty($email) && !empty($password)) {
        $sql = "SELECT * FROM login WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $hashed_password = md5($password);
        $stmt->bind_param("ss", $email, $hashed_password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($stmt->execute()) {
            // Redirect to the main screen after successful signup
            header("Location: main.html");  // Modify this to your actual main screen URL
            exit();
        } else {
            $loginMessage = "Invalid email or password.";
        }
        $stmt->close();
    } else {
        $loginMessage = "Please fill in all fields.";
    }
}
$conn->close();
?>

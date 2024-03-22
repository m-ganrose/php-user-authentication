<?php
// Define a function to generate a random token
function generateToken($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

// Database connection
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "php_db";

$connection = mysqli_connect($hostname, $username, $password, $dbname) or die("Database connection failed.");

// Handle form submission
if(isset($_POST['submit'])) {
    // Retrieve form data
    $firstname = mysqli_real_escape_string($connection, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($connection, $_POST['lastname']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $mobilenumber = mysqli_real_escape_string($connection, $_POST['mobilenumber']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate a token
    $token = generateToken();

    // Insert data into database
    $query = "INSERT INTO users (firstname, lastname, email, mobilenumber, password, token) 
              VALUES ('$firstname', '$lastname', '$email', '$mobilenumber', '$hashed_password', '$token')";

    
    $result = mysqli_query($connection, $query);
    if($result) {
        echo "Registration successful!";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

// Close database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Event Registration</h1>
        <form action="register.php" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" required><br>
    
            <label for="email">Email:</label>
            <input type="email" name="email" required><br>
    
            <label for="password">Password:</label>
            <input type="password" name="password" required><br>
    
            <label for="phone">Phone:</label>
            <input type="text" name="phone" required><br>
    
            <label for="event">Select Event:</label>
            <select name="event" required>
                <option value="singing">Singing</option>
                <option value="dancing">Dancing</option>
                <option value="gaming">Game</option>
            </select><br>
    
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>


<?php
$conn = new mysqli("localhost", "root", "", "event_registration");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form fields are set
if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['phone'], $_POST['event'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
    $event = $_POST['event'];

    try {
        $sql = "INSERT INTO users (name, email, password, phone, event) VALUES ('$name', '$email', '$password', '$phone', '$event')";
        $conn->query($sql);
        echo "<h2>Registration successful!</h2>";
    } catch (mysqli_sql_exception $e) {
        // Check for duplicate entry error
        if ($e->getCode() == 1062) { // MySQL error code for duplicate entry 
            echo "<h2>User with this email already registered.</h3>";
        } else {
            echo "Error: " . $sql . "<br>" . $e->getMessage();
        }
    }
} else {
    echo "<h2>Please fill in all the fields.</h3>";
}

$conn->close();
?>


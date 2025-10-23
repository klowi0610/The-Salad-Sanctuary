<?php
session_start();
include 'db_connect.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        $message = "Email already exists!";
    } else {
        $sql = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$password')";
        if ($conn->query($sql)) {
            $message = "Registration successful! You can now log in.";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sign Up - The Salad Sanctuary</title>
<style>
    body {
        font-family: 'Montserrat', sans-serif;
        background: linear-gradient(to right, #4caf50, #2e7d32);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        color: white;
    }
    form {
        background: rgba(255,255,255,0.1);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.4);
        width: 350px;
        text-align: center;
    }
    input {
        width: 90%;
        padding: 10px;
        margin: 10px 0;
        border: none;
        border-radius: 5px;
    }
    button {
        background: #66bb6a;
        color: white;
        padding: 10px;
        border: none;
        width: 100%;
        border-radius: 5px;
        cursor: pointer;
    }
    button:hover { background: #43a047; }
    a { color: #fff; text-decoration: underline; }
</style>
</head>
<body>
<form method="POST" action="">
    <h2>Create Account</h2>
    <input type="text" name="fullname" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Sign Up</button>
    <p><?= $message ?></p>
    <p>Already have an account? <a href="login.php">Login</a></p>
</form>
</body>
</html>

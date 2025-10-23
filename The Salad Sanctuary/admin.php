<?php
// Database connection details
$servername = "localhost";
$username = "root";  // or your database username
$password = "Bbmwkkil7";      // or your database password
$dbname = "salad_sanctuary";  // replace with your database name

// Start session to track login state
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $adminUsername = $_POST['username'];
    $adminPassword = $_POST['password'];

    // Create MySQL connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to check if the admin credentials match
    $sql = "SELECT * FROM admin WHERE admin_Username = ? AND admin_Password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $adminUsername, $adminPassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Successful login, store session data and redirect
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = $adminUsername;
        header("Location: inventory.php"); // Redirect to inventory page
        exit();
    } else {
        // Invalid credentials
        $error_message = "Invalid login credentials. Please try again.";
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - The Salad Sanctuary</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background-color: #f4f4f4;
            position: relative;
        }

        .content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
            z-index: 2;
        }

        .login-form {
            background: rgba(255, 255, 255, 0.9); /* Slight transparency */
            padding: 40px 60px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
            animation: fadeInUp 1s ease-out;
            position: relative;
            z-index: 3;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-form h2 {
            color: #4caf50;
            margin-bottom: 20px;
            font-size: 2rem;
            font-family: 'Satisfy', cursive;
        }

        .login-form input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s;
        }

        .login-form input:focus {
            border-color: #4caf50;
        }

        .login-form button {
        width: 60%; /* Adjust the width to 60% or any value you prefer */
        padding: 12px;
        background-color: #4caf50;
        border: none;
        color: white;
        font-size: 1.1rem;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        margin: 0 auto; /* Center the button */
        display: block; /* Make the button a block-level element */
    }

        .login-form button:hover {
            background-color: #ff0d00;
        }

        .login-form p {
            margin-top: 20px;
            font-size: 0.9rem;
            color: #666;
        }

        header {
            background: none;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 20px 50px;
            z-index: 1000;
        }

        header nav {
            margin-right: auto;
        }

        header nav a {
            text-decoration: none;
            color: #ffffff;
            margin: 0 10px;
            font-size: 1.2rem;
            transition: color 0.3s, text-decoration 0.3s;
        }

        header nav a:hover {
            color: #af4c4c;
        }

        header nav a.active {
            text-decoration: underline;
            text-decoration-color: white;
        }

        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            overflow: hidden;
        }

        .video-background video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            transform: translate(-50%, -50%);
            filter: blur(5px);
        }

    </style>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Satisfy&display=swap">
</head>
<body>
    <header>
        <nav>
            <a href="home.php">Home</a>
            <a href="salads.php">Salads</a>
            <a href="about-us.php" id="about-us-link">About Us</a>
            <a href="contact.php" id="contact-link">Contact</a>
            <a href="admin.php" class="active" id="admin-link">Admin</a>
        </nav>
    </header>

    <div class="video-background">
        <video autoplay loop muted>
            <source src="salad.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
<div class="content">
    <div class="login-form">
        <!-- Added Welcome Heading -->
        <h1 style="font-family:'Satisfy', cursive; color:#4caf50; font-size:2.5rem; margin-bottom:15px;">
            The Salad Sanctuary 
        </h1>

        <h2>Admin Login</h2>
        <form action="admin.php" method="POST" id="loginForm">
            <input type="text" name="username" id="username" placeholder="Username" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <?php
        if (isset($error_message)) {
            echo "<p style='color:red;'>$error_message</p>";
        }
        ?>
    </div>
</div>

</body>
</html>

<?php
session_start();
include 'db_connect.php';

$message = "";

// Handle POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // LOGIN PROCESS
    if (isset($_POST['login'])) {
        $email = $conn->real_escape_string($_POST['email']);
        $password = $_POST['password'];

        $result = $conn->query("SELECT * FROM users WHERE email='$email'");

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];
                header("Location: home.php");
                exit;
            } else {
                $message = "Incorrect password.";
            }
        } else {
            $message = "No account found with that email.";
        }

    // SIGNUP PROCESS
    } elseif (isset($_POST['signup'])) {
        $fullname = $conn->real_escape_string($_POST['fullname']);
        $email = $conn->real_escape_string($_POST['email']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $address = $conn->real_escape_string($_POST['address']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $check = $conn->query("SELECT * FROM users WHERE email='$email'");

        if ($check && $check->num_rows > 0) {
            $message = "Email already exists. Please log in.";
        } else {
            $sql = "INSERT INTO users (fullname, email, phone, address, password) 
                    VALUES ('$fullname', '$email', '$phone', '$address', '$password')";
            if ($conn->query($sql)) {
                $message = "Account created successfully! Please login.";
            } else {
                $message = "Error creating account: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>The Salad Sanctuary - Login or Sign Up</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
<style>
/* Reset and body */
body {
    font-family: 'Montserrat', sans-serif;
    margin: 0;
    padding: 0;
    height: 100vh;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
    background: transparent !important;
    color: white;
}

/* Background video */
.video-background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: -2;
}

/* Overlay for readability */
.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.35);
    z-index: -1;
}

/* Form container */
.container {
    width: 380px;
    background: rgba(0,0,0,0.6);
    border-radius: 10px;
    padding: 30px;
    text-align: center;
    position: relative;
    z-index: 1;
    animation: fadeIn 1.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Inputs and buttons */
input {
    width: 90%;
    padding: 10px;
    margin: 10px 0;
    border: none;
    border-radius: 5px;
    font-size: 16px;
}

button {
    width: 100%;
    padding: 10px;
    background: #66bb6a;
    border: none;
    color: white;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    font-size: 16px;
    transition: 0.3s;
}

button:hover {
    background: #43a047;
}

/* Toggle link */
.toggle {
    margin-top: 15px;
    color: #fff;
    cursor: pointer;
    text-decoration: underline;
}

/* Message */
p.message {
    color: #ffeb3b;
    font-weight: bold;
}

/* Dropdown (Account Name example) */
.dropdown {
    position: relative;
    font-size: 1.2rem;
    color: white;
    cursor: default;
    padding: 5px 10px;
    text-decoration: none;
    background: transparent;
    border-radius: 0;
}

/* Dropdown content */
.dropdown-content {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: rgba(0,0,0,0.8);
    min-width: 150px;
    z-index: 2000;
}

.dropdown-content a {
    color: white;
    padding: 10px 15px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #4caf50;
}

.dropdown:hover .dropdown-content {
    display: block;
}
</style>
</head>
<body>

<!-- Video background -->
<video autoplay muted loop playsinline class="video-background">
    <source src="login.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<div class="overlay"></div>

<!-- Login Form -->
<div class="container" id="loginForm">
    <h1 style="font-family:'Satisfy', cursive; font-size:2.5rem; color:#66bb6a; margin-bottom:20px;">
        Welcome to The Salad Sanctuary 
    </h1>
    <h2>Login</h2>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
        <p class="message"><?= $message ?></p>
        <p class="toggle" onclick="toggleForm()">Don’t have an account? Sign up</p>
    </form>
</div>

<!-- Signup Form -->
<div class="container" id="signupForm" style="display:none;">
    <h1 style="font-family:'Satisfy', cursive; font-size:2.5rem; color:#66bb6a; margin-bottom:20px;">
        Welcome to The Salad Sanctuary
    </h1>
    <h2>Create Account</h2>
    <form method="POST" action="">
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="signup">Sign Up</button>
        <p class="message"><?= $message ?></p>
        <p class="toggle" onclick="toggleForm()">Already have an account? Login</p>
    </form>
</div>


<script>
function toggleForm() {
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');
    loginForm.style.display = loginForm.style.display === "none" ? "block" : "none";
    signupForm.style.display = signupForm.style.display === "none" ? "block" : "none";
}
</script>

</body>
</html>

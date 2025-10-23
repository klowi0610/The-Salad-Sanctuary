<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - The Salad Sanctuary</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: transparent; /* allow video background to show */
            color: #ffffff;
            overflow-x: hidden;
        }

        /* Loading Screen */
        #loading {
            position: fixed;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1001;
        }

        body.loaded #loading {
            display: none;
        }

        /* Header Navigation */
        header {
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
            color: #38ff15cd;
        }

        header nav a.active {
            text-decoration: underline;
        }

        /* VIDEO BACKGROUND */
        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
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
            transform: translate(-50%, -50%) scale(1.1);
            object-fit: cover;
        }

        /* Dark overlay for readability */
        .video-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: -1;
        }

        /* Content Area */
        .content {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .contact-info {
            margin-bottom: 30px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
            color: rgba(255, 255, 255, 0.9);
        }

        .contact-info h2 {
            font-family: 'Satisfy', cursive;
            font-size: 3rem;
            color: #ffffff;
            margin-bottom: 20px;
        }

        .contact-info p {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        /* Form Styles */
        form {
            max-width: 600px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            text-align: left;
        }

        form label {
            display: block;
            margin-bottom: 10px;
            color: #e1e1e1;
            font-family: 'Arial', sans-serif;
            letter-spacing: 1px;
            font-size: 1.1rem;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        form input,
        form textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            background: rgba(255, 255, 255, 0.844);
            border: none;
            outline: none;
            color: #000000;
            border-radius: 5px;
            font-family: 'Arial', sans-serif;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            border: none;
            color: #ffffff;
            cursor: pointer;
            border-radius: 5px;
            font-size: 0.9rem;
            font-family: 'Arial', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        form button:hover {
            background-color: #fa0000cb;
        }

        /* Social Media */
        .social-media {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .social-media a {
            margin: 0 20px;
        }

        .social-media img {
            width: 50px;
            height: 50px;
            transition: transform 0.3s;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px;
            border-radius: 50%;
        }

        .social-media img:hover {
            transform: scale(1.2);
        }

        /* Notification Box */
        #notification {
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            background-color: #38ff15cd;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 5px;
            z-index: 9999;
            display: none;
            text-align: center;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        /* Footer */
        footer {
            width: 100%;
            padding: 15px;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.8);
            color: #ffffff;
            font-size: 0.9rem;
            position: relative;
            bottom: 0;
        }

    </style>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Satisfy&display=swap">
</head>
<body>
    <header>
        <nav>
            <a href="home.php" id="home-link">Home</a>
            <a href="salads.php" id="salads-link">Salads</a>
            <a href="about-us.php" id="about-us-link">About Us</a>
            <a href="#" id="contact-link" class="active">Contact</a>
            <a href="admin.php" id="admin-link">Admin</a>
        </nav>
    </header>

    <!-- ✅ Video Background -->
    <div class="video-background">
        <video autoplay loop muted playsinline>
            <source src="socialmedia.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <!-- ✅ Overlay for readability -->
    <div class="video-overlay"></div>

    <div class="content">
        <div class="contact-info">
            <h2>Send Us A Feedback</h2>
        </div>

        <form id="contact-form" action="contact.php" method="POST">
            <label for="name" style="font-family: 'Georgia', serif;">Name:</label><br>
            <input type="text" id="name" name="name" required><br><br>

            <label for="email" style="font-family: 'Georgia', serif;">Email:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="message" style="font-family: 'Georgia', serif;">Message:</label><br>
            <textarea id="message" name="message" rows="4" required></textarea><br><br>

            <button type="submit" id="send-button">Send Message</button>
        </form>

        <h3>Connect With Us:</h3>
        <div class="social-media">
            <a href="https://www.facebook.com/yourpage" target="_blank"><img src="facebook.webp" alt="Facebook"></a>
            <a href="https://www.twitter.com/yourpage" target="_blank"><img src="twitter.png" alt="Twitter"></a>
            <a href="https://www.instagram.com/yourpage" target="_blank"><img src="instagram.jpeg" alt="Instagram"></a>
        </div>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $servername = "localhost";
        $username = "root";
        $password = "Bbmwkkil7";
        $dbname = "salad_sanctuary";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $message = $conn->real_escape_string($_POST['message']);
        $created_at = date('Y-m-d H:i:s');

        $sql = "INSERT INTO contact_us (name, email, message, created_at) VALUES ('$name', '$email', '$message', '$created_at')";

        if ($conn->query($sql) === TRUE) {
            echo "<div id='notification'>Message sent successfully! Thank you for your feedback.</div>";
        } else {
            echo "<p style='color: red; text-align: center;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }

        $conn->close();
    }
    ?>

    <footer>
        &copy; 2025 The Salad Sanctuary. All rights reserved.
    </footer>

    <script>
        // Show success notification
        window.onload = function() {
            var notification = document.getElementById('notification');
            if (notification) {
                notification.style.display = 'block';
                setTimeout(function() {
                    notification.style.display = 'none';
                }, 3000);
            }
        };
    </script>
</body>
</html>

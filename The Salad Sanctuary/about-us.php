<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - The Salad Sanctuary</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            font-family: 'Montserrat', sans-serif;
            position: relative;
            background-color: #f0f0f0;
            color: #ffffff;
            transition: opacity 0.5s ease-in-out;
        }

        .fade-in-up {
            opacity: 0;
            transform: translateY(-20px);
        }

        .fade-in-up.active {
            opacity: 1;
            transform: translateY(0);
        }

        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
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
            color: #4caf50;
            text-decoration-color: #ffffff;
            transform: scale(1.1);
        }

        header nav a.active {
            text-decoration: underline;
            text-decoration-color: #ffffff;
        }

        .content {
            position: relative;
            padding: 100px;
            text-align: justify;
            z-index: 1;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        h2 {
            font-family: 'Satisfy', cursive;
            font-size: 4rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        p {
            font-size: 1.5rem;
            line-height: 1.6;
            text-align: justify;
        }

        /* New Box for Founders Section */
        .founders-box {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 10px;
            margin: 20px auto;
            text-align: center;
            width: 40%;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .founders-box h3 {
            font-family: 'Satisfy', cursive;
            font-size: 2rem;
            margin-bottom: 5px;
        }

        .founders-box p {
            font-size: 1.2rem;
            line-height: 1.2;
            margin: 5px 0;
            text-align: center;
        }

        /* Footer Section */
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
<body class="fade-in-up">
    <div class="video-background">
        <video id="video1" autoplay muted>
            <source src="lettuce.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <video id="video2" muted style="display:none;">
            <source src="video/lettuce.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <header>
        <nav>
            <a href="home.php" id="home-link">Home</a>
            <a href="salads.php" id="salads-link">Salads</a>
            <a href="about-us.php" class="active">About Us</a>
            <a href="contact.php" id="contact-link">Contact</a>
            <a href="admin.php" id="admin-link">Admin</a>
        </nav>
    </header>

    <div class="content">
        <h2>Nature's Best in Every Bowl</h2>
        <p>
            Welcome to Salad Sanctuary, where "Nature's Best in Every Bowl" is more than a tagline—it's our commitment to you. We craft each salad with the freshest ingredients from trusted local farms, celebrating nature's bounty in every bite. Our passion for quality and flavor means you'll always find vibrant, crisp vegetables and perfectly paired dressings in every bowl. Whether you're craving a light lunch or a hearty meal, Salad Sanctuary offers a unique and delicious dining experience that nourishes both body and soul delivered right at your doorstep. Join us and savor the pure, simple pleasure of eating well. Order Now!
        </p>
    </div>

    <!-- New Founders Section -->
    <div class="founders-box">
        <h3>Founders</h3>
        <p>De Leon, Ma. Christina Chloe R.</p>
        <p>Parman, Bea Mae D.</p>
        <p>Morilla, Daniella Marie B.</p>
        <p>Pasiwen, Troy T.</p>
        <p>Ronquillo, Guilliana Marie H.</p>
        <p>INF225</p>
    </div>

    <footer>
        &copy; 2025 The Salad Sanctuary. All rights reserved.
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            console.log("DOM fully loaded and parsed");

            const navLinks = document.querySelectorAll('header nav a');
            navLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    document.querySelector('.content').style.opacity = '0';
                    console.log("Content fading out");
                    setTimeout(() => {
                        window.location.href = this.getAttribute('href');
                    }, 500); // Adjust delay according to transition duration
                });
            });

            const video1 = document.getElementById('video1');
            const video2 = document.getElementById('video2');

            video1.addEventListener('ended', function() {
                video1.style.display = 'none';
                video2.style.display = 'block';
                video2.play();
            });

            video2.addEventListener('ended', function() {
                video2.style.display = 'none';
                video1.style.display = 'block';
                video1.play();
            });
        });

        window.addEventListener('load', function() {
            console.log("Window loaded");
            document.body.classList.add('active');
        });
    </script>
</body>
</html>

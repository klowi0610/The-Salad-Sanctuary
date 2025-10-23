<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>The Salad Sanctuary</title>
<style>
body {
    font-family: 'Montserrat', sans-serif;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    background: transparent !important;
}

/* Video Background */
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
    background: rgba(0,0,0,0.3);
    z-index: -1;
}

header {
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 50px;
   background: none;
    z-index: 1000;
}

/* Navigation links */
header nav a {
    text-decoration: none;
    color: white;
    margin: 0 10px;
    font-size: 1.2rem;
}

header nav a:hover {
    color: #4caf50;
}

/* Dropdown (Account Name) */
.dropdown {
    position: relative;
    font-size: 1.2rem;
    color: white; /* fully white text */
    cursor: default;
    padding-left: 100px;
    padding-right: 100px;
    background: transparent; /* no background */
    border-radius: 0; /* remove radius */
    text-decoration: none;
}

/* Dropdown content */
.dropdown-content {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: rgba(0, 0, 0, 0.8); /* dark dropdown menu */
    min-width: 150px;
    z-index: 2000;
}

/* Links inside dropdown */
.dropdown-content a {
    color: white; /* white links */
    padding: 10px 15px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #4caf50;
}

/* Show dropdown on hover */
.dropdown:hover .dropdown-content {
    display: block;
}


/* Hero */
.hero {
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    position: relative;
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
    transform: translateZ(0);
}

.hero h1 {
    font-family: 'Satisfy', cursive;
    font-size: 7rem;
    margin-bottom: 20px;
    line-height: 1;
    color: #ffffff;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    animation: textFadeIn 2s ease-out, textSlideIn 2s ease-out;
}

@keyframes textFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes textSlideIn {
    from { transform: translateX(-20px); }
    to { transform: translateX(0); }
}

.hero p {
    font-size: 2rem;
    margin-bottom: 40px;
    animation: fadeInUp 2.5s ease-out;
    color: #ffffff;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.order-button {
    background-color: #4caf50;
    color: #fff;
    border: none;
    padding: 15px 60px;
    font-size: 24px;
    margin-top: 20px;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    border-radius: 30px;
    font-family: 'Satisfy', cursive;
}

.order-button:hover {
    background-color: #ff0000;
    transform: perspective(1000px) rotateX(-2deg) translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
}

</style>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Satisfy&display=swap">
</head>
<body>

<!-- Video Background -->
<video autoplay muted loop playsinline class="video-background">
    <source src="homesalad.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>
<div class="overlay"></div>

<header>
    <nav>
        <a href="home.php" class="active">Home</a>
        <a href="salads.php">Salads</a>
        <a href="about-us.php">About Us</a>
        <a href="contact.php">Contact</a>
        <a href="admin.php">Admin</a>
    </nav>

    <!-- User Dropdown -->
<!-- User Dropdown -->
<?php if(isset($_SESSION['user_id'])): ?>
<div class="dropdown">
    <span class="account-name"><?= $_SESSION['fullname']; ?></span>
    <div class="dropdown-content">
        <a href="index.php">Logout</a>
    </div>
</div>
<?php endif; ?>

</header>

<div class="hero">
    <div class="hero-content">
        <h1>The <span style="color:#4caf50;">Salad</span> Sanctuary</h1>
        <p>Nature's Best In Every Bowl!</p>
        <a href="salads.php" class="order-button">Order Now</a>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const navLinks = document.querySelectorAll('header nav a');
    navLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            if(this.getAttribute('href') !== window.location.pathname) {
                event.preventDefault();
                document.querySelector('.hero').style.opacity = '0';
                setTimeout(() => {
                    window.location.href = this.getAttribute('href');
                }, 500);
            }
        });
    });
});
</script>
</body>
</html>

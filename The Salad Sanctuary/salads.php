<?php
$servername = "localhost";
$username = "root";
$password = "Bbmwkkil7";
$dbname = "salad_sanctuary";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, salad_name, price, description, image_filename FROM inventory ORDER BY id LIMIT 16";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salads - Salad Sanctuary</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
    
        body:before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('grass_blur.jpg') no-repeat center center fixed;
            background-size: cover; 
            z-index: -1;
            filter: blur(5px); 
        }

        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background: transparent !important;
        }

        .header { position: fixed; width: 100%; top: 0; left: 0; display: flex; justify-content: space-between; align-items: center; padding: 20px 50px; z-index: 1000; }
        .header nav a { text-decoration: none; color: #ffffff; margin: 0 10px; font-size: 1.2rem; transition: color 0.3s, text-decoration 0.3s; }
        .header nav a:hover { color: #4caf50; }
        .header nav a.active { text-decoration: underline; text-decoration-color: white; }

        .basket-button {
            color: white; font-size: 1.5rem; cursor: pointer;
            position: fixed; top: 20px; right: 20px; z-index: 1001;
            background-color: #388e3c; border: 2px solid #388e3c; border-radius: 5px; padding: 10px 20px; font-weight: bold; text-transform: uppercase;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
        }
        .basket-button:hover { background-color: #f11616cd; border: 2px solid #f11616cd; color: #fff; }

        .basket-container { position: fixed; right: 20px; top: 50px; width: 300px; height: 100%; background-color: rgba(0, 0, 0, 0.8); color: white; padding: 20px; overflow-y: auto; z-index: 10; display: none; }
        .basket-item { display: flex; justify-content: space-between; padding: 10px; border-bottom: 1px solid white; }
        .basket-total { font-size: 1.5rem; margin-top: 20px; font-weight: bold; }

        .content { transition: opacity 0.5s ease-in-out; opacity: 1; margin-top: 100px; padding: 20px; display: flex; justify-content: center; padding-top: 80px; width: 100%; }
        .salad-cards { display: flex; gap: 20px; overflow-x: auto; padding-bottom: 20px; scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; padding-right: 320px; }
        .salad-card { background-color: rgba(207, 255, 197, 0.8); border-radius: 10px; padding: 20px; width: 265px; box-shadow: 0 0 10px rgba(0,0,0,0.1); transition: transform 0.3s ease; text-align: center; flex-shrink: 0; scroll-snap-align: start; }
        .salad-card:hover { transform: scale(1.05); }

        .salad-img { width: 100%; border-radius: 10px; margin-bottom: 10px; object-fit: cover; }
        .salad-title { font-family: 'Great Vibes', cursive; font-size: 1.5rem; font-weight: bold; color: #333333; }
        .salad-price { font-family: 'Arial', sans-serif; font-size: 1.2rem; color: #4caf50; margin-top: 5px; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; }
        .salad-description { font-family: 'Arial', sans-serif; font-size: 1rem; color: #666666; margin-top: 10px; }

        .salad-card button { margin-top: 10px; background-color: #388e3c; color: #ffffff; border: 2px solid #388e3c; border-radius: 5px; padding: 10px 20px; font-size: 1rem; cursor: pointer; transition: background-color 0.3s, color 0.3s, border-color 0.3s; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; }
        .salad-card button:hover { background-color: #f11616cd; border: 2px solid #f11616cd; color: #fff; }

        .checkout-button { background-color: #388e3c; color: white; border: 2px solid #388e3c; border-radius: 5px; padding: 10px 20px; font-size: 1.2rem; cursor: pointer; width: 100%; text-transform: uppercase; font-weight: bold; transition: background-color 0.3s, color 0.3s, border-color 0.3s; }
        .checkout-button:hover { background-color: #f11616cd; border: 2px solid #f11616cd; color: #fff; }

        .quantity-container button { font-size: 1.2rem; padding: 5px; width: 30px; height: 30px; background-color: #388e3c; color: white; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s; }
        .quantity-container input { font-size: 1.2rem; width: 40px; text-align: center; background: none; border: none; color: green; }
        .quantity-container button:hover { background-color: #f11616cd; }
    </style>
</head>
<body>
    <div class="header">
        <nav>
            <a href="home.php">Home</a>
            <a href="salads.php" class="active">Salads</a>
            <a href="about-us.php">About Us</a>
            <a href="contact.php">Contact</a>
            <a href="admin.php">Admin</a>
        </nav>
        <div class="basket-button" onclick="toggleBasket()">
            🛒 (<span id="basketQuantity">0</span>)
        </div>
    </div>

    <div class="basket-container" id="basketContainer">
        <h2>Basket</h2>
        <div id="basketItems"></div>
        <div class="basket-total" id="basketTotal">Total: 0 PHP</div>
        <button class="checkout-button" onclick="checkout()">Checkout</button>
    </div>

    <div class="content">
        <div class="salad-cards">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $imagePath = 'images/' . $row['image_filename'];
                    echo '
                    <div class="salad-card">
                        <img src="' . $imagePath . '" alt="Salad ' . $row['id'] . '" class="salad-img">
                        <h2 class="salad-title">' . $row['salad_name'] . '</h2>
                        <p class="salad-price">' . number_format($row['price'], 2) . ' PHP</p>
                        <p class="salad-description">' . $row['description'] . '</p>
                        <div class="quantity-container">
                            <button onclick="decreaseQuantity(\'' . $row['id'] . '\')">-</button>
                            <input type="text" id="quantity-' . $row['id'] . '" value="1" readonly>
                            <button onclick="increaseQuantity(\'' . $row['id'] . '\')">+</button>
                        </div>
                        <button onclick="addToBasket(\'' . $row['salad_name'] . '\',' . $row['price'] . ',\'' . $row['id'] . '\')">Add to Basket</button>
                    </div>';
                }
            } else {
                echo "<p>No salads found</p>";
            }
            ?>
        </div>
    </div>

    <script>
        let basketItems = JSON.parse(localStorage.getItem("basketItems")) || [];
        let basketQuantity = basketItems.reduce((sum, item) => sum + parseInt(item.quantity), 0);
        let basketTotal = basketItems.reduce((sum, item) => sum + parseFloat(item.price), 0);
        let quantities = {};

        document.getElementById('basketQuantity').innerText = basketQuantity;
        document.getElementById('basketTotal').innerText = 'Total: ' + basketTotal.toFixed(2) + ' PHP';

        function increaseQuantity(id) {
            let quantityInput = document.getElementById('quantity-' + id);
            let quantity = parseInt(quantityInput.value);
            quantityInput.value = quantity + 1;
            quantities[id] = quantityInput.value;
        }

        function decreaseQuantity(id) {
            let quantityInput = document.getElementById('quantity-' + id);
            let quantity = parseInt(quantityInput.value);
            if (quantity > 1) {
                quantityInput.value = quantity - 1;
                quantities[id] = quantityInput.value;
            }
        }

        function addToBasket(name, price, id) {
            let quantity = parseInt(quantities[id] || 1);
            let totalPrice = price * quantity;

            basketItems.push({ name: name, price: totalPrice, quantity: quantity });
            basketQuantity += quantity;
            basketTotal += totalPrice;

            localStorage.setItem("basketItems", JSON.stringify(basketItems));

            document.getElementById('basketQuantity').innerText = basketQuantity;
            document.getElementById('basketTotal').innerText = 'Total: ' + basketTotal.toFixed(2) + ' PHP';

            updateBasketDisplay();
        }

        function updateBasketDisplay() {
            let basketItemsDiv = document.getElementById('basketItems');
            basketItemsDiv.innerHTML = '';

            basketItems.forEach((item, index) => {
                let itemDiv = document.createElement('div');
                itemDiv.classList.add('basket-item');
                itemDiv.innerHTML = `
                    ${item.name} x ${item.quantity} - ${item.price.toFixed(2)} PHP
                `;
                basketItemsDiv.appendChild(itemDiv);
            });
        }

        function toggleBasket() {
            const basketContainer = document.getElementById('basketContainer');
            basketContainer.style.display = basketContainer.style.display === 'none' || basketContainer.style.display === '' ? 'block' : 'none';
        }

        function checkout() {
            if (basketItems.length > 0) {
                window.location.href = "checkout.php";
            } else {
                alert("Your basket is empty!");
            }
        }

        // Initialize basket display
        updateBasketDisplay();
    </script>
</body>
</html>

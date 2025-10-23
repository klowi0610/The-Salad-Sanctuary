<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "Bbmwkkil7", "salad_sanctuary");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Collect POST data
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$orders = $_POST['orders']; // text of basket items
$payment = $_POST['payment'];

$gcash_number = isset($_POST['gcash-number']) ? $_POST['gcash-number'] : NULL;
$card_number = isset($_POST['card-number']) ? $_POST['card-number'] : NULL;
$cardholder_name = isset($_POST['cardholder-name']) ? $_POST['cardholder-name'] : NULL;

// Optional: Basket JSON for stock update
$basketJSON = isset($_POST['basketJSON']) ? $_POST['basketJSON'] : '[]';
$basketItems = json_decode($basketJSON, true);

// 1️⃣ Insert into record_of_orders (admin dashboard)
$stmt = $conn->prepare("INSERT INTO record_of_orders 
    (customer_name, address, phone, email, order_details, payment_method) 
    VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $name, $address, $phone, $email, $orders, $payment);
$stmt->execute();
$stmt->close();

// 2️⃣ Update inventory stock
if(!empty($basketItems)){
    foreach($basketItems as $item){
        $product_id = $item['id'];       // ensure basket items include 'id'
        $quantity = $item['quantity'];
        $update = $conn->prepare("UPDATE inventory SET quantity = quantity - ? WHERE id = ?");
        $update->bind_param("ii", $quantity, $product_id);
        $update->execute();
        $update->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Processing Order</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
body { font-family: 'Montserrat', sans-serif; background: url('prc.jpg') center center fixed; background-size:130%; display:flex; justify-content:center; align-items:center; height:100vh; margin:0;}
#content { background-color: rgba(255,255,255,0.9); padding:30px; border-radius:10px; box-shadow:0 0 20px rgba(0,0,0,0.1); text-align:center; max-width:600px; width:90%; }
h1 { font-family: 'Satisfy', cursive; font-size:28px; color:#333; margin-bottom:20px; }
p { font-family: 'Cinzel', serif; font-size:18px; color:#666; }
button { background-color:#4caf50; color:#fff; border:none; padding:15px 60px; font-size:20px; margin-top:20px; cursor:pointer; border-radius:30px; font-family:'Satisfy', cursive; }
button:hover { background-color:#ea1000df; }
.fa-spinner { animation: spin 2s linear infinite; }
@keyframes spin { 0% { transform: rotate(0deg);} 100% { transform: rotate(360deg);} }
</style>
</head>
<body>
<div id="content">
    <div style="border-radius: 10px; padding: 20px; background-color: rgba(240,240,240,0.8);">
        <h1>We are now preparing your order and will hand it over to our delivery riders once it's ready. <i class="fas fa-spinner fa-spin"></i></h1>
        <p>Thank you for choosing The Salad Sanctuary!</p>
    </div>
    <button onclick="window.location.href='home.php'">Home Page</button>
</div>

<script>
    // Clear basket after order
    localStorage.removeItem("basketItems");

    // Auto redirect after 5 seconds
    setTimeout(() => { window.location.href = 'home.php'; }, 5000);
</script>
</body>
</html>
